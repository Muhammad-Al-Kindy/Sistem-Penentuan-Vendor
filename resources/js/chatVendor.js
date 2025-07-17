function waitForChatPartnerId(callback) {
    if (window.chatPartnerId !== undefined && window.chatPartnerId !== null) {
        callback();
    } else {
        setTimeout(() => waitForChatPartnerId(callback), 100);
    }
}

document.addEventListener("DOMContentLoaded", function () {
    console.log("Chat vendor script loaded");

    waitForChatPartnerId(() => {
        // DOM elements
        const messageInput = document.querySelector(
            'input[placeholder="Tulis pesan..."]'
        );
        const sendButton = document.querySelector("#send-button");
        const chatContainer = document.querySelector("#chat-container");
        const loadingMessage = document.getElementById("loading-message");
        const loadHistoryButton = document.getElementById(
            "load-history-button"
        );

        // Globals
        const chatPartnerId = window.chatPartnerId;
        console.log("Debug: chatPartnerId =", chatPartnerId);
        const authUserId = window.authUserId;
        const nonConformanceId = window.nonConformanceId;

        const sendMessageUrl = "/vendor/chat-vendor/message";
        const fetchMessagesUrl = "/vendor/chat-vendor/messages";

        // Protect from multiple sends
        let isSending = false;

        if (!messageInput || !sendButton || !chatContainer) {
            console.error("Essential chat elements not found");
            return;
        }

        function appendMessage(message, isSender, timestamp = null) {
            const wrapper = document.createElement("div");
            wrapper.classList.add(
                "flex",
                "flex-col",
                isSender ? "items-end" : "items-start",
                "mb-2"
            );

            const bubble = document.createElement("div");
            bubble.classList.add(
                "px-3",
                "py-2",
                "rounded",
                "text-sm",
                "max-w-[75%]",
                "whitespace-pre-wrap",
                isSender ? "bg-blue-100" : "bg-gray-200"
            );
            bubble.textContent = message;

            wrapper.appendChild(bubble);

            if (timestamp) {
                const time = document.createElement("div");
                time.classList.add(
                    "text-xs",
                    "text-gray-400",
                    isSender ? "text-right" : "text-left",
                    "mt-1"
                );
                time.textContent = new Date(timestamp).toLocaleString();
                wrapper.appendChild(time);
            }

            chatContainer.appendChild(wrapper);
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }

        function clearLoadingMessage() {
            if (loadingMessage) loadingMessage.textContent = "";
        }

        function loadMessages() {
            if (!chatPartnerId) {
                console.error(
                    "Chat partner ID is missing or falsy:",
                    chatPartnerId
                );
                alert("Chat partner ID tidak ditemukan.");
                return;
            }

            if (loadingMessage) loadingMessage.textContent = "Memuat pesan...";

            // Use GET with query parameters instead of POST
            const url = new URL(fetchMessagesUrl, window.location.origin);
            url.searchParams.append('from_id', authUserId);
            url.searchParams.append('to_id', chatPartnerId);
            url.searchParams.append('non_conformance_id', nonConformanceId);

            fetch(url.toString(), {
                method: "GET",
                headers: {
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
            })
                .then((res) => res.json())
                .then((data) => {
                    if (data.status === "success") {
                        chatContainer.innerHTML = "";
                        if (data.messages.length === 0) {
                            chatContainer.innerHTML =
                                "<p class='text-gray-500'>Tidak ada riwayat pesan.</p>";
                        } else {
                            data.messages.forEach((msg) => {
                                const isSender = msg.from_id === authUserId;
                                appendMessage(
                                    msg.message,
                                    isSender,
                                    msg.created_at
                                );
                            });
                        }
                    } else {
                        alert("Gagal memuat pesan.");
                    }
                })
                .catch((error) => {
                    console.error("Gagal memuat pesan:", error);
                    alert("Terjadi kesalahan saat mengambil pesan.");
                })
                .finally(() => {
                    clearLoadingMessage();
                });
        }

        sendButton.addEventListener("click", function (e) {
            e.preventDefault();
            console.log("✅ Tombol kirim ditekan");

            const message = messageInput.value.trim();

            if (!message) {
                alert("Tulis pesan terlebih dahulu.");
                return;
            }

            if (message.length > 1000) {
                alert("Pesan terlalu panjang. Maksimal 1000 karakter.");
                return;
            }

            if (isSending) return;
            isSending = true;
            const originalText = sendButton.textContent;
            sendButton.textContent = "Mengirim...";
            sendButton.disabled = true;

            fetch(sendMessageUrl, {
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
                    non_conformance_id: nonConformanceId,
                }),
            })
                .then((res) => {
                    console.log("📦 Response status:", res.status);
                    return res.json();
                })
                .then((data) => {
                    if (data.status === "success") {
                        appendMessage(message, true, new Date().toISOString());
                        messageInput.value = "";
                    } else {
                        alert(data.message || "Gagal mengirim pesan.");
                    }
                })
                .catch((error) => {
                    console.error("Error sending message:", error);
                    alert("Terjadi kesalahan saat mengirim pesan.");
                })
                .finally(() => {
                    isSending = false;
                    sendButton.textContent = originalText;
                    sendButton.disabled = false;
                });
        });

        if (window.Echo) {
            window.Echo.channel("chat-channel").listen(".chat-event", (e) => {
                const fromId = e.message.from_id;
                const toId = e.message.to_id;
                const messageText = e.message.message;

                if (toId === authUserId && fromId === chatPartnerId) {
                    appendMessage(messageText, false, new Date().toISOString());
                }
            });
        }

        if (loadHistoryButton) {
            loadHistoryButton.addEventListener("click", loadMessages);
        }

        loadMessages(); // auto-load on page ready
    });
});
