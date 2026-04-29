-- ════════════════════════════════════════════════════════════════════════════
-- FICHIER D'INITIALISATION DE LA BASE DE DONNÉES
-- Gestion des Notes - CodeIgniter 4
-- ════════════════════════════════════════════════════════════════════════════

-- Créer la base de données
CREATE DATABASE IF NOT EXISTS gestion_bulletin;
USE gestion_bulletin;

-- ─────────────────────────────────────────────────────────────────────────────
-- TABLE: utilisateur (Administrateurs/Professeurs)
-- ─────────────────────────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS utilisateur (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    mdp VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    role ENUM('admin', 'prof') DEFAULT 'prof',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ─────────────────────────────────────────────────────────────────────────────
-- TABLE: classe (Niveaux d'études: L2, L3, etc.)
-- ─────────────────────────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS classe (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL UNIQUE,
    total_credits INT NOT NULL DEFAULT 60,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ─────────────────────────────────────────────────────────────────────────────
-- TABLE: semestre (S3, S4)
-- ─────────────────────────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS semestre (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    id_classe INT NOT NULL,
    total_credits INT NOT NULL DEFAULT 30,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_classe) REFERENCES classe(id) ON DELETE CASCADE,
    UNIQUE KEY uk_semestre_classe (nom, id_classe),
    INDEX idx_classe (id_classe)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ─────────────────────────────────────────────────────────────────────────────
-- TABLE: prof (Professeurs)
-- ─────────────────────────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS prof (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    telephone VARCHAR(20),
    specialite VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_nom (nom)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ─────────────────────────────────────────────────────────────────────────────
-- TABLE: option_etude (Options: Dev, BDDRes, Web)
-- ─────────────────────────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS option_etude (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_nom (nom)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ─────────────────────────────────────────────────────────────────────────────
-- TABLE: eleve (Étudiants)
-- ─────────────────────────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS eleve (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(150) NOT NULL,
    prenom VARCHAR(100),
    id_classe INT NOT NULL,
    email VARCHAR(100),
    telephone VARCHAR(20),
    date_inscription TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    numero_etudiant VARCHAR(50) UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_classe) REFERENCES classe(id) ON DELETE CASCADE,
    INDEX idx_classe (id_classe),
    INDEX idx_nom (nom)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ─────────────────────────────────────────────────────────────────────────────
-- TABLE: eleve_option (Relation Étudiant-Option par Semestre)
-- ─────────────────────────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS eleve_option (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_eleve INT NOT NULL,
    id_semestre INT NOT NULL,
    id_option INT NOT NULL,
    date_choix TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_eleve) REFERENCES eleve(id) ON DELETE CASCADE,
    FOREIGN KEY (id_semestre) REFERENCES semestre(id) ON DELETE CASCADE,
    FOREIGN KEY (id_option) REFERENCES option_etude(id) ON DELETE CASCADE,
    UNIQUE KEY uk_eleve_semestre_option (id_eleve, id_semestre, id_option),
    INDEX idx_eleve (id_eleve),
    INDEX idx_semestre (id_semestre),
    INDEX idx_option (id_option)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ─────────────────────────────────────────────────────────────────────────────
-- TABLE: matiere (Matières/Unités d'Enseignement)
-- ─────────────────────────────────────────────────────────────────────────────
-- id_option NULL = matière obligatoire
-- id_option != NULL = matière optionnelle
-- ─────────────────────────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS matiere (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(150) NOT NULL,
    ue VARCHAR(100),
    credit INT NOT NULL DEFAULT 4,
    id_semestre INT NOT NULL,
    id_prof INT NOT NULL,
    id_option INT NULL,
    coefficient DECIMAL(3,2) DEFAULT 1.00,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_semestre) REFERENCES semestre(id) ON DELETE CASCADE,
    FOREIGN KEY (id_prof) REFERENCES prof(id) ON DELETE RESTRICT,
    FOREIGN KEY (id_option) REFERENCES option_etude(id) ON DELETE SET NULL,
    INDEX idx_semestre (id_semestre),
    INDEX idx_prof (id_prof),
    INDEX idx_option (id_option),
    INDEX idx_nom (nom)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ─────────────────────────────────────────────────────────────────────────────
-- TABLE: note (Notes des Étudiants)
-- ─────────────────────────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS note (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_eleve INT NOT NULL,
    id_matiere INT NOT NULL,
    note DECIMAL(5,2) NOT NULL,
    date_saisie TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    date_modification TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    saisie_par INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_eleve) REFERENCES eleve(id) ON DELETE CASCADE,
    FOREIGN KEY (id_matiere) REFERENCES matiere(id) ON DELETE CASCADE,
    FOREIGN KEY (saisie_par) REFERENCES utilisateur(id) ON DELETE SET NULL,
    UNIQUE KEY uk_eleve_matiere (id_eleve, id_matiere),
    INDEX idx_eleve (id_eleve),
    INDEX idx_matiere (id_matiere),
    INDEX idx_note (note),
    CHECK (note >= 0 AND note <= 20)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ─────────────────────────────────────────────────────────────────────────────
-- TABLE: bulletin_semestre (Résultats par Semestre)
-- ─────────────────────────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS bulletin_semestre (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_eleve INT NOT NULL,
    id_semestre INT NOT NULL,
    moyenne DECIMAL(5,2),
    credits_obtenus INT DEFAULT 0,
    mention VARCHAR(50),
    resultat VARCHAR(50),
    date_generation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_eleve) REFERENCES eleve(id) ON DELETE CASCADE,
    FOREIGN KEY (id_semestre) REFERENCES semestre(id) ON DELETE CASCADE,
    UNIQUE KEY uk_eleve_semestre (id_eleve, id_semestre),
    INDEX idx_eleve (id_eleve),
    INDEX idx_semestre (id_semestre)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ─────────────────────────────────────────────────────────────────────────────
-- TABLE: bulletin_annuel (Résultats Annuels - L2)
-- ─────────────────────────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS bulletin_annuel (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_eleve INT NOT NULL,
    moyenne_generale DECIMAL(5,2),
    credits_total INT DEFAULT 0,
    mention VARCHAR(50),
    resultat VARCHAR(50),
    date_generation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_eleve) REFERENCES eleve(id) ON DELETE CASCADE,
    UNIQUE KEY uk_eleve_annuel (id_eleve),
    INDEX idx_eleve (id_eleve)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ─────────────────────────────────────────────────────────────────────────────
-- TABLE: audit (Historique des modifications)
-- ─────────────────────────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS audit (
    id INT AUTO_INCREMENT PRIMARY KEY,
    table_name VARCHAR(100) NOT NULL,
    operation ENUM('INSERT', 'UPDATE', 'DELETE') NOT NULL,
    record_id INT,
    user_id INT,
    old_values JSON,
    new_values JSON,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_table (table_name),
    INDEX idx_operation (operation),
    INDEX idx_timestamp (timestamp)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ════════════════════════════════════════════════════════════════════════════
-- INSERTION DES DONNÉES DE BASE
-- ════════════════════════════════════════════════════════════════════════════

-- Classe L2
INSERT INTO classe (nom, total_credits) VALUES ('L2', 60);

-- Semestres
INSERT INTO semestre (nom, id_classe, total_credits) VALUES
('S3', 1, 30),
('S4', 1, 30);

-- Options
INSERT INTO option_etude (nom, description) VALUES
('dev', 'Option Développement'),
('bddres', 'Option Base de données et Réseaux'),
('web', 'Option Web');

-- Professeurs
INSERT INTO prof (nom) VALUES
('Prof A'), 
('Prof B'), 
('Prof C');

-- Étudiants
INSERT INTO eleve (nom, id_classe) VALUES
('Rakoto', 1);

-- Options de l'étudiant
INSERT INTO eleve_option (id_eleve, id_semestre, id_option)
VALUES (1, 2, 1); -- Rakoto choisit Dev pour S4

-- Matières S3 (obligatoires)
INSERT INTO matiere (nom, ue, credit, id_semestre, id_prof) VALUES
('Programmation orientée objet', 'INF201', 6, 1, 1),
('Bases de données objets', 'INF202', 6, 1, 1),
('Programmation système', 'INF203', 4, 1, 2),
('Réseaux informatiques', 'INF208', 6, 1, 2),
('Méthodes numériques', 'MTH201', 4, 1, 3),
('Bases de gestion', 'ORG201', 4, 1, 3);

-- Matières S4 (obligatoires + optionnelles)
INSERT INTO matiere (nom, ue, credit, id_semestre, id_prof, id_option) VALUES
('Eléments Algorithmique', 'INF207', 6, 2, 1, NULL),
('Mini-projet de développement', 'INF210', 10, 2, 2, 1),
('Système Information géographique', 'INF204', 6, 2, 2, 1),
('MAO', 'MTH203', 4, 2, 3, NULL),
('Optimisation', 'MTH206', 4, 2, 3, NULL);

-- Notes S3
INSERT INTO note (id_eleve, id_matiere, note) VALUES
(1, 1, 10.5),
(1, 2, 14),
(1, 3, 11),
(1, 4, 10),
(1, 5, 6.5),
(1, 6, 13);

-- Notes S4
INSERT INTO note (id_eleve, id_matiere, note) VALUES
(1, 7, 9.5),
(1, 8, 12.2),
(1, 9, 12),
(1, 10, 11.33),
(1, 11, 12.25);

-- ════════════════════════════════════════════════════════════════════════════
-- VUES UTILES (optionnel)
-- ════════════════════════════════════════════════════════════════════════════

-- Vue: Notes avec informations complètes
CREATE OR REPLACE VIEW v_notes_complete AS
SELECT 
    n.id,
    n.id_eleve,
    e.nom as eleve_nom,
    n.id_matiere,
    m.nom as matiere_nom,
    m.ue,
    m.credit,
    n.note,
    m.id_semestre,
    s.nom as semestre_nom,
    m.id_option,
    o.nom as option_nom,
    m.id_prof,
    p.nom as prof_nom
FROM note n
JOIN eleve e ON n.id_eleve = e.id
JOIN matiere m ON n.id_matiere = m.id
JOIN semestre s ON m.id_semestre = s.id
LEFT JOIN option_etude o ON m.id_option = o.id
LEFT JOIN prof p ON m.id_prof = p.id;

-- Vue: Résumé des options par étudiant
CREATE OR REPLACE VIEW v_eleve_options AS
SELECT 
    eo.id,
    eo.id_eleve,
    e.nom as eleve_nom,
    eo.id_semestre,
    s.nom as semestre_nom,
    eo.id_option,
    o.nom as option_nom
FROM eleve_option eo
JOIN eleve e ON eo.id_eleve = e.id
JOIN semestre s ON eo.id_semestre = s.id
JOIN option_etude o ON eo.id_option = o.id;

-- ════════════════════════════════════════════════════════════════════════════
-- FIN DU SCRIPT D'INITIALISATION
-- ════════════════════════════════════════════════════════════════════════════
