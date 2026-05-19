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
          <h3><i class="bi bi-plus-circle" style="color:var(--accent);margin-right:6px;"></i>Ajouter un créneau</h3>
          <form action="/ajouter-creneau" method="post">
              <div class="form-grid-2" style="margin-bottom:1rem;">
                  <div class="form-group">
                      <label class="form-label">Ressource</label>
                      <select name="ressource_id" class="select-custom" required>
                          <?php foreach($ressources as $ressource): ?>
                              <option value="<?= $ressource['id'] ?>">
                                  <?= esc($ressource['nom']) ?> - <?= esc($ressource['type']) ?>
                              </option>
                          <?php endforeach; ?>
                      </select>
                  </div>

                  <div class="form-group">
                      <label class="form-label">Nombre de places</label>
                      <input type="number" name="places_dispo" class="form-control" min="1" required>
                  </div>

                  <div class="form-group">
                      <label class="form-label">Date et heure de début</label>
                      <input type="datetime-local" name="date_debut" class="form-control" required>
                  </div>

                  <div class="form-group">
                      <label class="form-label">Date et heure de fin</label>
                      <input type="datetime-local" name="date_fin" class="form-control" required>
                  </div>
              </div>

              <div style="display:flex;gap:10px;flex-wrap:wrap;">
                  <button type="submit" class="btn-submit">
                      <i class="bi bi-plus"></i> Ajouter le créneau
                  </button>
                  <button type="reset" class="btn-secondary-custom">Réinitialiser</button>
              </div>
          </form>
        </div>

        <!-- Liste des créneaux -->
        <div class="data-card">
          <div class="data-card-header">
            <h3>Tous les créneaux</h3>
            <span style="font-size:0.8rem;color:var(--muted);">6 créneaux</span>
          </div>
          <table class="table-custom">
            <thead>
              <tr><th>Ressource</th><th>Date début</th><th>Date fin</th><th>Places dispo</th><th>Actif</th><th>Actions</th></tr>
            </thead>
            <tbody>
            <?php foreach($creneaux as $creneau): ?>
                <tr>
                    <td class="td-name">
                        <?= esc($creneau['ressource_nom']) ?>
                        <span class="creneau-type type-<?= esc($creneau['ressource_type']) ?>" style="font-size:0.65rem;margin-left:5px;">
                            <?= ucfirst(esc($creneau['ressource_type'])) ?>
                        </span>
                    </td>

                    <td class="td-muted">
                        <?= date('d M · H\hi', strtotime($creneau['date_debut'])) ?>
                    </td>

                    <td class="td-muted">
                        <?= date('d M · H\hi', strtotime($creneau['date_fin'])) ?>
                    </td>

                    <td>
                        <?= esc($creneau['places_dispo']) ?> / <?= esc($creneau['capacite']) ?>
                    </td>

                    <td>
                        <?php if($creneau['actif'] == 1): ?>
                            <span class="badge-statut s-confirmee" style="font-size:0.68rem;">Oui</span>
                        <?php else: ?>
                            <span class="badge-statut s-annulee" style="font-size:0.68rem;">Non</span>
                        <?php endif; ?>
                    </td>

                    <td>
                        <div class="action-btns">
                          <a href="/editer-creneau/<?= $creneau['id'] ?>" class="btn-sm-custom btn-edit">
                              <i class="bi bi-pencil"></i> Éditer
                          </a>
                          <a href="/admin/creneaux/supprimer/<?= $creneau['id'] ?>" class="btn-sm-custom btn-del">
                              <i class="bi bi-trash"></i>
                          </a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div>

      </div>
    </div>
  </div>
</section>

<?= $this->endSection() ?>