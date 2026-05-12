<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

    <section id="page-inscription" style="background:var(--surface);">
  <nav class="nav-public">
    <a href="#" class="brand">Fit<span>Space</span></a>
  </nav>
  <div class="auth-wrapper">
    <div class="auth-card">
      <div class="auth-logo">Fit<span>Space</span></div>
      <div class="auth-subtitle">Créez votre compte client gratuitement.</div>

      <form>
        <div class="form-grid-2 mb-3">
          <div class="form-group">
            <label class="form-label">Prénom</label>
            <input type="text" class="form-control" placeholder="Jean" />
          </div>
          <div class="form-group">
            <label class="form-label">Nom</label>
            <input type="text" class="form-control" placeholder="Dupont" />
          </div>
        </div>
        <div class="form-group mb-3">
          <label class="form-label">Adresse email</label>
          <input type="email" class="form-control" placeholder="jean.dupont@email.com" />
          <!-- Erreur de validation CI4 -->
          <small style="color:var(--accent);font-size:0.78rem;margin-top:3px;">Cet email est déjà utilisé.</small>
        </div>
        <div class="form-group mb-3">
          <label class="form-label">Mot de passe</label>
          <input type="password" class="form-control" placeholder="8 caractères minimum" />
        </div>
        <div class="form-group mb-4">
          <label class="form-label">Confirmer le mot de passe</label>
          <input type="password" class="form-control" placeholder="Retapez votre mot de passe" />
        </div>
        <button type="submit" class="btn-primary-custom">Créer mon compte</button>
      </form>

      <hr class="auth-divider" />
      <div class="auth-footer">Déjà inscrit ? <a href="#page-login">Se connecter</a></div>
    </div>
  </div>
</section>
<?= $this->endSection() ?>