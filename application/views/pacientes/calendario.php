<div class="doctor-dashboard">
  <div class="agenda-card">
    <div class="card-header">
      <h2>Mi Agenda</h2>
      <p>Consulta tus recordatorios, citas y actividades asignadas por tu médico.</p>
    </div>

    <div class="neu-section calendar-wrapper">
      <div id="calendar"></div>
    </div>
  </div>
</div>

<div id="detalleModal" class="modal">
  <div class="modal-content neu-section">
    <h3 id="detalleTitulo">📋 Detalles del Evento</h3>
    <p id="detalleDescripcion" class="detalle-descripcion"></p>
    <p><b>📆 Fecha:</b> <span id="detalleFecha"></span></p>
    <p><b>⏰ Hora:</b> <span id="detalleHora"></span></p>
    <div class="botones">
      <button type="button" class="neu-button cerrar">Cerrar</button>
    </div>
  </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/locales/es.global.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
  const calendarEl = document.getElementById("calendar");
  const modal = document.getElementById("detalleModal");
  const cerrarBtn = modal.querySelector(".cerrar");

  const detalleTitulo = document.getElementById("detalleTitulo");
  const detalleDescripcion = document.getElementById("detalleDescripcion");
  const detalleFecha = document.getElementById("detalleFecha");
  const detalleHora = document.getElementById("detalleHora");

  const calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: "dayGridMonth",
    locale: "es",
    selectable: false,
    editable: false,
    height: "auto",
    headerToolbar: {
      left: "prev,next",
      center: "title",
      right: "dayGridMonth,timeGridWeek,timeGridDay"
    },
    buttonText: {
      month: "Mes",
      week: "Semana",
      day: "Día"
    },
    dayMaxEvents: 1,
    moreLinkText: function(num) {
      return "+ " + num + " más";
    },
    moreLinkClick: "popover",

    displayEventTime: true,
    eventTimeFormat: {
      hour: '2-digit',
      minute: '2-digit',
      hour12: true,
      meridiem: 'short'
    },
    slotMinTime: "06:00:00",
    slotMaxTime: "22:00:00",

    events: "<?= site_url('pacientes/get_recordatorios_asignados') ?>",

    eventDidMount: function(info) {
      const color = info.event.backgroundColor || "#3498db";
      info.el.style.borderLeft = `4px solid ${color}`;
      info.el.style.fontWeight = "500";
    },

    eventClick: function(info) {
      const evento = info.event;
      detalleTitulo.textContent = evento.title;
      detalleDescripcion.textContent = evento.extendedProps.descripcion || "Sin descripción disponible.";
      detalleFecha.textContent = new Date(evento.start).toLocaleDateString("es-ES", {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric"
      });
      if (evento.start) {
        const inicio = new Date(evento.start).toLocaleTimeString("es-ES", {
          hour: "2-digit",
          minute: "2-digit"
        });
        const fin = evento.end
          ? new Date(evento.end).toLocaleTimeString("es-ES", { hour: "2-digit", minute: "2-digit" })
          : "";
        detalleHora.textContent = fin ? `${inicio} - ${fin}` : inicio;
      } else {
        detalleHora.textContent = "—";
      }
      modal.style.display = "flex";
    }
  });

  calendar.render();

  cerrarBtn.addEventListener("click", () => (modal.style.display = "none"));
  modal.addEventListener("click", (e) => {
    if (e.target === modal) modal.style.display = "none";
  });
});
</script>

<style>
/* ---------- ESTRUCTURA PRINCIPAL ---------- */
.doctor-dashboard {
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 50px 20px;
  font-family: 'Inter', sans-serif;
}

/* ---------- TARJETA DE CALENDARIO ---------- */
.agenda-card {
  background: #e0e5ec;
  border-radius: 25px;
  padding: 35px 40px;
  box-shadow: 15px 15px 30px #bec3cf, -15px -15px 30px #ffffff;
  width: 100%;
  max-width: 900px;
  transition: transform 0.3s ease;
}

/* ---------- ENCABEZADO ---------- */
.card-header {
  text-align: center;
  margin-bottom: 25px;
}

.card-header h2 {
  font-weight: 600;
  font-size: 1.8rem;
  color: #3d4468;
  margin-bottom: 8px;
}

.card-header p {
  color: #6c7293;
  font-size: 15px;
}

/* ---------- CONTENEDOR DEL CALENDARIO ---------- */
.calendar-wrapper {
  background: #e0e5ec;
  border-radius: 20px;
  box-shadow: inset 6px 6px 12px #bec3cf, inset -6px -6px 12px #ffffff;
  padding: 25px;
}

#calendar {
  background: #f5f7fb;
  border-radius: 15px;
  box-shadow: 5px 5px 10px #bec3cf, -5px -5px 10px #ffffff;
  padding: 15px;
}

/* 🔹 Eventos en el calendario */
.fc-event {
  border-radius: 6px !important;
  padding: 2px 4px !important;
  margin: 1px 0 !important;
  font-size: 13px !important;
}

.fc-daygrid-event {
  white-space: normal !important;
}

/* 🔹 Link "+X más" */
.fc-daygrid-more-link {
  color: #3498db !important;
  font-weight: 600 !important;
  font-size: 12px !important;
  margin-top: 2px !important;
  text-decoration: none !important;
}

.fc-daygrid-more-link:hover {
  color: #2980b9 !important;
  text-decoration: underline !important;
}

/* 🔹 Popover */
.fc-popover {
  background: #e0e5ec !important;
  border: none !important;
  border-radius: 15px !important;
  box-shadow: 8px 8px 16px #bec3cf, -8px -8px 16px #ffffff !important;
  padding: 10px !important;
  z-index: 1000 !important;
}

.fc-popover-header {
  background: transparent !important;
  color: #3d4468 !important;
  font-weight: 600 !important;
  border-bottom: 2px solid #d0d5dc !important;
  padding: 8px 12px !important;
}

.fc-popover-close {
  color: #3d4468 !important;
  opacity: 0.7 !important;
}

.fc-popover-close:hover {
  opacity: 1 !important;
}

.fc-popover-body {
  padding: 8px !important;
}

/* 🔹 Altura fija de celdas para evitar que crezcan mucho */
.fc-daygrid-day-frame {
  min-height: 100px !important;
  max-height: 120px !important;
}

.fc-daygrid-day-events {
  margin-bottom: 2px !important;
}

/* ---------- BOTONES DEL CALENDARIO ---------- */
.fc-button {
  background: #e0e5ec !important;
  border: none !important;
  color: #3d4468 !important;
  border-radius: 12px !important;
  box-shadow: 4px 4px 8px #bec3cf, -4px -4px 8px #ffffff;
  transition: all 0.25s ease;
  font-size: 13px !important;
  padding: 6px 12px !important;
}

.fc-button:hover {
  background: linear-gradient(145deg, #ffffff, #d9dee5) !important;
  transform: translateY(-2px);
}

.fc-button-active {
  background: linear-gradient(145deg, #d9dee5, #ffffff) !important;
  box-shadow: inset 3px 3px 6px #bec3cf, inset -3px -3px 6px #ffffff !important;
}

/* ---------- MODAL ---------- */
.modal {
  display: none;
  position: fixed;
  inset: 0;
  background: rgba(224, 229, 236, 0.65);
  backdrop-filter: blur(6px);
  justify-content: center;
  align-items: center;
  z-index: 999;
}

.modal-content {
  width: 450px;
  max-width: 95%;
  background: #e0e5ec;
  border-radius: 25px;
  padding: 30px;
  box-shadow: 12px 12px 25px #bec3cf, -12px -12px 25px #ffffff;
  animation: aparecer 0.3s ease;
  max-height: 90vh;
  overflow-y: auto;
  text-align: center;
}

@keyframes aparecer {
  from { opacity: 0; transform: scale(0.95); }
  to { opacity: 1; transform: scale(1); }
}

#detalleTitulo {
  color: #3d4468;
  margin-bottom: 15px;
  font-size: 1.4rem;
}

.detalle-descripcion {
  background: #f5f7fb;
  padding: 10px;
  border-radius: 10px;
  box-shadow: inset 3px 3px 6px #bec3cf, inset -3px -3px 6px #ffffff;
  color: #3d4468;
  font-size: 14px;
  margin-bottom: 10px;
}

/* ---------- BOTÓN CERRAR ---------- */
.botones {
  display: flex;
  justify-content: center;
  gap: 15px;
  margin-top: 20px;
}

.neu-button {
  background: #e0e5ec;
  border: none;
  border-radius: 14px;
  padding: 10px 18px;
  color: #3d4468;
  font-weight: 600;
  cursor: pointer;
  box-shadow: 5px 5px 10px #bec3cf, -5px -5px 10px #ffffff;
  transition: all 0.2s ease;
}

.neu-button:hover {
  background: linear-gradient(145deg, #ffffff, #d9dee5);
  transform: translateY(-2px);
}

.neu-button:active {
  transform: translateY(0);
  box-shadow: inset 3px 3px 6px #bec3cf, inset -3px -3px 6px #ffffff;
}

/* --- Separación más amplia entre los botones del calendario --- */
.fc-toolbar.fc-header-toolbar {
  margin-bottom: 1.2rem !important;
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 14px !important; /* espacio entre los grupos (prev/next, título, vistas) */
}

.fc-toolbar-chunk {
  display: flex;
  align-items: center;
  gap: 10px; /* separación entre botones dentro de cada grupo */
}

.fc-toolbar-chunk button {
  margin: 0 6px !important; /* más separación lateral */
}

.fc-toolbar-title {
  margin: 0 10px !important; /* espacio lateral respecto a los botones */
  color: #3d4468;
  font-weight: 600;
  font-size: 1.4rem !important;
}

/* --- Celulares pequeños --- */
@media (max-width: 480px) {
  .doctor-dashboard {
    padding: 15px 10px;
  }

  .agenda-card {
    width: 100%;
    padding: 18px;
    border-radius: 18px;
  }

  .card-header h2 {
    font-size: 1.2rem;
  }

  .card-header p {
    font-size: 13px;
  }

  #calendar {
    padding: 8px;
    box-shadow: 3px 3px 8px #bec3cf, -3px -3px 8px #ffffff;
  }

  .fc-toolbar.fc-header-toolbar {
    flex-direction: column !important;
    gap: 10px;
  }

  .fc-toolbar-chunk {
    gap: 6px;
  }

  .fc-button {
    font-size: 11px !important;
    padding: 5px 9px !important;
  }

  .fc-toolbar-title {
    font-size: 1.1rem !important;
  }

  .modal-content {
    width: 95%;
    padding: 20px;
    max-height: 88vh;
    border-radius: 18px;
  }

  #modalTitle {
    font-size: 1.2rem;
  }

  .color-presets {
    gap: 6px;
  }

  .color-preset {
    width: 32px;
    height: 32px;
  }

  .botones {
    flex-direction: column;
    gap: 10px;
  }

  .neu-button {
    width: 100%;
    font-size: 14px;
    padding: 9px 14px;
  }

  #detalleTitulo {
    font-size: 1.2rem;
  }
}
</style>