<?php

namespace App\Helpers;

/**
 * Helper pour les calculs de notes et moyennes
 */
class NoteHelper
{
    /**
     * Calcule la moyenne pondérée avec règles de gestion
     * 
     * Règles appliquées:
     * 1. Note maximale par matière
     * 2. Meilleure note pour matières optionnelles
     * 3. Pondération par crédit
     * 
     * @param array $notes - Array de notes avec structure: 
     *        ['note' => float, 'credit' => int, 'id_option' => ?int, 'matiere_nom' => string]
     * @return float - Moyenne pondérée
     */
    public static function calculateWeightedAverage(array $notes): float
    {
        if (empty($notes)) {
            return 0;
        }

        // Étape 1: Grouper par matière et garder la note maximale
        $matieresByName = [];
        foreach ($notes as $note) {
            $matiereName = $note['matiere_nom'];
            
            if (!isset($matieresByName[$matiereName])) {
                $matieresByName[$matiereName] = [
                    'note' => $note['note'],
                    'credit' => $note['credit'],
                    'id_option' => $note['id_option'] ?? null,
                    'is_optional' => isset($note['id_option']) && $note['id_option'] !== null
                ];
            } else {
                // Garder la note maximale
                if ($note['note'] > $matieresByName[$matiereName]['note']) {
                    $matieresByName[$matiereName]['note'] = $note['note'];
                }
            }
        }

        // Étape 2: Pour les matières optionnelles, garder la meilleure
        $optionalsByOption = [];
        $obligatoires = [];

        foreach ($matieresByName as $matiereName => $data) {
            if ($data['is_optional']) {
                $optionId = $data['id_option'];
                
                if (!isset($optionalsByOption[$optionId])) {
                    $optionalsByOption[$optionId] = $data;
                } else {
                    // Garder la meilleure note pour cette option
                    if ($data['note'] > $optionalsByOption[$optionId]['note']) {
                        $optionalsByOption[$optionId] = $data;
                    }
                }
            } else {
                $obligatoires[] = $data;
            }
        }

        // Étape 3: Calculer la moyenne pondérée
        $totalNotes = 0;
        $totalCredits = 0;

        // Matières obligatoires
        foreach ($obligatoires as $matiere) {
            $totalNotes += $matiere['note'] * $matiere['credit'];
            $totalCredits += $matiere['credit'];
        }

        // Meilleures matières optionnelles
        foreach ($optionalsByOption as $option) {
            $totalNotes += $option['note'] * $option['credit'];
            $totalCredits += $option['credit'];
        }

        return $totalCredits > 0 ? round($totalNotes / $totalCredits, 2) : 0;
    }

    /**
     * Obtient la mention basée sur la moyenne
     * 
     * @param float $moyenne - Moyenne générale
     * @return string - Mention (Excellent, Très Bien, Bien, Passable, Faible)
     */
    public static function getMention(float $moyenne): string
    {
        if ($moyenne >= 18) {
            return 'Excellent';
        } elseif ($moyenne >= 16) {
            return 'Très Bien';
        } elseif ($moyenne >= 14) {
            return 'Bien';
        } elseif ($moyenne >= 12) {
            return 'Assez Bien';
        } elseif ($moyenne >= 10) {
            return 'Passable';
        } else {
            return 'Faible';
        }
    }

    /**
     * Détermine le résultat (Admis/Rejeté/Compensé)
     * 
     * @param float $moyenne - Moyenne générale
     * @param array $moyennesBySemestre - ['s3' => float, 's4' => float]
     * @return string - Résultat
     */
    public static function getResultat(float $moyenne, array $moyennesBySemestre = []): string
    {
        // Si tous les semestres >= 10: Admis
        if (count(array_filter($moyennesBySemestre, fn($m) => $m >= 10)) === count($moyennesBySemestre)) {
            return 'Admis';
        }
        
        // Si moyenne générale >= 10 et min semestre >= 8: Admis par compensation
        $minSemestre = min($moyennesBySemestre);
        if ($moyenne >= 10 && $minSemestre >= 8) {
            return 'Admis par compensation';
        }
        
        // Sinon: Rejeté
        return 'Rejeté';
    }

    /**
     * Formate une note pour l'affichage
     * 
     * @param float $note - Note brute
     * @param int $decimales - Nombre de décimales (défaut: 2)
     * @return string - Note formatée
     */
    public static function formatNote(float $note, int $decimales = 2): string
    {
        return number_format($note, $decimales, ',', ' ');
    }

    /**
     * Obtient la classe CSS pour une note
     * 
     * @param float $note - Note
     * @return string - Classe CSS (good, medium, low)
     */
    public static function getNoteClass(float $note): string
    {
        if ($note >= 12) {
            return 'good';
        } elseif ($note >= 10) {
            return 'medium';
        } else {
            return 'low';
        }
    }

    /**
     * Valide une note
     * 
     * @param mixed $note - Valeur à valider
     * @return array - ['valid' => bool, 'error' => ?string]
     */
    public static function validateNote($note): array
    {
        if (!is_numeric($note)) {
            return [
                'valid' => false,
                'error' => 'La note doit être un nombre'
            ];
        }

        $note = (float) $note;

        if ($note < 0) {
            return [
                'valid' => false,
                'error' => 'La note ne peut pas être négative'
            ];
        }

        if ($note > 20) {
            return [
                'valid' => false,
                'error' => 'La note ne peut pas dépasser 20'
            ];
        }

        return ['valid' => true];
    }

    /**
     * Calcule les statistiques complètes d'un ensemble de notes
     * 
     * @param array $notes - Tableau de notes
     * @return array - ['moyenne' => float, 'min' => float, 'max' => float, 'total' => int]
     */
    public static function getStats(array $notes): array
    {
        if (empty($notes)) {
            return [
                'moyenne' => 0,
                'min' => 0,
                'max' => 0,
                'total' => 0
            ];
        }

        $values = array_column($notes, 'note');
        
        return [
            'moyenne' => round(array_sum($values) / count($values), 2),
            'min' => min($values),
            'max' => max($values),
            'total' => count($values)
        ];
    }

    /**
     * Regroupe les notes par semestre
     * 
     * @param array $notes - Tableau de notes
     * @return array - Notes groupées par semestre
     */
    public static function groupBySemestre(array $notes): array
    {
        $grouped = [];
        
        foreach ($notes as $note) {
            $semestre = $note['semestre_nom'] ?? 'Inconnu';
            
            if (!isset($grouped[$semestre])) {
                $grouped[$semestre] = [];
            }
            
            $grouped[$semestre][] = $note;
        }
        
        return $grouped;
    }

    /**
     * Regroupe les notes par option
     * 
     * @param array $notes - Tableau de notes
     * @return array - Notes groupées par option
     */
    public static function groupByOption(array $notes): array
    {
        $grouped = [
            'obligatoires' => [],
            'options' => []
        ];
        
        foreach ($notes as $note) {
            if (isset($note['id_option']) && $note['id_option'] !== null) {
                $option = $note['option_nom'] ?? 'Inconnu';
                
                if (!isset($grouped['options'][$option])) {
                    $grouped['options'][$option] = [];
                }
                
                $grouped['options'][$option][] = $note;
            } else {
                $grouped['obligatoires'][] = $note;
            }
        }
        
        return $grouped;
    }

    /**
     * Calcule les crédits obtenus pour une moyenne donnée
     * 
     * @param array $notes - Tableau de notes
     * @param float $noteMinimum - Note minimale pour valider (défaut: 10)
     * @return int - Crédits obtenus
     */
    public static function calculateCreditsObtained(array $notes, float $noteMinimum = 10): int
    {
        $credits = 0;
        
        foreach ($notes as $note) {
            if ($note['note'] >= $noteMinimum) {
                $credits += $note['credit'] ?? 0;
            }
        }
        
        return $credits;
    }

    /**
     * Génère un résumé textuel des notes
     * 
     * @param float $moyenne - Moyenne
     * @param array $stats - Statistiques additionnelles
     * @return string - Résumé
     */
    public static function generateSummary(float $moyenne, array $stats = []): string
    {
        $mention = self::getMention($moyenne);
        $formatted = self::formatNote($moyenne);
        
        return "Moyenne: {$formatted}/20 ({$mention})";
    }
}
