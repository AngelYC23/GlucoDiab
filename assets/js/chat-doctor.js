import { app, db } from "./firebase-config.js";
import { ref, push, onChildAdded, off } from "https://www.gstatic.com/firebasejs/12.4.0/firebase-database.js";

window.addEventListener("load", () => {
  const doctorID = window.USER_ID;
  const patientItems = document.querySelectorAll(".patient-item");
  const chatBody = document.getElementById("chatBody");
  const chatWith = document.getElementById("chatWith");
  const input = document.getElementById("messageInput");
  const sendButton = document.getElementById("sendMessage");

  let currentPatient = null;
  let mensajesRef = null;

  patientItems.forEach(item => {
    item.addEventListener("click", () => {
      const patientID = item.dataset.id;
      const patientName = item.querySelector("strong").textContent;

      if (patientID === currentPatient) return;

      currentPatient = patientID;
      chatWith.textContent = patientName;

      chatBody.innerHTML = '<div class="loading">Cargando conversación...</div>';
      input.disabled = false;
      sendButton.disabled = false;

      const chatPath = `chats/${currentPatient}_${doctorID}/mensajes`;
      const nuevaRef = ref(db, chatPath);

      if (mensajesRef) {
        off(mensajesRef);
        console.log("🧹 Listener anterior eliminado");
      }

      mensajesRef = nuevaRef;
      chatBody.innerHTML = "";

      onChildAdded(mensajesRef, (snapshot) => {
        const msg = snapshot.val();
        const div = document.createElement("div");
        div.className = msg.remitente == doctorID ? "chat-message self" : "chat-message other";
        div.textContent = msg.texto;
        chatBody.appendChild(div);
        chatBody.scrollTop = chatBody.scrollHeight;
      });

      console.log(`📡 Escuchando chat de paciente ${patientID}`);
    });
  });

  sendButton.addEventListener("click", async () => {
    if (!currentPatient) return;

    const texto = input.value.trim();
    if (!texto) return;

    const nuevoMsg = {
      remitente: doctorID,
      texto,
      timestamp: Date.now()
    };

    const path = `chats/${currentPatient}_${doctorID}/mensajes`;
    await push(ref(db, path), nuevoMsg);
    input.value = "";
  });
});
