<div class="doctor-dashboard">
  <div class="pacientes-card">
    <div class="card-header">
      <h2>👩‍⚕️ Mis Pacientes</h2>
      <p>Listado general de pacientes registrados en <span>GlucoDiab</span></p>
    </div>

    <div class="tabla-pacientes neu-section">
      <table class="tabla">
        <thead>
          <tr>
            <th>#</th>
            <th>Nombre</th>
            <th class="acciones-header">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1; foreach ($pacientes as $p): ?>
          <tr>
            <td><?= $i++ ?></td>
            <td><?= $p->nombre ?></td>
            <td class="acciones">
              <button class="btn-accion historial" title="Agregar historial médico">🩺</button>
              <button class="btn-accion glucosa" title="Ver control de glucosa">📊</button>
              <button class="btn-accion baja" title="Dar de baja">❌</button>
              <button class="btn-accion mensaje" title="Enviar recordatorio o mensaje">💬</button>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<style>
  /* ---------- CONTENEDOR PRINCIPAL ---------- */
  .doctor-dashboard {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 50px 20px;
    font-family: 'Inter', sans-serif;
  }

  /* ---------- TARJETA PRINCIPAL ---------- */
  .pacientes-card {
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

  .card-header span {
    color: #5a8dee;
    font-weight: 600;
  }

  /* ---------- TABLA ---------- */
  .neu-section {
    background: #e0e5ec;
    border-radius: 20px;
    box-shadow: inset 6px 6px 12px #bec3cf, inset -6px -6px 12px #ffffff;
    padding: 20px;
  }

  .tabla {
    width: 100%;
    border-collapse: collapse;
    border-radius: 15px;
    overflow: hidden;
  }

  .tabla thead tr {
    background: #5a8dee;
    color: white;
    text-align: left;
  }

  .tabla th, .tabla td {
    padding: 14px 18px;
    border-bottom: 1px solid #d1d9e6;
  }

  .tabla th.acciones-header {
    text-align: center;
  }

  .tabla td.acciones {
    text-align: center;
  }

  .tabla tbody tr {
    transition: 0.3s ease;
    background: #f5f7fb;
  }

  .tabla tbody tr:hover {
    background: #edf2ff;
  }

  /* ---------- BOTONES ---------- */
  .acciones {
    display: flex;
    justify-content: center;
    gap: 12px;
  }

  .btn-accion {
    border: none;
    border-radius: 10px;
    background: #e0e5ec;
    box-shadow: 4px 4px 8px #bec3cf, -4px -4px 8px #ffffff;
    padding: 8px 10px;
    font-size: 1.2rem;
    cursor: pointer;
    transition: all 0.2s ease;
  }

  .btn-accion:hover {
    background: linear-gradient(145deg, #ffffff, #d8dde3);
    transform: translateY(-2px);
  }

  /* Colores de hover personalizados */
  .btn-accion.historial:hover {
    background: #e0f7fa;
  }

  .btn-accion.glucosa:hover {
    background: #e6f4ea;
  }

  .btn-accion.baja:hover {
    background: #ffeaea;
  }

  .btn-accion.mensaje:hover {
    background: #f0f3ff;
  }

  /* ---------- RESPONSIVE ---------- */
  @media (max-width: 768px) {
    .tabla th:nth-child(1),
    .tabla td:nth-child(1) { display: none; }

    .pacientes-card {
      padding: 25px;
    }

    .acciones {
      flex-wrap: wrap;
      gap: 8px;
    }
  }
</style>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    const botonesHistorial = document.querySelectorAll(".btn-accion.historial");
    const botonesGlucosa = document.querySelectorAll(".btn-accion.glucosa");
    const botonesBaja = document.querySelectorAll(".btn-accion.baja");
    const botonesMensaje = document.querySelectorAll(".btn-accion.mensaje");

    botonesHistorial.forEach(btn => {
      btn.addEventListener("click", () => alert("Abrir formulario de historial médico."));
    });

    botonesGlucosa.forEach(btn => {
      btn.addEventListener("click", () => alert("Ver gráfico/control de glucosa del paciente."));
    });

    botonesBaja.forEach(btn => {
      btn.addEventListener("click", () => {
        if (confirm("¿Deseas dar de baja a este paciente?")) {
          alert("Paciente dado de baja.");
        }
      });
    });

    botonesMensaje.forEach(btn => {
      btn.addEventListener("click", () => alert("Enviar recordatorio o mensaje."));
    });
  });
</script>
