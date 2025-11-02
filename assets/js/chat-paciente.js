import { app, db } from "./firebase-config.js";
import { ref, push, onChildAdded } from "https://www.gstatic.com/firebasejs/12.4.0/firebase-database.js";

document.addEventListener("DOMContentLoaded", () => {
  const pacienteID = window.PACIENTE_ID;
  const doctorID = 1;
  const chatPath = `chats/${pacienteID}_${doctorID}/mensajes`;

  const chatBody = document.querySelector(".chat-body");
  const input = document.getElementById("messageInput");
  const sendButton = document.getElementById("sendMessage");

  if (!chatBody || !input || !sendButton) {
    console.warn("⚠️ Elementos del chat no encontrados en esta vista.");
    return;
  }

  const mensajesRef = ref(db, chatPath);

  onChildAdded(mensajesRef, (snapshot) => {
    const msg = snapshot.val();
    console.log("💬 Mensaje recibido:", msg);
    const div = document.createElement("div");
    div.className = msg.remitente == pacienteID ? "chat-message patient" : "chat-message doctor";
    div.textContent = msg.texto;
    chatBody.appendChild(div);
    chatBody.scrollTop = chatBody.scrollHeight;
  });

  sendButton.addEventListener("click", async () => {
    const texto = input.value.trim();
    if (!texto) {
      console.warn("⚠️ Intento de enviar mensaje vacío.");
      return;
    }

    const nuevoMsg = {
      remitente: pacienteID,
      texto,
      timestamp: Date.now()
    };

    try {
      const res = await push(mensajesRef, nuevoMsg);
      //console.log("✅ Mensaje guardado en Firebase con key:", res.key);
      input.value = "";
    } catch (err) {
      console.error("❌ Error al guardar mensaje:", err);
    }
  });
});
