# Documentation API - Gestion des Notes

## 📚 Endpoints

### 1. Liste des Étudiants
```
GET /student
```
Retourne la vue HTML listant tous les étudiants

**Réponse**: Vue HTML avec grille des étudiants

---

### 2. Détails des Notes - Tous les Semestres
```
GET /student/{id}/details
```
Affiche toutes les notes (S3 + S4) avec moyenne générale

**Paramètres**:
- `id` (entier) : ID de l'étudiant

**Réponse**: Vue HTML avec toutes les notes

---

### 3. Détails des Notes - Semestre 3
```
GET /student/{id}/details/s3
```
Affiche uniquement les notes du Semestre 3

**Paramètres**:
- `id` (entier) : ID de l'étudiant

**Réponse**: Vue HTML avec notes S3 + moyenne S3

---

### 4. Détails des Notes - Semestre 4
```
GET /student/{id}/details/s4
```
Affiche les notes du Semestre 4

**Paramètres**:
- `id` (entier) : ID de l'étudiant
- `option` (entier, optionnel) : ID de l'option (1=Dev, 2=BDDRes, 3=Web)

**Réponse**: Vue HTML avec notes S4 filtrées + moyenne S4

**Exemple**:
```
GET /student/1/details/s4?option=1
```

---

### 5. Détails des Notes - Licence 2 Complète
```
GET /student/{id}/details/l2
```
Affiche toutes les notes (S3 + S4) avec résumé complet

**Paramètres**:
- `id` (entier) : ID de l'étudiant

**Réponse**: Vue HTML avec:
- Toutes les notes des 2 semestres
- Moyenne S3
- Moyenne S4
- Moyenne Générale L2

---

### 6. Formulaire de Modification des Notes
```
GET /student/{id}/edit-notes
```
Affiche le formulaire d'édition des notes

**Paramètres**:
- `id` (entier) : ID de l'étudiant

**Réponse**: Vue HTML avec formulaire d'édition

---

### 7. Mise à Jour d'une Note (AJAX)
```
POST /student/update-note
```
Sauvegarde une note modifiée

**Headers**:
```
Content-Type: application/x-www-form-urlencoded
X-Requested-With: XMLHttpRequest
```

**Paramètres**:
| Paramètre | Type | Description |
|-----------|------|-------------|
| `eleve_id` | entier | ID de l'étudiant |
| `matiere_id` | entier | ID de la matière |
| `note` | décimal | Note (0-20) |

**Réponse (Succès)**:
```json
{
  "success": true,
  "message": "Note mise à jour avec succès"
}
```

**Réponse (Erreur de validation)**:
```json
{
  "success": false,
  "message": "La note doit être entre 0 et 20"
}
```

**Réponse (Données manquantes)**:
```json
{
  "success": false,
  "message": "Données incomplètes"
}
```

**Exemple cURL**:
```bash
curl -X POST http://localhost:8080/student/update-note \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -H "X-Requested-With: XMLHttpRequest" \
  -d "eleve_id=1&matiere_id=1&note=15.5"
```

**Exemple JavaScript**:
```javascript
fetch('/student/update-note', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/x-www-form-urlencoded',
    'X-Requested-With': 'XMLHttpRequest'
  },
  body: new URLSearchParams({
    eleve_id: 1,
    matiere_id: 1,
    note: 15.5
  })
})
.then(response => response.json())
.then(data => {
  if (data.success) {
    console.log('Note sauvegardée');
  } else {
    console.error(data.message);
  }
});
```

---

## 🔧 Codes de Réponse HTTP

| Code | Signification |
|------|---------------|
| 200 | OK - Requête réussie |
| 404 | Not Found - Étudiant introuvable |
| 400 | Bad Request - Paramètres invalides |
| 405 | Method Not Allowed - Mauvaise méthode HTTP |

---

## 📊 Structures de Données

### Étudiant
```json
{
  "id": 1,
  "nom": "Rakoto",
  "id_classe": 1,
  "options": [
    {
      "id": 1,
      "id_eleve": 1,
      "id_semestre": 2,
      "id_option": 1,
      "option_nom": "dev",
      "semestre_nom": "S4"
    }
  ]
}
```

### Note
```json
{
  "id": 1,
  "id_eleve": 1,
  "id_matiere": 1,
  "note": 10.5,
  "matiere_nom": "Programmation orientée objet",
  "ue": "INF201",
  "credit": 6,
  "id_option": null,
  "option_nom": null,
  "semestre_nom": "S3"
}
```

### Statistiques Étudiant
```json
{
  "notes_s3": [/* array de notes S3 */],
  "notes_s4": [/* array de notes S4 */],
  "all_notes": [/* array de toutes les notes */],
  "moyenne_s3": 10.97,
  "moyenne_s4": 12.15,
  "moyenne_generale": 11.56
}
```

---

## 🎯 Cas d'Usage

### Afficher toutes les notes d'un étudiant
```
GET /student/1/details
```

### Afficher uniquement les notes S3
```
GET /student/1/details/s3
```

### Afficher S4 pour l'option Développement
```
GET /student/1/details/s4?option=1
```

### Afficher le bilan L2 complet
```
GET /student/1/details/l2
```

### Modifier la note de POO pour l'étudiant 1
```
POST /student/update-note
Body: eleve_id=1&matiere_id=1&note=12.5
```

---

## ⚠️ Validations

### Création/Modification de Note
- `note` doit être un décimal
- `note` doit être >= 0
- `note` doit être <= 20
- `eleve_id` doit exister
- `matiere_id` doit exister

### Format des Réponses AJAX
- Content-Type: `application/json`
- Tous les champs retournent `success` (booléen)
- Message d'erreur toujours fourni en cas d'échec

---

## 🔄 Flux de Données

```
Utilisateur
    ↓
Navigateur (UI)
    ↓
StudentController
    ↓
EleveModel / NoteModel
    ↓
Base de Données
```

### Consultation des notes (GET)
```
1. GET /student/1/details/s3
2. StudentController::details($id, 's3')
3. EleveModel::getNotesS3($id)
4. Requête BD → Récupère notes S3
5. EleveModel::calculerMoyenne()
6. Vue affiche les résultats
```

### Modification de note (POST)
```
1. POST /student/update-note
2. StudentController::updateNote()
3. NoteModel::updateNote($eleve, $matiere, $note)
4. Requête BD → Insère/Met à jour
5. JSON response → Frontend
6. Frontend met à jour l'UI
```

---

## 📝 Exemple Complet

### Scénario: Consulter et modifier les notes d'un étudiant

**Étape 1: Accéder à la liste**
```
GET /student → Affiche grille d'étudiants
```

**Étape 2: Consulter les notes S3**
```
GET /student/1/details/s3
→ Affiche 6 matières + moyenne S3
```

**Étape 3: Aller au formulaire d'édition**
```
GET /student/1/edit-notes
→ Affiche tous les champs éditables
```

**Étape 4: Modifier une note**
```
POST /student/update-note
{eleve_id: 1, matiere_id: 1, note: 12.5}
← {success: true, message: "..."}
```

**Étape 5: Retour aux détails pour voir la moyenne mise à jour**
```
GET /student/1/details/s3
→ Nouvelle moyenne s'affiche
```

---

## 🐛 Débogage

### Activer les logs
Vérifier `writable/logs/log-*.log`

### Inspecter les requêtes AJAX
```javascript
// Dans la console du navigateur
fetch('/student/update-note', {...})
  .then(r => {
    console.log('Status:', r.status);
    return r.json();
  })
  .then(d => console.log('Response:', d))
  .catch(e => console.error('Error:', e));
```

### Vérifier la base de données
```sql
SELECT * FROM note WHERE id_eleve = 1;
SELECT * FROM eleve_option WHERE id_eleve = 1;
```

---

**Version API**: 1.0.0  
**Framework**: CodeIgniter 4  
**Format**: REST JSON
