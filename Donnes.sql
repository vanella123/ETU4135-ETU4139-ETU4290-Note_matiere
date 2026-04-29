INSERT INTO classe (nom, total_credits) VALUES ('L2', 60);

INSERT INTO semestre (nom, id_classe, total_credits) VALUES
('S3', 1, 30),
('S4', 1, 30);

INSERT INTO option_etude (nom) VALUES
('dev'),
('bddres'),
('web');

INSERT INTO prof (nom) VALUES
('Prof A'), ('Prof B'), ('Prof C');

INSERT INTO eleve (nom, id_classe) VALUES
('Rakoto', 1);

INSERT INTO eleve_option (id_eleve, id_semestre, id_option)
VALUES (1, 2, 1);

INSERT INTO matiere (nom, ue, credit, id_semestre, id_prof) VALUES
('Programmation orientée objet', 'INF201', 6, 1, 1),
('Bases de données objets', 'INF202', 6, 1, 1),
('Programmation système', 'INF203', 4, 1, 2),
('Réseaux informatiques', 'INF208', 6, 1, 2),
('Méthodes numériques', 'MTH201', 4, 1, 3),
('Bases de gestion', 'ORG201', 4, 1, 3);

INSERT INTO matiere (nom, ue, credit, id_semestre, id_prof, id_option) VALUES
('Eléments Algorithmique', 'INF207', 6, 2, 1, NULL),
('Mini-projet de développement', 'INF210', 10, 2, 2, 1),
('Système Information géographique', 'INF204', 6, 2, 2, 1),
('MAO', 'MTH203', 4, 2, 3, NULL),
('Optimisation', 'MTH206', 4, 2, 3, NULL);

INSERT INTO note (id_eleve, id_matiere, note) VALUES
(1, 1, 10.5),
(1, 2, 14),
(1, 3, 11),
(1, 4, 10),
(1, 5, 6.5),
(1, 6, 13),

(1, 7, 9.5),
(1, 8, 12.2),
(1, 9, 12),
(1, 10, 11.33),
(1, 11, 12.25);