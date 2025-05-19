import Swal from "sweetalert2";

document.addEventListener("DOMContentLoaded", function () {
    const appElement = document.getElementById("app");
    const updateForms = document.querySelectorAll("form[data-update-form]");

    updateForms.forEach((form) => {
        const redirectUrl = form.dataset.redirectUrl || null;

        form.addEventListener("submit", function (e) {
            e.preventDefault();

            const action = form.getAttribute("action");
            const token = form.querySelector('input[name="_token"]').value;
            const formData = new FormData(form);

            fetch(action, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": token,
                    Accept: "application/json",
                },
                body: formData,
            })
                .then((res) => {
                    if (!res.ok) throw new Error("Failed to update");
                    return res.json();
                })
                .then(() => {
                    Swal.fire({
                        toast: true,
                        position: "bottom-end",
                        icon: "success",
                        title: "Data berhasil diperbarui!",
                        showConfirmButton: false,
                        timer: 1000,
                        timerProgressBar: true,
                    }).then(() => {
                        if (redirectUrl) {
                            window.location.href = redirectUrl;
                        }
                    });
                })
                .catch((error) => {
                    console.error("Update failed", error);
                    Swal.fire({
                        icon: "error",
                        title: "Gagal",
                        text: "Terjadi kesalahan saat memperbarui data.",
                    });
                });
        });
    });
});
