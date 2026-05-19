<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

    <section id="page-admin-creneaux">
  <div class="app-wrapper">
    <aside class="sidebar">
      <div class="sidebar-logo">Fit<span>Space</span> <span style="font-size:0.6rem;background:var(--accent);color:#fff;padding:2px 6px;border-radius:4px;vertical-align:middle;">Admin</span></div>
      <ul class="sidebar-nav" style="margin-top:1rem;">
        <li><a href="#page-dashboard-admin"><i class="bi bi-speedometer2"></i> Vue d'ensemble</a></li>
        <li><a href="#page-admin-reservations"><i class="bi bi-bookmark-star-fill"></i> Réservations</a></li>
        <li><a href="#page-admin-creneaux" class="active"><i class="bi bi-calendar-week-fill"></i> Créneaux</a></li>
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
        <span class="topbar-title">Gestion des créneaux</span>
      </div>

      <div class="page-content">

        <!-- Flash info -->
        <div class="flash-message flash-info">
          <i class="bi bi-info-circle-fill"></i>
          Créneau mis à jour avec succès.
        </div>

        <!-- Formulaire ajout créneau -->
        <div class="form-section">
          <h3><i class="bi bi-plus-circle" style="color:var(--accent);margin-right:6px;"></i>Ajouter un créneau</h3>
          <form action="/admin/creneaux/ajouter" method="post">
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
              <tr>
                <td class="td-name">Yoga Détente <span class="creneau-type type-cours" style="font-size:0.65rem;margin-left:5px;">Cours</span></td>
                <td class="td-muted">16 juin · 08h00</td>
                <td class="td-muted">16 juin · 09h30</td>
                <td>6 / 10</td>
                <td><span class="badge-statut s-confirmee" style="font-size:0.68rem;">Oui</span></td>
                <td>
                  <div class="action-btns">
                    <button class="btn-sm-custom btn-edit"><i class="bi bi-pencil"></i> Éditer</button>
                    <button class="btn-sm-custom btn-del"><i class="bi bi-trash"></i></button>
                  </div>
                </td>
              </tr>
              <tr>
                <td class="td-name">CrossFit Intensif <span class="creneau-type type-cours" style="font-size:0.65rem;margin-left:5px;">Cours</span></td>
                <td class="td-muted">16 juin · 18h00</td>
                <td class="td-muted">16 juin · 19h30</td>
                <td>0 / 15</td>
                <td><span class="badge-statut s-confirmee" style="font-size:0.68rem;">Oui</span></td>
                <td>
                  <div class="action-btns">
                    <button class="btn-sm-custom btn-edit"><i class="bi bi-pencil"></i> Éditer</button>
                    <button class="btn-sm-custom btn-del"><i class="bi bi-trash"></i></button>
                  </div>
                </td>
              </tr>
              <tr>
                <td class="td-name">Terrain squash A <span class="creneau-type type-terrain" style="font-size:0.65rem;margin-left:5px;">Terrain</span></td>
                <td class="td-muted">18 juin · 14h00</td>
                <td class="td-muted">18 juin · 15h00</td>
                <td>1 / 2</td>
                <td><span class="badge-statut s-confirmee" style="font-size:0.68rem;">Oui</span></td>
                <td>
                  <div class="action-btns">
                    <button class="btn-sm-custom btn-edit"><i class="bi bi-pencil"></i> Éditer</button>
                    <button class="btn-sm-custom btn-del"><i class="bi bi-trash"></i></button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

      </div>
    </div>
  </div>
</section>

<?= $this->endSection() ?>