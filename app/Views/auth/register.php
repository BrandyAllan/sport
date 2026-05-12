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

      <form action="/register" method="post">
        <div class="form-grid-2 mb-3">
          <div class="form-group">
            <label class="form-label">Nom</label>
            <input type="text" class="form-control" name="nom" placeholder="Dupont" />
          </div>
        </div>
        <div class="form-group mb-3">
          <label class="form-label">Adresse email</label>
          <input type="email" class="form-control" name="email" placeholder="jean.dupont@email.com" />
          <!-- Erreur de validation CI4 -->
          <small style="color:var(--accent);font-size:0.78rem;margin-top:3px;">Cet email est déjà utilisé.</small>
        </div>
        <div class="form-group mb-3">
            <label class="form-label">Mot de passe</label>
            <div class="input-group-password"> 
              <input type="password" class="form-control" name="password" id="password" placeholder="8 caractères minimum" />
                <button type="button" id="togglePassword" class="btn-eye-toggle"> 
                  <i class="bi bi-eye" id="toggleIcon"></i>
                </button>
            </div>
        </div>

        <button type="submit" class="btn-primary-custom">Créer mon compte</button>
      </form>

      <hr class="auth-divider" />
      <div class="auth-footer">Déjà inscrit ? <a href="/login">Se connecter</a></div>
    </div>
  </div>
</section>
<?= $this->endSection() ?>


<script>
  const passwordInput = document.getElementById('password');
  const togglePassword = document.getElementById('togglePassword');
  const toggleIcon = document.getElementById('toggleIcon');
  togglePassword.addEventListener('click', function () {
    // Basculer le type entre 'password' et 'text'
    const isPassword = passwordInput.getAttribute('type') === 'password';
    passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
    
    // Basculer l'icône Bootstrap (oeil ouvert / oeil barré)
    toggleIcon.classList.toggle('bi-eye');
    toggleIcon.classList.toggle('bi-eye-slash');
});
</script>