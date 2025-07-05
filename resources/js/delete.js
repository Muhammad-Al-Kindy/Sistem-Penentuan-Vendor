import Swal from "sweetalert2";

document.addEventListener("DOMContentLoaded", function () {
    const deleteForms = document.querySelectorAll("form[data-delete-form]");

    deleteForms.forEach((form) => {
        form.addEventListener("submit", async function (e) {
            e.preventDefault();

            const action = form.getAttribute("action");
            if (!action || action.includes("undefined")) {
                console.error("Invalid delete action URL:", action);
                Swal.fire({
                    icon: "error",
                    title: "Invalid Delete Request",
                    text: "Delete action URL is invalid or undefined.",
                });
                return;
            }

            const result = await Swal.fire({
                title: "Yakin ingin menghapus?",
                text: "Data yang dihapus tidak bisa dikembalikan!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Ya, hapus!",
                cancelButtonText: "Batal",
            });

            if (result.isConfirmed) {
                console.log("Delete action URL:", action);
                const token = form.querySelector('input[name="_token"]').value;

                // Use FormData to send _method=DELETE as POST request for method spoofing
                const formData = new FormData();
                formData.append("_method", "DELETE");
                formData.append("_token", token);

                try {
                    const response = await fetch(action, {
                        method: "POST",
                        headers: {
                            Accept: "application/json",
                        },
                        body: formData,
                    });

                    if (!response.ok) {
                        const errorData = await response
                            .json()
                            .catch(() => ({}));
                        const errorMessage =
                            errorData.error || "Failed to delete.";
                        throw new Error(errorMessage);
                    }

                    const data = await response.json().catch(() => ({}));

                    Swal.fire({
                        toast: true,
                        position: "bottom-end",
                        icon: "success",
                        title: "Data berhasil dihapus!",
                        showConfirmButton: false,
                        timer: 1000,
                        timerProgressBar: true,
                    });

                    // Optional: remove deleted row or reload
                    setTimeout(() => location.reload(), 1000);
                } catch (error) {
                    console.error("Deletion failed", error);
                    Swal.fire({
                        icon: "error",
                        title: "Gagal",
                        text:
                            error.message ||
                            "Terjadi kesalahan saat menghapus.",
                    });
                }
            }
        });
    });
});
