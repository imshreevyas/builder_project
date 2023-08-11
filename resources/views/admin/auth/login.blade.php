<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="assets/">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Login</title>

    <meta name="description" content="" />
    @include('include.header')
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}" />

</head>

<body background="{{ asset('assets/img/backgrounds/27.jpg') }}">
    <!-- Content -->

    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Register -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center">
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-2">Welcome Admin!!</h4>

                        <form id="login" class="mb-3">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control" id="email" name="email"
                                    placeholder="Enter your email" autofocus />
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">Password</label>
                                    <a href="{{ url('/forgot-password') }}">
                                        <small></small>
                                    </a>
                                </div>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" name="password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                            </div>
                        </form>

                        <p class="text-center">
                            <span>Having trouble signing in?</span>
                            <a href="{{ route('forgot-password') }}">
                                <span>reset password</span>
                            </a>
                        </p>
                    </div>
                </div>
                <!-- /Register -->
            </div>
        </div>
    </div>

    <!-- / Content -->

    @include('include.footer')
    <script>
    $('#login').on('submit', function(e) {
        e.preventDefault();
        axios.post(`${url}/admin/adminLoginPost`, new FormData(this)).then(function(response) {
            // handle success
            show_Toaster(response.data.message, response.data.type)
            if (response.data.type === 'success') {
                setTimeout(() => {
                    window.location.href = `${url}/admin/dashboard`;
                }, 500);
            }
        }).catch(function(err) {
            show_Toaster(err.response.data.message, 'error')
        })
    });
    </script>
</body>

</html>