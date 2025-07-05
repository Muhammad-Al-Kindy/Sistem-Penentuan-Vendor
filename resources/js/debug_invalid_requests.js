document.addEventListener("DOMContentLoaded", function () {
    // Intercept all fetch requests to log URLs with 'undefined'
    const originalFetch = window.fetch;
    window.fetch = function () {
        const url = arguments[0];
        if (typeof url === "string" && url.includes("undefined")) {
            console.error("Fetch request with undefined URL detected:", url);
            alert("Fetch request with undefined URL detected: " + url);
        }
        return originalFetch.apply(this, arguments);
    };

    // Intercept all clicks on links to detect navigation to 'undefined' URLs
    document.body.addEventListener("click", function (e) {
        const target = e.target.closest("a");
        if (target && target.href && target.href.includes("undefined")) {
            e.preventDefault();
            console.error(
                "Navigation to undefined URL prevented:",
                target.href
            );
            alert("Navigation to undefined URL prevented: " + target.href);
        }
    });
});
