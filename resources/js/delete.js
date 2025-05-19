import Swal from "sweetalert2";

document.addEventListener("DOMContentLoaded", function () {
    const deleteForms = document.querySelectorAll("form[data-delete-form]");

    deleteForms.forEach((form) => {
        form.addEventListener("submit", function (e) {
            e.preventDefault();

            Swal.fire({
                title: "Yakin ingin menghapus?",
                text: "Data yang dihapus tidak bisa dikembalikan!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Ya, hapus!",
                cancelButtonText: "Batal",
            }).then((result) => {
                if (result.isConfirmed) {
                    const action = form.getAttribute("action");
                    const token = form.querySelector(
                        'input[name="_token"]'
                    ).value;

                    fetch(action, {
                        method: "DELETE",
                        headers: {
                            "X-CSRF-TOKEN": token,
                            Accept: "application/json",
                        },
                    })
                        .then((res) => {
                            if (!res.ok) throw new Error("Failed");
                            return res.json();
                        })
                        .then((data) => {
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
                        })
                        .catch((error) => {
                            console.error("Deletion failed", error);
                            Swal.fire({
                                icon: "error",
                                title: "Gagal",
                                text: "Terjadi kesalahan saat menghapus.",
                            });
                        });
                }
            });
        });
    });
});
