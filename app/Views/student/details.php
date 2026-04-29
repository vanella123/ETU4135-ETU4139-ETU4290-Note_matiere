<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= $title ?? 'Détails'; ?> — SysInfo</title>
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
      <div class="topbar-title">Détails des Notes</div>
      <div class="topbar-actions">
        <a href="<?= base_url('student') ?>" class="icon-btn" title="Retour">
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

        <div class="student-actions">
          <a href="<?= base_url('student/' . $etudiant['id'] . '/edit-notes') ?>" class="btn btn-secondary">
            <svg viewBox="0 0 24 24" width="16"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            Modifier les notes
          </a>
        </div>
      </div>

      <!-- Onglets de navigation -->
      <div class="tabs-nav">
        <a href="<?= base_url('student/' . $etudiant['id'] . '/details/s3') ?>" class="tab-item <?= ($type === 's3') ? 'active' : '' ?>">
          S3
        </a>
        <a href="<?= base_url('student/' . $etudiant['id'] . '/details/s4') ?>" class="tab-item <?= ($type === 's4') ? 'active' : '' ?>">
          S4
        </a>
        <a href="<?= base_url('student/' . $etudiant['id'] . '/details/l2') ?>" class="tab-item <?= ($type === 'l2') ? 'active' : '' ?>">
          L2
        </a>
      </div>

      <!-- Affichage des notes S4 par option si demandé -->
      <?php if ($type === 's4' && !empty($etudiant['options'])): ?>
        <div class="options-selector">
          <label>Filtre par option:</label>
          <div class="option-buttons">
            <a href="<?= base_url('student/' . $etudiant['id'] . '/details/s4') ?>" class="btn-option <?= ($optionId === null) ? 'active' : '' ?>">
              Toutes les options
            </a>
            <?php foreach ($etudiant['options'] as $option): ?>
              <?php if ($option['semestre_nom'] === 'S4'): ?>
                <a href="<?= base_url('student/' . $etudiant['id'] . '/details/s4?option=' . $option['id_option']) ?>" class="btn-option <?= ($optionId == $option['id_option']) ? 'active' : '' ?>">
                  <?= ucfirst(esc($option['option_nom'])) ?>
                </a>
              <?php endif; ?>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endif; ?>

      <!-- Affichage des notes -->
      <div class="notes-section">
        <div class="section-header">
          <h2><?= $titre ?></h2>
          <div class="section-stat">
            <span class="stat-label">Moyenne:</span>
            <span class="stat-value"><?= number_format($moyenne, 2) ?>/20</span>
          </div>
        </div>

        <?php if (!empty($notes)): ?>
          <div class="notes-table-container">
            <table class="notes-table">
              <thead>
                <tr>
                  <th>Matière</th>
                  <th>UE</th>
                  <th>Crédit</th>
                  <th>Note</th>
                  <th>Option</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($notes as $note): ?>
                  <tr>
                    <td class="matiere-cell"><?= esc($note['matiere_nom']) ?></td>
                    <td><?= esc($note['ue']) ?></td>
                    <td class="credit-cell"><?= $note['credit'] ?></td>
                    <td class="note-cell">
                      <span class="note-badge <?= ($note['note'] >= 12) ? 'good' : (($note['note'] >= 10) ? 'medium' : 'low') ?>">
                        <?= number_format($note['note'], 2) ?>
                      </span>
                    </td>
                    <td>
                      <?php if ($note['option_nom']): ?>
                        <span class="option-badge"><?= ucfirst(esc($note['option_nom'])) ?></span>
                      <?php else: ?>
                        <span class="text-muted">—</span>
                      <?php endif; ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>

          <!-- Résumé L2 -->
          <?php if ($type === 'l2'): ?>
            <div class="summary-box">
              <div class="summary-item">
                <span class="summary-label">Moyenne S3:</span>
                <span class="summary-value"><?= number_format($stats['moyenne_s3'], 2) ?>/20</span>
              </div>
              <div class="summary-item">
                <span class="summary-label">Moyenne S4:</span>
                <span class="summary-value"><?= number_format($stats['moyenne_s4'], 2) ?>/20</span>
              </div>
              <div class="summary-item highlight">
                <span class="summary-label">Moyenne Générale L2:</span>
                <span class="summary-value"><?= number_format($stats['moyenne_generale'], 2) ?>/20</span>
              </div>
            </div>
          <?php endif; ?>

        <?php else: ?>
          <div class="empty-state">
            <svg viewBox="0 0 24 24" width="48" height="48"><line x1="21" y1="4" x2="3" y2="4"/><line x1="21" y1="4" x2="21" y2="20" stroke-width="2"/><line x1="21" y1="20" x2="3" y2="20"/><line x1="3" y1="4" x2="3" y2="20"/><line x1="7" y1="8" x2="7" y2="16"/><line x1="11" y1="8" x2="11" y2="16"/><line x1="15" y1="8" x2="15" y2="16"/><line x1="17" y1="8" x2="17" y2="16"/></svg>
            <h3>Aucune note disponible</h3>
            <p>Aucune note n'a été saisie pour cette période</p>
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

.tabs-nav {
  display: flex;
  gap: 10px;
  margin-bottom: 20px;
  border-bottom: 2px solid #e9ecef;
}

.tab-item {
  padding: 10px 20px;
  border: none;
  background: none;
  cursor: pointer;
  font-size: 16px;
  color: #495057;
  border-bottom: 3px solid transparent;
  transition: all 0.3s ease;
}

.tab-item:hover {
  color: #667eea;
}

.tab-item.active {
  color: #667eea;
  border-bottom-color: #667eea;
}

.options-selector {
  margin-bottom: 20px;
  padding: 15px;
  background: #f8f9fa;
  border-radius: 8px;
}

.options-selector label {
  display: block;
  margin-bottom: 10px;
  font-weight: 600;
}

.option-buttons {
  display: flex;
  gap: 10px;
  flex-wrap: wrap;
}

.btn-option {
  padding: 8px 16px;
  border: 2px solid #dee2e6;
  background: white;
  border-radius: 6px;
  cursor: pointer;
  transition: all 0.3s ease;
  text-decoration: none;
}

.btn-option:hover {
  border-color: #667eea;
  color: #667eea;
}

.btn-option.active {
  background: #667eea;
  color: white;
  border-color: #667eea;
}

.notes-section {
  background: white;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.section-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 20px;
  border-bottom: 1px solid #e9ecef;
}

.section-header h2 {
  margin: 0;
  font-size: 18px;
}

.section-stat {
  text-align: right;
}

.stat-label {
  display: block;
  font-size: 12px;
  color: #6c757d;
  margin-bottom: 5px;
}

.stat-value {
  display: block;
  font-size: 24px;
  font-weight: bold;
  color: #667eea;
}

.notes-table-container {
  overflow-x: auto;
}

.notes-table {
  width: 100%;
  border-collapse: collapse;
}

.notes-table thead {
  background: #f8f9fa;
}

.notes-table th {
  padding: 12px 15px;
  text-align: left;
  font-weight: 600;
  color: #495057;
  border-bottom: 2px solid #dee2e6;
}

.notes-table td {
  padding: 12px 15px;
  border-bottom: 1px solid #e9ecef;
}

.matiere-cell {
  font-weight: 500;
}

.credit-cell {
  text-align: center;
}

.note-cell {
  text-align: center;
}

.note-badge {
  display: inline-block;
  padding: 4px 12px;
  border-radius: 20px;
  font-weight: 600;
  font-size: 14px;
}

.note-badge.good {
  background: #d4edda;
  color: #155724;
}

.note-badge.medium {
  background: #fff3cd;
  color: #856404;
}

.note-badge.low {
  background: #f8d7da;
  color: #721c24;
}

.option-badge {
  display: inline-block;
  padding: 4px 8px;
  background: #e7f3ff;
  color: #0056b3;
  border-radius: 4px;
  font-size: 12px;
  font-weight: 600;
}

.summary-box {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 15px;
  padding: 20px;
  background: #f8f9fa;
  border-top: 1px solid #e9ecef;
}

.summary-item {
  text-align: center;
  padding: 15px;
  background: white;
  border-radius: 6px;
  border: 1px solid #dee2e6;
}

.summary-item.highlight {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  border: none;
}

.summary-label {
  display: block;
  font-size: 12px;
  margin-bottom: 8px;
  opacity: 0.8;
}

.summary-value {
  display: block;
  font-size: 20px;
  font-weight: bold;
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

</body>
</html>
