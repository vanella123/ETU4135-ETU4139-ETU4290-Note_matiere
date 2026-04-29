<?php

/**
 * GUIDE DE TEST FONCTIONNEL
 * Gestion des Notes - CodeIgniter 4
 * 
 * Ce fichier guide les tests de toutes les fonctionnalités
 */

// Test 1: Afficher la liste des étudiants
echo "TEST 1: Liste des étudiants\n";
echo "URL: http://localhost:8080/student\n";
echo "Résultat attendu: Affiche une grille avec Rakoto\n\n";

// Test 2: Afficher les notes S3
echo "TEST 2: Notes Semestre 3\n";
echo "URL: http://localhost:8080/student/1/details/s3\n";
echo "Résultat attendu:\n";
echo "- Titre: Semestre 3 (S3)\n";
echo "- 6 matières affichées\n";
echo "- Moyenne S3 calculée\n\n";

// Test 3: Afficher les notes S4
echo "TEST 3: Notes Semestre 4\n";
echo "URL: http://localhost:8080/student/1/details/s4\n";
echo "Résultat attendu:\n";
echo "- Titre: Semestre 4 (S4)\n";
echo "- Filtre par option: Dev, BDDRes, Web\n";
echo "- Option Dev est l'option de l'étudiant Rakoto\n\n";

// Test 4: Afficher les notes S4 filtrées par option
echo "TEST 4: Notes S4 - Option Dev\n";
echo "URL: http://localhost:8080/student/1/details/s4?option=1\n";
echo "Résultat attendu:\n";
echo "- Affiche uniquement les matières de Dev\n";
echo "- Mini-projet de développement (10 credits)\n";
echo "- SIG (6 credits)\n\n";

// Test 5: Afficher L2 (toutes les notes)
echo "TEST 5: Licence 2 - Toutes les notes\n";
echo "URL: http://localhost:8080/student/1/details/l2\n";
echo "Résultat attendu:\n";
echo "- Affiche S3 + S4\n";
echo "- Résumé: Moyenne S3, Moyenne S4, Moyenne Générale L2\n";
echo "- Moyenne Générale = moyenne pondérée des 2 semestres\n\n";

// Test 6: Formulaire d'édition
echo "TEST 6: Modification des notes\n";
echo "URL: http://localhost:8080/student/1/edit-notes\n";
echo "Résultat attendu:\n";
echo "- Affiche tous les champs de notes groupés par semestre\n";
echo "- Champs éditables avec validation 0-20\n";
echo "- Icônes de statut (✓ succès, ✗ erreur)\n\n";

// Test 7: Mise à jour d'une note via AJAX
echo "TEST 7: Sauvegarde d'une note\n";
echo "Action: Modifier une note et quitter le champ\n";
echo "Résultat attendu:\n";
echo "- Indicateur \"⏳\" pendant la sauvegarde\n";
echo "- Indicateur \"✓\" si succès\n";
echo "- La note est mise à jour en base de données\n\n";

// Test 8: Validation des notes
echo "TEST 8: Validation des saisies\n";
echo "Action: Tenter d'entrer:\n";
echo "- Valeur > 20 → Rejet avec message d'erreur\n";
echo "- Valeur < 0 → Rejet avec message d'erreur\n";
echo "- Valeur valide (0-20) → Acceptée\n\n";

// Test 9: Recherche dans la liste
echo "TEST 9: Recherche d'étudiant\n";
echo "Action: Taper \"Rak\" dans la barre de recherche\n";
echo "Résultat attendu: La carte de Rakoto reste affichée\n";
echo "Action: Taper \"Toto\" \n";
echo "Résultat attendu: Aucune carte affichée\n\n";

// Test 10: Calcul des moyennes
echo "TEST 10: Vérification des calculs\n";
echo "Notes S3 de Rakoto:\n";
echo "- POO (6 credits): 10.5\n";
echo "- BDD (6 credits): 14\n";
echo "- Prog Sys (4 credits): 11\n";
echo "- Réseaux (6 credits): 10\n";
echo "- Méthodes num (4 credits): 6.5\n";
echo "- Gestion (4 credits): 13\n";
echo "\nMoyenne S3 = (10.5*6 + 14*6 + 11*4 + 10*6 + 6.5*4 + 13*4) / (6+6+4+6+4+4)\n";
echo "            = (63 + 84 + 44 + 60 + 26 + 52) / 30\n";
echo "            = 329 / 30 = 10.97\n\n";

// Test 11: Options multiples
echo "TEST 11: Gestion des options multiples\n";
echo "Situation: Si Rakoto avait plusieurs options (exemple: Dev + Web)\n";
echo "Comportement S4:\n";
echo "- Les matières obligatoires s'affichent toujours\n";
echo "- Le filtre \"Toutes les options\" affiche tous les cours\n";
echo "- Le filtre \"Dev\" affiche seulement les cours Dev\n";
echo "- Le filtre \"Web\" affiche seulement les cours Web\n\n";

// Test 12: Responsivité
echo "TEST 12: Responsive Design\n";
echo "Action: Redimensionner le navigateur\n";
echo "Attendu:\n";
echo "- Desktop (1200px+): Grille 4 colonnes\n";
echo "- Tablet (768px-1199px): Grille 2-3 colonnes\n";
echo "- Mobile (< 768px): 1 colonne, sidebar cachée\n\n";

// Test 13: Navigation
echo "TEST 13: Navigation\n";
echo "Depuis liste: Cliquer \"Voir notes\" → Va à /student/1/details/l2\n";
echo "Depuis détails: Cliquer bouton retour → Retourne à liste\n";
echo "Depuis détails: Cliquer onglet S3/S4/L2 → Change le filtre\n";
echo "Depuis détails: Cliquer \"Modifier\" → Va à /student/1/edit-notes\n";
echo "Depuis édition: Cliquer \"Retour\" → Retourne aux détails\n\n";

// Test 14: Absence d'un étudiant
echo "TEST 14: Gestion des absences\n";
echo "Situation: Si une note vaut 0\n";
echo "Comportement: Traitée comme présent/absent avec note 0\n";
echo "Impact sur moyenne: Réduit la moyenne normalement\n\n";

// Test 15: Règle des optionnelles
echo "TEST 15: Règle des matières optionnelles\n";
echo "Situation: Un étudiant a les notes optionnelles:\n";
echo "- Dev 1: 12\n";
echo "- Dev 2: 15 ← meilleure note\n";
echo "Comportement: Seule la note de Dev 2 (15) compte\n";
echo "Impact: Améliore la moyenne en sélectionnant la meilleure\n\n";

// Test 16: Multi-saisie rapide
echo "TEST 16: Édition rapide plusieurs notes\n";
echo "Action: Modifier 3-4 notes rapidement\n";
echo "Résultat attendu:\n";
echo "- Chaque modification se sauvegarde indépendamment\n";
echo "- Pas de conflit entre les requêtes AJAX\n";
echo "- Toutes les notes sont correctement mises à jour\n\n";

// Test 17: Cache et actualisation
echo "TEST 17: Actualisation des données\n";
echo "Action: Modifier une note, puis actualiser la page\n";
echo "Résultat attendu: La note modifiée est toujours affichée\n\n";

// Test 18: Codes HTTP
echo "TEST 18: Codes d'erreur HTTP\n";
echo "- GET /student → 200 (OK)\n";
echo "- GET /student/999/details → 404 (Not Found)\n";
echo "- POST /student/update-note (AJAX) → 200 avec JSON\n\n";

?>
