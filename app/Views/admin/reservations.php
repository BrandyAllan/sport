<?php
include 'layout/header.php';
?>
    <section id="page-admin-reservations">
  <div class="app-wrapper">
    <aside class="sidebar">
      <div class="sidebar-logo">Fit<span>Space</span> <span style="font-size:0.6rem;background:var(--accent);color:#fff;padding:2px 6px;border-radius:4px;vertical-align:middle;">Admin</span></div>
      <ul class="sidebar-nav" style="margin-top:1rem;">
        <li><a href="#page-dashboard-admin"><i class="bi bi-speedometer2"></i> Vue d'ensemble</a></li>
        <li><a href="#page-admin-reservations" class="active"><i class="bi bi-bookmark-star-fill"></i> Réservations</a></li>
        <li><a href="#page-admin-creneaux"><i class="bi bi-calendar-week-fill"></i> Créneaux</a></li>
        <li><a href="#page-admin-clients"><i class="bi bi-people-fill"></i> Clients</a></li>
      </ul>
      <div class="sidebar-footer">
        <div class="sidebar-user">
          <div class="avatar" style="background:#0f3460;">AD</div>
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
              <tr>
                <td><div style="display:flex;align-items:center;gap:8px;"><div class="avatar" style="width:28px;height:28px;font-size:0.65rem;">JD</div><div><div style="font-weight:600;font-size:0.875rem;">Jean Dupont</div><div style="font-size:0.75rem;color:var(--muted);">jean@email.com</div></div></div></td>
                <td><div style="font-weight:500;font-size:0.875rem;">Yoga Détente</div><div style="font-size:0.75rem;color:var(--muted);">16 juin · 08h00 – 09h30</div></td>
                <td class="td-muted">14 juin 2025 à 10h23</td>
                <td><span class="badge-statut s-attente">en attente</span></td>
                <td>
                  <div class="action-btns">
                    <button class="btn-sm-custom btn-confirm"><i class="bi bi-check"></i> Confirmer</button>
                    <button class="btn-sm-custom btn-refuse"><i class="bi bi-x"></i> Refuser</button>
                  </div>
                </td>
              </tr>
              <tr>
                <td><div style="display:flex;align-items:center;gap:8px;"><div class="avatar" style="width:28px;height:28px;font-size:0.65rem;background:#0f3460;">MA</div><div><div style="font-weight:600;font-size:0.875rem;">Marie Andria</div><div style="font-size:0.75rem;color:var(--muted);">marie@email.com</div></div></div></td>
                <td><div style="font-weight:500;font-size:0.875rem;">CrossFit Intensif</div><div style="font-size:0.75rem;color:var(--muted);">16 juin · 18h00 – 19h30</div></td>
                <td class="td-muted">14 juin 2025 à 14h05</td>
                <td><span class="badge-statut s-attente">en attente</span></td>
                <td>
                  <div class="action-btns">
                    <button class="btn-sm-custom btn-confirm"><i class="bi bi-check"></i> Confirmer</button>
                    <button class="btn-sm-custom btn-refuse"><i class="bi bi-x"></i> Refuser</button>
                  </div>
                </td>
              </tr>
              <tr>
                <td><div style="display:flex;align-items:center;gap:8px;"><div class="avatar" style="width:28px;height:28px;font-size:0.65rem;background:#1a6b39;">SR</div><div><div style="font-weight:600;font-size:0.875rem;">Soa Rabe</div><div style="font-size:0.75rem;color:var(--muted);">soa@email.com</div></div></div></td>
                <td><div style="font-weight:500;font-size:0.875rem;">Terrain squash</div><div style="font-size:0.75rem;color:var(--muted);">18 juin · 14h00 – 15h00</div></td>
                <td class="td-muted">13 juin 2025 à 09h12</td>
                <td><span class="badge-statut s-confirmee">confirmée</span></td>
                <td><span style="font-size:0.75rem;color:var(--muted);">—</span></td>
              </tr>
              <tr>
                <td><div style="display:flex;align-items:center;gap:8px;"><div class="avatar" style="width:28px;height:28px;font-size:0.65rem;background:#534AB7;">TR</div><div><div style="font-weight:600;font-size:0.875rem;">Tsiry Rako</div><div style="font-size:0.75rem;color:var(--muted);">tsiry@email.com</div></div></div></td>
                <td><div style="font-weight:500;font-size:0.875rem;">Salle musculation</div><div style="font-size:0.75rem;color:var(--muted);">17 juin · 10h00 – 12h00</div></td>
                <td class="td-muted">12 juin 2025 à 16h48</td>
                <td><span class="badge-statut s-refusee">refusée</span></td>
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