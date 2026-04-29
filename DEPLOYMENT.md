# Guide de Déploiement - Gestion des Notes

## 🚀 Démarrage Rapide

### Prérequis
- PHP 7.4 ou supérieur
- MySQL 5.7 ou supérieur  
- Composer
- Serveur Web (Apache, Nginx)

### Installation Locale (Développement)

```bash
# 1. Cloner le projet
git clone <url-du-repo>
cd projet

# 2. Installer les dépendances
composer install

# 3. Copier et configurer le fichier d'environnement
cp env .env

# 4. Éditer .env
# Localiser et modifier les sections:
# [database]
# database.default.hostname = localhost
# database.default.database = gestion_bulletin
# database.default.username = root
# database.default.password = 
# database.default.port = 3306

# 5. Importer la base de données
mysql -u root < Database.sql
mysql -u root gestion_bulletin < Donnes.sql

# 6. Donner les permissions sur le répertoire writable
chmod -R 775 writable/

# 7. Lancer le serveur de développement
php spark serve

# 8. Accéder à l'application
# http://localhost:8080
```

## 🗄️ Configuration de la Base de Données

### Option 1: Import SQL Direct

```bash
# Importer le schéma
mysql -u root < Database_Updated.sql

# Ou avec mot de passe
mysql -u root -p < Database_Updated.sql

# Vérifier l'import
mysql -u root
mysql> use gestion_bulletin;
mysql> show tables;
```

### Option 2: Via PHPMyAdmin

1. Ouvrir PHPMyAdmin (`http://localhost/phpmyadmin`)
2. Créer une nouvelle base de données: `gestion_bulletin`
3. Sélectionner la base
4. Aller dans "Importer"
5. Uploader `Database_Updated.sql`
6. Cliquer "Exécuter"

### Option 3: Via CodeIgniter CLI

```bash
# Utiliser les migrations CodeIgniter (si disponibles)
php spark migrate
```

## 📁 Structure des Répertoires

Assurer les permissions correctes:

```bash
# Répertoire pour les logs
chmod 755 writable/logs/

# Répertoire pour le cache
chmod 755 writable/cache/

# Répertoire pour les sessions
chmod 755 writable/session/

# Répertoire pour les uploads
chmod 755 writable/uploads/

# Répertoire pour la base de données de debug
chmod 755 writable/debugbar/
```

## 🔐 Configuration de Sécurité

### .env - Paramètres Importants

```ini
# Définir le mode en production
CI_ENVIRONMENT = production

# Clé de chiffrement (générer avec: php spark key:generate)
encryption.key = votre_clé_secrète_ici

# Paramètres de session
session.driver = database
session.expiration = 7200

# CORS (si nécessaire)
app.baseURL = https://votredomaine.com

# Désactiver la debug bar
debugbar.enabled = false
```

### Génération de Clé de Chiffrement

```bash
php spark key:generate
```

### Fichiers à Sécuriser

```bash
# Restreindre l'accès aux fichiers sensibles
chmod 600 .env
chmod 600 writable/logs/*

# Assurer que public/ est le document root web
# Apache: DocumentRoot /chemin/vers/projet/public
# Nginx: root /chemin/vers/projet/public;
```

## 🌐 Configuration Serveur Web

### Apache (.htaccess)

Le fichier `public/.htaccess` devrait contenir:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ index.php/$1 [L]
</IfModule>
```

### Nginx (nginx.conf)

```nginx
server {
    listen 80;
    server_name votredomaine.com;
    root /chemin/vers/projet/public;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\. {
        deny all;
    }
}
```

## 📊 Initialisation des Données

### Ajouter des Étudiants

```sql
INSERT INTO eleve (nom, id_classe) VALUES 
('Dupont', 1),
('Martin', 1),
('Bernard', 1);

INSERT INTO eleve_option (id_eleve, id_semestre, id_option) VALUES
(2, 2, 2),  -- Martin: Option BDDRes en S4
(3, 2, 3);  -- Bernard: Option Web en S4
```

### Ajouter des Notes

```sql
INSERT INTO note (id_eleve, id_matiere, note) VALUES
(2, 1, 13.5),  -- Martin: POO 13.5
(2, 2, 12.0);  -- Martin: BDD 12.0
```

### Vérifier les Données

```sql
-- Voir tous les étudiants avec leurs options
SELECT e.nom, o.nom as option_nom, s.nom as semestre_nom
FROM eleve e
LEFT JOIN eleve_option eo ON e.id = eo.id_eleve
LEFT JOIN option_etude o ON eo.id_option = o.id
LEFT JOIN semestre s ON eo.id_semestre = s.id;

-- Voir les notes d'un étudiant
SELECT e.nom, m.nom as matiere, n.note, m.credit
FROM note n
JOIN eleve e ON n.id_eleve = e.id
JOIN matiere m ON n.id_matiere = m.id
ORDER BY e.nom, m.nom;
```

## 🐛 Troubleshooting

### Erreur: "Can't connect to database"

**Cause**: Paramètres de connexion incorrects

**Solution**:
```bash
# Vérifier .env
grep -E "database\." .env

# Tester la connexion MySQL
mysql -h localhost -u root -p gestion_bulletin -e "SELECT 1;"
```

### Erreur: "The Controller does not exist"

**Cause**: Route ou contrôleur introuvable

**Solution**:
```bash
# Vérifier les routes
php spark routes

# Vérifier le fichier du contrôleur existe
ls -la app/Controllers/StudentController.php

# Vérifier le namespace
grep "namespace" app/Controllers/StudentController.php
```

### Erreur: "Class not found"

**Cause**: Fichier du modèle introuvable ou namespace incorrect

**Solution**:
```bash
# Régénérer l'autoload
composer dump-autoload

# Vérifier le namespace du modèle
grep "namespace" app/Models/EleveModel.php
```

### Permissions refusées

**Solution**:
```bash
# Donner les permissions au serveur web
sudo chown -R www-data:www-data /chemin/vers/projet
sudo chmod -R 755 /chemin/vers/projet
sudo chmod -R 775 writable/
```

### Pages blanches

**Solution**: Activer le debug et vérifier les logs

```bash
# .env
CI_ENVIRONMENT = development

# Logs
tail -f writable/logs/log-*.log
```

## 📈 Optimisation pour Production

### Désactiver le Debug

```ini
# .env
debugbar.enabled = false
```

### Compiler les Assets

```bash
# Si utilisant Sass/Less
npm install
npm run build
```

### Mettre en Cache

```ini
# .env
cache.handler = file
cache.ttl = 3600
```

### Optimiser les Images

```bash
# Compresser les images
find public/img -type f -name "*.png" -exec optipng -o2 {} \;
find public/img -type f -name "*.jpg" -exec jpegoptim {} \;
```

## 🔄 Mise à Jour

### Mise à jour du Code

```bash
git pull origin main
composer install
php spark migrate
```

### Sauvegarde de la BD

```bash
# Avant une mise à jour
mysqldump -u root gestion_bulletin > backup_$(date +%Y%m%d).sql

# Restauration si nécessaire
mysql -u root gestion_bulletin < backup_20240429.sql
```

## 📋 Checklist de Déploiement

- [ ] PHP 7.4+ installé
- [ ] MySQL 5.7+ installé et running
- [ ] Composer installé
- [ ] Fichier `.env` configuré
- [ ] Base de données créée et importée
- [ ] Permissions des répertoires correctes
- [ ] Serveur web configuré (Apache/Nginx)
- [ ] Domaine configuré (DNS, certificat SSL)
- [ ] Email de notification configuré
- [ ] Sauvegardes programmées
- [ ] Logs moniteur
- [ ] Tests fonctionnels complétés

## 📞 Support

- Documentation CodeIgniter: https://codeigniter.com/user_guide/
- MySQL: https://dev.mysql.com/doc/
- Logs: `writable/logs/`
- Issues: Vérifier les logs et utiliser le debug mode

---

**Dernière mise à jour**: Avril 2026
