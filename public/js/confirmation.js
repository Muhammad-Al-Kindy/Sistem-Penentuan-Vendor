function confirmDelete(id) {
    console.log("confirmDelete called with id:", id);
    Swal.fire({
        title: "Yakin ingin menghapus?",
        text: "Data tidak bisa dikembalikan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#e3342f",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            console.log("Form submitted");
            document.getElementById(`delete-form-${id}`).submit();
        }
    });
}
