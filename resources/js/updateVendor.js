import Swal from "sweetalert2";

document.addEventListener("DOMContentLoaded", function () {
    const updateVendorForms = document.querySelectorAll(
        "form[data-update-vendor-form]"
    );

    updateVendorForms.forEach((form) => {
        const redirectUrl = form.dataset.redirectUrl || null;

        form.addEventListener("submit", function (e) {
            e.preventDefault();

            const token = form.querySelector('input[name="_token"]').value;
            const vendorId = form.querySelector('input[name="id"]').value;
            const action = `/vendor/update/${vendorId}`;

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

            // Add _method for PUT
            formDataObj._method = "PUT";

            fetch(action, {
                method: "POST", // Use POST with method spoofing
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
                            throw new Error("Failed to update vendor");
                        }
                    }
                    return res.json();
                })
                .then(() => {
                    Swal.fire({
                        toast: true,
                        position: "bottom-end",
                        icon: "success",
                        title: "Vendor berhasil diperbarui!",
                        showConfirmButton: false,
                        timer: 1000,
                        timerProgressBar: true,
                    }).then(() => {
                        if (redirectUrl) {
                            window.location.href = redirectUrl;
                        } else {
                            window.location.href = "/vendor";
                        }
                    });
                })
                .catch((error) => {
                    console.error("Vendor update failed", error);
                    Swal.fire({
                        icon: "error",
                        title: "Gagal",
                        text:
                            error.message ||
                            "Terjadi kesalahan saat memperbarui vendor.",
                    });
                });
        });
    });
});
