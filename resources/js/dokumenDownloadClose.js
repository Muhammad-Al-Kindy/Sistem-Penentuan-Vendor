document.addEventListener("DOMContentLoaded", () => {
    const dokumenLink = document.querySelector("a.dokumen-download-link");
    if (!dokumenLink) return;

    dokumenLink.addEventListener("click", (e) => {
        e.preventDefault();
        const url = dokumenLink.href;
        const newWindow = window.open(url, "_blank");

        if (newWindow) {
            // Close the new window after 5 seconds
            setTimeout(() => {
                newWindow.close();
            }, 5000);
        } else {
            alert("Please allow popups for this website to download the file.");
        }
    });
});
