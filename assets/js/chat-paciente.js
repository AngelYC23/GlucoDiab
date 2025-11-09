import { app, db } from "./firebase-config.js";
import { ref, push, onChildAdded } from "https://www.gstatic.com/firebasejs/12.4.0/firebase-database.js";

document.addEventListener("DOMContentLoaded", () => {
  const pacienteID = window.PACIENTE_ID;
  const doctorID = 1;
  const chatPath = `chats/${pacienteID}_${doctorID}/mensajes`;

  const chatBody = document.querySelector(".chat-body");
  const input = document.getElementById("messageInput");
  const sendButton = document.getElementById("sendMessage");

  if (!chatBody || !input || !sendButton) return;

  const mensajesRef = ref(db, chatPath);

  onChildAdded(mensajesRef, (snapshot) => {
    const msg = snapshot.val();

    const div = document.createElement("div");
    div.className = msg.remitente == pacienteID ? "chat-message self" : "chat-message other";

    const texto = document.createElement("p");
    texto.textContent = msg.texto;

    const hora = document.createElement("span");
    hora.className = "msg-time";
    hora.textContent = new Date(msg.timestamp).toLocaleTimeString([], {
      hour: "2-digit",
      minute: "2-digit"
    });

    div.appendChild(texto);
    div.appendChild(hora);
    chatBody.appendChild(div);
    chatBody.scrollTop = chatBody.scrollHeight;
  });

  sendButton.addEventListener("click", async () => {
    const texto = input.value.trim();
    if (!texto) return;

    const nuevoMsg = {
      remitente: pacienteID,
      texto,
      timestamp: Date.now(),
    };

    await push(mensajesRef, nuevoMsg);
    input.value = "";
  });
});
