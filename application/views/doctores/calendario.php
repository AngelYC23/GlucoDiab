<div class="doctor-dashboard">
  <div class="agenda-card">
    <div class="card-header">
      <h2>Agenda Médica</h2>
      <p>Programa recordatorios y citas de seguimiento para tus pacientes.</p>
    </div>

    <div class="neu-section calendar-wrapper">
      <div id="calendar"></div>
    </div>
  </div>
</div>

<div id="recordatorioModal" class="modal">
  <div class="modal-content neu-section">
    <h3 id="modalTitle">📅 Nuevo Recordatorio</h3>
    <form id="formRecordatorio">
      <input type="hidden" id="fechaSeleccionada" name="fecha">
      
      <label for="paciente">Paciente:</label>
      <select id="paciente" name="id_usuario_recibe" required>
        <option value="">Selecciona un paciente</option>
        <?php foreach ($pacientes as $p): ?>
          <option value="<?= $p->id_usuario ?>"><?= $p->nombre ?></option>
        <?php endforeach; ?>
      </select>

      <label for="titulo">Título:</label>
      <input type="text" id="titulo" name="titulo" maxlength="150" required>

      <label for="color">Color:</label>
      <div class="color-picker-container">
        <input type="color" id="colorPicker" name="color" value="#3498db">
        <div class="color-presets">
          <button type="button" class="color-preset" data-color="#e74c3c" style="background: #e74c3c;" title="Rojo"></button>
          <button type="button" class="color-preset" data-color="#f39c12" style="background: #f39c12;" title="Naranja"></button>
          <button type="button" class="color-preset" data-color="#f1c40f" style="background: #f1c40f;" title="Amarillo"></button>
          <button type="button" class="color-preset" data-color="#2ecc71" style="background: #2ecc71;" title="Verde"></button>
          <button type="button" class="color-preset" data-color="#3498db" style="background: #3498db;" title="Azul"></button>
          <button type="button" class="color-preset" data-color="#9b59b6" style="background: #9b59b6;" title="Morado"></button>
          <button type="button" class="color-preset" data-color="#1abc9c" style="background: #1abc9c;" title="Turquesa"></button>
          <button type="button" class="color-preset" data-color="#34495e" style="background: #34495e;" title="Gris"></button>
        </div>
      </div>

      <label for="tipoEvento">Tipo de evento:</label>
      <select id="tipoEvento" name="tipo_evento" required>
        <option value="recordatorio">Recordatorio (solo hora)</option>
        <option value="cita">Cita/Reunión (hora inicio y fin)</option>
      </select>

      <label for="horaInicio">Hora inicio:</label>
      <input type="time" id="horaInicio" name="hora_inicio" required>

      <div id="horaFinContainer" style="display: none;">
        <label for="horaFin">Hora fin:</label>
        <input type="time" id="horaFin" name="hora_fin">
      </div>

      <label for="descripcion">Descripción:</label>
      <textarea id="descripcion" name="descripcion" rows="3" required placeholder="Detalles adicionales..."></textarea>

      <div class="botones">
        <button type="submit" class="neu-button">Guardar</button>
        <button type="button" class="neu-button cancelar">Cancelar</button>
      </div>
    </form>
  </div>
</div>

<div id="toast" class="toast hidden">
  <span id="toastMessage"></span>
</div>

<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/locales/es.global.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
  const calendarEl = document.getElementById("calendar");
  const modal = document.getElementById("recordatorioModal");
  const form = document.getElementById("formRecordatorio");
  const cancelarBtn = document.querySelector(".cancelar");
  const fechaInput = document.getElementById("fechaSeleccionada");
  const tituloInput = document.getElementById("titulo");
  const horaInicioInput = document.getElementById("horaInicio");
  const horaFinInput = document.getElementById("horaFin");
  const horaFinContainer = document.getElementById("horaFinContainer");
  const tipoEventoSelect = document.getElementById("tipoEvento");
  const descripcionInput = document.getElementById("descripcion");
  const pacienteSelect = document.getElementById("paciente");
  const colorPicker = document.getElementById("colorPicker");
  const modalTitle = document.getElementById("modalTitle");

  let editando = false;
  let recordatorioActual = null;

  document.querySelectorAll('.color-preset').forEach(btn => {
    btn.addEventListener('click', function() {
      const color = this.dataset.color;
      colorPicker.value = color;
      
      document.querySelectorAll('.color-preset').forEach(b => b.classList.remove('selected'));
      this.classList.add('selected');
    });
  });

  tipoEventoSelect.addEventListener("change", function() {
    if (this.value === "cita") {
      horaFinContainer.style.display = "block";
      horaFinInput.required = true;
    } else {
      horaFinContainer.style.display = "none";
      horaFinInput.required = false;
      horaFinInput.value = "";
    }
  });

  const calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: "dayGridMonth",
    locale: "es",
    selectable: true,
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
    events: "<?= site_url('doctores/get_recordatorios') ?>",
    
    eventDidMount: function(info) {
      const color = info.event.backgroundColor;
      info.el.style.borderLeft = `4px solid ${color}`;
      info.el.style.fontWeight = '500';
    },
    
    dateClick: function(info) {
      editando = false;
      recordatorioActual = null;
      form.reset();
      modalTitle.textContent = "📅 Nuevo Recordatorio";
      fechaInput.value = info.dateStr;
      horaInicioInput.value = "08:00";
      colorPicker.value = "#3498db";
      tipoEventoSelect.value = "recordatorio";
      horaFinContainer.style.display = "none";
      
      document.querySelectorAll('.color-preset').forEach(b => b.classList.remove('selected'));
      document.querySelector('.color-preset[data-color="#3498db"]')?.classList.add('selected');
      
      modal.style.display = "flex";
    },
    
    eventClick: function(info) {
      const evento = info.event;
      editando = true;
      recordatorioActual = evento.id;
      modalTitle.textContent = "✏️ Editar Recordatorio";
      
      const fechaStr = evento.startStr.split('T')[0];
      const horaInicio = evento.startStr.split('T')[1]?.slice(0, 5) || "08:00";
      
      fechaInput.value = fechaStr;
      horaInicioInput.value = horaInicio;
      tituloInput.value = evento.title;
      descripcionInput.value = evento.extendedProps.descripcion || "";
      
      colorPicker.value = evento.backgroundColor || "#3498db";
      document.querySelectorAll('.color-preset').forEach(b => {
        b.classList.toggle('selected', b.dataset.color === evento.backgroundColor);
      });
      
      if (evento.end) {
        const horaFin = evento.endStr.split('T')[1]?.slice(0, 5) || "";
        tipoEventoSelect.value = "cita";
        horaFinInput.value = horaFin;
        horaFinContainer.style.display = "block";
        horaFinInput.required = true;
      } else {
        tipoEventoSelect.value = "recordatorio";
        horaFinContainer.style.display = "none";
        horaFinInput.required = false;
      }
      
      Array.from(pacienteSelect.options).forEach(opt => {
        opt.selected = (opt.text === evento.extendedProps.paciente);
      });
      
      modal.style.display = "flex";
    }
  });

  calendar.render();
  form.addEventListener("submit", function(e) {
    e.preventDefault();
    
    const formData = new FormData(form);
    formData.append("editando", editando);
    if (editando) formData.append("id_recordatorio", recordatorioActual);

    fetch("<?= site_url('doctores/add_recordatorio') ?>", {
      method: "POST",
      body: formData
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        if (!editando) {
          const pacienteSeleccionado = pacienteSelect.options[pacienteSelect.selectedIndex];
          const nombrePaciente = pacienteSeleccionado ? pacienteSeleccionado.text : "";
          const color = colorPicker.value;
          
          const fechaHoraInicio = fechaInput.value + 'T' + horaInicioInput.value + ':00';
          
          const eventoData = {
            id: data.id_recordatorio,
            title: tituloInput.value.trim(),
            start: fechaHoraInicio,
            backgroundColor: color,
            borderColor: color,
            extendedProps: {
              descripcion: descripcionInput.value.trim(),
              paciente: nombrePaciente
            }
          };
          
          if (tipoEventoSelect.value === "cita" && horaFinInput.value) {
            eventoData.end = fechaInput.value + 'T' + horaFinInput.value + ':00';
          }
          
          calendar.addEvent(eventoData);
          mostrarToast("✅ Recordatorio agregado correctamente", "success");
        } else {
          calendar.refetchEvents();
          mostrarToast("✏️ Recordatorio actualizado correctamente", "success");
        }
      } else {
        mostrarToast("❌ Error al guardar el recordatorio", "error");
      }

      modal.style.display = "none";
      form.reset();
    })
    .catch(error => {
      console.error('Error:', error);
      mostrarToast("❌ Error de conexión", "error");
    });
  });

  cancelarBtn.addEventListener("click", () => {
    modal.style.display = "none";
    form.reset();
  });

  function mostrarToast(mensaje, tipo = "success") {
    const toast = document.getElementById("toast");
    const toastMsg = document.getElementById("toastMessage");

    toastMsg.textContent = mensaje;
    toast.className = `toast ${tipo} show`;

    setTimeout(() => toast.classList.remove("show"), 3000);
  }
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

/* 🔹 Estilo de eventos en el calendario */
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

/* 🔹 Popover cuando se hace clic en "+X más" */
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
}

@keyframes aparecer {
  from { opacity: 0; transform: scale(0.95); }
  to { opacity: 1; transform: scale(1); }
}

#modalTitle {
  color: #3d4468;
  margin-bottom: 20px;
  font-size: 1.4rem;
}

/* ---------- SELECTOR DE COLOR ---------- */
.color-picker-container {
  display: flex;
  flex-direction: column;
  gap: 12px;
  margin-top: 6px;
}

#colorPicker {
  width: 80px;
  height: 40px;
  border: none;
  border-radius: 10px;
  cursor: pointer;
  box-shadow: 3px 3px 6px #bec3cf, -3px -3px 6px #ffffff;
}

.color-presets {
  display: flex;
  gap: 8px;
  flex-wrap: wrap;
}

.color-preset {
  width: 36px;
  height: 36px;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  box-shadow: 3px 3px 6px #bec3cf, -3px -3px 6px #ffffff;
  transition: all 0.2s ease;
}

.color-preset:hover {
  transform: scale(1.1);
}

.color-preset.selected {
  box-shadow: inset 3px 3px 6px rgba(0,0,0,0.2), inset -3px -3px 6px rgba(255,255,255,0.5);
  transform: scale(0.95);
  border: 3px solid #fff;
}

/* ---------- INPUTS Y SELECT ---------- */
form label {
  font-weight: 600;
  color: #3d4468;
  display: block;
  margin-top: 12px;
  font-size: 14px;
}

input, select, textarea {
  width: 100%;
  margin-top: 6px;
  padding: 10px 12px;
  border: none;
  border-radius: 12px;
  background: #f5f7fb;
  box-shadow: inset 3px 3px 6px #bec3cf, inset -3px -3px 6px #ffffff;
  font-family: 'Inter', sans-serif;
  color: #3d4468;
  font-size: 14px;
}

input:focus, select:focus, textarea:focus {
  outline: none;
  box-shadow: inset 4px 4px 8px #bec3cf, inset -4px -4px 8px #ffffff;
}

input[type="time"] {
  font-size: 16px;
  font-weight: 500;
}

/* ---------- BOTONES ---------- */
.botones {
  display: flex;
  justify-content: center;
  gap: 15px;
  margin-top: 25px;
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

/* ---------- TOAST DE ÉXITO / ERROR ---------- */
.toast {
  position: fixed;
  bottom: 40px;
  left: 50%;
  transform: translateX(-50%);
  background: #e0e5ec;
  color: #3d4468;
  padding: 14px 22px;
  border-radius: 18px;
  box-shadow: 5px 5px 10px #bec3cf, -5px -5px 10px #ffffff;
  font-weight: 600;
  font-family: 'Inter', sans-serif;
  opacity: 0;
  pointer-events: none;
  transition: all 0.5s ease;
  z-index: 2000;
}

.toast.show {
  opacity: 1;
  bottom: 60px;
  pointer-events: auto;
}

.toast.success {
  border-left: 5px solid #5cb85c;
}

.toast.error {
  border-left: 5px solid #d9534f;
}

.toast.hidden {
  display: none;
}

/* --- Celulares pequeños (<= 480px) --- */
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
}
</style>