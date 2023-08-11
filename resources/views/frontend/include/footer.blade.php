<!-- footer part start-->
<footer class="footer-area">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-sm-6 col-md-5">
                <div class="single-footer-widget">
                    <h4>Discover Destination</h4>
                    <ul>
                        <li><a href="https://www.sobotours.com/">Miami, USA</a></li>
                        <li><a href="https://www.sobotours.com/">California, USA</a></li>
                        <li><a href="https://www.sobotours.com/">London, UK</a></li>
                        <li><a href="https://www.sobotours.com/">Saintmartine, Bangladesh</a></li>
                        <li><a href="https://www.sobotours.com/">Mount Everast, India</a></li>
                        <li><a href="https://www.sobotours.com/">Sidney, Australia</a></li>
                        <li><a href="https://www.sobotours.com/">Miami, USA</a></li>
                        <li><a href="https://www.sobotours.com/">California, USA</a></li>
                        <li><a href="https://www.sobotours.com/">London, UK</a></li>
                        <li><a href="https://www.sobotours.com/">Saintmartine, Bangladesh</a></li>
                        <li><a href="https://www.sobotours.com/">Mount Everast, India</a></li>
                        <li><a href="https://www.sobotours.com/">Sidney, Australia</a></li>
                    </ul>

                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="single-footer-widget footer_icon">
                    <h4>Contact Us</h4>
                    <p>{{ $contact_details['address'] }}</p>
                    <span>{{ $contact_details['email'] }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="copyright_part_text text-center">
                    <p class="footer-text m-0">
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        Copyright &copy;<script>
                        document.write(new Date().getFullYear());
                        </script> All rights reserved | {{ $title }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- footer part end-->

<!-- jquery plugins here-->
<script src="{{ asset('assets/frontend/js/jquery-1.12.1.min.js') }}"></script>
<!-- popper js -->
<script src="{{ asset('assets/frontend/js/popper.min.js') }}"></script>
<!-- bootstrap js -->
<script src="{{ asset('assets/frontend/js/bootstrap.min.js') }}"></script>
<!-- magnific js -->
<script src="{{ asset('assets/frontend/js/jquery.magnific-popup.js') }}"></script>
<!-- swiper js -->
<script src="{{ asset('assets/frontend/js/owl.carousel.min.js') }}"></script>
<!-- masonry js -->
<script src="{{ asset('assets/frontend/js/masonry.pkgd.js') }}"></script>
<!-- masonry js -->
<script src="{{ asset('assets/frontend/js/jquery.nice-select.min.js') }}"></script>
<script src="{{ asset('assets/frontend/js/gijgo.min.js') }}"></script>
<!-- contact js -->
<script src="{{ asset('assets/frontend/js/jquery.ajaxchimp.min.js') }}"></script>
<script src="{{ asset('assets/frontend/js/jquery.form.js') }}"></script>
<script src="{{ asset('assets/frontend/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/frontend/js/mail-script.js') }}"></script>
<script src="{{ asset('assets/frontend/js/contact.js') }}"></script>
<!-- custom js -->
<script src="{{ asset('assets/frontend/js/custom.js') }}"></script>

<script>
$(document).ready(function() {
    // Add smooth scrolling to all links
    $("a").on('click', function(event) {

        // Make sure this.hash has a value before overriding default behavior
        if (this.hash !== "") {
            // Prevent default anchor click behavior
            event.preventDefault();

            // Store hash
            var hash = this.hash;

            // Using jQuery's animate() method to add smooth page scroll
            // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
            $('html, body').animate({
                scrollTop: $(hash).offset().top
            }, 800, function() {

                // Add hash (#) to URL when done scrolling (default click behavior)
                window.location.hash = hash;
            });
        } // End if
    });
});
</script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
</body>
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

</html>