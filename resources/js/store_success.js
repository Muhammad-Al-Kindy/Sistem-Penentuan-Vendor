import Swal from "sweetalert2";

document.addEventListener("DOMContentLoaded", function () {
    const storeForms = document.querySelectorAll("form[data-store-form]");
    const appElement = document.getElementById("app");
    const subUrl = appElement ? appElement.dataset.subkriteriaUrl : null;

    function formDataToJson(form) {
        const formData = new FormData(form);
        const obj = {};

        for (const [key, value] of formData.entries()) {
            const keys = key.match(/[^[\]]+/g);
            let current = obj;

            for (let i = 0; i < keys.length; i++) {
                const k = keys[i];
                if (i === keys.length - 1) {
                    if (k.match(/^\d+$/)) {
                        if (!Array.isArray(current)) current = [];
                        current[parseInt(k)] = value;
                    } else {
                        current[k] = value;
                    }
                } else {
                    if (!current[k]) {
                        if (keys[i + 1].match(/^\d+$/)) {
                            current[k] = [];
                        } else {
                            current[k] = {};
                        }
                    }
                    current = current[k];
                }
            }
        }
        return obj;
    }

    storeForms.forEach((form) => {
        form.addEventListener("submit", function (e) {
            e.preventDefault();

            const action = form.getAttribute("action");
            const tokenInput = form.querySelector('input[name="_token"]');
            const token = tokenInput ? tokenInput.value : "";

            const jsonData = formDataToJson(form);

            fetch(action, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": token,
                    Accept: "application/json",
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(jsonData),
            })
                .then((res) => {
                    if (!res.ok)
                        return res.json().then((err) => {
                            throw err;
                        });
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
                        if (subUrl !== null) {
                            window.location.href = subUrl;
                        }
                    });
                })
                .catch((error) => {
                    console.error("Store failed", error);
                    let errorMessage =
                        "Terjadi kesalahan saat menambahkan data.";
                    if (error.message) {
                        errorMessage = error.message;
                    } else if (error.errors) {
                        errorMessage = Object.values(error.errors)
                            .flat()
                            .join(" ");
                    }
                    Swal.fire({
                        icon: "error",
                        title: "Gagal",
                        text: errorMessage,
                    });
                });
        });
    });
});
