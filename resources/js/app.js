import "./bootstrap";
import "./store_success.js";
import "./delete.js";
import "./navbar.js";
import "./update.js";
import "./updateVendor.js";
import "./updateSubKriteria.js";
import "./debug_invalid_requests.js";
import "./updateKedatangan.js";
import "./user-update.js";
import "../css/app.css";
import "../js/chat.js";

Echo.channel("chat-channel").listen(".chat-event", (e) => {
    console.log("Pesan masuk:", e.message);
});
