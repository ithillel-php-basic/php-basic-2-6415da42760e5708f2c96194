<?php
/**
 * @var string|null $projectId
 * @var string $url
 * @var string $queryStr
 * @var string $pageName
 */

?>
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="/" class="nav-link <?php echo ($url === '/'.$queryStr) ? 'disabled' : '' ?>">Дошка</a>
        </li>
        <li class="nav-item <?php echo (str_contains($url, $pageName)) ? 'bg-secondary' : 'bg-primary' ?> d-none d-sm-inline-block">
            <a href="<?php echo (isset($projectId)) ? '/add.php?project_id='.urlencode($projectId) : '/add.php' ?>" class="nav-link <?php echo (str_contains($url, $pageName)) ? 'disabled' : '' ?>">Створити задачу</a>
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