<?php
/**
 * @var string $title
 * @var array $errors
 */
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title ?></title>

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

<body class="hold-transition register-page">
<div class="register-box">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="#" class="h1">Завдання та проекти</a>
        </div>
        <div class="card-body">
            <p class="login-box-msg">Зареєструватися</p>

            <form action="register.php" method="POST">
                <div class="input-group mb-3 <?php echo (isset($errors['name'])) ? 'is-invalid' : '' ?>">
                    <label for="name"></label>
                    <input type="text"
                           class="form-control <?php echo (isset($errors['name'])) ? 'is-invalid' : '' ?>"
                           placeholder="Повне ім'я"
                           name="name"
                           id="name"
                    >
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>

                <?php if(isset($errors['name'])): ?>
                    <?php foreach ($errors['name'] as $error): ?>
                        <span id="name-error" class="error invalid-feedback"><?php echo $error ?></span>
                    <?php endforeach; ?>
                <?php endif; ?>

                <div class="input-group mb-3 <?php echo (isset($errors['email'])) ? 'is-invalid' : '' ?>">
                    <label for="email"></label>
                    <input type="email"
                           class="form-control <?php echo (isset($errors['email'])) ? 'is-invalid' : '' ?>"
                           placeholder="Email"
                           name="email"
                           id="email"
                    >
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>

                <?php if(isset($errors['email'])): ?>
                    <?php foreach ($errors['email'] as $error): ?>
                        <span id="email-error" class="error invalid-feedback"><?php echo $error ?></span>
                    <?php endforeach; ?>
                <?php endif; ?>

                <div class="input-group mb-3 <?php echo (isset($errors['password']) || isset($errors['password_confirmation'])) ? 'is-invalid' : '' ?>">
                    <label for="password"></label>
                    <input type="password"
                           class="form-control <?php echo (isset($errors['password']) || isset($errors['password_confirmation'])) ? 'is-invalid' : '' ?>"
                           placeholder="Пароль"
                           name="password"
                           id="password"
                    >
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>

                <?php if(isset($errors['password'])): ?>
                    <?php foreach ($errors['password'] as $error): ?>
                        <span id="password-error" class="error invalid-feedback"><?php echo $error ?></span>
                    <?php endforeach; ?>
                <?php endif; ?>

                <div class="input-group mb-3 <?php echo (isset($errors['password_confirmation'])) ? 'is-invalid' : '' ?>">
                    <label for="password_confirmation"></label>
                    <input type="password"
                           class="form-control <?php echo (isset($errors['password_confirmation'])) ? 'is-invalid' : '' ?>"
                           placeholder="Повторіть пароль"
                           name="password_confirmation"
                           id="password_confirmation"
                    >
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>

                <?php if(isset($errors['password_confirmation'])): ?>
                    <?php foreach ($errors['password_confirmation'] as $error): ?>
                        <span id="password_confirmation-error" class="error invalid-feedback"><?php echo $error ?></span>
                    <?php endforeach; ?>
                <?php endif; ?>

                <?php
                if (!empty($errors))
                {
                    echo '<span class="error invalid-feedback">Будь-ласка виправте помилки.</span>';
                }
                ?>

                <div class="row">
                    <div class="col-8 offset-2">
                        <button type="submit" class="btn btn-primary btn-block">Зареєструватися</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            <a href="#" class="text-center">В мене вже є аккаунт</a>
        </div>
        <!-- /.form-box -->
    </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="../static/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../static/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../static/js/adminlte.min.js"></script>
</body>

</html>
