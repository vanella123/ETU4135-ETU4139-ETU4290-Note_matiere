# Gestion des Notes Étudiants - CodeIgniter 4

## 📋 Vue d'ensemble

Application web de gestion des notes pour les étudiants en Licence 2 (L2) avec :
- **Semestre 3 (S3)** : matières obligatoires
- **Semestre 4 (S4)** : matières obligatoires + matières optionnelles (Dev, BDDRes, Web)

## 🚀 Fonctionnalités

### 1. Liste des Étudiants
- Affichage de tous les étudiants en grille
- Recherche rapide par nom
- Accès direct aux notes et formulaire d'édition

### 2. Consultation des Notes
Les notes peuvent être affichées selon 3 filtres :

#### S3 (Semestre 3)
- Affiche toutes les matières du S3
- Calcule la moyenne du S3

#### S4 (Semestre 4)
- Affiche les matières du S4 selon l'option choisie
- Filtre par option (Dev, BDDRes, Web)
- Calcule la moyenne du S4

#### L2 (Licence 2)
- Affiche toutes les notes (S3 + S4)
- Moyenne générale sur les 2 semestres
- Résumé des moyennes S3, S4 et générale

### 3. Modification des Notes
- Interface d'édition par semestre
- Validation en temps réel (0-20)
- Sauvegarde immédiate via AJAX
- Feedback visuel (✓ succès, ✗ erreur)

## 📐 Règles de Gestion

1. **Note maximale** : Pour une même matière, on conserve la note maximale obtenue
2. **Matières optionnelles** : On ne considère que la matière avec la meilleure note
3. **Absence** : Note égale à 0 si l'étudiant est absent
4. **Options** : Concernent uniquement le S4
5. **Affichage S4** : Seules les matières de l'option de l'étudiant sont affichées

## 🗄️ Structure de Base de Données

### Tables principales
- `eleve` : Étudiants
- `semestre` : S3, S4
- `matiere` : Matières par semestre
- `note` : Notes des étudiants
- `option_etude` : Options (Dev, BDDRes, Web)
- `eleve_option` : Lien étudiant-option par semestre

## 📁 Structure du Projet

```
app/
├── Controllers/
│   └── StudentController.php      # Contrôleur principal
├── Models/
│   ├── EleveModel.php             # Modèle étudiant
│   └── NoteModel.php              # Modèle notes
├── Views/
│   └── student/
│       ├── list.php               # Liste des étudiants
│       ├── details.php            # Détails des notes
│       └── edit_notes.php          # Formulaire d'édition
├── Config/
│   └── Routes.php                 # Routes
└── ...

public/
├── css/
│   └── style.css                  # Styles (réutilisé du design)
└── ...
```

## 🔧 Installation

### 1. Prérequis
- PHP 7.4+
- MySQL 5.7+
- CodeIgniter 4
- Composer

### 2. Installation du Projet

```bash
# Cloner le projet
git clone <repo-url>

# Installer les dépendances
composer install

# Copier env
cp env .env

# Configurer .env
# Mettre à jour les paramètres de connexion BD
```

### 3. Configuration Base de Données

```bash
# Éditer .env
DB_DATABASE=gestion_bulletin
DB_USERNAME=root
DB_PASSWORD=

# Importer le schéma
mysql -u root gestion_bulletin < Database.sql

# Importer les données
mysql -u root gestion_bulletin < Donnes.sql
```

### 4. Routes Disponibles

```
GET  /student                          # Liste des étudiants
GET  /student/:id/details              # Toutes les notes
GET  /student/:id/details/s3           # Notes S3
GET  /student/:id/details/s4           # Notes S4 (avec option)
GET  /student/:id/details/l2           # Notes L2 + moyennes
GET  /student/:id/edit-notes           # Formulaire d'édition
POST /student/update-note              # Sauvegarde note (AJAX)
```

## 💾 API - Mise à Jour des Notes

### Endpoint
```
POST /student/update-note
Content-Type: application/x-www-form-urlencoded
X-Requested-With: XMLHttpRequest
```

### Paramètres
```json
{
  "eleve_id": 1,
  "matiere_id": 1,
  "note": 14.5
}
```

### Réponses
```json
// Succès
{
  "success": true,
  "message": "Note mise à jour avec succès"
}

// Erreur
{
  "success": false,
  "message": "La note doit être entre 0 et 20"
}
```

## 🎨 Interface

### Palette de Couleurs
- **Primaire** : #2563eb (Bleu)
- **Accent** : #06b6d4 (Cyan)
- **Succès** : #22c55e (Vert)
- **Danger** : #ef4444 (Rouge)
- **Arrière-plan** : #f0f2f5 (Gris clair)
- **Sidebar** : #0f1729 (Bleu foncé)

### Responsive
- Desktop : Layout complet
- Tablet : 1-2 colonnes
- Mobile : 1 colonne, sidebar cachée

## 📝 Exemples d'Utilisation

### Voir les notes S3 d'un étudiant
```
GET /student/1/details/s3
```

### Voir les notes S4 - Option Dev
```
GET /student/1/details/s4?option=1
```

### Voir les notes L2
```
GET /student/1/details/l2
```

### Modifier une note
```javascript
fetch('/student/update-note', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/x-www-form-urlencoded',
    'X-Requested-With': 'XMLHttpRequest'
  },
  body: 'eleve_id=1&matiere_id=1&note=15.5'
})
.then(r => r.json())
.then(data => console.log(data))
```

## 🔍 Calcul des Moyennes

### Moyenne Pondérée
```
Moyenne = (∑(Note × Crédit)) / ∑Crédit
```

### Règles Appliquées
1. Grouper par matière → garder note maximale
2. Grouper les optionnelles par option → garder meilleure note
3. Calculer la moyenne pondérée
4. Exclure les matières non de l'option pour S4

## 📊 Données de Test

L'étudiant "Rakoto" est fourni avec :
- **S3** : 6 matières obligatoires
- **S4** : Option "Dev" avec 5 matières
- Notes variables pour tester les différents cas

## 🐛 Troubleshooting

### Erreur "Base de données indisponible"
Vérifier la configuration .env et les paramètres MySQL

### Les vues ne s'affichent pas
Vérifier que les fichiers sont bien dans `app/Views/student/`

### Les notes ne se sauvegardent pas
Vérifier la console du navigateur pour les erreurs AJAX

## 📞 Support

Pour les questions ou problèmes, consultez :
- Documentation CodeIgniter 4
- Les commentaires du code source
- Les logs dans `writable/logs/`

---

**Version**: 1.0.0  
**Framework**: CodeIgniter 4  
**Base de données**: MySQL 5.7+
