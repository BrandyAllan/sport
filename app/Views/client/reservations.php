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

  </div>
</section>

<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet">



<script>
document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'fr',
        firstDay: 1,

        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },

        // URL unique gérée par l'EventController
        events: '/events',

        // ACTION 1 : Clic sur un jour vide -> Code du Prof (Ajouter un événement texte)
        dateClick: function(info) {
            let title = prompt("Ajouter une note/événement perso pour ce jour :");
            if (!title) return;

            fetch('/events/save', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: 'title=' + encodeURIComponent(title) + '&start=' + info.dateStr + '&end=' + info.dateStr
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    calendar.refetchEvents(); // Recharge instantanément le calendrier
                } else {
                    alert("Erreur lors de l'enregistrement.");
                }
            })
            .catch(error => console.error('Erreur:', error));
        },

        // ACTION 2 : Clic sur un bouton du calendrier -> Gestion FitSpace (S'inscrire à un cours)
        eventClick: function(info) {
            const typeEvent = info.event.extendedProps.type;
            const creneauId = info.event.id;
            const coursTitre = info.event.title;

            // Si c'est une note du prof ou un cours déjà réservé, on ne fait rien pour la réservation
            if (typeEvent === 'prof_event' || typeEvent === 'deja_reserve') {
                alert("Vous êtes déjà lié à cet élément.");
                return;
            }

            // Si c'est un créneau de sport libre (couleur grise)
            if (typeEvent === 'creneau_libre') {
                if (confirm(`Voulez-vous réserver votre place pour le cours : ${coursTitre} ?`)) {
                    // Redirection directe vers ta méthode de réservation SQL d'origine
                    window.location.href = '/reserver/' + creneauId;
                }
            }
        }
    });

    calendar.render();
});
</script>
<?= $this->endSection() ?>