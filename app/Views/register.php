<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SysInfo — Inscription</title>
  <link rel="stylesheet" href="<?= base_url('css/style.css') ?>" />
</head>
<body>

<div class="login-page">
  <div class="login-card">
    <div class="login-logo">
      <div class="logo-icon">
        <svg viewBox="0 0 24 24" width="22" height="22"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
      </div>
      <div>
        <h1>SysInfo</h1>
        <span>Système d'Information</span>
      </div>
    </div>

    <h2>Créer un compte</h2>

    <?php if (session()->getFlashdata('success')): ?>
      <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <?php $errors = session()->getFlashdata('errors') ?? (isset($errors) ? $errors : null); ?>
    <?php if (! empty($errors)): ?>
      <div class="alert alert-error">
        <ul>
          <?php foreach ($errors as $err): ?>
            <li><?= esc($err) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <form action="<?= base_url('register/store') ?>" method="post">
      <div class="field-group">
        <label for="nom">Nom complet</label>
        <input id="nom" name="nom" type="text" value="<?= old('nom') ?>" required />
      </div>

      <div class="field-group">
        <label for="email">Adresse e-mail</label>
        <input id="email" name="email" type="email" value="<?= old('email') ?>" required />
      </div>

      <div class="field-group">
        <label for="password">Mot de passe</label>
        <input id="password" name="password" type="password" required />
      </div>

      <div class="field-group">
        <label for="pass_confirm">Confirmez le mot de passe</label>
        <input id="pass_confirm" name="pass_confirm" type="password" required />
      </div>

      <button type="submit" class="btn btn-primary btn-full">S'inscrire</button>
    </form>

    <div class="login-footer">
      Déjà un compte ? <a href="<?= base_url('/') ?>">Se connecter</a>
    </div>
  </div>
</div>

</body>
</html>
