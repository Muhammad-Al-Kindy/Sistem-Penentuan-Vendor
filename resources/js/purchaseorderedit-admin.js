import Swal from "sweetalert2";

document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector(
        "form[data-purchaseorderedit-form-admin]"
    );
    if (!form) return;

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const action = form.getAttribute("action");
        const method = form.getAttribute("method") || "POST";
        const token = form.querySelector('input[name="_token"]')?.value;

        const formData = new FormData(form);
        formData.append("_method", "PUT");

        fetch(action, {
            method: "POST", // tetap POST karena _method = PUT
            headers: {
                "X-CSRF-TOKEN": token,
                "X-Requested-With": "XMLHttpRequest",
            },
            body: formData,
        })
            .then(async (res) => {
                if (!res.ok) {
                    const data = await res.json();
                    let errorMsg = "Gagal memperbarui data.";

                    if (res.status === 422 && data.errors) {
                        errorMsg = Object.values(data.errors).flat().join("\n");
                    } else if (data.message) {
                        errorMsg = data.message;
                    }

                    throw new Error(errorMsg);
                }

                return res.json();
            })
            .then((data) => {
                Swal.fire({
                    toast: true,
                    position: "bottom-end",
                    icon: "success",
                    title: data.message || "Data berhasil diperbarui!",
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true,
                }).then(() => {
                    window.location.href = "/purchase-order";
                });
            })
            .catch((err) => {
                Swal.fire({
                    icon: "error",
                    title: "Gagal",
                    text: err.message,
                });
            });
    });
});
