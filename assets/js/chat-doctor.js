import { app, db } from "./firebase-config.js";
import { ref, push, onChildAdded, onValue, off, update, query, limitToLast, get, child} from "https://www.gstatic.com/firebasejs/12.4.0/firebase-database.js";

window.addEventListener("load", () => {
  const doctorID = window.USER_ID;
  const patientItems = document.querySelectorAll(".patient-item");
  const chatBody = document.getElementById("chatBody");
  const chatWith = document.getElementById("chatWith");
  const input = document.getElementById("messageInput");
  const sendButton = document.getElementById("sendMessage");

  let currentPatient = null;
  let activeChatUnsubscribe = null;

  patientItems.forEach((item) => {
    const patientID = item.dataset.id;
    const lastMsgElem = item.querySelector(".last-message");

    const chatPath = `chats/${patientID}_${doctorID}/mensajes`;
    const lastMsgQuery = query(ref(db, chatPath), limitToLast(1));

    onValue(lastMsgQuery, (snapshot) => {
      let lastMsg = null;
      
      snapshot.forEach((msgSnap) => {
        lastMsg = msgSnap.val();
      });

      if (lastMsg) {
        const texto = lastMsg.texto || "";
        const hora = new Date(lastMsg.timestamp).toLocaleTimeString([], {
          hour: "2-digit",
          minute: "2-digit",
        });

        lastMsgElem.textContent = texto
          ? `${texto.slice(0, 30)}${texto.length > 30 ? "..." : ""} • ${hora}`
          : "Sin mensajes";

        if (!lastMsg.leido && lastMsg.remitente !== doctorID) {
          if (!item.querySelector(".badge-unread")) {
            const badge = document.createElement("span");
            badge.className = "badge-unread";
            badge.textContent = "●";
            item.appendChild(badge);
          }
        } else {
          const badge = item.querySelector(".badge-unread");
          if (badge) badge.remove();
        }
      } else {
        lastMsgElem.textContent = "Sin mensajes";
      }
    });
  });

  patientItems.forEach((item) => {
    item.addEventListener("click", async () => {

      const patientID = item.dataset.id;
      const patientName = item.querySelector("strong").textContent;
      const chatPath = `chats/${patientID}_${doctorID}/mensajes`;

      if (patientID === currentPatient) return;
      currentPatient = patientID;
      chatWith.textContent = patientName;

      chatBody.innerHTML = '<div class="loading">Cargando conversación...</div>';
      input.disabled = false;
      sendButton.disabled = false;

      if (activeChatUnsubscribe) {
        activeChatUnsubscribe();
        activeChatUnsubscribe = null;
      }

      const mensajesRefAll = ref(db, chatPath);
      const snap = await get(mensajesRefAll);

      snap.forEach((m) => {
        const msg = m.val();
        if (msg.remitente !== doctorID && !msg.leido) {
          update(child(mensajesRefAll, m.key), { leido: true });
        }
      });

      chatBody.innerHTML = "";

      const currentChatRef = ref(db, chatPath);
    
      activeChatUnsubscribe = onChildAdded(currentChatRef, (snapshot) => {
        const msg = snapshot.val();
        const div = document.createElement("div");
        div.className = msg.remitente == doctorID ? "chat-message self" : "chat-message other";

        const hora = document.createElement("small");
        hora.className = "msg-time";
        hora.textContent = new Date(msg.timestamp).toLocaleTimeString([], { hour: "2-digit", minute: "2-digit" });

        div.textContent = msg.texto;
        div.appendChild(hora);
        chatBody.appendChild(div);
        chatBody.scrollTop = chatBody.scrollHeight;

        if (msg.remitente != doctorID && !msg.leido) {
          update(ref(db, `${chatPath}/${snapshot.key}`), { leido: true });
        }
      });

    });
  });

  sendButton.addEventListener("click", async () => {
    if (!currentPatient) return;

    const texto = input.value.trim();
    if (!texto) return;

    const nuevoMsg = {
      remitente: doctorID,
      texto,
      timestamp: Date.now(),
      leido: false
    };

    const path = `chats/${currentPatient}_${doctorID}/mensajes`;
    await push(ref(db, path), nuevoMsg);
    input.value = "";
  });
});