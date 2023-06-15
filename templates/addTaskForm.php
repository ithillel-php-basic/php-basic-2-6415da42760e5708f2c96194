<?php
/**
 * @var resource $mainSidebar
 * @var resource $navbar
 * @var array $projects
 * @var int|null $projectId;
 * @var array $errors
 * @var array $oldValues
 */
?>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <!-- Navbar -->
    <?php echo $navbar ?>
    <!-- /.navbar -->


    <!-- Main Sidebar Container -->
    <?php echo $mainSidebar; ?>

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
            <form action="<?php echo '/add.php' ?>" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Основні</h3>

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
                                    <label for="title">Назва задачі</label>
                                    <input type="text"
                                           id="title"
                                           class="form-control <?php echo (!empty($errors)
                                               && isset($errors['title'])) ? 'is-invalid' : '' ?>"
                                           name="title"
                                           value="<?php
                                                echo isset($oldValues['title'])
                                                ? htmlentities($oldValues['title']) : ''
                                            ?>"
                                    >
                                    <?php if (isset($errors['title'])) : ?>
                                        <?php foreach ($errors['title'] as $error) : ?>
                                            <span id="title-error" class="error invalid-feedback">
                                                <?php echo $error; ?>
                                            </span>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <label for="description">Опис задачі</label>
                                    <textarea id="description"
                                              class="form-control"
                                              rows="4"
                                              name="description"
                                    ><?php echo isset($oldValues['description'])
                                            ? htmlentities($oldValues['description'])
                                            : '' ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="project">Оберіть проєкт</label>
                                    <select class="form-control
                                            <?php echo (!empty($errors)
                                            && isset($errors['project'])) ? 'is-invalid' : '' ?>"
                                            id="project"
                                            name="project"
                                    >
                                        <option value="<?php echo null ?>">-- Не обрано --</option>
                                        <?php foreach ($projects as $project) : ?>
                                            <option value="<?php echo $project['id']; ?>"
                                                <?php echo (isset($oldValues['project'])
                                                    && $project['id'] === intval($oldValues['project'])
                                                    || $project['id'] === $projectId)
                                                    ? 'selected' : ''
                                                ?>
                                            ><?php echo htmlspecialchars($project['title']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php if (isset($errors['project'])) : ?>
                                        <?php foreach ($errors['project'] as $error) : ?>
                                            <span id="project-error" class="error invalid-feedback">
                                                <?php echo $error ?>
                                            </span>
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
                                    <button type="button" class="btn btn-tool"
                                            data-card-widget="collapse"
                                            title="Collapse"
                                    >
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="inputDate">Дата виконання</label>
                                    <input type="date"
                                           id="inputDate"
                                           class="form-control
                                                <?php echo (!empty($errors)
                                                && isset($errors['deadline'])) ? 'is-invalid' : '' ?>"
                                           name="deadline"
                                           value="<?php echo isset($oldValues['deadline'])
                                               ? htmlentities($oldValues['deadline'])
                                               : '' ?>"
                                    >
                                    <?php if (isset($errors['deadline'])) : ?>
                                        <?php foreach ($errors['deadline'] as $error) : ?>
                                        <span id="deadline-error"
                                              class="error invalid-feedback"
                                        ><?php echo $error ?></span>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <label for="file">Прикріпити файл</label>
                                    <input type="file"
                                           id="file"
                                           class="form-control
                                                <?php echo (!empty($errors)
                                                && isset($errors['file'])) ? 'is-invalid' : '' ?>"
                                           name="file"
                                    >
                                    <?php if (isset($errors['file'])) : ?>
                                        <?php foreach ($errors['file'] as $error) : ?>
                                            <span id="file-error"
                                                  class="error invalid-feedback"
                                            ><?php echo $error ?></span>
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
<!-- toastr script -->
<script src="../static/plugins/toastr/toastr.min.js"></script>
<script src="../static/js/toastrMessages.js"></script>
</body>