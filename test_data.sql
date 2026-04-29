-- ════════════════════════════════════════════════════════════════════════════
-- DONNÉES SUPPLÉMENTAIRES POUR TESTING
-- Gestion des Notes - CodeIgniter 4
-- ════════════════════════════════════════════════════════════════════════════

USE gestion_bulletin;

-- ─────────────────────────────────────────────────────────────────────────────
-- AJOUT D'ÉTUDIANTS ADDITIONNELS
-- ─────────────────────────────────────────────────────────────────────────────

-- Étudiant 2: Option BDDRes
INSERT INTO eleve (nom, id_classe) VALUES ('Martin Dupont', 1);
INSERT INTO eleve_option (id_eleve, id_semestre, id_option) VALUES (2, 2, 2);

-- Étudiant 3: Option Web
INSERT INTO eleve (nom, id_classe) VALUES ('Sophie Bernard', 1);
INSERT INTO eleve_option (id_eleve, id_semestre, id_option) VALUES (3, 2, 3);

-- Étudiant 4: Plusieurs options (exemple)
INSERT INTO eleve (nom, id_classe) VALUES ('Jean Lefebvre', 1);
INSERT INTO eleve_option (id_eleve, id_semestre, id_option) VALUES 
(4, 2, 1),  -- Dev
(4, 2, 3);  -- Web

-- Étudiant 5: Cas limites
INSERT INTO eleve (nom, id_classe) VALUES ('Marie Leclerc', 1);
INSERT INTO eleve_option (id_eleve, id_semestre, id_option) VALUES (5, 2, 1);

-- ─────────────────────────────────────────────────────────────────────────────
-- NOTES POUR MARTIN DUPONT (ID: 2) - S3
-- ─────────────────────────────────────────────────────────────────────────────

INSERT INTO note (id_eleve, id_matiere, note) VALUES
(2, 1, 13.5),   -- POO: 13.5
(2, 2, 14.0),   -- BDD: 14.0
(2, 3, 12.0),   -- Prog Sys: 12.0
(2, 4, 15.5),   -- Réseaux: 15.5
(2, 5, 10.0),   -- Méthodes num: 10.0
(2, 6, 11.5);   -- Gestion: 11.5

-- ─────────────────────────────────────────────────────────────────────────────
-- NOTES POUR MARTIN DUPONT (ID: 2) - S4 (Option BDDRes)
-- ─────────────────────────────────────────────────────────────────────────────

INSERT INTO note (id_eleve, id_matiere, note) VALUES
(2, 7, 13.0),   -- Eléments Algorithmique: 13.0
(2, 10, 14.5),  -- MAO: 14.5
(2, 11, 13.2);  -- Optimisation: 13.2

-- ─────────────────────────────────────────────────────────────────────────────
-- NOTES POUR SOPHIE BERNARD (ID: 3) - S3
-- ─────────────────────────────────────────────────────────────────────────────

INSERT INTO note (id_eleve, id_matiere, note) VALUES
(3, 1, 16.5),   -- POO: 16.5 (excellente)
(3, 2, 15.0),   -- BDD: 15.0
(3, 3, 14.0),   -- Prog Sys: 14.0
(3, 4, 13.0),   -- Réseaux: 13.0
(3, 5, 12.5),   -- Méthodes num: 12.5
(3, 6, 14.5);   -- Gestion: 14.5

-- ─────────────────────────────────────────────────────────────────────────────
-- NOTES POUR SOPHIE BERNARD (ID: 3) - S4 (Option Web)
-- ─────────────────────────────────────────────────────────────────────────────

INSERT INTO note (id_eleve, id_matiere, note) VALUES
(3, 7, 15.0),   -- Eléments Algorithmique: 15.0
(3, 10, 13.5),  -- MAO: 13.5
(3, 11, 14.0);  -- Optimisation: 14.0

-- ─────────────────────────────────────────────────────────────────────────────
-- NOTES POUR JEAN LEFEBVRE (ID: 4) - S3
-- ─────────────────────────────────────────────────────────────────────────────

INSERT INTO note (id_eleve, id_matiere, note) VALUES
(4, 1, 9.5),    -- POO: 9.5 (limite basse)
(4, 2, 10.5),   -- BDD: 10.5
(4, 3, 8.0),    -- Prog Sys: 8.0 (faible)
(4, 4, 11.0),   -- Réseaux: 11.0
(4, 5, 7.5),    -- Méthodes num: 7.5 (très faible)
(4, 6, 9.0);    -- Gestion: 9.0

-- ─────────────────────────────────────────────────────────────────────────────
-- NOTES POUR JEAN LEFEBVRE (ID: 4) - S4 (Plusieurs options)
-- ─────────────────────────────────────────────────────────────────────────────

INSERT INTO note (id_eleve, id_matiere, note) VALUES
(4, 7, 10.0),   -- Eléments Algorithmique: 10.0
(4, 10, 9.5),   -- MAO: 9.5
(4, 11, 8.5);   -- Optimisation: 8.5

-- ─────────────────────────────────────────────────────────────────────────────
-- NOTES POUR MARIE LECLERC (ID: 5) - S3 - Cas de Test: Absence
-- ─────────────────────────────────────────────────────────────────────────────

INSERT INTO note (id_eleve, id_matiere, note) VALUES
(5, 1, 12.0),   -- POO: 12.0
(5, 2, 13.5),   -- BDD: 13.5
(5, 3, 0.0),    -- Prog Sys: 0.0 (ABSENCE)
(5, 4, 14.0),   -- Réseaux: 14.0
(5, 5, 11.5),   -- Méthodes num: 11.5
(5, 6, 13.0);   -- Gestion: 13.0

-- ─────────────────────────────────────────────────────────────────────────────
-- NOTES POUR MARIE LECLERC (ID: 5) - S4 - Cas de Test: Options Multiples
-- ─────────────────────────────────────────────────────────────────────────────

INSERT INTO note (id_eleve, id_matiere, note) VALUES
(5, 7, 12.5),   -- Eléments Algorithmique: 12.5
(5, 8, 11.0),   -- Mini-projet Dev: 11.0
(5, 9, 12.0),   -- SIG: 12.0
(5, 10, 13.0),  -- MAO: 13.0
(5, 11, 12.0);  -- Optimisation: 12.0

-- ─────────────────────────────────────────────────────────────────────────────
-- DONNÉES D'AGRÉGATION (Calculs pour validation)
-- ─────────────────────────────────────────────────────────────────────────────

-- Formule pour vérifier les calculs manuels:
/*
RAKOTO (ID: 1) - S3:
  POO (6 credits): 10.5 → 63
  BDD (6 credits): 14 → 84
  Prog Sys (4 credits): 11 → 44
  Réseaux (6 credits): 10 → 60
  Méthodes num (4 credits): 6.5 → 26
  Gestion (4 credits): 13 → 52
  Total: (63+84+44+60+26+52) / (6+6+4+6+4+4) = 329 / 30 = 10.97

MARTIN (ID: 2) - S3:
  POO (6): 13.5 → 81
  BDD (6): 14 → 84
  Prog Sys (4): 12 → 48
  Réseaux (6): 15.5 → 93
  Méthodes num (4): 10 → 40
  Gestion (4): 11.5 → 46
  Total: (81+84+48+93+40+46) / 30 = 392 / 30 = 13.07

SOPHIE (ID: 3) - S3:
  POO (6): 16.5 → 99
  BDD (6): 15 → 90
  Prog Sys (4): 14 → 56
  Réseaux (6): 13 → 78
  Méthodes num (4): 12.5 → 50
  Gestion (4): 14.5 → 58
  Total: (99+90+56+78+50+58) / 30 = 431 / 30 = 14.37

JEAN (ID: 4) - S3:
  POO (6): 9.5 → 57
  BDD (6): 10.5 → 63
  Prog Sys (4): 8 → 32
  Réseaux (6): 11 → 66
  Méthodes num (4): 7.5 → 30
  Gestion (4): 9 → 36
  Total: (57+63+32+66+30+36) / 30 = 284 / 30 = 9.47

MARIE (ID: 5) - S3:
  POO (6): 12 → 72
  BDD (6): 13.5 → 81
  Prog Sys (4): 0 → 0 (absence)
  Réseaux (6): 14 → 84
  Méthodes num (4): 11.5 → 46
  Gestion (4): 13 → 52
  Total: (72+81+0+84+46+52) / 30 = 335 / 30 = 11.17
*/

-- ─────────────────────────────────────────────────────────────────────────────
-- VÉRIFICATION DES DONNÉES
-- ─────────────────────────────────────────────────────────────────────────────

-- Pour vérifier l'insertion:
/*
SELECT e.id, e.nom, COUNT(n.id) as nb_notes 
FROM eleve e 
LEFT JOIN note n ON e.id = n.id_eleve 
GROUP BY e.id;

SELECT e.nom, m.nom as matiere, n.note, m.credit 
FROM note n 
JOIN eleve e ON n.id_eleve = e.id 
JOIN matiere m ON n.id_matiere = m.id 
ORDER BY e.nom, m.nom;

SELECT e.nom, COUNT(DISTINCT eo.id_option) as nb_options 
FROM eleve e 
LEFT JOIN eleve_option eo ON e.id = eo.id_eleve 
GROUP BY e.id;
*/

-- ════════════════════════════════════════════════════════════════════════════
-- FIN DES DONNÉES DE TEST
-- ════════════════════════════════════════════════════════════════════════════
