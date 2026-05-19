<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<style>
.custom-modal{
    position:fixed;
    inset:0;
    background:rgba(0,0,0,0.5);
    display:none;
    justify-content:center;
    align-items:center;
    z-index:9999;
}

.custom-modal-content{
    background:white;
    padding:25px;
    border-radius:12px;
    width:350px;
    display:flex;
    flex-direction:column;
    gap:12px;
}
</style>

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
<div id="eventModal" class="custom-modal">

    <div class="custom-modal-content">

        <h3>Ajouter un événement</h3>

        <input
            type="text"
            id="eventTitle"
            placeholder="Titre"
            class="form-control"
        >

        <input
            type="time"
            id="eventStart"
            class="form-control"
        >

        <input
            type="time"
            id="eventEnd"
            class="form-control"
        >

        <div style="display:flex;gap:10px;margin-top:15px;">

            <button id="saveEventBtn" class="btn-submit">
                Ajouter
            </button>

            <button id="closeModalBtn" class="btn-secondary-custom">
                Annuler
            </button>

        </div>

    </div>

</div>
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet">

<script src="assets/js/index.global.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const calendarEl = document.getElementById('calendar');

    const modal = document.getElementById('eventModal');

    const titleInput = document.getElementById('eventTitle');

    const startInput = document.getElementById('eventStart');

    const endInput = document.getElementById('eventEnd');

    const saveBtn = document.getElementById('saveEventBtn');

    const closeBtn = document.getElementById('closeModalBtn');

    let selectedDate = null;

    const calendar = new FullCalendar.Calendar(calendarEl, {

        initialView: 'dayGridMonth',

        locale: 'fr',

        firstDay: 1,

        height: 'auto',

        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },

        events: '/events',

        dateClick: function(info) {

            selectedDate = info.dateStr;

            modal.style.display = 'flex';
        }
    });

    saveBtn.addEventListener('click', function () {

        const title = titleInput.value.trim();

        const startHour = startInput.value;

        const endHour = endInput.value;

        if (!title || !startHour || !endHour) {

            alert('Veuillez remplir tous les champs');

            return;
        }

        const start = selectedDate + 'T' + startHour + ':00';

        const end = selectedDate + 'T' + endHour + ':00';


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

                modal.style.display = 'none';

                titleInput.value = '';

                startInput.value = '';

                endInput.value = '';

            } else {

                alert("Erreur lors de l'ajout.");
            }
        })

        .catch(error => {

            console.error(error);

            alert('Erreur serveur');
        });
    });

    closeBtn.addEventListener('click', function () {

        modal.style.display = 'none';
    });

    window.addEventListener('click', function (e) {

        if (e.target === modal) {

            modal.style.display = 'none';
        }
    });

    calendar.render();
});
</script>
<?= $this->endSection() ?>