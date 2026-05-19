<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

    <section id="page-admin-reservations">
  <div class="app-wrapper">
    <aside class="sidebar">
      <div class="sidebar-logo">Fit<span>Space</span> <span style="font-size:0.6rem;background:var(--accent);color:#fff;padding:2px 6px;border-radius:4px;vertical-align:middle;">Admin</span></div>
      <ul class="sidebar-nav" style="margin-top:1rem;">
        <li><a href="/dashboard"><i class="bi bi-speedometer2"></i> Vue d'ensemble</a></li>
        <li><a href="/reservation" class="active"><i class="bi bi-bookmark-star-fill"></i> Réservations</a></li>
        <li><a href="/creneau"><i class="bi bi-calendar-week-fill"></i> Créneaux</a></li>
        <li><a href="/liste-client"><i class="bi bi-people-fill"></i> Clients</a></li>
      </ul>
      <div class="sidebar-footer">
        <div class="sidebar-user">
          <div class="avatar" style="background:#0f3460;"><?= strtoupper(substr($name, 0, 2)) ?></div>
          <div class="user-info"><div class="name">Admin</div><div class="role">Administrateur</div></div>
        </div>
      </div>
    </aside>

    <div class="main-content">
      <div class="topbar">
        <span class="topbar-title">Toutes les réservations</span>
      </div>

      <div class="page-content">
        <div class="data-card">
          <div class="data-card-header">
            <h3>Réservations</h3>
            <div style="display:flex;gap:8px;">
              <select class="select-custom" style="font-size:0.8rem;padding:6px 10px;">
                <option>Tous les statuts</option>
                <option>En attente</option>
                <option>Confirmée</option>
                <option>Annulée</option>
                <option>Refusée</option>
              </select>
            </div>
          </div>
          <table class="table-custom">
            <thead>
              <tr><th>Client</th><th>Créneau</th><th>Date réservation</th><th>Statut</th><th>Actions</th></tr>
            </thead>
            <tbody>
              <?php foreach($reservations as $res): ?>
              <tr>
                  <td>
                      <div style="display:flex;align-items:center;gap:8px;">
                          <div class="avatar" style="width:28px;height:28px;font-size:0.65rem;">
                              <?= strtoupper(substr($res['user_name'], 0, 2)) ?>
                          </div>

                          <div>
                              <div style="font-weight:600;font-size:0.875rem;">
                                  <?= esc($res['user_name']) ?>
                              </div>
                              <div style="font-size:0.75rem;color:var(--muted);">
                                  <?= esc($res['user_email']) ?>
                              </div>
                          </div>
                      </div>
                  </td>

                  <td>
                      <div style="font-weight:500;font-size:0.875rem;">
                          <?= esc($res['ressource_nom']) ?>
                      </div>
                      <div style="font-size:0.75rem;color:var(--muted);">
                          <?= date('d M', strtotime($res['date_debut'])) ?>
                          ·
                          <?= date('H\hi', strtotime($res['date_debut'])) ?>
                          –
                          <?= date('H\hi', strtotime($res['date_fin'])) ?>
                      </div>
                  </td>

                  <td class="td-muted">
                      <?= date('d M Y à H\hi', strtotime($res['created_at'])) ?>
                  </td>

                  <td>
                      <span class="badge-statut s-<?= esc($res['statut']) ?>">
                          <?= esc($res['statut']) ?>
                      </span>
                  </td>

                  <td>
                      <?php if($res['statut'] === 'en_attente'): ?>
                          <div class="action-btns">
                              <a href="/confirmer/<?= $res['id'] ?>" class="btn-sm-custom btn-confirm">
                                  <i class="bi bi-check"></i> Confirmer
                              </a>

                              <a href="/refuser/<?= $res['id'] ?>" class="btn-sm-custom btn-refuse">
                                  <i class="bi bi-x"></i> Refuser
                              </a>
                          </div>
                      <?php elseif($res['statut'] === 'confirmee'): ?>
                          <a href="/annuler/<?= $res['id'] ?>" class="btn-sm-custom btn-cancel">
                              <i class="bi bi-x"></i> Annuler
                          </a>
                      <?php else: ?>
                          <span style="font-size:0.75rem;color:var(--muted);">—</span>
                      <?php endif; ?>
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