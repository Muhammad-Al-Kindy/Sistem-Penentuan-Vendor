import Swal from "sweetalert2";

document.addEventListener("DOMContentLoaded", function () {
    const updateForms = document.querySelectorAll("form[data-update-form]");

    updateForms.forEach((form) => {
        form.addEventListener("submit", function (e) {
            e.preventDefault();

            const token = form.querySelector('input[name="_token"]').value;
            const action = form.getAttribute("action");

            // Collect form data as JSON
            const formDataObj = {};
            const formElements = form.elements;

            for (let i = 0; i < formElements.length; i++) {
                const element = formElements[i];
                if (!element.name) continue;

                // Handle arrays for item_ids[] and item_qty_diterima[]
                if (element.name.endsWith("[]")) {
                    const name = element.name.slice(0, -2);
                    if (!formDataObj[name]) {
                        formDataObj[name] = [];
                    }
                    formDataObj[name].push(element.value);
                } else {
                    formDataObj[element.name] = element.value;
                }
            }

            // Add _method to payload for PUT
            formDataObj._method = "PUT";

            fetch(action, {
                method: "POST", // Laravel expects POST with _method=PUT
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": token,
                    "X-Requested-With": "XMLHttpRequest",
                    Accept: "application/json",
                },
                body: JSON.stringify(formDataObj),
            })
                .then(async (res) => {
                    if (!res.ok) {
                        if (res.status === 422) {
                            const data = await res.json();
                            let errorMessages = "";
                            if (data.errors) {
                                for (const key in data.errors) {
                                    errorMessages +=
                                        data.errors[key].join(" ") + "\n";
                                }
                            } else if (data.message) {
                                errorMessages = data.message;
                            } else {
                                errorMessages = "Validation error";
                            }
                            throw new Error(errorMessages);
                        } else {
                            throw new Error("Failed to update");
                        }
                    }
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
                        // Redirect to kelola kedatangan index page after successful update
                        window.location.href = "/kelola-kedatangan";
                    });
                })
                .catch((error) => {
                    console.error("Update failed", error);
                    Swal.fire({
                        icon: "error",
                        title: "Gagal",
                        text:
                            error.message ||
                            "Terjadi kesalahan saat memperbarui data.",
                    });
                });
        });
    });
});
