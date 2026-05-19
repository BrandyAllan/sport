<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

    <section id="page-admin-creneaux">
  <div class="app-wrapper">
    <aside class="sidebar">
      <div class="sidebar-logo">Fit<span>Space</span> <span style="font-size:0.6rem;background:var(--accent);color:#fff;padding:2px 6px;border-radius:4px;vertical-align:middle;">Admin</span></div>
      <ul class="sidebar-nav" style="margin-top:1rem;">
        <li><a href="/dashboard"><i class="bi bi-speedometer2"></i> Vue d'ensemble</a></li>
        <li><a href="/reservation"><i class="bi bi-bookmark-star-fill"></i> Réservations</a></li>
        <li><a href="/creneau" class="active"><i class="bi bi-calendar-week-fill"></i> Créneaux</a></li>
        <li><a href="/liste-client"><i class="bi bi-people-fill"></i> Clients</a></li>
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
          <div class="user-info"><div class="name"><?= $name ?></div><div class="role">Administrateur</div></div>
        </div>
      </div>
    </aside>

    <div class="main-content">
      <div class="topbar">
        <span class="topbar-title">Gestion des créneaux</span>
      </div>

      <div class="page-content">

              <!-- Flash success -->
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
        
        <!-- Formulaire ajout créneau -->
        <div class="form-section">
          <h3><i class="bi bi-plus-circle" style="color:var(--accent);margin-right:6px;"></i>Éditer un créneau</h3>
          <form action="/editer-creneau" method="post">
              <div class="form-grid-2" style="margin-bottom:1rem;">
                <input type="hidden" value="<?= $creneau['id'] ?>" name="id_creneau">
                  <div class="form-group">
                      <label class="form-label">Ressource</label>
                      <select name="ressource_id" class="select-custom" required>
                          <?php foreach($ressources as $ressource): ?>
                              <option value="<?= $ressource['id'] ?>" <?= $ressource['id'] == $creneau['ressource_id'] ? 'selected' : '' ?>>
                                  <?= esc($ressource['nom']) ?> - <?= esc($ressource['type']) ?>
                              </option>
                          <?php endforeach; ?>
                      </select>
                  </div>

                  <div class="form-group">
                      <label class="form-label">Nombre de places</label>
                      <input type="number" name="places_dispo" class="form-control" value="<?= $creneau['places_dispo'] ?>" required>
                  </div>

                  <div class="form-group">
                      <label class="form-label">Date et heure de début</label>
                      <input type="datetime-local" name="date_debut" class="form-control" value="<?= date('Y-m-d\TH:i', strtotime($creneau['date_debut'])) ?>" required>
                  </div>

                  <div class="form-group">
                      <label class="form-label">Date et heure de fin</label>
                      <input type="datetime-local" name="date_fin" class="form-control" value="<?= date('Y-m-d\TH:i', strtotime($creneau['date_fin'])) ?>" required>
                  </div>
              </div>

              <div style="display:flex;gap:10px;flex-wrap:wrap;">
                  <button type="submit" class="btn-submit">
                      <i class="bi bi-plus"></i> Mettre à jour
                  </button>
                  <button type="reset" class="btn-secondary-custom">Réinitialiser</button>
              </div>
          </form>
        </div>


      </div>
    </div>
  </div>
</section>

<?= $this->endSection() ?>