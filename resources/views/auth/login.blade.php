<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Login</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="icon" href="https://themekita.com/demo-atlantis-bootstrap/livepreview/examples/assets/img/icon.ico"
        type="image/x-icon" />
    <script src="{{ asset('assets') }}/js/plugin/webfont/webfont.min.js"></script>

    <script src="{{ asset('assets') }}/js/core/jquery.3.2.1.min.js"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Lato:300,400,700,900"]
            },
            custom: {
                "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands", "simple-line-icons"
                ],
                urls: ['{{ asset('assets') }}/css/fonts.min.css']
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>
    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets') }}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/css/atlantis.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="login">
    <div class="wrapper wrapper-login wrapper-login-full p-0">
        <div class="login-aside w-50 d-flex flex-column align-items-center justify-content-center text-center"
            style="
            background: url('{{ asset('assets/img/spk.jpg') }}');
            background-size: cover;
            background-position: bottom center;
            ">

        </div>
        <div class="login-aside w-50 d-flex align-items-center justify-content-center bg-white">
            @csrf
            <div class="container container-login container-transparent animated fadeIn" style="margin-top:-210px">
                <br /> <br /><br />
                <div style="text-align:center">
                    <br /> <br /><br />
                    <img src="{{ asset('assets/img/logo_telkom.png') }}" class="img-responsive" style="width: 50%" />

                    <h4 className="text-center" style="text-align: center;">
                        SISTEM INFORMASI PRESENSI SMP MUHAMMADIYAH 17 CIPUTAT
                    </h4>
                </div>

                <br /> <br /><br />`
                <form method="POST" action="{{ route('login') }}" id="loginacti" class="form-hocrizontal">

                    <div class="login-form">

                        <div class="form-group">
                            <label for="username" class="placeholder"><b>Username</b></label>
                            <input id="username" name="username" value="{{ old('email') }}" type="text"
                                class="form-control" required>
                            @if ($errors->has('username'))
                                <b>
                                    <strong style="color: red">{{ $errors->first('username') }}</strong>
                                </b>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="password" class="placeholder"><b>Password</b></label>

                            <div class="position-relative">
                                <input id="password" name="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" required>
                                @if ($errors->has('password'))
                                    <b>
                                        <strong style="color: red">{{ $errors->first('password') }}</strong>
                                    </b>
                                @endif
                                <div class=" show-password">
                                    <i class="icon-eye"></i>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                        </div>
                        <button href="#" class="btn btn-secondary col-md-5 float-right mt-3 mt-sm-0 fw-bold">Sign
                            In</button>

                    </div>
                </form>
            </div>
        </div>
        <script>
            $(document).on('submit', '#loginacti', function(e) {
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'post',
                    data: $(this).serialize(),
                    chace: false,
                    asynch: false,
                    success: function(data, JqXHR) {
                        window.location.href = 'home?contract=2022';
                        console.log(JqXHR);
                    },
                    error: function(data, JqXHR, err) {
                        err = '';
                        respon = data.responseJSON;
                        $.each(respon.errors, function(index, value) {
                            err += "<li>" + value + "</li>";
                        });
                        Swal.fire({
                            title: 'Opp ada kesalahan',
                            html: err,
                            icon: 'error',
                            confirmButtonText: 'Cool'
                        })
                    }
                });
            });
        </script>

        <script src="{{ asset('assets') }}/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
        <script src="{{ asset('assets') }}/js/core/popper.min.js"></script>
        <script src="{{ asset('assets') }}/js/core/bootstrap.min.js"></script>
        <script src="{{ asset('assets') }}/js/atlantis.min.js"></script>
</body>

</html>
