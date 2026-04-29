<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SysInfo — Ajouter une note</title>
  <link rel="stylesheet" href="<?= base_url('css/style.css') ?>" />
</head>
<body>

<div class="app">
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

    <a href="<?= base_url('dashboard') ?>" class="nav-item">
      <svg viewBox="0 0 24 24"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
      Tableau de bord
    </a>
    <a href="<?= base_url('eleves') ?>" class="nav-item">
      <svg viewBox="0 0 24 24"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
      Étudiants
    </a>
    <a href="<?= base_url('bulletin/create') ?>" class="nav-item active">
      <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
      Ajouter une note
    </a>
  </aside>

  <div class="main">
    <div class="topbar">
      <div class="topbar-title">Ajouter une note</div>
      <div class="topbar-search">
        <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="text" placeholder="Rechercher…" />
      </div>
      <div class="topbar-actions">
        <button class="icon-btn" type="button">
          <svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
        </button>
        <button class="icon-btn" type="button">
          <svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M20 21a8 8 0 1 0-16 0"/></svg>
        </button>
      </div>
    </div>

    <div class="content">
      <div class="page-header">
        <div>
          <h2>Formulaire de note</h2>
          <div class="breadcrumb">Accueil / Bulletins / <span>Nouvelle note</span></div>
        </div>
        <a href="<?= base_url('eleves') ?>" class="btn btn-secondary btn-sm">
          <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
          Voir les étudiants
        </a>
      </div>

      <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-info">
          <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
          <span><?= esc(session()->getFlashdata('success')) ?></span>
        </div>
      <?php endif; ?>

      <?php $errors = session()->getFlashdata('errors') ?? []; ?>
      <?php if (! empty($errors)): ?>
        <div class="alert alert-error">
          <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
          <div>
            <?php foreach ($errors as $error): ?>
              <div><?= esc($error) ?></div>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endif; ?>

      <div class="form-card">
        <div class="form-section-title">Saisie d'une note</div>
        <p class="field-hint" style="margin-bottom:20px">Enregistrez une note, puis revenez sur ce formulaire pour saisir la suivante.</p>

        <form method="post" action="<?= base_url('bulletin/store') ?>">
          <?= csrf_field() ?>

          <div class="form-grid">
            <div>
              <label class="field-label" for="id_eleve">Étudiant</label>
              <select id="id_eleve" name="id_eleve" required>
                <option value="">— Sélectionner —</option>
                <?php foreach ($eleves as $e): ?>
                  <option value="<?= esc($e['id']) ?>" <?= old('id_eleve') == $e['id'] ? 'selected' : '' ?>>
                    <?= esc($e['nom']) ?><?= ! empty($e['classe']) ? ' - ' . esc($e['classe']) : '' ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div>
              <label class="field-label" for="id_option">Option</label>
              <select id="id_option" name="id_option" required>
                <option value="">— Sélectionner —</option>
                <?php foreach ($options as $o): ?>
                  <option value="<?= esc($o['id']) ?>" <?= old('id_option') == $o['id'] ? 'selected' : '' ?>>
                    <?= esc($o['nom']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div>
              <label class="field-label" for="id_matiere">Matière</label>
              <select id="id_matiere" name="id_matiere" required>
                <option value="">— Sélectionner —</option>
                <?php foreach ($matieres as $m): ?>
                  <option value="<?= esc($m['id']) ?>" <?= old('id_matiere') == $m['id'] ? 'selected' : '' ?>>
                    <?= esc($m['ue']) ?> - <?= esc($m['nom']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div>
              <label class="field-label" for="note">Note /20</label>
              <input id="note" name="note" type="number" step="0.01" min="0" max="20" value="<?= old('note') ?>" placeholder="Ex: 14.5" required />
            </div>
          </div>

          <div class="form-grid cols-1">
            <div>
              <label class="field-label" for="resultat">Résultat</label>
              <select id="resultat" name="resultat" required>
                <option value="">— Sélectionner —</option>
                <?php foreach (['P', 'AB', 'B', 'Comp.'] as $resultat): ?>
                  <option value="<?= esc($resultat) ?>" <?= old('resultat') === $resultat ? 'selected' : '' ?>>
                    <?= esc($resultat) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <div class="form-footer">
            <a href="<?= base_url('dashboard') ?>" class="btn btn-secondary">Retour au tableau de bord</a>
            <button type="submit" class="btn btn-primary">
              <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
              Enregistrer la note
            </button>
          </div>
        </form>
      </div>

      <div class="table-card" style="margin-top:20px">
        <table>
          <thead>
            <tr>
              <th>Nom</th>
              <th>Classe</th>
              <th>Utiliser</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($eleves as $e): ?>
              <tr>
                <td>
                  <div style="display:flex;align-items:center;gap:10px">
                    <div class="avatar-sm"><?= strtoupper(substr($e['nom'], 0, 2)) ?></div>
                    <div>
                      <div style="font-weight:600"><?= esc($e['nom']) ?></div>
                    </div>
                  </div>
                </td>
                <td><?= esc($e['classe'] ?? '') ?></td>
                <td><span class="badge badge-blue">Sélectionnable</span></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

</body>
</html>
