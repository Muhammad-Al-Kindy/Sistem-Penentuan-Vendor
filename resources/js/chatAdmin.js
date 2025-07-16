document.addEventListener("DOMContentLoaded", function () {
    const authUserId = window.authUserId ?? null;

    const messageInput = document.querySelector("#chat-input");
    const sendButton = document.querySelector("#chat-send");
    const chatContainer = document.querySelector("#chat-container");
    const vendorList = document.querySelector("#vendor-list");
    const chatWithName = document.querySelector("#chat-with-name");
    const loadingMessage = document.getElementById("loading-message");

    let selectedVendorId = null;
    let selectedVendorName = null;

    if (!messageInput || !sendButton || !vendorList || !chatContainer) {
        console.warn(
            "❌ Elemen chat admin tidak lengkap. Keluar dari chatAdminOnly.js"
        );
        return;
    }

    function appendMessage(message, isSender) {
        const messageDiv = document.createElement("div");
        messageDiv.classList.add(
            "px-3",
            "py-2",
            "rounded",
            "text-sm",
            "max-w-[75%]",
            "whitespace-pre-wrap"
        );
        messageDiv.textContent = message;

        if (isSender) {
            messageDiv.classList.add("bg-blue-100", "text-right", "ml-auto");
        } else {
            messageDiv.classList.add("bg-gray-200", "text-left");
        }

        chatContainer.appendChild(messageDiv);
        chatContainer.scrollTop = chatContainer.scrollHeight;
    }

    function loadMessages() {
        if (!selectedVendorId) {
            chatContainer.innerHTML = "";
            loadingMessage.textContent = "Pilih vendor untuk mulai chat.";
            return;
        }

        loadingMessage.textContent = "Memuat pesan...";
        chatContainer.innerHTML = "";

        fetch("/chat/messages", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
            body: JSON.stringify({ user_id: selectedVendorId }),
        })
            .then((res) => res.json())
            .then((data) => {
                if (data.status === "success") {
                    data.messages.forEach((msg) => {
                        const isSender = msg.from_id === authUserId;
                        appendMessage(msg.message, isSender);
                    });
                } else {
                    alert("Gagal memuat pesan.");
                }
            })
            .catch(() => alert("Terjadi kesalahan saat memuat pesan."))
            .finally(() => {
                loadingMessage.textContent = "";
            });
    }

    vendorList.addEventListener("click", function (e) {
        const vendorItem = e.target.closest(".vendor-item");
        if (!vendorItem) return;

        document
            .querySelectorAll(".vendor-item")
            .forEach((el) => el.classList.remove("bg-blue-50"));
        vendorItem.classList.add("bg-blue-50");

        selectedVendorId = vendorItem.getAttribute("data-user-id");
        selectedVendorName = vendorItem.getAttribute("data-vendor-name");

        chatWithName.textContent = selectedVendorName;
        loadMessages();
    });

    sendButton.addEventListener("click", function () {
        const message = messageInput.value.trim();
        if (!message || !selectedVendorId) {
            alert("Tulis pesan dan pilih vendor terlebih dahulu.");
            return;
        }

        sendButton.disabled = true;

        fetch("/chat/message", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
            body: JSON.stringify({
                to_id: selectedVendorId,
                message: message,
            }),
        })
            .then((res) => res.json())
            .then((data) => {
                if (data.status === "success") {
                    appendMessage(message, true);
                    messageInput.value = "";
                } else {
                    alert("Pesan gagal dikirim.");
                }
            })
            .catch(() => alert("Gagal mengirim pesan."))
            .finally(() => {
                sendButton.disabled = false;
            });
    });

    if (window.Echo) {
        window.Echo.channel("chat-channel").listen(".chat-event", (e) => {
            const fromId = e.message.from_id;
            const toId = e.message.to_id;
            const messageText = e.message.message;

            if (
                selectedVendorId &&
                ((toId === authUserId && fromId === selectedVendorId) ||
                    (fromId === authUserId && toId === selectedVendorId))
            ) {
                appendMessage(messageText, fromId === authUserId);
            }
        });
    }

    loadingMessage.textContent = "Pilih vendor untuk mulai chat.";
});
