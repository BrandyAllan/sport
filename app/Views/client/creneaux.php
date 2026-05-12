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
      <span class="count">8 créneaux trouvés</span>
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

      <!-- Créneau 1 — disponible -->
      <div class="creneau-card">
        <div class="creneau-header">
          <span class="creneau-type type-cours"><i class="bi bi-people-fill"></i> Cours</span>
          <span style="font-size:0.75rem;color:var(--muted);">Lun 16 juin</span>
        </div>
        <p class="creneau-title">Yoga Détente</p>
        <div class="creneau-meta">
          <div class="meta-row"><i class="bi bi-clock"></i> 08h00 — 09h30</div>
          <div class="meta-row"><i class="bi bi-geo-alt"></i> Salle Zen · 2e étage</div>
        </div>
        <div>
          <div class="places-bar"><div class="places-fill" style="width:40%"></div></div>
          <div class="places-label">6 places restantes sur 10</div>
        </div>
        <a href="#" class="btn-reserver">Réserver ce créneau</a>
      </div>

      <!-- Créneau 2 — complet -->
      <div class="creneau-card full">
        <div class="creneau-header">
          <span class="creneau-type type-cours"><i class="bi bi-people-fill"></i> Cours</span>
          <span style="font-size:0.75rem;color:var(--muted);">Lun 16 juin</span>
        </div>
        <p class="creneau-title">CrossFit Intensif</p>
        <div class="creneau-meta">
          <div class="meta-row"><i class="bi bi-clock"></i> 18h00 — 19h30</div>
          <div class="meta-row"><i class="bi bi-geo-alt"></i> Salle Cross · RDC</div>
        </div>
        <div>
          <div class="places-bar"><div class="places-fill" style="width:100%;background:var(--muted)"></div></div>
          <div class="places-label">Complet — 0 place restante</div>
        </div>
        <button class="btn-reserver disabled" disabled>Complet</button>
      </div>

      <!-- Créneau 3 — salle -->
      <div class="creneau-card">
        <div class="creneau-header">
          <span class="creneau-type type-salle"><i class="bi bi-door-open-fill"></i> Salle</span>
          <span style="font-size:0.75rem;color:var(--muted);">Mar 17 juin</span>
        </div>
        <p class="creneau-title">Salle de musculation</p>
        <div class="creneau-meta">
          <div class="meta-row"><i class="bi bi-clock"></i> 10h00 — 12h00</div>
          <div class="meta-row"><i class="bi bi-geo-alt"></i> Bloc Muscu · RDC</div>
        </div>
        <div>
          <div class="places-bar"><div class="places-fill" style="width:25%"></div></div>
          <div class="places-label">3 places restantes sur 4</div>
        </div>
        <a href="#" class="btn-reserver">Réserver ce créneau</a>
      </div>

      <!-- Créneau 4 — terrain -->
      <div class="creneau-card">
        <div class="creneau-header">
          <span class="creneau-type type-terrain"><i class="bi bi-dribbble"></i> Terrain</span>
          <span style="font-size:0.75rem;color:var(--muted);">Mer 18 juin</span>
        </div>
        <p class="creneau-title">Terrain de squash</p>
        <div class="creneau-meta">
          <div class="meta-row"><i class="bi bi-clock"></i> 14h00 — 15h00</div>
          <div class="meta-row"><i class="bi bi-geo-alt"></i> Court A</div>
        </div>
        <div>
          <div class="places-bar"><div class="places-fill" style="width:50%"></div></div>
          <div class="places-label">1 place restante sur 2</div>
        </div>
        <a href="#" class="btn-reserver">Réserver ce créneau</a>
      </div>

    </div>
  </div>

  <div class="footer-public">FitSpace &copy; 2025 — Projet CodeIgniter 4 · Tous droits <span>réservés</span></div>
</section>
<?= $this->endSection() ?>