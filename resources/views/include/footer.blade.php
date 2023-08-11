<!-- build:js assets/vendor/js/core.js -->
<script src={{asset("assets/vendor/libs/jquery/jquery.js")}}></script>
<script src={{asset("assets/vendor/libs/popper/popper.js")}}></script>
<script src={{asset("assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js")}}></script>
<script src={{asset("assets/vendor/js/menu.js")}}></script>
<!-- endbuild -->
<!-- Vendors JS -->
<!-- Main JS -->
<script src={{asset("assets/js/main.js")}}></script>
<!-- Page JS -->
<script src={{asset("assets/js/dashboards-analytics.js")}}></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script>
    function show_Toaster(message, type) {
        var success = "#00b09b, #96c93d";
        var error = "#a7202d, #ff4044";
        var ColorCode = type == "success" ? success : error;

        return Toastify({
            text: message,
            duration: 3000,
            close: true,
            gravity: "bottom", // top or bottom
            position: "center", // left, center or right
            stopOnFocus: true, // Prevents dismissing of toast on hover
            style: {
                background: `linear-gradient(to right, ${ColorCode})`,
            },
        }).showToast();
    }
    </script>