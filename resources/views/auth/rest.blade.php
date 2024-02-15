<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <style>
        .form-gap {
            padding-top: 10%;
        }
        body {
            background-image: url('../assets/Adidas.jpg');
        }
        .alert {
            margin-top: 10px;
        }
    </style>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
</head>
<body>
    <div class="form-gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-5 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">
                            <h3><i class="fa fa-lock fa-4x"></i></h3>
                            <h2 class="text-center">Forgot Password?</h2>
                            <p>You can reset your password here.</p>
                            <div class="panel-body">
                                <form id="reset-password-form" role="form" autocomplete="off" class="form" method="post" action="{{ url('/password/email') }}">
                                    @csrf
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                            <input id="email" name="email" placeholder="Email Address" class="form-control  " type="email" aria-describedby="email-error">
                                        </div>
                                        <div id="email-error" class="error" style="display: none;">Invalid email address</div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" name="recover-submit" class="btn btn-lg btn-success btn-block">Reset Password</button>
                                    </div>
                                    <div class="alert alert-success" id="success-message" style="display: none;" role="alert">
                                        Password reset link sent to your email.
                                    </div>
                                    <div class="alert alert-danger" id="error-message" style="display: none;" role="alert">
                                        An error occurred. Please try again later.
                                    </div>
                                </form>
                                <p>Remember your password? <a href="{{ url('/login') }}">Log in here</a>.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <script>
        $(document).ready(function() {
            $('#reset-password-form').submit(function(event) {
                event.preventDefault(); 

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#success-message').show();
                        $('#error-message').hide();
                    },
                    error: function(xhr, status, error) {
                        $('#success-message').hide();
                        $('#error-message').show();
                    }
                });
            });
        });
    </script> --}}
</body>
</html>
