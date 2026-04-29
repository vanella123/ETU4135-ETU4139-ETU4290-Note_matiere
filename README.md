# 📚 Gestion des Notes - Licence 2

Système complet de gestion des notes pour étudiants en Licence 2 (L2) développé avec **CodeIgniter 4** et **MySQL**.

## 🎯 Présentation

Cette application permet de:
- **Consulter** les notes des étudiants par semestre (S3, S4) ou l'année complète (L2)
- **Calculer** les moyennes automatiquement avec règles pédagogiques avancées
- **Gérer** les options (Dev, BDDRes, Web) pour le semestre 4
- **Modifier** les notes en temps réel via une interface intuitive

## ✨ Fonctionnalités Principales

### 📊 Affichage des Notes
- ✅ Liste de tous les étudiants
- ✅ Notes du Semestre 3 (S3)
- ✅ Notes du Semestre 4 (S4) avec filtre par option
- ✅ Vue complète Licence 2 (S3 + S4) avec moyenne générale
- ✅ Recherche rapide par nom d'étudiant

### 📈 Calcul des Moyennes
- ✅ Moyenne pondérée par crédit
- ✅ Note maximale par matière (plusieurs prises)
- ✅ Meilleure note pour matières optionnelles
- ✅ Gestion des absences (note = 0)
- ✅ Moyennes par semestre et générale L2

### 🎓 Gestion des Options
- ✅ Support de 3 options: Développement, BDD/Réseaux, Web
- ✅ Un étudiant peut avoir plusieurs options
- ✅ Filtre des matières par option
- ✅ Affichage respectif des notes S4 par option

### ✏️ Modification des Notes
- ✅ Interface d'édition user-friendly
- ✅ Validation en temps réel (0-20)
- ✅ Sauvegarde AJAX sans rechargement
- ✅ Feedback visuel immédiat

## 🚀 Démarrage Rapide

### Prérequis
- PHP 7.4+
- MySQL 5.7+
- Composer
- Git (optionnel)

### Installation
```bash
# 1. Cloner/télécharger le projet
cd ETU4135-ETU4139-ETU4290-Note_matiere

# 2. Installer les dépendances
composer install

# 3. Configurer l'environnement
cp env .env
# Éditer .env avec vos paramètres MySQL

# 4. Importer la base de données
mysql -u root < Database.sql
mysql -u root gestion_bulletin < Donnes.sql

# 5. Lancer le serveur
php spark serve

# 6. Accéder à l'application
# http://localhost:8080/student
```

> Voir [INSTALLATION.md](INSTALLATION.md) pour une documentation complète.

## 📁 Structure du Projet

```
app/
├── Controllers/        # Logique applicative
│   └── StudentController.php
├── Models/            # Accès à la base de données
│   ├── EleveModel.php
│   └── NoteModel.php
├── Views/             # Interface utilisateur
│   └── student/
│       ├── list.php
│       ├── details.php
│       └── edit_notes.php
├── Helpers/           # Fonctions utilitaires
│   └── NoteHelper.php
└── Config/
    └── Routes.php     # Déclaration des routes

public/
├── css/
│   └── style.css      # Feuille de style (responsive)
└── index.php          # Point d'entrée

Documentation/
├── INSTALLATION.md           # Guide d'installation
├── API_DOCUMENTATION.md      # Documentation API REST
├── DEPLOYMENT.md             # Guide de déploiement
├── RESUME_IMPLEMENTATION.md  # Résumé du projet
└── TESTING.php              # Guide de test

Database/
├── Database.sql       # Schéma initial
├── Database_Updated.sql  # Schéma complet (recommandé)
├── Donnes.sql         # Données de test initiales
└── test_data.sql      # Données supplémentaires
```

## 🎨 Interface

### Responsive Design
- 📱 Mobile: Layout 1 colonne
- 📊 Tablet: 2-3 colonnes
- 🖥️ Desktop: Grille complète

### Composants UI
- Grille de cartes pour les étudiants
- Tableaux clairs pour afficher les notes
- Onglets pour filtrer les semestres
- Formulaires d'édition intuitifs
- Sidebar + Topbar pour la navigation

## 📊 Données de Test

L'application est fournie avec des données de test:
- **Rakoto**: S3 + S4 (Option Dev)
- **Martin Dupont**: S3 + S4 (Option BDDRes)
- **Sophie Bernard**: S3 + S4 (Option Web)
- **Jean Lefebvre**: S3 + S4 (Cas limites)
- **Marie Leclerc**: S3 + S4 (Absences, options multiples)

Utilisez `test_data.sql` pour ajouter plus de données.

## 🔧 Routes Disponibles

```
GET  /student                      # Liste des étudiants
GET  /student/{id}/details         # Toutes les notes
GET  /student/{id}/details/s3      # Notes S3
GET  /student/{id}/details/s4      # Notes S4 (avec filtre option)
GET  /student/{id}/edit-notes      # Formulaire d'édition
POST /student/update-note          # API AJAX pour sauvegarder
```

## 📝 Exemple d'Utilisation

### 1. Voir les notes S3
```
http://localhost:8080/student/1/details/s3
```

### 2. Voir les notes S4 (option Dev)
```
http://localhost:8080/student/1/details/s4?option=1
```

### 3. Voir le bilan L2
```
http://localhost:8080/student/1/details/l2
```

### 4. Modifier une note (via API)
```javascript
fetch('/student/update-note', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/x-www-form-urlencoded',
    'X-Requested-With': 'XMLHttpRequest'
  },
  body: 'eleve_id=1&matiere_id=1&note=15.5'
})
```

## 📐 Règles de Gestion

1. **Note maximale**: Pour une même matière, on conserve la meilleure note
2. **Matières optionnelles**: On ne retient que la meilleure note de l'option
3. **Absences**: Traitées comme une note de 0
4. **Options**: Concernent uniquement le S4
5. **Moyenne**: Pondérée par le nombre de crédits

## 🔑 Technologies Utilisées

- **Framework**: CodeIgniter 4
- **Base de Données**: MySQL 5.7+
- **Backend**: PHP 7.4+
- **Frontend**: HTML5 + CSS3 + JavaScript vanilla
- **Design**: Responsive (Mobile-first)

## 📚 Documentation

Consultez les fichiers suivants pour plus de détails:

| Fichier | Description |
|---------|------------|
| [INSTALLATION.md](INSTALLATION.md) | Guide complet d'installation |
| [API_DOCUMENTATION.md](API_DOCUMENTATION.md) | Documentation des endpoints |
| [DEPLOYMENT.md](DEPLOYMENT.md) | Guide de déploiement production |
| [TESTING.php](TESTING.php) | Guide de test fonctionnel |
| [RESUME_IMPLEMENTATION.md](RESUME_IMPLEMENTATION.md) | Résumé du projet |

## 🧪 Tests

### Vérification du Setup
```bash
chmod +x verify_setup.sh
./verify_setup.sh
```

### Tests Manuels
Consultez [TESTING.php](TESTING.php) pour un guide complet des cas de test.

## 🐛 Troubleshooting

### Erreur de connexion à la base de données
```bash
# Vérifier .env
grep "database\." .env

# Tester la connexion
mysql -h localhost -u root -p gestion_bulletin -e "SELECT 1;"
```

### Pages blanches
```bash
# Activer le debug
# .env: CI_ENVIRONMENT = development

# Consulter les logs
tail -f writable/logs/log-*.log
```

### Les notes ne se sauvegardent pas
- Vérifier la console du navigateur pour les erreurs AJAX
- Vérifier les permissions du répertoire `writable/`
- S'assurer que JavaScript est activé

## 🚀 Déploiement Production

1. Consulter [DEPLOYMENT.md](DEPLOYMENT.md)
2. Configurer le serveur web (Apache/Nginx)
3. Générer les clés de sécurité
4. Désactiver le debug mode
5. Mettre en place les sauvegardes

## 📊 Calcul des Moyennes - Exemple

```
Étudiant: Rakoto (S3)
Matière                 Note    Crédit  Total
POO                     10.5    6       63
BDD                     14      6       84
Prog Sys                11      4       44
Réseaux                 10      6       60
Méthodes numériques     6.5     4       26
Gestion                 13      4       52
                                ------  ----
Totaux                                  30      329

Moyenne = 329 / 30 = 10.97/20
Mention: Passable
```

## 🤝 Contribution

Pour améliorer le projet:
1. Fork le projet
2. Créer une branche (`git checkout -b feature/amelioration`)
3. Committer les changements (`git commit -am 'Ajout de feature'`)
4. Pousser la branche (`git push origin feature/amelioration`)
5. Ouvrir une Pull Request

## 📝 Licence

Ce projet est fourni à titre éducatif dans le cadre du cours ETU4135-ETU4139-ETU4290.

## 📞 Support

- 📧 Pour les questions: consultez la documentation
- 🐛 Pour les bugs: vérifiez d'abord les logs
- 💡 Pour les suggestions: ouvrez une issue

## 🎓 Ressources Supplémentaires

- [Documentation CodeIgniter 4](https://codeigniter.com/user_guide/)
- [MySQL Documentation](https://dev.mysql.com/doc/)
- [PHP Handbook](https://www.php.net/manual/)

## ✅ Checklist d'Installation

- [ ] PHP 7.4+ installé
- [ ] MySQL installé et en cours d'exécution
- [ ] Composer installé
- [ ] Projet cloné/téléchargé
- [ ] `.env` configuré
- [ ] Base de données importée
- [ ] Permissions correctes (writable/)
- [ ] Serveur lancé (`php spark serve`)
- [ ] Application accessible

---

**Version**: 1.0.0  
**Date**: Avril 2026  
**Framework**: CodeIgniter 4  
**Base de Données**: MySQL 5.7+  
**État**: ✅ Production Ready (avec améliorations possibles)

Fait avec ❤️ pour la gestion pédagogique des notes.
More information can be found at the [official site](https://codeigniter.com).

This repository holds the distributable version of the framework.
It has been built from the
[development repository](https://github.com/codeigniter4/CodeIgniter4).

More information about the plans for version 4 can be found in [CodeIgniter 4](https://forum.codeigniter.com/forumdisplay.php?fid=28) on the forums.

You can read the [user guide](https://codeigniter.com/user_guide/)
corresponding to the latest version of the framework.

## Important Change with index.php

`index.php` is no longer in the root of the project! It has been moved inside the *public* folder,
for better security and separation of components.

This means that you should configure your web server to "point" to your project's *public* folder, and
not to the project root. A better practice would be to configure a virtual host to point there. A poor practice would be to point your web server to the project root and expect to enter *public/...*, as the rest of your logic and the
framework are exposed.

**Please** read the user guide for a better explanation of how CI4 works!

## Repository Management

We use GitHub issues, in our main repository, to track **BUGS** and to track approved **DEVELOPMENT** work packages.
We use our [forum](http://forum.codeigniter.com) to provide SUPPORT and to discuss
FEATURE REQUESTS.

This repository is a "distribution" one, built by our release preparation script.
Problems with it can be raised on our forum, or as issues in the main repository.

## Contributing

We welcome contributions from the community.

Please read the [*Contributing to CodeIgniter*](https://github.com/codeigniter4/CodeIgniter4/blob/develop/CONTRIBUTING.md) section in the development repository.

## Server Requirements

PHP version 8.2 or higher is required, with the following extensions installed:

- [intl](http://php.net/manual/en/intl.requirements.php)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)

> [!WARNING]
> - The end of life date for PHP 7.4 was November 28, 2022.
> - The end of life date for PHP 8.0 was November 26, 2023.
> - The end of life date for PHP 8.1 was December 31, 2025.
> - If you are still using below PHP 8.2, you should upgrade immediately.
> - The end of life date for PHP 8.2 will be December 31, 2026.

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php) if you plan to use MySQL
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library
