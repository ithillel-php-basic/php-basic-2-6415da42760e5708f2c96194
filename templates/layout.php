<?php

use services\MainTemplateService;

/**
 * @var string $title
 * @var MainTemplateService $body
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
    <!-- Ekko Lightbox -->
    <link rel="stylesheet" href="../static/plugins/ekko-lightbox/ekko-lightbox.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../static/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="../static/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- custom kanban styles -->
    <link rel="stylesheet" href="../static/css/kanban.css">
    <!-- toastr styles -->
    <link rel="stylesheet" href="../static/plugins/toastr/toastr.min.css">

    <?php if (!isset($_SESSION['user'])) : ?>
    <link rel="stylesheet" href="../static/css/cover.css">
    <?php endif; ?>
</head>
<?php echo $body ?>

</html>
