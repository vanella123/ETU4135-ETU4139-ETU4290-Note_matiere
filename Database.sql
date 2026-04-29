CREATE DATABASE gestion_bulletin;
USE gestion_bulletin;


CREATE TABLE utilisateur (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    mdp VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE
);

INSERT INTO utilisateur (nom, mdp, email) VALUES
('Admin Sys', 'password', 'admin@sysinfo.mg');

CREATE TABLE prof (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL
);

CREATE TABLE classe (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    total_credits INT NOT NULL
);

CREATE TABLE semestre (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL, -- S3, S4
    id_classe INT NOT NULL,
    total_credits INT NOT NULL,
    FOREIGN KEY (id_classe) REFERENCES classe(id)
);

CREATE TABLE option_etude (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL
);

CREATE TABLE eleve (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(150) NOT NULL,
    id_classe INT NOT NULL,
    FOREIGN KEY (id_classe) REFERENCES classe(id)
);

CREATE TABLE eleve_option (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_eleve INT NOT NULL,
    id_semestre INT NOT NULL,
    id_option INT NOT NULL,
    FOREIGN KEY (id_eleve) REFERENCES eleve(id),
    FOREIGN KEY (id_semestre) REFERENCES semestre(id),
    FOREIGN KEY (id_option) REFERENCES option_etude(id)
);

CREATE TABLE matiere (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(150) NOT NULL,
    ue VARCHAR(100),
    credit INT NOT NULL,
    id_semestre INT NOT NULL,
    id_prof INT NOT NULL,
    id_option INT NULL, -- NULL = matière normale, sinon option
    FOREIGN KEY (id_semestre) REFERENCES semestre(id),
    FOREIGN KEY (id_prof) REFERENCES prof(id),
    FOREIGN KEY (id_option) REFERENCES option_etude(id)
);

CREATE TABLE note (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_eleve INT NOT NULL,
    id_matiere INT NOT NULL,
    note DECIMAL(5,2) NOT NULL,
    FOREIGN KEY (id_eleve) REFERENCES eleve(id),
    FOREIGN KEY (id_matiere) REFERENCES matiere(id)
);

CREATE TABLE bulletin_semestre (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_eleve INT NOT NULL,
    id_semestre INT NOT NULL,
    moyenne DECIMAL(5,2),
    credits_obtenus INT,
    mention VARCHAR(50),
    resultat VARCHAR(50),
    FOREIGN KEY (id_eleve) REFERENCES eleve(id),
    FOREIGN KEY (id_semestre) REFERENCES semestre(id)
);

CREATE TABLE bulletin_annuel (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_eleve INT NOT NULL,
    moyenne_generale DECIMAL(5,2),
    credits_total INT,
    mention VARCHAR(50),
    resultat VARCHAR(50),
    FOREIGN KEY (id_eleve) REFERENCES eleve(id)
);
