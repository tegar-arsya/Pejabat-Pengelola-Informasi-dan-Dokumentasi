<!doctype html>
<html lang="en">

<head>
    <title>Login 01</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" sizes="16x16" href="../Assets/img/logo_jateng.png">

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="../Assets/css/login.css">

</head>

<body>
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center" style="margin-top: -80px;">
                <div class="col-md-6 text-center mb-5">
                    <img class="img" src="../Assets/img/logo_jateng.png" />
                    <h2 class="heading-section" style="font-weight: bold; font-size: 22px;">PERMOHONAN INFORMASI</h2>
                    <h3 style="font-size: 22px;">PROVINSI JAWA TENGAH</h3>
                </div>
            </div>
            <div class="row justify-content-center" style="margin-top: -50px;">
                <div class="col-md-7 col-lg-5">
                    <div class="login-wrap p-4 p-md-5">
                        <h3 class="text-center mb-4">Sign in to start your session</h3>
                        <form action="../controller/login_proses_admin.php" method="POST" class="login-form">
                            <div class="form-group">
                                <input type="text" id="username" name="username" class="form-control rounded-left"
                                    placeholder="Username" required>
                            </div>
                            <div class="form-group d-flex">
                                <input type="password" id="password" name="password" class="form-control rounded-left"
                                    placeholder="Password" required>
                            </div>
                            <div class="form-group">
                                <button type="submit"
                                    class="form-control btn btn-primary rounded submit px-3">Login</button>
                            </div>
                            <div class="form-group d-md-flex">
                                <div class="w-50">
                                    <label class="checkbox-wrap checkbox-primary">Remember Me
                                        <input type="checkbox" checked>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="w-50 text-md-right">
                                    <a href="#">Forgot Password</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="../Assets/js/jquery.min.js"></script>
    <script src="../Assets/js/popper.js"></script>
    <script src="../Assets/js/bootstrap.min.js"></script>
    <script src="../Assets/js/main.js"></script>

</body>

</html>