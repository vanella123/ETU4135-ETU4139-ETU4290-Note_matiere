#!/bin/bash

# ════════════════════════════════════════════════════════════════════════════
# SCRIPT DE VÉRIFICATION DU PROJET
# Gestion des Notes - CodeIgniter 4
# ════════════════════════════════════════════════════════════════════════════

echo "🔍 Vérification de la structure du projet..."
echo ""

# Colors
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Compteurs
PASSED=0
FAILED=0

# Fonction de test
check_file() {
    if [ -f "$1" ]; then
        echo -e "${GREEN}✓${NC} $1"
        ((PASSED++))
    else
        echo -e "${RED}✗${NC} $1 (MANQUANT)"
        ((FAILED++))
    fi
}

check_directory() {
    if [ -d "$1" ]; then
        echo -e "${GREEN}✓${NC} $1/"
        ((PASSED++))
    else
        echo -e "${RED}✗${NC} $1/ (MANQUANT)"
        ((FAILED++))
    fi
}

# ─────────────────────────────────────────────────────────────────────────────
# VÉRIFICATION DES MODÈLES
# ─────────────────────────────────────────────────────────────────────────────
echo -e "${YELLOW}=== MODÈLES ===${NC}"
check_file "app/Models/EleveModel.php"
check_file "app/Models/NoteModel.php"
echo ""

# ─────────────────────────────────────────────────────────────────────────────
# VÉRIFICATION DES CONTRÔLEURS
# ─────────────────────────────────────────────────────────────────────────────
echo -e "${YELLOW}=== CONTRÔLEURS ===${NC}"
check_file "app/Controllers/StudentController.php"
echo ""

# ─────────────────────────────────────────────────────────────────────────────
# VÉRIFICATION DES VUES
# ─────────────────────────────────────────────────────────────────────────────
echo -e "${YELLOW}=== VUES ===${NC}"
check_directory "app/Views/student"
check_file "app/Views/student/list.php"
check_file "app/Views/student/details.php"
check_file "app/Views/student/edit_notes.php"
echo ""

# ─────────────────────────────────────────────────────────────────────────────
# VÉRIFICATION DES HELPERS
# ─────────────────────────────────────────────────────────────────────────────
echo -e "${YELLOW}=== HELPERS ===${NC}"
check_file "app/Helpers/NoteHelper.php"
echo ""

# ─────────────────────────────────────────────────────────────────────────────
# VÉRIFICATION DE LA CONFIGURATION
# ─────────────────────────────────────────────────────────────────────────────
echo -e "${YELLOW}=== CONFIGURATION ===${NC}"
check_file "app/Config/Routes.php"
check_file ".env"
echo ""

# ─────────────────────────────────────────────────────────────────────────────
# VÉRIFICATION DES FICHIERS CSS/JS
# ─────────────────────────────────────────────────────────────────────────────
echo -e "${YELLOW}=== ASSETS ===${NC}"
check_file "public/css/style.css"
echo ""

# ─────────────────────────────────────────────────────────────────────────────
# VÉRIFICATION DE LA DOCUMENTATION
# ─────────────────────────────────────────────────────────────────────────────
echo -e "${YELLOW}=== DOCUMENTATION ===${NC}"
check_file "INSTALLATION.md"
check_file "API_DOCUMENTATION.md"
check_file "DEPLOYMENT.md"
check_file "RESUME_IMPLEMENTATION.md"
check_file "TESTING.php"
check_file "Database_Updated.sql"
check_file "test_data.sql"
echo ""

# ─────────────────────────────────────────────────────────────────────────────
# VÉRIFICATION DE LA BASE DE DONNÉES
# ─────────────────────────────────────────────────────────────────────────────
echo -e "${YELLOW}=== BASE DE DONNÉES ===${NC}"
check_file "Database.sql"
check_file "Donnes.sql"
echo ""

# ─────────────────────────────────────────────────────────────────────────────
# VÉRIFICATION DES PERMISSIONS
# ─────────────────────────────────────────────────────────────────────────────
echo -e "${YELLOW}=== PERMISSIONS ===${NC}"
if [ -w "writable/" ]; then
    echo -e "${GREEN}✓${NC} writable/ est accessible en écriture"
    ((PASSED++))
else
    echo -e "${RED}✗${NC} writable/ n'est pas accessible en écriture"
    ((FAILED++))
fi
echo ""

# ─────────────────────────────────────────────────────────────────────────────
# VÉRIFICATION DES DÉPENDANCES
# ─────────────────────────────────────────────────────────────────────────────
echo -e "${YELLOW}=== DÉPENDANCES ===${NC}"
if command -v php &> /dev/null; then
    PHP_VERSION=$(php -v | head -n1)
    echo -e "${GREEN}✓${NC} PHP: $PHP_VERSION"
    ((PASSED++))
else
    echo -e "${RED}✗${NC} PHP non trouvé"
    ((FAILED++))
fi

if command -v mysql &> /dev/null; then
    MYSQL_VERSION=$(mysql --version)
    echo -e "${GREEN}✓${NC} MySQL: $MYSQL_VERSION"
    ((PASSED++))
else
    echo -e "${YELLOW}⚠${NC} MySQL CLI non trouvé (peut être OK si utilisant via PHP)"
fi

if [ -d "vendor/" ]; then
    echo -e "${GREEN}✓${NC} vendor/ (dépendances Composer)"
    ((PASSED++))
else
    echo -e "${RED}✗${NC} vendor/ (Composer non exécuté)"
    ((FAILED++))
fi
echo ""

# ─────────────────────────────────────────────────────────────────────────────
# VÉRIFICATION DU CODE
# ─────────────────────────────────────────────────────────────────────────────
echo -e "${YELLOW}=== VÉRIFICATION DU CODE ===${NC}"

# Vérifier la syntaxe PHP
for php_file in app/Controllers/StudentController.php app/Models/EleveModel.php app/Models/NoteModel.php; do
    if php -l "$php_file" > /dev/null 2>&1; then
        echo -e "${GREEN}✓${NC} $php_file (syntaxe OK)"
        ((PASSED++))
    else
        echo -e "${RED}✗${NC} $php_file (erreur de syntaxe)"
        ((FAILED++))
    fi
done
echo ""

# ─────────────────────────────────────────────────────────────────────────────
# RÉSUMÉ
# ─────────────────────────────────────────────────────────────────────────────
echo -e "${YELLOW}=== RÉSUMÉ ===${NC}"
TOTAL=$((PASSED + FAILED))
echo -e "Total: $TOTAL vérifications"
echo -e "${GREEN}Succès: $PASSED${NC}"
if [ $FAILED -gt 0 ]; then
    echo -e "${RED}Échecs: $FAILED${NC}"
else
    echo -e "${GREEN}Échecs: 0${NC}"
fi
echo ""

# ─────────────────────────────────────────────────────────────────────────────
# INSTRUCTIONS SUIVANTES
# ─────────────────────────────────────────────────────────────────────────────
echo -e "${YELLOW}=== ÉTAPES SUIVANTES ===${NC}"
echo "1. Configurer .env avec les paramètres MySQL"
echo "2. Importer la base de données:"
echo "   mysql -u root < Database.sql"
echo "   mysql -u root gestion_bulletin < Donnes.sql"
echo "3. Lancer le serveur de développement:"
echo "   php spark serve"
echo "4. Accéder à: http://localhost:8080/student"
echo ""

# ─────────────────────────────────────────────────────────────────────────────
# CONCLUSION
# ─────────────────────────────────────────────────────────────────────────────
if [ $FAILED -eq 0 ]; then
    echo -e "${GREEN}✓ Vérification complète! Prêt pour le déploiement.${NC}"
    exit 0
else
    echo -e "${RED}✗ Quelques fichiers sont manquants. Consultez la liste ci-dessus.${NC}"
    exit 1
fi
