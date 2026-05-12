<?php
include 'layout/header.php';
?>

    <section id="page-dashboard-admin">
  <div class="app-wrapper">

    <aside class="sidebar">
      <div class="sidebar-logo">Fit<span>Space</span> <span style="font-size:0.6rem;background:var(--accent);color:#fff;padding:2px 6px;border-radius:4px;vertical-align:middle;">Admin</span></div>
      <div class="sidebar-section">Gestion</div>
      <ul class="sidebar-nav">
        <li><a href="#page-dashboard-admin" class="active"><i class="bi bi-speedometer2"></i> Vue d'ensemble</a></li>
        <li>
          <a href="#page-admin-reservations">
            <i class="bi bi-bookmark-star-fill"></i> Réservations
            <span class="sidebar-badge urgent">4</span>
          </a>
        </li>
        <li><a href="#page-admin-creneaux"><i class="bi bi-calendar-week-fill"></i> Créneaux</a></li>
        <li><a href="#page-admin-clients"><i class="bi bi-people-fill"></i> Clients</a></li>
      </ul>
      <div class="sidebar-footer">
        <div class="sidebar-user">
          <div class="avatar" style="background:#0f3460;">AD</div>
          <div class="user-info"><div class="name">Admin</div><div class="role">Administrateur</div></div>
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

        <div class="metrics-row">
          <div class="metric-card">
            <div class="metric-icon yellow"><i class="bi bi-hourglass-split"></i></div>
            <div class="metric-value">4</div>
            <div class="metric-label">En attente</div>
            <div class="metric-trend up"><i class="bi bi-arrow-up-short"></i> +2 aujourd'hui</div>
          </div>
          <div class="metric-card">
            <div class="metric-icon green"><i class="bi bi-check-circle-fill"></i></div>
            <div class="metric-value">18</div>
            <div class="metric-label">Confirmées ce mois</div>
          </div>
          <div class="metric-card">
            <div class="metric-icon blue"><i class="bi bi-calendar-check"></i></div>
            <div class="metric-value">6</div>
            <div class="metric-label">Créneaux actifs</div>
          </div>
          <div class="metric-card">
            <div class="metric-icon red"><i class="bi bi-people-fill"></i></div>
            <div class="metric-value">31</div>
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
              <tr>
                <td><div style="display:flex;align-items:center;gap:8px;"><div class="avatar" style="width:28px;height:28px;font-size:0.65rem;">JD</div><span class="td-name">Jean Dupont</span></div></td>
                <td class="td-muted">Yoga Détente</td>
                <td class="td-muted">16 juin · 08h00</td>
                <td><span class="badge-statut s-attente">en attente</span></td>
                <td>
                  <div class="action-btns">
                    <button class="btn-sm-custom btn-confirm"><i class="bi bi-check"></i> Confirmer</button>
                    <button class="btn-sm-custom btn-refuse"><i class="bi bi-x"></i> Refuser</button>
                  </div>
                </td>
              </tr>
              <tr>
                <td><div style="display:flex;align-items:center;gap:8px;"><div class="avatar" style="width:28px;height:28px;font-size:0.65rem;background:#0f3460;">MA</div><span class="td-name">Marie Andria</span></div></td>
                <td class="td-muted">CrossFit Intensif</td>
                <td class="td-muted">16 juin · 18h00</td>
                <td><span class="badge-statut s-attente">en attente</span></td>
                <td>
                  <div class="action-btns">
                    <button class="btn-sm-custom btn-confirm"><i class="bi bi-check"></i> Confirmer</button>
                    <button class="btn-sm-custom btn-refuse"><i class="bi bi-x"></i> Refuser</button>
                  </div>
                </td>
              </tr>
              <tr>
                <td><div style="display:flex;align-items:center;gap:8px;"><div class="avatar" style="width:28px;height:28px;font-size:0.65rem;background:#1a6b39;">SR</div><span class="td-name">Soa Rabe</span></div></td>
                <td class="td-muted">Terrain squash</td>
                <td class="td-muted">18 juin · 14h00</td>
                <td><span class="badge-statut s-confirmee">confirmée</span></td>
                <td><span style="font-size:0.75rem;color:var(--muted);">—</span></td>
              </tr>
            </tbody>
          </table>
        </div>

      </div>
    </div>
  </div>
</section>
<?php
include 'layout/footer.php';
?>