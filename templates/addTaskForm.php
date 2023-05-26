<?php
/**
 * @var resource $sidebar
 * @var array $projects
 * @var int|null $projectId;
 * @var array $errors
 */

session_start();
?>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="/" class="nav-link">Дошка</a>
            </li>
            <li class="nav-item bg-secondary d-none d-sm-inline-block">
                <a href="../add.php" class="nav-link disabled">Створити задачу</a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->


    <!-- Main Sidebar Container -->
    <?php echo $sidebar; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h1>Створити задачу</h1>
                    </div>
                    <div class="col-sm-6 d-none d-sm-block">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">Створити задачу</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <form action="../add.php" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Основні</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="title">Назва задачі</label>
                                    <input type="text"
                                           id="title"
                                           class="form-control <?php echo (!empty($errors) && isset($errors['title'])) ? 'is-invalid' : '' ?>"
                                           name="title"
                                           value="<?php echo $_SESSION['title'] = $_POST['title'] ?? '' ?>"
                                    >
                                    <?php if(isset($errors['title'])): ?>
                                        <?php foreach ($errors['title'] as $error): ?>
                                            <span id="title-error" class="error invalid-feedback"><?php echo $error; ?></span>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <label for="description">Опис задачі</label>
                                    <textarea id="description"
                                              class="form-control"
                                              rows="4"
                                              name="description"
                                    ><?php echo $_SESSION['description'] = $_POST['description'] ?? '' ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="project">Оберіть проєкт</label>
                                    <select class="form-control <?php echo (!empty($errors) && isset($errors['project'])) ? 'is-invalid' : '' ?>"
                                            id="project"
                                            name="project"
                                    >
                                        <option>-- Не обрано --</option>
                                        <?php foreach ($projects as $project): ?>
                                            <option value="<?php echo $project['id']; ?>" <?php echo ($project['id'] === $projectId) ? 'selected' : '' ?>><?php echo $project['title'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php if(isset($errors['project'])): ?>
                                        <?php foreach ($errors['project'] as $error): ?>
                                            <span id="project-error" class="error invalid-feedback"><?php echo $error ?></span>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <div class="col-md-6">
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">Додаткові</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="inputDate">Дата виконання</label>
                                    <input type="date"
                                           id="inputDate"
                                           class="form-control <?php echo (!empty($errors) && isset($errors['deadline'])) ? 'is-invalid' : '' ?>"
                                           name="deadline"
                                           value="<?php echo $_SESSION['deadline'] = $_POST['deadline'] ?? '' ?>"
                                    >
                                    <?php if(isset($errors['deadline'])): ?>
                                        <?php foreach ($errors['deadline'] as $error): ?>
                                        <span id="deadline-error" class="error invalid-feedback"><?php echo $error ?></span>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <label for="file">Прикріпити файл</label>
                                    <input type="file"
                                           id="file"
                                           class="form-control"
                                           name="file"
                                    >
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <a href="#" class="btn btn-secondary">Відмініти</a>
                        <input type="submit" value="Створити нову задачу" class="btn btn-success">
                    </div>
                </div>
            </form>
        </section>
    </div>

    <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
            <b>Version</b> 0.1.0
        </div>
        <strong>Copyright &copy; 2023 <a href="https://ithillel.ua/">Комп'ютерна школа Hillel</a>.</strong> All rights
        reserved.
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../static/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="../static/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Bootstrap -->
<script src="../static/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Ekko Lightbox -->
<script src="../static/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
<!-- overlayScrollbars -->
<script src="../static/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="../static/js/adminlte.min.js"></script>
<!-- Filterizr-->
<script src="../static/plugins/filterizr/jquery.filterizr.min.js"></script>
<!-- Page specific script -->
<script src="../static/js/kanban.js"></script>
</body>