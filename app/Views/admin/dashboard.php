<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
  /* Petite structure flexbox pour afficher les deux graphiques côte à côte proprement */
  .charts-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 20px;
    margin-bottom: 20px;
  }
  .chart-card {
    background: #ffffff;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
  }
  .chart-card h3 {
    margin-top: 0;
    margin-bottom: 15px;
    font-size: 1rem;
    color: #333;
  }
</style>

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
          <div class="user-info"><div class="name"><?= esc($name) ?></div><div class="role"><?= esc($role) ?></div></div>
          <a href="/logout" style="margin-left:auto;color:rgba(255,255,255,0.3);font-size:1.1rem;"><i class="bi bi-box-arrow-right"></i></a>
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

        <div class="charts-row">
          <div class="chart-card">
            <h3>Taux d'occupation par semaine</h3>
            <canvas id="occupationChart"></canvas>
          </div>
          <div class="chart-card">
            <h3>Ressources les plus réservées</h3>
            <canvas id="resourcesChart"></canvas>
          </div>
        </div>

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
                    <span class="td-name"><?= esc($res['client_nom']) ?></span>
                  </div>
                </td>
                <td class="td-muted"><?= esc($res['ressource_type']) ?></td>
                <td class="td-muted"><?= date('d/m/Y H:i', strtotime($res['date_debut'])) ?></td>
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
</section>

<script>
    // 1. Évolution de l'occupation par semaine (Line Chart)
    const statsSemaines = <?= json_encode($statsSemaines) ?>;
    const labelsSemaines = statsSemaines.map(item => 'Semaine ' + item.semaine);
    const dataSemaines = statsSemaines.map(item => item.total);

    const ctxOccupation = document.getElementById('occupationChart').getContext('2d');
    new Chart(ctxOccupation, {
        type: 'line',
        data: {
            labels: labelsSemaines,
            datasets: [{
                label: 'Réservations',
                data: dataSemaines, 
                borderColor: '#3498db',
                backgroundColor: 'rgba(52, 152, 219, 0.1)',
                borderWidth: 2,
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { 
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1 // Force l'affichage des entiers uniquement (1, 2, 3...)
                    }
                }
            }
        }
    });

    // 2. Top ressources réservées (Horizontal Bar Chart)
    const statsRessources = <?= json_encode($statsRessources) ?>;
    const labelsRessources = statsRessources.map(item => item.ressource_nom);
    const dataRessources = statsRessources.map(item => item.total);

    const ctxResources = document.getElementById('resourcesChart').getContext('2d');
    new Chart(ctxResources, {
        type: 'bar',
        data: {
            labels: labelsRessources,
            datasets: [{
                label: 'Nombre de réservations',
                data: dataRessources,
                backgroundColor: [
                    '#2ecc71',
                    '#3498db',
                    '#f39c12',
                    '#e74c3c'
                ],
                borderWidth: 0,
                borderRadius: 4
            }]
        },
        options: {
            indexAxis: 'y', // Mode barres horizontales
            responsive: true,
            scales: {
                x: { 
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1 // Force l'affichage des entiers uniquement (1, 2, 3...)
                    }
                }
            }
        }
    });
</script>

<?= $this->endSection() ?>