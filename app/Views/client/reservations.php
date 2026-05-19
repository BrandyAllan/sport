<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>


<section id="page-mes-reservations">
  <div class="app-wrapper">
    <aside class="sidebar">
      <div class="sidebar-logo">Fit<span>Space</span></div>
      <ul class="sidebar-nav" style="margin-top:1rem;">
        <li><a href="/dashboard"><i class="bi bi-grid-1x2-fill"></i> Tableau de bord</a></li>
        <li><a href="/creneau"><i class="bi bi-calendar3"></i> Voir les créneaux</a></li>
        <li><a href="/reservation" class="active"><i class="bi bi-bookmark-check-fill"></i> Mes réservations</a></li>
        <li><a href="/profil"><i class="bi bi-person-fill"></i> Mon profil</a></li>
      </ul>
      <div class="sidebar-footer">
        <div class="sidebar-user">
          <div class="avatar"><?= strtoupper(substr($name, 0, 2)) ?></div>
          <div class="user-info"><div class="name"><?= $name ?></div><div class="role">Client</div></div>
          <a href="/logout" style="margin-left:auto;color:rgba(255,255,255,0.3);font-size:1.1rem;" title="Déconnexion"><i class="bi bi-box-arrow-right"></i></a>
        </div>
      </div>
    </aside>

    <div class="main-content">
        <div class="topbar">
            <span class="topbar-title">Calendrier de mes réservations</span>
        </div>

        <div class="page-content">
            <div class="data-card">
                <div class="data-card-header">
                    <h3>Calendrier</h3>
                </div>

                <div id="calendar"></div>
            </div>
        </div>
    </div>
</section>

<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const calendarEl = document.getElementById('calendar');

    const calendar = new FullCalendar.Calendar(calendarEl, {

        initialView: 'dayGridMonth',
        locale: 'fr',

        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },

        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },

        events: '/events',

        /*
        |--------------------------------------------------------------------------
        | Sélection avec heure
        |--------------------------------------------------------------------------
        */

        dateClick: function(info) {
            let title = prompt("Titre de l'événement :");
            if (!title) return;

            let heureDebut = prompt("Heure de début ? Exemple : 14:00");
            if (!heureDebut) return;

            let heureFin = prompt("Heure de fin ? Exemple : 16:00");
            if (!heureFin) return;

            let start = info.dateStr + "T" + heureDebut + ":00";
            let end   = info.dateStr + "T" + heureFin + ":00";

            fetch('/events/save', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body:
                    'title=' + encodeURIComponent(title) +
                    '&start=' + encodeURIComponent(start) +
                    '&end=' + encodeURIComponent(end)
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    calendar.refetchEvents();
                } else {
                    alert("Erreur lors de l'ajout.");
                }
            });
        }
    });

    calendar.render();
});
</script>
<?= $this->endSection() ?>