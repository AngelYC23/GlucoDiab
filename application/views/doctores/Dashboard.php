<div class="doctor-dashboard">

  <!-- Saludo dinámico -->
  <section class="welcome-section neu-section">
    <h2 id="greeting">Buenos días, <span><?= $this->session->userdata('nombre'); ?></span> 👋</h2>
    <p>Bienvenido a tu panel médico. Aquí puedes gestionar tus pacientes, agregar historiales y visualizar sus progresos.</p>
  </section>

  <!-- Accesos rápidos -->
  <div class="quick-actions">
    <div class="action-card neu-section">
      <h3>👩‍⚕️ Mis Pacientes</h3>
      <p>Consulta y gestiona la información de tus pacientes registrados.</p>
      <button class="neu-button small-btn">Ver lista</button>
    </div>

    <div class="action-card neu-section">
      <h3>📋 Historial Médico</h3>
      <p>Agrega o revisa registros médicos de tus pacientes fácilmente.</p>
      <button class="neu-button small-btn">Agregar historial</button>
    </div>

    <div class="action-card neu-section">
      <h3>⏰ Recordatorios</h3>
      <p>Configura alertas y recordatorios personalizados para tus pacientes.</p>
      <button class="neu-button small-btn">Programar</button>
    </div>

    <div class="action-card neu-section">
      <h3>📈 Control de Glucosa</h3>
      <p>Visualiza la evolución de la glucosa de tus pacientes por día, mes o año.</p>
      <button class="neu-button small-btn">Ver estadísticas</button>
    </div>
  </div>

  <!-- Espacio para futuras métricas o gráficos -->
  <section class="neu-section stats-preview">
    <h3>📊 Próximamente</h3>
    <p>Aquí podrás visualizar el progreso general de tus pacientes con gráficos interactivos.</p>
  </section>

</div>

<!-- Script de saludo dinámico -->
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const greeting = document.getElementById("greeting");
    const hour = new Date().getHours();
    let saludo = "Hola";

    if (hour >= 5 && hour < 12) saludo = "Buenos días";
    else if (hour >= 12 && hour < 18) saludo = "Buenas tardes";
    else saludo = "Buenas noches";

    greeting.innerHTML = `${saludo}, <span><?= $this->session->userdata('nombre'); ?></span> 👋`;
  });
</script>
