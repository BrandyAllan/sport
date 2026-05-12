<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

    <section id="page-login" style="background:var(--surface);">
  <nav class="nav-public">
    <a href="#" class="brand">Fit<span>Space</span></a>
  </nav>
  <div class="auth-wrapper">
    <div class="auth-card">
      <div class="auth-logo">Fit<span>Space</span></div>
      <div class="auth-subtitle">Bienvenue ! Connectez-vous à votre espace.</div>

      <!-- Flashdata erreur CI4 -->
      <div class="flash-message flash-error">
        <i class="bi bi-exclamation-circle-fill"></i>
        Email ou mot de passe incorrect.
      </div>

      <form action="/login" method="post">
        <div class="form-group mb-3">
          <label class="form-label">Adresse email</label>
          <input type="email" class="form-control" placeholder="votre@email.com" />
        </div>
        <div class="form-group mb-4">
          <label class="form-label">Mot de passe</label>
          <input type="password" class="form-control" placeholder="••••••••" />
        </div>
        <button type="submit" class="btn-primary-custom">Se connecter</button>
      </form>

      <hr class="auth-divider" />
      <div class="auth-footer">Pas encore de compte ? <a href="/register">Créer un compte</a></div>
    </div>
  </div>
</section>

<?= $this->endSection() ?>