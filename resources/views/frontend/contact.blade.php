@include('frontend.include.header')
<!-- breadcrumb start-->
<section class="breadcrumb breadcrumb_bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb_iner">
                    <div class="breadcrumb_iner_item text-center">
                        <h2>contact</h2>
                        <p>home . contact</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- breadcrumb start-->

<!-- ================ contact section start ================= -->
<section class="contact-section">
    <div class="container">

        <div class="row">
            <div class="col-12">
                <h2 class="contact-title">Get in Touch</h2>
            </div>
            <div class="col-lg-8">
                <form class="form-contact contact_form" action="contact_process.php" method="post" id="contactForm"
                    novalidate="novalidate">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <textarea class="form-control w-100" name="message" id="message" cols="30" rows="9"
                                    onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Message'"
                                    placeholder='Enter Message'></textarea>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input class="form-control" name="name" id="name" type="text"
                                    onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter your name'"
                                    placeholder='Enter your name'>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input class="form-control" name="email" id="email" type="email"
                                    onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter email address'"
                                    placeholder='Enter email address'>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <input class="form-control" name="subject" id="subject" type="text"
                                    onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Subject'"
                                    placeholder='Enter Subject'>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <button type="submit" class="button button-contactForm btn_1">Send Message</button>
                    </div>
                </form>
            </div>
            <div class="col-lg-4">
                <div class="media contact-info">
                    <span class="contact-info__icon"><i class="ti-home"></i></span>
                    <div class="media-body">
                        <h3>Find us</h3>
                        <p>{{ $contact_details['address'] }}</p>
                    </div>
                </div>
                <div class="media contact-info">
                    <span class="contact-info__icon"><i class="ti-tablet"></i></span>
                    <div class="media-body">
                        <h3>Call Us</h3>
                        <p>{{ $contact_details['mobile'] }}</p>
                    </div>
                </div>
                <div class="media contact-info">
                    <span class="contact-info__icon"><i class="ti-email"></i></span>
                    <div class="media-body">
                        <h3>Chat with us</h3>
                        <p>{{ $contact_details['email'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ================ contact section end ================= -->

@include('frontend.include.footer')

<script>
$('#addClient').on('submit', function(e) {

    $('#process').text('Please Wait... Uploading files and creating Client');
    e.preventDefault();
    var formdata = new FormData(this);
    formdata.append('process', $('#process').val());
    axios.post(`${url}/addClient`, formdata).then(function(response) {
        // handle success
        $('#process').text('Save Changes');
        show_Toaster(response.data.message, response.data.type)
        if (response.data.type === 'success') {
            setTimeout(() => {
                window.location.href = `${url}/add-client`;
            }, 500);
        }
    }).catch(function(err) {
        $('#process').text('Save Changes');
        show_Toaster(err.response.data.message, 'error')
    })
});
</script>