import Swal from "sweetalert2";

document.addEventListener("DOMContentLoaded", function () {
    const updateForms = document.querySelectorAll(
        "form[data-update-user-form]"
    );

    updateForms.forEach((form) => {
        const redirectUrl = form.dataset.redirectUrl || null;

        form.addEventListener("submit", function (e) {
            e.preventDefault();

            // Override action URL to correct update URL
            const token = form.querySelector('input[name="_token"]').value;
            const userId = form.action.split("/").pop();
            const action = `/users/${userId}`;

            // Collect form data as JSON
            const formDataObj = {};
            const formElements = form.elements;

            for (let i = 0; i < formElements.length; i++) {
                const element = formElements[i];
                if (!element.name) continue;

                if (element.type === "checkbox") {
                    formDataObj[element.name] = element.checked;
                } else if (element.type === "radio") {
                    if (element.checked) {
                        formDataObj[element.name] = element.value;
                    }
                } else {
                    formDataObj[element.name] = element.value;
                }
            }

            // Tambahkan _method ke payload
            formDataObj._method = "PUT";

            fetch(action, {
                method: "PUT",
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
                        // Redirect to users index page after successful update
                        window.location.href = "/users";
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
