<?php

use helpers\TemplateRenderer;
use services\MainSidebarTemplateService;
use services\NavbarTemplateService;

/**
 * @var NavbarTemplateService $navbarTemplate
 * @var MainSidebarTemplateService $mainSidebarTemplate
 * @var array $oldValues
 * @var array $errors
 */

?>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <!-- Navbar -->
    <?php echo $navbarTemplate ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php echo $mainSidebarTemplate ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h1>Додати проєкт</h1>
                    </div>
                    <div class="col-sm-6 d-none d-sm-block">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">Додати проєкт</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <form action="../addProject.php" method="POST">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">General</h3>

                                <div class="card-tools">
                                    <button type="button"
                                            class="btn btn-tool"
                                            data-card-widget="collapse"
                                            title="Collapse"
                                    >
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="inputTitle">Назва проекту</label>
                                    <input type="text"
                                           id="inputTitle"
                                           class="form-control <?php echo (isset($errors['title']))
                                               ? 'is-invalid' : '' ?>"
                                           name="title"
                                           value="<?php echo isset($oldValues['title']) ?
                                               htmlentities($oldValues['title']) : '' ?>"
                                           required
                                    >
                                    <?php if (isset($errors['title'])) : ?>
                                        <?php foreach ($errors['title'] as $error) : ?>
                                            <?php echo TemplateRenderer::errorTemplate($error, 'title'); ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <input type="submit" value="Створити" class="btn btn-success">
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
</body>

