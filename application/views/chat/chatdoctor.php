<div class="doctor-dashboard">
  <div class="chat-layout">
    <aside class="patient-list-sidebar" id="patientListSidebar">
      <div class="sidebar-header">
        <h3>📋 Pacientes</h3>
      </div>
      <ul class="patients-list">
        <?php foreach ($pacientes as $p): ?>
          <li class="patient-item" data-id="<?= $p->id_usuario ?>">
            <div class="patient-avatar-circle">
              <span><?= strtoupper(substr($p->nombre, 0, 1)) ?></span>
            </div>
            <div class="patient-data">
              <strong class="patient-name"><?= $p->nombre ?></strong>
              <small class="last-message">Cargando...</small>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>
    </aside>

    <section class="chat-window-main" id="chatWindowMain">
      <div class="chat-header">
        <button class="back-button" id="backToList">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M19 12H5M12 19l-7-7 7-7"/>
          </svg>
        </button>
        <div class="chat-user-info">
          <div class="chat-avatar-header">
            <span id="chatAvatar">?</span>
          </div>
          <span id="chatWith">Selecciona un paciente</span>
        </div>
      </div>
      <div class="chat-body" id="chatBody">
        <div class="empty-state">
          <div class="empty-icon">💬</div>
          <p>Selecciona un paciente para comenzar la conversación</p>
        </div>
      </div>
      <div class="chat-input">
        <input type="text" id="messageInput" placeholder="Escribe un mensaje..." disabled />
        <button id="sendMessage" disabled>
          <span>Enviar</span>
        </button>
      </div>
    </section>
  </div>
</div>

<script type="module" src="<?= base_url('assets/js/firebase-config.js') ?>"></script>
<script type="module" src="<?= base_url('assets/js/chat-doctor.js') ?>"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const patientItems = document.querySelectorAll('.patient-item');
  const chatWindow = document.getElementById('chatWindowMain');
  const patientList = document.getElementById('patientListSidebar');
  const backButton = document.getElementById('backToList');
  
  patientItems.forEach(item => {
    item.addEventListener('click', function() {
      if (window.innerWidth <= 768) {
        chatWindow.classList.add('show-mobile');
        patientList.classList.add('hide-mobile');
      }
    });
  });

  backButton.addEventListener('click', function() {
    chatWindow.classList.remove('show-mobile');
    patientList.classList.remove('hide-mobile');
  });

  window.addEventListener('resize', function() {
    if (window.innerWidth > 768) {
      chatWindow.classList.remove('show-mobile');
      patientList.classList.remove('hide-mobile');
    }
  });
});
</script>

<style>
/* ============================= */
/* CHAT DOCTOR - ESTILO NEUMÓRFICO */
/* ============================= */

.chat-layout {
  display: flex;
  gap: 25px;
  margin-top: 30px;
  height: calc(100vh - 250px);
  min-height: 600px;
}

/* ============================= */
/* SIDEBAR DE PACIENTES */
/* ============================= */

.patient-list-sidebar {
  width: 360px;
  background: #e0e5ec;
  border-radius: 20px;
  box-shadow:
    8px 8px 20px #bec3cf,
    -8px -8px 20px #ffffff;
  display: flex;
  flex-direction: column;
  overflow: hidden;
  transition: all 0.3s ease;
}

.sidebar-header {
  background: linear-gradient(135deg, #5a8dee 0%, #4a7dd6 100%);
  padding: 20px;
  box-shadow: 0 4px 12px rgba(90, 141, 238, 0.3);
}

.sidebar-header h3 {
  color: white;
  font-size: 1.1rem;
  font-weight: 600;
  margin: 0;
  letter-spacing: 0.3px;
}

.patients-list {
  list-style: none;
  padding: 12px;
  overflow-y: auto;
  flex: 1;
}

.patients-list::-webkit-scrollbar {
  width: 6px;
}

.patients-list::-webkit-scrollbar-track {
  background: transparent;
}

.patients-list::-webkit-scrollbar-thumb {
  background: #bec3cf;
  border-radius: 10px;
}

.patients-list::-webkit-scrollbar-thumb:hover {
  background: #9499b7;
}

.patient-item {
  display: flex;
  align-items: center;
  gap: 14px;
  padding: 14px;
  margin-bottom: 10px;
  cursor: pointer;
  border-radius: 15px;
  background: #e0e5ec;
  transition: all 0.3s ease;
  box-shadow:
    4px 4px 10px #bec3cf,
    -4px -4px 10px #ffffff;
}

.patient-item:hover {
  transform: translateY(-2px);
  box-shadow:
    6px 6px 14px #bec3cf,
    -6px -6px 14px #ffffff;
}

.patient-item.active {
  background: linear-gradient(135deg, #dce9fc 0%, #c8dcf5 100%);
  box-shadow:
    inset 4px 4px 8px #b0c5e0,
    inset -4px -4px 8px #ffffff;
}

.patient-avatar-circle {
  width: 48px;
  height: 48px;
  border-radius: 50%;
  background: linear-gradient(135deg, #5a8dee 0%, #4a7dd6 100%);
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-weight: 700;
  font-size: 1.2rem;
  box-shadow:
    4px 4px 10px rgba(90, 141, 238, 0.4),
    -2px -2px 6px rgba(255, 255, 255, 0.8);
  flex-shrink: 0;
}

.patient-data {
  flex: 1;
  min-width: 0;
}

.patient-name {
  display: block;
  color: #3d4468;
  font-size: 0.95rem;
  font-weight: 600;
  margin-bottom: 4px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.last-message {
  display: block;
  color: #9499b7;
  font-size: 0.85rem;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

/* ============================= */
/* VENTANA DE CHAT PRINCIPAL */
/* ============================= */

.chat-window-main {
  flex: 1;
  background: #e0e5ec;
  border-radius: 20px;
  box-shadow:
    8px 8px 20px #bec3cf,
    -8px -8px 20px #ffffff;
  display: flex;
  flex-direction: column;
  overflow: hidden;
}

.chat-header {
  background: linear-gradient(135deg, #5a8dee 0%, #4a7dd6 100%);
  padding: 18px 24px;
  box-shadow: 0 2px 8px rgba(90, 141, 238, 0.25);
  border-bottom: 1px solid rgba(255, 255, 255, 0.2);
  display: flex;
  align-items: center;
  gap: 12px;
}

.back-button {
  display: none;
  background: transparent;
  border: none;
  color: white;
  cursor: pointer;
  padding: 4px;
  border-radius: 8px;
  transition: all 0.3s ease;
}

.back-button:hover {
  background: rgba(255, 255, 255, 0.2);
}

.back-button svg {
  display: block;
}

.chat-user-info {
  display: flex;
  align-items: center;
  gap: 14px;
}

.chat-avatar-header {
  width: 42px;
  height: 42px;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.25);
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-weight: 700;
  font-size: 1.1rem;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

#chatWith {
  color: white;
  font-size: 1rem;
  font-weight: 600;
  letter-spacing: 0.3px;
}

.chat-body::-webkit-scrollbar {
  width: 8px;
}

.chat-body::-webkit-scrollbar-track {
  background: transparent;
}

.chat-body::-webkit-scrollbar-thumb {
  background: #bec3cf;
  border-radius: 10px;
}

.chat-body::-webkit-scrollbar-thumb:hover {
  background: #9499b7;
}

.empty-state {
  flex: 1;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 16px;
  color: #9499b7;
}

.empty-icon {
  font-size: 3.5rem;
  opacity: 0.4;
  animation: float 3s ease-in-out infinite;
}

@keyframes float {
  0%, 100% { transform: translateY(0px); }
  50% { transform: translateY(-10px); }
}

.empty-state p {
  font-size: 0.95rem;
  opacity: 0.8;
  text-align: center;
  max-width: 300px;
}

@keyframes messageSlide {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Ajuste tipo WhatsApp: mensajes a la derecha/izquierda con ancho dinámico */
.chat-body {
  display: flex;
  flex-direction: column;
  padding: 20px;
  overflow-y: auto;
  background: linear-gradient(180deg, #f5f7fb 0%, #e9edf5 100%);
}

.chat-message {
  display: inline-block;
  margin: 6px 0;
  padding: 10px 16px;
  border-radius: 16px;
  font-size: 0.93rem;
  line-height: 1.5;
  word-wrap: break-word;
  width: fit-content;
  max-width: 75%;
  animation: messageSlide 0.3s ease;
}

.chat-message.self {
  align-self: flex-end;
  background: linear-gradient(135deg, #5a8dee 0%, #4a7dd6 100%);
  color: white;
  border-bottom-right-radius: 4px;
  box-shadow: 2px 2px 6px rgba(90, 141, 238, 0.3), -2px -2px 6px rgba(255, 255, 255, 0.6);
}

.chat-message.other {
  align-self: flex-start;
  background: white;
  color: #3d4468;
  border-bottom-left-radius: 4px;
  box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.05), -2px -2px 6px rgba(255, 255, 255, 0.6);
}

/*--------------------------------------------------------------------------------*/

.chat-input {
  display: flex;
  gap: 12px;
  padding: 18px 20px;
  background: #e0e5ec;
  border-top: 1px solid rgba(190, 195, 207, 0.3);
}

#messageInput {
  flex: 1;
  padding: 14px 20px;
  border: none;
  border-radius: 25px;
  background: #e0e5ec;
  color: #3d4468;
  font-size: 0.93rem;
  box-shadow:
    inset 4px 4px 10px #bec3cf,
    inset -4px -4px 10px #ffffff;
  transition: all 0.3s ease;
  outline: none;
}

#messageInput:focus {
  box-shadow:
    inset 6px 6px 12px #bec3cf,
    inset -6px -6px 12px #ffffff;
}

#messageInput::placeholder {
  color: #9499b7;
}

#messageInput:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

#sendMessage {
  padding: 14px 24px;
  border: none;
  border-radius: 25px;
  background: #e0e5ec;
  color: #3d4468;
  font-size: 0.93rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  box-shadow:
    4px 4px 10px #bec3cf,
    -4px -4px 10px #ffffff;
}

#sendMessage:hover:not(:disabled) {
  background: linear-gradient(135deg, #5a8dee 0%, #4a7dd6 100%);
  color: white;
  transform: translateY(-2px);
  box-shadow:
    6px 6px 14px rgba(90, 141, 238, 0.4),
    -4px -4px 10px rgba(255, 255, 255, 0.8);
}

#sendMessage:active:not(:disabled) {
  transform: translateY(0);
  box-shadow:
    inset 3px 3px 8px #bec3cf,
    inset -3px -3px 8px #ffffff;
}

#sendMessage:disabled {
  opacity: 0.5;
  cursor: not-allowed;
  color: #9499b7;
}

/* ============================= */
/* RESPONSIVE */
/* ============================= */

@media (max-width: 1024px) {
  .chat-layout {
    height: calc(100vh - 230px);
    min-height: 550px;
  }

  .patient-list-sidebar {
    width: 320px;
  }

  .chat-message {
    max-width: 75%;
  }
}

@media (max-width: 768px) {
  .doctor-dashboard {
    padding: 20px;
  }

  .welcome-section h2 {
    font-size: 1.5rem;
  }

  .chat-layout {
    position: relative;
    width: 100%;
    height: calc(100vh - 220px);
    min-height: 500px;
    overflow: hidden;
  }

  .patient-list-sidebar {
    width: 100%;
    height: 100%;
    max-height: none;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 10;
    transition: transform 0.3s ease;
  }

  .patient-list-sidebar.hide-mobile {
    transform: translateX(-100%);
  }

  .chat-window-main {
    width: 100%;
    height: 100%;
    max-height: none;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 5;
    transform: translateX(100%);
    transition: transform 0.3s ease;
  }

  .chat-window-main.show-mobile {
    transform: translateX(0);
    z-index: 15;
  }

  .back-button {
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .chat-message {
    max-width: 75%;
  }

  .patient-item {
    padding: 12px;
  }

  .patient-avatar-circle {
    width: 44px;
    height: 44px;
    font-size: 1.1rem;
  }
}

  .chat-message {
    max-width: 80%;
  }

  .patient-item {
    padding: 12px;
  }

  .patient-avatar-circle {
    width: 44px;
    height: 44px;
    font-size: 1.1rem;
  }
}

@media (max-width: 480px) {
  .doctor-dashboard {
    padding: 10px;
  }

  .welcome-section {
    margin-bottom: 20px;
  }

  .welcome-section h2 {
    font-size: 1.3rem;
  }

  .welcome-section p {
    font-size: 0.85rem;
  }

  .chat-layout {
    height: calc(100vh - 200px);
    min-height: 450px;
  }

  .sidebar-header {
    padding: 16px;
  }

  .sidebar-header h3 {
    font-size: 1rem;
  }

  .patients-list {
    padding: 10px;
  }

  .patient-name {
    font-size: 0.9rem;
  }

  .last-message {
    font-size: 0.8rem;
  }

  .chat-header {
    padding: 14px 16px;
  }

  #chatWith {
    font-size: 0.9rem;
  }

  .chat-avatar-header {
    width: 36px;
    height: 36px;
    font-size: 0.95rem;
  }

  .chat-message {
    max-width: 85%;
    font-size: 0.88rem;
    padding: 10px 14px;
  }

  .chat-input {
    padding: 12px 14px;
    gap: 10px;
  }

  #messageInput {
    font-size: 0.88rem;
    padding: 12px 16px;
  }

  #sendMessage {
    padding: 12px 18px;
    font-size: 0.85rem;
  }
}
</style>