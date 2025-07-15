document.addEventListener("DOMContentLoaded", function () {
    const messageInput = document.querySelector(
        'input[placeholder="Tulis pesan..."]'
    );
    const sendButton = document.querySelector("#send-button");
    const chatContainer = document.querySelector("#chat-container");
    const vendorList = document.querySelector("#vendor-list");
    const chatHeaderName = document.querySelector(
        "h3.text-lg.font-bold.text-gray-800"
    );
    const chatHeaderSub = document.querySelector("p.text-sm.text-gray-500");
    const loadingMessage = document.getElementById("loading-message");

    let selectedVendorId = null;
    let selectedVendorName = null;

    // Initialize selectedVendorId from localStorage or window.selectedVendorId
    const storedVendorId = localStorage.getItem("selectedVendorId");
    if (storedVendorId) {
        selectedVendorId = storedVendorId;
    } else if (window.selectedVendorId) {
        selectedVendorId = window.selectedVendorId;
        localStorage.setItem("selectedVendorId", selectedVendorId);
    }

    // Fungsi untuk menambahkan pesan ke tampilan chat
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

    // Handle saat user memilih vendor
    if (vendorList) {
        vendorList.addEventListener("click", function (e) {
            const vendorItem = e.target.closest(".vendor-item");
            if (!vendorItem) return;

            console.log("Vendor selected:", vendorItem);

            // Remove active class from all vendor items
            document.querySelectorAll(".vendor-item").forEach((el) => {
                el.classList.remove("bg-blue-50");
            });

            // Add active class to selected vendor item
            vendorItem.classList.add("bg-blue-50");

            selectedVendorId = vendorItem.getAttribute("data-user-id");
            selectedVendorName = vendorItem.getAttribute("data-vendor-name");

            // Store selected vendor id in localStorage to persist selection
            localStorage.setItem("selectedVendorId", selectedVendorId);

            console.log("Selected Vendor ID:", selectedVendorId);
            console.log("Selected Vendor Name:", selectedVendorName);

            chatHeaderName.textContent = "Chat dengan " + selectedVendorName;
            chatHeaderSub.textContent = "Silakan kirim pesan untuk vendor";

            chatContainer.innerHTML = "";
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
                    user_id: selectedVendorId,
                }),
            })
                .then((response) => response.json())
                .then((data) => {
                    console.log("Fetch messages response data:", data);
                    if (data.status === "success") {
                        chatContainer.innerHTML = "";
                        data.messages.forEach((msg) => {
                            // Fix logic: message is sender if from_id equals authenticated user id
                            // But invert the isSender to fix the color bug (blue for me, gray for vendor)
                            const isSender = msg.from_id !== window.authUserId;
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
        });
    }

    // Tombol kirim
    sendButton.addEventListener("click", function () {
        const message = messageInput.value.trim();

        // Retrieve selectedVendorId from localStorage in case it was lost
        const storedVendorId = localStorage.getItem("selectedVendorId");
        if (storedVendorId) {
            selectedVendorId = storedVendorId;
        }

        // Use window.chatPartnerId if defined (vendor chat), else selectedVendorId
        const toId = window.chatPartnerId
            ? window.chatPartnerId
            : selectedVendorId;

        if (!message || !toId) {
            alert("Tulis pesan dan pilih vendor terlebih dahulu.");
            return;
        }

        // Disable send button to prevent multiple sends
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
                to_id: toId.trim(),
                message: message,
            }),
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.status === "success") {
                    appendMessage(message, true);
                    messageInput.value = "";
                } else {
                    console.error("Send message error response:", data);
                    alert("Pesan gagal dikirim.");
                }
                // Re-enable send button after response
                sendButton.disabled = false;
            })
            .catch((error) => {
                console.error("Send message fetch error:", error);
                alert("Gagal mengirim pesan.");
                // Re-enable send button on error
                sendButton.disabled = false;
            });
    });

    // Menerima pesan dari Pusher
    if (window.Echo) {
        window.Echo.channel("chat-channel").listen(".chat-event", (e) => {
            const fromId = e.message.from_id;
            const toId = e.message.to_id;
            const messageText = e.message.message;

            const chatPartnerId = window.chatPartnerId
                ? window.chatPartnerId
                : selectedVendorId;

            // Show message only if it involves the chat partner and authenticated user
            if (fromId === window.authUserId && toId == chatPartnerId) {
                // Message sent by authenticated user
                appendMessage(messageText, true);
            } else if (toId === window.authUserId && fromId == chatPartnerId) {
                // Message received from chat partner
                appendMessage(messageText, false);
            }
        });
    }
});
