import Swal from "sweetalert2";

document.addEventListener("DOMContentLoaded", function () {
    const storeForms = document.querySelectorAll("form[data-store-form]");
    const appElement = document.getElementById("app");
    const subUrl = appElement ? appElement.dataset.subkriteriaUrl : null;

    storeForms.forEach((form) => {
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
                    if (!res.ok) throw new Error("Failed to store");
                    return res.json();
                })
                .then(() => {
                    Swal.fire({
                        toast: true,
                        position: "bottom-end",
                        icon: "success",
                        title: "Berhasil!",
                        text: "Data berhasil ditambahkan.",
                        showConfirmButton: false,
                        timer: 1000,
                        timerProgressBar: true,
                    }).then(() => {
                        if (subUrl) {
                            window.location.href = subUrl;
                        }
                    });
                })
                .catch((error) => {
                    console.error("Store failed", error);
                    Swal.fire({
                        icon: "error",
                        title: "Gagal",
                        text: "Terjadi kesalahan saat menambahkan data.",
                    });
                });
        });
    });
});
