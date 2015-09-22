<?php
session_start();
if (isset($_SESSION['user'])) {
    header('Location: http://localhost/puyaOjo/pages/home.php');
}

include_once 'inc/html_block.php';
$elements = new ElementHTML();
$idiom = new Idiom();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $idiom->getTitle(); ?> | <?php echo $idiom->getTitle_login(); ?></title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="plugins/iCheck/square/blue.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <a href="index.php"><b><?php echo $idiom->getTitle(); ?></a>
            </div><!-- /.login-logo -->
            <div class="login-box-body">
                <form action="inc/log_in.php" method="post">
                    <div class="form-group has-feedback">
                        <label for="loginUsername"><?php echo $idiom->getUsername(); ?></label>
                        <input type="text" class="form-control" name="loginUsername" placeholder=<?php echo '"' . $idiom->getClue_username() . '"'; ?>>
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <label for="loginPassword"><?php echo $idiom->getPassword(); ?></label>
                        <input type="password" class="form-control" name="loginPassword" placeholder=<?php echo '"' . $idiom->getClue_password() . '"'; ?>>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <button type="submit" class="btn btn-primary btn-block btn-flat"><?php echo $idiom->getBtn_login(); ?></button>
                    </div>
                </form>

                <!--                <div class="social-auth-links text-center">
                                    <p>- OR -</p>
                                    <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using Facebook</a>
                                    <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using Google+</a>
                                </div> /.social-auth-links -->

                <a href="#"><?php echo $idiom->getClue_Iforgot(); ?></a><br>
                <a href="#" class="text-center"><?php echo $idiom->getClue_register(); ?></a>

            </div><!-- /.login-box-body -->
        </div><!-- /.login-box -->

        <!-- jQuery 2.1.4 -->
        <script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
        <!-- Bootstrap 3.3.5 -->
        <script src="../../bootstrap/js/bootstrap.min.js"></script>
        <!-- iCheck -->
        <script src="../../plugins/iCheck/icheck.min.js"></script>
        <script>
            $(function () {
                $('input').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                    increaseArea: '20%' // optional
                });
            });
        </script>
    </body>
</html>
