document.addEventListener("DOMContentLoaded", function () {
    const messageInput = document.querySelector(
        'input[placeholder="Tulis pesan..."]'
    );
    const sendButton = document.querySelector("#send-button");
    const chatContainer = document.querySelector("#chat-container");
    const loadingMessage = document.getElementById("loading-message");

    // Use window.chatPartnerId as the chat partner ID for vendor chat
    const chatPartnerId = window.chatPartnerId;

    // Append message to chat container
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

    // Load chat messages on page load
    function loadMessages() {
        if (!chatPartnerId) {
            alert("Chat partner ID is not defined.");
            return;
        }
        loadingMessage.textContent = "Memuat pesan...";

        fetch("/chat/messages", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
            body: JSON.stringify({
                user_id: chatPartnerId,
            }),
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.status === "success") {
                    chatContainer.innerHTML = "";
                    data.messages.forEach((msg) => {
                        const isSender = msg.from_id === window.authUserId;
                        appendMessage(msg.message, isSender);
                    });
                    loadingMessage.textContent = "";
                } else {
                    alert("Gagal memuat pesan.");
                    loadingMessage.textContent = "";
                }
            })
            .catch(() => {
                alert("Gagal memuat pesan.");
                loadingMessage.textContent = "";
            });
    }

    // Send message handler
    sendButton.addEventListener("click", function () {
        const message = messageInput.value.trim();

        if (!message || !chatPartnerId) {
            alert("Tulis pesan terlebih dahulu.");
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
                to_id: chatPartnerId,
                message: message,
            }),
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.status === "success") {
                    appendMessage(message, true);
                    messageInput.value = "";
                } else {
                    alert("Pesan gagal dikirim.");
                }
                sendButton.disabled = false;
            })
            .catch(() => {
                alert("Gagal mengirim pesan.");
                sendButton.disabled = false;
            });
    });

    // Listen for incoming messages via Pusher/Echo
    if (window.Echo) {
        window.Echo.channel("chat-channel").listen(".chat-event", (e) => {
            const fromId = e.message.from_id;
            const toId = e.message.to_id;
            const messageText = e.message.message;

            if (toId === window.authUserId && fromId === chatPartnerId) {
                appendMessage(messageText, false);
            } else if (fromId === window.authUserId && toId === chatPartnerId) {
                appendMessage(messageText, true);
            }
        });
    }

    // Initial load of messages
    loadMessages();
});
