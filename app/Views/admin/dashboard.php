<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

    <section id="page-dashboard-admin">
  <div class="app-wrapper">

    <aside class="sidebar">
      <div class="sidebar-logo">Fit<span>Space</span> <span style="font-size:0.6rem;background:var(--accent);color:#fff;padding:2px 6px;border-radius:4px;vertical-align:middle;">Admin</span></div>
      <div class="sidebar-section">Gestion</div>
      <ul class="sidebar-nav">
        <li><a href="/dashboard" class="active"><i class="bi bi-speedometer2"></i> Vue d'ensemble</a></li>
        <li>
          <a href="/reservation">
            <i class="bi bi-bookmark-star-fill"></i> Réservations
            <span class="sidebar-badge urgent">4</span>
          </a>
        </li>
        <li><a href="/creneau"><i class="bi bi-calendar-week-fill"></i> Créneaux</a></li>
        <li><a href="#page-admin-clients"><i class="bi bi-people-fill"></i> Clients</a></li>
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
          <div class="user-info"><div class="name"><?= $name ?></div><div class="role"><?= $role ?></div></div>
          <a href="#page-login" style="margin-left:auto;color:rgba(255,255,255,0.3);font-size:1.1rem;"><i class="bi bi-box-arrow-right"></i></a>
        </div>
      </div>
    </aside>

    <div class="main-content">
      <div class="topbar">
        <span class="topbar-title">Vue d'ensemble</span>
        <div class="topbar-actions">
          <a href="#page-admin-creneaux" class="icon-btn" title="Ajouter un créneau"><i class="bi bi-plus-lg"></i></a>
        </div>
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
        
        <div class="metrics-row">
          <div class="metric-card">
            <div class="metric-icon yellow"><i class="bi bi-hourglass-split"></i></div>
            <div class="metric-value"><?= $en_attente ?></div>
            <div class="metric-label">En attente</div>
            <div class="metric-trend up"><i class="bi bi-arrow-up-short"></i> +2 aujourd'hui</div>
          </div>
          <div class="metric-card">
            <div class="metric-icon green"><i class="bi bi-check-circle-fill"></i></div>
            <div class="metric-value"><?= $confirmees_ce_mois ?></div>
            <div class="metric-label">Confirmées ce mois</div>
          </div>
          <div class="metric-card">
            <div class="metric-icon blue"><i class="bi bi-calendar-check"></i></div>
            <div class="metric-value"><?= $creneaux_actifs ?></div>
            <div class="metric-label">Créneaux actifs</div>
          </div>
          <div class="metric-card">
            <div class="metric-icon red"><i class="bi bi-people-fill"></i></div>
            <div class="metric-value"><?= $clients_inscrits ?></div>
            <div class="metric-label">Clients inscrits</div>
            <div class="metric-trend up"><i class="bi bi-arrow-up-short"></i> +3 cette semaine</div>
          </div>
        </div>

        <!-- Réservations récentes -->
        <div class="data-card">
          <div class="data-card-header">
            <h3>Réservations récentes</h3>
            <a href="#page-admin-reservations" style="font-size:0.8rem;color:var(--accent);text-decoration:none;">Tout voir →</a>
          </div>
          <table class="table-custom">
            <thead>
              <tr><th>Client</th><th>Créneau</th><th>Date</th><th>Statut</th><th>Actions</th></tr>
            </thead>
            <tbody>
              <?php foreach($reservationsRecentes as $res): ?>
              <tr>
                <td>
                  <div style="display:flex;align-items:center;gap:8px;">
                  <?php 
                    $mots = explode(' ', trim($res['client_nom'])); 
                    $initiales = mb_substr($mots[0], 0, 1); 
                    if (count($mots) > 1) {
                        $initiales .= mb_substr($mots[1], 0, 1);
                    }
                    $initiales = mb_strtoupper($initiales); 
                  ?>
                    <div class="avatar" style="width:28px;height:28px;font-size:0.65rem;"><?=$initiales?></div>
                    <span class="td-name"><?=$res['client_nom']?></span>
                  </div>
                </td>
                <td class="td-muted"><?=$res['ressource_type']?></td>
                <td class="td-muted"><?=$res['date_debut']?></td>
                <?php if($res['statut'] === 'en_attente') { ?>
                  <td><span class="badge-statut s-attente">en attente</span></td>
                  <td>
                    <div class="action-btns">
                      <a href="/confirmer/<?=$res['id']?>" class="btn-sm-custom btn-confirm"><i class="bi bi-check"></i> Confirmer</a>
                      <a href="/refuser/<?=$res['id']?>" class="btn-sm-custom btn-refuse"><i class="bi bi-x"></i> Refuser</a>
                    </div>
                  </td>
                <?php } elseif($res['statut'] === 'confirmee') { ?>
                  <td><span class="badge-statut s-confirmee">confirmée</span></td>
                  <td>
                    <div class="action-btns">
                      <a href="/annuler/<?=$res['id']?>" class="btn-sm-custom btn-cancel"><i class="bi bi-x"></i> Annuler</a>
                    </div>
                  </td>
                <?php } ?>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>

      </div>
    </div>
  </div>
</section>

<?= $this->endSection() ?>