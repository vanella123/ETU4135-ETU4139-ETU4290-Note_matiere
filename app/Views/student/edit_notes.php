<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= $title ?? 'Modifier'; ?> — SysInfo</title>
  <link rel="stylesheet" href="<?= base_url('css/style.css') ?>" />
</head>
<body>

<div class="app">

  <!-- ── Sidebar ──────────────────────────────────────────────────────────── -->
  <aside class="sidebar">
    <div class="sidebar-brand">
      <div class="logo-icon">
        <svg viewBox="0 0 24 24" width="18" height="18"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
      </div>
      <div>
        <div class="brand-name">SysInfo</div>
        <div class="brand-sub">v2.4.0</div>
      </div>
    </div>

    <div class="sidebar-section">Navigation</div>

    <a href="<?= base_url('student') ?>" class="nav-item">
      <svg viewBox="0 0 24 24"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
      Étudiants
    </a>

    <div class="sidebar-section">Système</div>

    <a href="#" class="nav-item">
      <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14"/></svg>
      Paramètres
    </a>

    <div class="sidebar-bottom">
      <a href="#" class="user-row">
        <div class="avatar">AD</div>
        <div class="user-info">
          <div class="name">Admin Sys</div>
          <div class="role">Super administrateur</div>
        </div>
      </a>
    </div>
  </aside>

  <!-- ── Main ─────────────────────────────────────────────────────────────── -->
  <div class="main">

    <div class="topbar">
      <div class="topbar-title">Modification des Notes</div>
      <div class="topbar-actions">
        <a href="<?= base_url('student/' . $etudiant['id'] . '/details') ?>" class="icon-btn" title="Retour">
          <svg viewBox="0 0 24 24"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        </a>
      </div>
    </div>

    <div class="content">

      <div class="student-header">
        <div class="student-header-info">
          <div class="avatar-xl">
            <?= strtoupper(substr($etudiant['nom'], 0, 2)) ?>
          </div>
          <div>
            <h1><?= esc($etudiant['nom']) ?></h1>
            <p class="text-muted">Classe: L2 | ID: <?= $etudiant['id'] ?></p>
          </div>
        </div>
      </div>

      <div class="edit-notes-container">
        <h2>Modifier les notes</h2>
        <p class="help-text">Cliquez sur une note pour la modifier. Les notes doivent être entre 0 et 20.</p>

        <?php if (!empty($notes)): ?>
          <div class="notes-edit-grid">
            <?php 
            $currentSemestre = null;
            foreach ($notes as $note): 
            ?>
              <?php if ($currentSemestre !== $note['semestre_nom']): ?>
                <?php if ($currentSemestre !== null): ?>
                  </div>
                <?php endif; ?>
                <div class="semestre-group">
                  <h3><?= $note['semestre_nom'] ?></h3>
                  <div class="notes-edit-list">
              <?php 
              $currentSemestre = $note['semestre_nom'];
              endif; 
              ?>

              <div class="note-edit-item">
                <div class="note-edit-info">
                  <div class="matiere-name"><?= esc($note['matiere_nom']) ?></div>
                  <div class="matiere-meta">
                    <span><?= esc($note['ue']) ?></span>
                    <span class="credit-tag"><?= $note['credit'] ?> crédits</span>
                    <?php if ($note['option_nom']): ?>
                      <span class="option-tag"><?= ucfirst(esc($note['option_nom'])) ?></span>
                    <?php endif; ?>
                  </div>
                </div>
                <div class="note-edit-input-group">
                  <input type="number" 
                         class="note-input" 
                         min="0" 
                         max="20" 
                         step="0.01"
                         value="<?= $note['note'] ?>"
                         data-eleve-id="<?= $etudiant['id'] ?>"
                         data-matiere-id="<?= $note['id_matiere'] ?>"
                         data-current-note="<?= $note['note'] ?>">
                  <span class="note-status"></span>
                </div>
              </div>

            <?php endforeach; ?>
              </div>
                  </div>
        <?php else: ?>
          <div class="empty-state">
            <svg viewBox="0 0 24 24" width="48" height="48"><line x1="21" y1="4" x2="3" y2="4"/><line x1="21" y1="4" x2="21" y2="20" stroke-width="2"/><line x1="21" y1="20" x2="3" y2="20"/><line x1="3" y1="4" x2="3" y2="20"/><line x1="7" y1="8" x2="7" y2="16"/><line x1="11" y1="8" x2="11" y2="16"/><line x1="15" y1="8" x2="15" y2="16"/><line x1="17" y1="8" x2="17" y2="16"/></svg>
            <h3>Aucune note disponible</h3>
            <p>Aucune note n'a été saisie pour cet étudiant</p>
          </div>
        <?php endif; ?>

      </div>

    </div>

  </div>

</div>

<style>
.student-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 20px;
  background: #f8f9fa;
  border-radius: 8px;
  margin-bottom: 20px;
}

.student-header-info {
  display: flex;
  align-items: center;
  gap: 15px;
}

.avatar-xl {
  width: 60px;
  height: 60px;
  border-radius: 50%;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: bold;
  font-size: 20px;
}

.student-header h1 {
  margin: 0;
  font-size: 24px;
}

.text-muted {
  color: #6c757d;
  font-size: 14px;
}

.edit-notes-container {
  background: white;
  border-radius: 8px;
  padding: 20px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.edit-notes-container h2 {
  margin-top: 0;
  margin-bottom: 10px;
  font-size: 20px;
}

.help-text {
  color: #6c757d;
  font-size: 14px;
  margin-bottom: 20px;
}

.notes-edit-grid {
  display: grid;
  gap: 20px;
}

.semestre-group h3 {
  margin: 0 0 15px 0;
  padding: 10px 15px;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  border-radius: 6px;
  font-size: 16px;
}

.notes-edit-list {
  display: grid;
  gap: 10px;
}

.note-edit-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 12px;
  background: #f8f9fa;
  border-radius: 6px;
  border: 1px solid #e9ecef;
  transition: all 0.3s ease;
}

.note-edit-item:hover {
  border-color: #667eea;
  background: #f0f2ff;
}

.note-edit-info {
  flex: 1;
  min-width: 0;
}

.matiere-name {
  font-weight: 600;
  color: #212529;
  margin-bottom: 5px;
}

.matiere-meta {
  display: flex;
  gap: 10px;
  font-size: 12px;
  color: #6c757d;
  flex-wrap: wrap;
}

.credit-tag {
  background: #e9ecef;
  padding: 2px 8px;
  border-radius: 4px;
}

.option-tag {
  background: #e7f3ff;
  color: #0056b3;
  padding: 2px 8px;
  border-radius: 4px;
  font-weight: 600;
}

.note-edit-input-group {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-left: 15px;
}

.note-input {
  width: 80px;
  padding: 8px 12px;
  border: 2px solid #dee2e6;
  border-radius: 6px;
  font-size: 14px;
  font-weight: 600;
  text-align: center;
  transition: all 0.3s ease;
}

.note-input:focus {
  outline: none;
  border-color: #667eea;
  box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.note-status {
  width: 20px;
  height: 20px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 16px;
}

.note-status.saving::before {
  content: '⏳';
}

.note-status.success::before {
  content: '✓';
  color: #28a745;
}

.note-status.error::before {
  content: '✗';
  color: #dc3545;
}

.empty-state {
  text-align: center;
  padding: 40px 20px;
  color: #6c757d;
}

.empty-state svg {
  margin-bottom: 20px;
  opacity: 0.5;
}

.empty-state h3 {
  margin: 10px 0;
  font-size: 18px;
}

.empty-state p {
  margin: 0;
  font-size: 14px;
}
</style>

<script>
document.querySelectorAll('.note-input').forEach(input => {
  let timeout;

  input.addEventListener('change', function() {
    const eleveId = this.getAttribute('data-eleve-id');
    const matiereId = this.getAttribute('data-matiere-id');
    const noteValue = this.value;
    const statusEl = this.nextElementSibling;

    if (noteValue === this.getAttribute('data-current-note')) {
      return; // Pas de changement
    }

    if (isNaN(noteValue) || noteValue < 0 || noteValue > 20) {
      statusEl.className = 'note-status error';
      setTimeout(() => {
        statusEl.className = 'note-status';
      }, 3000);
      this.value = this.getAttribute('data-current-note');
      return;
    }

    statusEl.className = 'note-status saving';

    fetch('<?= base_url('student/update-note') ?>', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
        'X-Requested-With': 'XMLHttpRequest'
      },
      body: 'eleve_id=' + eleveId + '&matiere_id=' + matiereId + '&note=' + noteValue
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        statusEl.className = 'note-status success';
        this.setAttribute('data-current-note', noteValue);
        setTimeout(() => {
          statusEl.className = 'note-status';
        }, 3000);
      } else {
        statusEl.className = 'note-status error';
        this.value = this.getAttribute('data-current-note');
        setTimeout(() => {
          statusEl.className = 'note-status';
        }, 3000);
      }
    })
    .catch(error => {
      statusEl.className = 'note-status error';
      this.value = this.getAttribute('data-current-note');
      setTimeout(() => {
        statusEl.className = 'note-status';
      }, 3000);
    });
  });
});
</script>

</body>
</html>
