<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
  .profile-container {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px 0;
  }
  
  .form-group {
    margin-bottom: 20px;
  }
  
  .form-group label {
    display: block;
    font-size: 0.85rem;
    font-weight: 600;
    margin-bottom: 8px;
    color: var(--muted, #666);
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }
  
  .form-control {
    width: 100%;
    padding: 12px 14px;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    font-size: 0.95rem;
    color: #333;
    transition: border-color 0.2s, box-shadow 0.2s;
  }
  
  .form-control:focus {
    outline: none;
    border-color: var(--accent, #e94560);
    box-shadow: 0 0 0 3px rgba(233, 69, 96, 0.1);
  }
  
  .form-control:disabled {
    background: #f8fafc;
    color: #94a3b8;
    cursor: not-allowed;
  }
  
  .password-note {
    font-size: 0.8rem;
    color: #94a3b8;
    margin-top: 6px;
  }
  
  .btn-save-profile {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: var(--accent, #e94560);
    color: #ffffff;
    border: none;
    padding: 12px 24px;
    border-radius: 6px;
    font-size: 0.95rem;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.2s;
  }
  
  .btn-save-profile:hover {
    background: #d23d54;
  }
</style>

<section id="page-profile">
  <div class="app-wrapper">

    <aside class="sidebar">
      <div class="sidebar-logo">Fit<span>Space</span>
        <?php if(session()->get('role') === 'admin'): ?>
          <span style="font-size:0.6rem;background:var(--accent);color:#fff;padding:2px 6px;border-radius:4px;vertical-align:middle;margin-left:5px;">Admin</span>
        <?php endif; ?>
      </div>
      
      <div class="sidebar-section">Menu</div>
      <ul class="sidebar-nav">
        <li><a href="/dashboard"><i class="bi bi-speedometer2"></i> Tableau de bord</a></li>
        
        <?php if(session()->get('role') === 'admin'): ?>
          <li><a href="/reservation"><i class="bi bi-bookmark-star-fill"></i> Réservations</a></li>
          <li><a href="/creneau"><i class="bi bi-calendar3"></i>  Créneaux</a></li>
        <?php else: ?>
          <li><a href="/creneau"><i class="bi bi-calendar3"></i>  Voir les créneaux</a></li>
          <li><a href="/mes-reservations"><i class="bi bi-bookmark-check-fill"></i> Mes réservations</a></li>
        <?php endif; ?>
        
        <li><a href="/profil" class="active"><i class="bi bi-person-fill"></i> Mon profil</a></li>
      </ul>
      
      <div class="sidebar-footer">
        <div class="sidebar-user">
          <?php 
            $mots = explode(' ', trim($name)); 
            $initiales = mb_substr($mots[0], 0, 1); 
            if (count($mots) > 1) {
                $initiales .= mb_substr($mots[1], 0, 1);
            }
            $initiales = mb_strtoupper($initiales); 
          ?>
          <div class="avatar" style="background:#0f3460;"><?= $initiales ?></div>
          <div class="user-info">
            <div class="name"><?= esc($name) ?></div>
            <div class="role"><?= esc($role) ?></div>
          </div>
          <a href="/logout" style="margin-left:auto;color:rgba(255,255,255,0.3);font-size:1.1rem;"><i class="bi bi-box-arrow-right"></i></a>
        </div>
      </div>
    </aside>

    <div class="main-content">
      <div class="topbar">
        <span class="topbar-title">Mon Profil</span>
      </div>

      <div class="page-content">

        <?php if(session()->getFlashdata('succes')): ?>
          <div class="flash-message flash-success">
            <i class="bi bi-check-circle-fill"></i>
            <?= session()->getFlashdata('succes') ?>
          </div>
        <?php endif; ?>
        
        <?php if(session()->getFlashdata('error')): ?>
          <div class="flash-message flash-error">
            <i class="bi bi-exclamation-circle-fill"></i>
            <?= session()->getFlashdata('error') ?>
          </div>
        <?php endif; ?>

        <div class="profile-container">
          <div class="data-card" style="padding: 30px;">
            <div style="display: flex; align-items: center; gap: 20px; margin-bottom: 30px; border-bottom: 1px solid #f1f5f9; padding-bottom: 20px;">
              <div class="avatar" style="width: 60px; height: 60px; font-size: 1.5rem; background: #0f3460;"><?= $initiales ?></div>
              <div>
                <h3 style="margin: 0 0 5px 0; font-size: 1.2rem;"><?= esc($name) ?></h3>
                <span class="badge-statut s-confirmee" style="text-transform: uppercase; font-size: 0.75rem;"><?= esc($role) ?></span>
              </div>
            </div>

            <form action="/profil/update" method="POST">
              <?= csrf_field() ?>

              <div class="form-group">
                <label for="name">Nom complet</label>
                <input type="text" name="name" id="name" class="form-control" value="<?= esc($name) ?>" required>
              </div>

              <div class="form-group">
                <label for="email">Adresse Email</label>
                <input type="email" id="email" class="form-control" value="<?= esc(session()->get('user_email') ?? '') ?>" disabled>
                <div class="password-note">L'adresse email est liée à votre compte et ne peut pas être modifiée.</div>
              </div>

              <hr style="border: 0; border-top: 1px solid #f1f5f9; margin: 30px 0;">
              <h4 style="margin-top: 0; margin-bottom: 15px; color: #333;">Modifier le mot de passe</h4>

              <div class="form-group">
                <label for="current_password">Mot de passe actuel</label>
                <input type="password" name="current_password" id="current_password" class="form-control">
                <div class="password-note">Requis uniquement si vous changez de mot de passe.</div>
              </div>

              <div class="form-group">
                <label for="new_password">Nouveau mot de passe</label>
                <input type="password" name="new_password" id="new_password" class="form-control">
              </div>

              <div class="form-group">
                <label for="confirm_password">Confirmer le nouveau mot de passe</label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control">
              </div>

              <div style="margin-top: 30px; text-align: right;">
                <button type="submit" class="btn-save-profile">
                  <i class="bi bi-save"></i> Enregistrer les modifications
                </button>
              </div>
            </form>

          </div>
        </div>

      </div>
    </div>
  </div>
</section>

<?= $this->endSection() ?>