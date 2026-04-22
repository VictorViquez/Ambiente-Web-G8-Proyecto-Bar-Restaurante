<?php include __DIR__ . '/../layout/header.php'; ?>

<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet">

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Calendario de reservas</h2>
        <a href="<?= base_url('/index.php?route=reservas.create') ?>" class="btn btn-primary">
            Nueva reserva
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div id="calendar"></div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        height: 'auto',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: [
            <?php foreach ($reservas as $r): ?>
            {
                title: '<?= addslashes($r['nombre']) ?> - <?= (int)$r['personas'] ?> persona(s)',
                start: '<?= $r['fecha'] ?>T<?= $r['hora'] ?>',
                extendedProps: {
                    estado: '<?= addslashes($r['estado']) ?>'
                }
            },
            <?php endforeach; ?>
        ],
        eventDidMount: function(info) {
            info.el.title = 'Estado: ' + info.event.extendedProps.estado;
        }
    });

    calendar.render();
});
</script>

<?php include __DIR__ . '/../layout/footer.php'; ?>