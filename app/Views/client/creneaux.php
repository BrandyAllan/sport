<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

    <section id="page-creneaux" style="padding-top:1rem;">

  <nav class="nav-public">
    <a href="/" class="brand">Fit<span>Space</span></a>
    <?php if(session()->get('logged_in')): ?>

      <div class="nav-links">
        <a href="#page-dashboard-client">Mon espace</a>
        <a href="/logout">Déconnexion</a>
      </div>

    <?php else: ?>

        <div class="nav-links">
          <a href="/creneau">Nos créneaux</a>
          <a href="/tarifs">Tarifs</a>
          <a href="/login">Connexion</a>
          <a href="/register" class="btn-nav-primary">S'inscrire</a>
        </div>

    <?php endif; ?>
    
  </nav>

  <div class="page-section">
    <div class="section-head">
      <h2>Créneaux disponibles</h2>
      <span class="count"><?= $total ?> créneaux trouvés</span>
    </div>

    <!-- Filtres -->
    <div class="filter-bar">
      <button class="filter-pill active">Tous</button>
      <button class="filter-pill"><i class="bi bi-people-fill"></i> Cours collectifs</button>
      <button class="filter-pill"><i class="bi bi-door-open-fill"></i> Salles</button>
      <button class="filter-pill"><i class="bi bi-dribbble"></i> Terrains</button>
    </div>

    <!-- Grille créneaux -->
    <div class="creneaux-grid">

      <?php foreach($creneaux as $creneau): ?>
        <div class="creneau-card <?= $creneau['places_dispo'] == 0 ? 'full' : '' ?>">
          <div class="creneau-header">
            <span class="creneau-type type-<?= $creneau['ressource_type'] ?>"><i class="bi bi-people-fill"></i> <?= ucfirst($creneau['ressource_type']) ?></span>
            <span style="font-size:0.75rem;color:var(--muted);"><?= date('D d M', strtotime($creneau['date_debut'])) ?></span>
          </div>
          <p class="creneau-title"><?= $creneau['ressource_nom'] ?></p>
          <div class="creneau-meta">
            <div class="meta-row"><i class="bi bi-clock"></i> <?= date('H\hi', strtotime($creneau['date_debut'])) ?> — <?= date('H\hi', strtotime($creneau['date_fin'])) ?></div>
            <div class="meta-row"><i class="bi bi-geo-alt"></i> <?= $creneau['description'] ?></div>
          </div>
          <div>
            <div class="places-bar"><div class="places-fill" style="width:<?= ($creneau['places_dispo'] / $creneau['capacite']) * 100 ?>%"></div></div>
            <div class="places-label"><?= $creneau['places_dispo'] > 0 ? $creneau['places_dispo'] . ' places restantes sur ' . $creneau['capacite'] : 'Complet — 0 place restante' ?></div>
          </div>
          <?php if($creneau['places_dispo'] > 0): ?>
            <a href="#" class="btn-reserver">Réserver ce créneau</a>
          <?php else: ?>
            <button class="btn-reserver disabled" disabled>Complet</button>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>

    </div>
  </div>

  <div class="footer-public">FitSpace &copy; 2025 — Projet CodeIgniter 4 · Tous droits <span>réservés</span></div>
</section>
<?= $this->endSection() ?>