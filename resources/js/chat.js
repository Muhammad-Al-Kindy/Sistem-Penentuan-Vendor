document.addEventListener("DOMContentLoaded", function () {
    console.log("Chat.js loaded");

    const vendorList = document.querySelectorAll(".vendor-item");
    const chatWithName = document.getElementById("chat-with-name");
    const chatContainer = document.getElementById("chat-container");
    const chatInput = document.getElementById("chat-input");
    const chatSendButton = document.getElementById("chat-send");
    const loadingMessage = document.getElementById("loading-message");
    const reportContainer = document.getElementById("report-container");
    const reportDropdown = document.getElementById("report-dropdown");
    document.getElementById("chat-form").style.display = "block";

    let selectedVendorId = null;
    let selectedVendorName = null;
    let selectedReportId = null;
    let allReports = [];

    // 1. Handle pilih vendor
    vendorList.forEach((item) => {
        item.addEventListener("click", () => {
            selectedVendorId = item.dataset.userId;
            selectedVendorName = item.dataset.vendorName;
            selectedReportId = null;
            chatWithName.innerText = `Vendor ${selectedVendorName}`;
            loadingMessage.innerText = "Silakan pilih laporan...";
            chatContainer.innerHTML = "";
            reportDropdown.innerHTML = `<option value="">-- Pilih Laporan --</option>`;
            fetchReports(selectedVendorId);
        });
    });

    // 2. Ambil semua report dari Laravel (dikirim via blade)
    allReports = window.nonConformanceReports || [];

    function fetchReports(vendorUserId) {
        console.log("fetchReports dijalankan untuk vendor", vendorUserId);

        const filtered = allReports.filter((r) => {
            return (
                r.goods_receipt_item &&
                r.goods_receipt_item.goods_receipt &&
                r.goods_receipt_item.goods_receipt.vendor &&
                r.goods_receipt_item.goods_receipt.vendor.user &&
                r.goods_receipt_item.goods_receipt.vendor.user.idUser ==
                    vendorUserId
            );
        });

        reportDropdown.innerHTML = `<option value="">-- Pilih Laporan --</option>`;
        filtered.forEach((r) => {
            const id = r.idNonConformance;

            const descRaw = r.keterangan || "Tidak ada deskripsi";
            const descCleaned = descRaw
                .replace(/Dipesan:.*Sesua[i|u]:.*$/, "")
                .trim();
            const desc = descCleaned.replace(/\.*$/, ""); // hilangkan titik di akhir

            const qty_dipesan = r.goods_receipt_item?.qty_po || "-";
            const qty_sesuai = r.goods_receipt_item?.qty_sesuai || "-";
            const option = document.createElement("option");
            option.value = id;
            option.textContent = `Laporan #${id} - ${desc}. Dipesan: ${qty_dipesan}, Sesuai: ${qty_sesuai}`;
            console.log("Menambahkan option:", option.textContent);
            reportDropdown.appendChild(option);
        });

        reportContainer.classList.remove("hidden");
    }

    // 3. Handle pilih laporan
    reportDropdown.addEventListener("change", () => {
        selectedReportId = reportDropdown.value;
        if (selectedReportId) {
            fetchMessages();
        }
    });

    // 4. Ambil pesan dari backend
    function fetchMessages() {
        if (!selectedVendorId || !selectedReportId) return;

        loadingMessage.innerText = "Memuat pesan...";
        chatContainer.innerHTML = "";

        const payload = {
            from_id: window.authUserId,
            to_id: selectedVendorId,
            non_conformance_id: selectedReportId,
        };

        fetch("/chat/messages", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
            body: JSON.stringify(payload),
        })
            .then((res) => res.json())
            .then((data) => {
                if (data.status === "success") {
                    renderMessages(data.messages);
                    loadingMessage.innerText = "";
                } else {
                    chatContainer.innerHTML =
                        '<div class="text-red-600">Gagal memuat pesan.</div>';
                }
            })
            .catch((err) => {
                console.error("fetchMessages error:", err);
                chatContainer.innerHTML =
                    '<div class="text-red-600">Gagal memuat pesan.</div>';
            });
    }

    // 5. Render pesan ke tampilan
    function renderMessages(messages) {
        chatContainer.innerHTML = "";
        messages.forEach((msg) => {
            const isAdmin = msg.from_id == window.authUserId;
            const msgDiv = document.createElement("div");
            msgDiv.className = `p-2 rounded-lg max-w-xs ${
                isAdmin
                    ? "bg-blue-100 text-right ml-auto"
                    : "bg-gray-200 text-left"
            }`;
            msgDiv.textContent = msg.message;

            chatContainer.appendChild(msgDiv);
        });
        chatContainer.scrollTop = chatContainer.scrollHeight;
    }

    // 6. Kirim pesan
    chatSendButton.addEventListener("click", () => {
        const message = chatInput.value.trim();
        if (!message || !selectedVendorId || !selectedReportId) return;

        const payload = {
            from_id: window.authUserId,
            to_id: selectedVendorId,
            non_conformance_id: selectedReportId,
            message: message,
        };

        fetch("/chat/message", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
            body: JSON.stringify(payload),
        })
            .then((res) => res.json())
            .then((data) => {
                if (data.status === "success") {
                    chatInput.value = "";
                    fetchMessages();
                } else {
                    alert("Gagal mengirim pesan.");
                }
            })
            .catch((err) => {
                console.error("send message error:", err);
                alert("Gagal mengirim pesan.");
            });
    });
});
