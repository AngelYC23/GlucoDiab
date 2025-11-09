<div class="paciente-dashboard">

  <!-- Saludo dinámico -->
  <section class="welcome-section neu-section">
    <h2 id="greeting">Buenos días, <span><?= $this->session->userdata('nombre'); ?></span> 🌞</h2>
    <p>Bienvenido a tu panel personal. Aquí podrás registrar tus mediciones, ver tus recordatorios y mantenerte en contacto con tu doctor.</p>
  </section>

  <!-- Acciones principales -->
  <div class="patient-actions">
    <div class="action-card neu-section">
      <h3>🩸 Registrar Glucosa</h3>
      <p>Agrega tus niveles de glucosa del día según las indicaciones de tu doctor.</p>
      <button class="neu-button small-btn">Registrar</button>
    </div>

    <div class="action-card neu-section">
      <h3>📆 Recordatorios</h3>
      <p>Consulta tus próximos controles o notificaciones médicas.</p>
      <button class="neu-button small-btn" onclick="window.location.href='<?= site_url('pacientes/calendario') ?>'">Ver recordatorios</button>
    </div>

    <div class="action-card neu-section">
      <h3>📊 Mi Progreso</h3>
      <p>Visualiza cómo han variado tus niveles de glucosa a lo largo del tiempo.</p>
      <button class="neu-button small-btn">Ver progreso</button>
    </div>
  </div>

  <!-- Espacio futuro para recomendaciones -->
  <section class="neu-section recomendaciones">
    <h3>💡 Recomendaciones del día</h3>
    <ul>
      <li>Desayuna dentro de la primera hora después de despertar.</li>
      <li>Realiza al menos 30 minutos de caminata ligera.</li>
      <li>Evita el exceso de azúcares simples.</li>
      <li>Mantén una buena hidratación.</li>
    </ul>
  </section>

  <!-- Ícono flotante de chat -->
  <div class="chat-icon" id="chatIcon" title="Chatear con tu doctor">
    💬
  </div>

  <!-- Ventana flotante del chat -->
  <div class="chat-window" id="chatWindow">
    <div class="chat-header">
      <span>Dra. Joselyn</span>
      <button id="closeChat">×</button>
    </div>
    <div class="chat-body">
      
      
    </div>
    <div class="chat-input">
      <input type="text" id="messageInput" placeholder="Escribe un mensaje..." />
      <button id="sendMessage">Enviar</button>
    </div>
  </div>

</div>

<script>
  window.PACIENTE_ID = "<?= $this->session->userdata('id_usuario'); ?>";
  window.USER_ROLE = "<?= $this->session->userdata('id_rol'); ?>";
  window.USER_NAME = "<?= $this->session->userdata('nombre'); ?>";
</script>

<script type="module" src="<?= base_url('assets/js/firebase-config.js') ?>"></script>
<script type="module" src="<?= base_url('assets/js/chat-paciente.js') ?>"></script>

<!-- Script para saludo y chat -->
<script>
document.addEventListener("DOMContentLoaded", function() {
  const greeting = document.getElementById("greeting");
  const hour = new Date().getHours();
  let saludo = "Hola";

  if (hour >= 5 && hour < 12) saludo = "Buenos días";
  else if (hour >= 12 && hour < 18) saludo = "Buenas tardes";
  else saludo = "Buenas noches";

  greeting.innerHTML = `${saludo}, <span><?= $this->session->userdata('nombre'); ?></span> 👋`;

  // Chat
  const chatIcon = document.getElementById("chatIcon");
  const chatWindow = document.getElementById("chatWindow");
  const closeChat = document.getElementById("closeChat");
  const sendMessage = document.getElementById("sendMessage");
  const input = document.getElementById("messageInput");
  const chatBody = document.querySelector(".chat-body");

  chatIcon.addEventListener("click", () => chatWindow.classList.add("open"));
  closeChat.addEventListener("click", () => chatWindow.classList.remove("open"));
});
</script>
