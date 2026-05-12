<?php
include 'layout/header.php';
?>
    <section id="page-mes-reservations">
  <div class="app-wrapper">
    <aside class="sidebar">
      <div class="sidebar-logo">Fit<span>Space</span></div>
      <ul class="sidebar-nav" style="margin-top:1rem;">
        <li><a href="#page-dashboard-client"><i class="bi bi-grid-1x2-fill"></i> Tableau de bord</a></li>
        <li><a href="#page-creneaux"><i class="bi bi-calendar3"></i> Voir les créneaux</a></li>
        <li><a href="#page-mes-reservations" class="active"><i class="bi bi-bookmark-check-fill"></i> Mes réservations</a></li>
        <li><a href="#page-profil"><i class="bi bi-person-fill"></i> Mon profil</a></li>
      </ul>
      <div class="sidebar-footer">
        <div class="sidebar-user">
          <div class="avatar">JD</div>
          <div class="user-info"><div class="name">Jean Dupont</div><div class="role">Client</div></div>
        </div>
      </div>
    </aside>

    <div class="main-content">
      <div class="topbar">
        <span class="topbar-title">Mes réservations</span>
      </div>
      <div class="page-content">
        <div class="data-card">
          <div class="data-card-header">
            <h3>Toutes mes réservations</h3>
          </div>
          <table class="table-custom">
            <thead>
              <tr><th>Ressource</th><th>Date</th><th>Horaire</th><th>Type</th><th>Statut</th><th>Action</th></tr>
            </thead>
            <tbody>
              <tr>
                <td class="td-name">Yoga Détente</td>
                <td class="td-muted">16 juin 2025</td>
                <td class="td-muted">08h00 – 09h30</td>
                <td><span class="creneau-type type-cours" style="font-size:0.68rem;">Cours</span></td>
                <td><span class="badge-statut s-attente">en attente</span></td>
                <td><button class="btn-sm-custom btn-cancel"><i class="bi bi-x"></i> Annuler</button></td>
              </tr>
              <tr>
                <td class="td-name">Salle musculation</td>
                <td class="td-muted">17 juin 2025</td>
                <td class="td-muted">10h00 – 12h00</td>
                <td><span class="creneau-type type-salle" style="font-size:0.68rem;">Salle</span></td>
                <td><span class="badge-statut s-confirmee">confirmée</span></td>
                <td><span style="font-size:0.75rem;color:var(--muted);">—</span></td>
              </tr>
              <tr>
                <td class="td-name">CrossFit Intensif</td>
                <td class="td-muted">10 juin 2025</td>
                <td class="td-muted">18h00 – 19h30</td>
                <td><span class="creneau-type type-cours" style="font-size:0.68rem;">Cours</span></td>
                <td><span class="badge-statut s-annulee">annulée</span></td>
                <td><span style="font-size:0.75rem;color:var(--muted);">—</span></td>
              </tr>
              <tr>
                <td class="td-name">Terrain de squash</td>
                <td class="td-muted">18 juin 2025</td>
                <td class="td-muted">14h00 – 15h00</td>
                <td><span class="creneau-type type-terrain" style="font-size:0.68rem;">Terrain</span></td>
                <td><span class="badge-statut s-attente">en attente</span></td>
                <td><button class="btn-sm-custom btn-cancel"><i class="bi bi-x"></i> Annuler</button></td>
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