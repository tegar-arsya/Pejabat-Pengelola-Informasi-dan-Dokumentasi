<?php
session_start();
include('../../../Model/CSRF/CSRFA.php');
?>
<!DOCTYPE html>
<html class="h-100" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>ppid</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../../../Assets/images/logo_jateng.png">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link href="../../../Assets/css/style-admin.css" rel="stylesheet">
    
</head>

<body class="h-100">
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>
    <div class="login-form-bg h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100">
                <div class="col-xl-6">
                    <div class="form-input-content">
                        <div class="row justify-content-center">
                            <div class="col-md-6 text-center mb-5">
                                <img class="img" src="../../../Assets/img/logo_jateng.png" width="100px"/>
                                <h2 class="heading-section" style="font-weight: bold; font-size: 22px;">PERMOHONAN INFORMASI</h2>
                                <h3 style="font-size: 22px;">PROVINSI JAWA TENGAH</h3>
                            </div>
                        </div>
                        <div class="card login-form mb-0">
                            <div class="card-body pt-5">
                                <h3 style="text-align: center;">Sign in to start your session</h3>
                                <form action="../../../controller/Admin/auth/login_proses_admin.php" method="POST" enctype="multipart/form-data" class="mt-5 mb-5 login-input">
                                <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                                    <div class="form-group">
                                        <input type="username" class="form-control" id="username" name="username" placeholder="username" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                                    </div>
                                    <button class="btn login-form__btn submit w-100" style="
                                    background-color: #9F0000;
                                ">Sign in</button>
                                </form>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    

    <!--**********************************
        Scripts
    ***********************************-->
    <script src="../../../Assets/plugins/common/common.min.js"></script>
    <script src="../../../Assets/js/custom.min.js"></script>
    <script src="../../../Assets/js/settings.js"></script>
    <script src="../../Assets/js/gleek.js"></script>
    <script src="../../../Assets/js/styleSwitcher.js"></script>
</body>
</html>





