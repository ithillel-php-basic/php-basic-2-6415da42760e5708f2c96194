<?php
/**
 * @var array $errors
 * @var array $oldValues
 */
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Завдання та проекти | Вхід</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../static/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="../static/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../static/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
<div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="#" class="h1">Завдання та проекти</a>
        </div>
        <div class="card-body">
            <p class="login-box-msg">Увійдіть для доступу до своїх задач</p>

            <form action="auth.php" method="POST">
                <div class="input-group <?php echo (!empty($errors)
                    && isset($errors['email'])) ? 'is-invalid' : 'mb-3' ?>">
                    <label for="email"></label>
                    <input type="email"
                           class="form-control
                           <?php echo (!empty($errors) && isset($errors['email'])) ? 'is-invalid' : '' ?>"
                           placeholder="Email"
                           id="email"
                           name="email"
                           value="<?php echo isset($oldValues['email']) ? htmlentities($oldValues['email']) : '' ?>"
                    >
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <?php
                if (isset($errors['email'])) :
                    foreach ($errors['email'] as $error) :
                        echo '<span id="email-error" class="error invalid-feedback">'. $error .'</span>';
                    endforeach;
                endif;
                ?>
                <div class="input-group <?php echo (!empty($errors)
                    && isset($errors['password'])) ? 'is-invalid' : 'mb-3' ?>">
                    <label for="password"></label>
                    <input type="password"
                           class="form-control
                           <?php echo (!empty($errors) && isset($errors['password'])) ? 'is-invalid' : '' ?>"
                           placeholder="Password"
                           id="password"
                           name="password"
                    >
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <?php
                if (isset($errors['password'])) :
                    foreach ($errors['password'] as $error) :
                        echo '<span id="password-error" class="error invalid-feedback">'. $error .'</span>';
                    endforeach;
                endif;
                ?>
                <div class="row">
                    <div class="col-4 offset-4">
                        <button type="submit" class="btn btn-primary btn-block">Вхід</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            <p class="mb-0">
                <a href="register.php" class="text-center">Зареєструватися</a>
            </p>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="../static/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../static/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../static/js/adminlte.min.js"></script>
</body>

</html>
