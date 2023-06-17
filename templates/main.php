<?php
use services\KanbanService;
use services\MainSidebarTemplateService;
use services\NavbarTemplateService;

/**
 * @var KanbanService $kanbanTemplate
 * @var NavbarTemplateService $navbarTemplate
 * @var MainSidebarTemplateService $mainSidebarTemplate
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
    <?php echo $kanbanTemplate ?>

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