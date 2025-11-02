import { initializeApp, getApps } from "https://www.gstatic.com/firebasejs/12.4.0/firebase-app.js";
import { getAuth } from "https://www.gstatic.com/firebasejs/12.4.0/firebase-auth.js";
import { getDatabase } from "https://www.gstatic.com/firebasejs/12.4.0/firebase-database.js";

const firebaseConfig = {
  apiKey: "AIzaSyATNCZfqKdncLjZr-Ra9Ustbr_IoZQ-GTY",
  authDomain: "glucodiab.firebaseapp.com",
  projectId: "glucodiab",
  storageBucket: "glucodiab.appspot.com",
  messagingSenderId: "1066934605584",
  appId: "1:1066934605584:web:251cb23337c72683673795",
  databaseURL: "https://glucodiab-default-rtdb.firebaseio.com"
};

const app = getApps().length ? getApps()[0] : initializeApp(firebaseConfig);
const auth = getAuth(app);
const db = getDatabase(app);

export { app, auth, db };
