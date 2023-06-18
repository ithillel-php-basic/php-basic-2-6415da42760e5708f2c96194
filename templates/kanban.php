<?php

use helpers\DateHandler;
use services\TaskService;

/**
 * @var TaskService $tasks
 * @var string $pageTitle
 * @var int|null $projectId
 * @var string $url
 * @var string $filter
 */
?>
<div class="content-wrapper kanban">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1><?php echo htmlspecialchars($pageTitle) ?>
                </div>
                <div class="col-sm-6 d-none d-sm-block">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active"><?php echo htmlspecialchars($pageTitle) ?></li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 offset-md-4">
                    <div class="row">
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <a type="button"
                               href="/<?php echo isset($projectId) ? '?project_id=' . urlencode($projectId) : '' ?>"
                               class="btn <?php echo ($url == '/' || isset($projectId) && !isset($filter))
                                   ? 'btn-secondary active'
                                   : 'btn-default'?>"
                            >Усі завдання</a>

                            <a type="button"
                               href="/?<?php echo isset($projectId)
                                   ? 'project_id=' . urlencode($projectId) . '&'
                                   : '' ?>filter=today"
                               class="btn <?php echo (isset($filter) && $filter === 'today')
                                   ? 'btn-secondary active'
                                   : 'btn-default'?>"
                            >Порядок денний</a>

                            <a type="button"
                               href="/?<?php echo isset($projectId)
                                   ? 'project_id=' . urlencode($projectId) . '&'
                                   : '' ?>filter=tomorrow"
                               class="btn <?php echo (isset($filter) && $filter === 'tomorrow')
                                   ? 'btn-secondary active'
                                   : 'btn-default'?>"
                            >Завтра</a>

                            <a type="button"
                               href="/?<?php echo isset($projectId)
                                   ? 'project_id=' . urlencode($projectId) . '&'
                                   : '' ?>filter=expired"
                               class="btn <?php echo (isset($filter) && $filter === 'expired')
                                   ? 'btn-secondary active'
                                   : 'btn-default'?>"
                            >Прострочені</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="content pb-3">
        <div class="container-fluid h-100">
            <div class="card card-row card-secondary">
                <div class="card-header">
                    <h3 class="card-title">
                        Беклог
                    </h3>
                </div>
                <div class="card-body connectedSortable" data-status="backlog" >
                    <?php foreach ($tasks as $key => $task) : ?>
                        <?php
                        if (
                            $task['status'] === 'backlog'
                            && isset($projectId)
                            && $task['project_id'] === $projectId
                        ) :
                            ?>
                            <div class="card card-info card-outline" data-task-id="<?php echo $task['id'] ?>">
                                <div class="card-header">
                                    <h5 class="card-title"><?php echo htmlspecialchars($task['title']) ?></h5>
                                    <div class="card-tools">
                                        <a href="#" class="btn btn-tool btn-link"><?php echo '#' . $task['id'] ?></a>
                                        <a href="#" class="btn btn-tool">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <p>
                            <?php echo htmlspecialchars($task['description'] ?? '') ?>
                                    </p>
                            <?php if (!is_null($task['file'])) : ?>
                                        <a href="<?php echo 'downloadDoc.php?file=' . urlencode($task['file']) ?>"
                                           class="btn btn-tool"
                                        >
                                            <i class="fas fa-file"></i>
                                        </a>
                            <?php endif; ?>
                            <?php
                            if (!is_null($task['deadline'])) :
                                echo DateHandler::timeRemains($task['deadline']);
                            endif;
                            ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if ($task['status'] === 'backlog' && !isset($projectId)) : ?>
                            <div class="card card-info card-outline" data-task-id="<?php echo $task['id'] ?>">
                                <div class="card-header">
                                    <h5 class="card-title"><?php echo htmlspecialchars($task['title']) ?></h5>
                                    <div class="card-tools">
                                        <a href="#" class="btn btn-tool btn-link"><?php echo '#' . $task['id'] ?></a>
                                        <a href="#" class="btn btn-tool">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <p>
                                        <?php echo htmlspecialchars($task['description'] ?? '') ?>
                                    </p>
                                    <?php if (!is_null($task['file'])) : ?>
                                        <a href="<?php echo 'downloadDoc.php?file=' . urlencode($task['file']) ?>"
                                           class="btn btn-tool"
                                        >
                                            <i class="fas fa-file"></i>
                                        </a>
                                    <?php endif; ?>
                                    <?php
                                    if (!is_null($task['deadline'])) :
                                        echo DateHandler::timeRemains($task['deadline']);
                                    endif;
                                    ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="card card-row card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        Зробити
                    </h3>
                </div>
                <div class="card-body connectedSortable" data-status="to-do">
                    <?php foreach ($tasks as $key => $task) : ?>
                        <?php
                        if (
                            $task['status'] === 'to-do'
                            && isset($projectId)
                            && $task['project_id'] === $projectId
                        ) :
                            ?>
                            <div class="card card-info card-outline" data-task-id="<?php echo $task['id'] ?>">
                                <div class="card-header">
                                    <h5 class="card-title"><?php echo htmlspecialchars($task['title']) ?></h5>
                                    <div class="card-tools">
                                        <a href="#" class="btn btn-tool btn-link"><?php echo '#' . $task['id'] ?></a>
                                        <a href="#" class="btn btn-tool">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <p>
                                        <?php echo htmlspecialchars($task['description'] ?? '') ?>
                                    </p>
                                    <?php if (!is_null($task['file'])) : ?>
                                        <a href="<?php echo 'downloadDoc.php?file=' . urlencode($task['file']) ?>"
                                           class="btn btn-tool"
                                        >
                                            <i class="fas fa-file"></i>
                                        </a>
                                    <?php endif; ?>
                                    <?php
                                    if (!is_null($task['deadline'])) :
                                        echo DateHandler::timeRemains($task['deadline']);
                                    endif;
                                    ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if ($task['status'] === 'to-do' && !isset($projectId)) : ?>
                            <div class="card card-info card-outline" data-task-id="<?php echo $task['id'] ?>">
                                <div class="card-header">
                                    <h5 class="card-title"><?php echo htmlspecialchars($task['title']) ?></h5>
                                    <div class="card-tools">
                                        <a href="#" class="btn btn-tool btn-link"><?php echo '#' . $task['id'] ?></a>
                                        <a href="#" class="btn btn-tool">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <p>
                                        <?php echo htmlspecialchars($task['description'] ?? '') ?>
                                    </p>
                                    <?php if (!is_null($task['file'])) : ?>
                                        <a href="<?php echo 'downloadDoc.php?file=' . urlencode($task['file']) ?>"
                                           class="btn btn-tool"
                                        >
                                            <i class="fas fa-file"></i>
                                        </a>
                                    <?php endif; ?>
                                    <?php
                                    if (!is_null($task['deadline'])) :
                                        echo DateHandler::timeRemains($task['deadline']);
                                    endif;
                                    ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="card card-row card-default">
                <div class="card-header bg-info">
                    <h3 class="card-title">
                        В процесі
                    </h3>
                </div>
                <div class="card-body connectedSortable" data-status="in-progress">
                    <?php foreach ($tasks as $key => $task) : ?>
                        <?php
                        if (
                            $task['status'] === 'in-progress'
                            && isset($projectId)
                            && $task['project_id'] === $projectId
                        ) :
                            ?>
                            <div class="card card-info card-outline" data-task-id="<?php echo $task['id'] ?>">
                                <div class="card-header">
                                    <h5 class="card-title"><?php echo htmlspecialchars($task['title']) ?></h5>
                                    <div class="card-tools">
                                        <a href="#" class="btn btn-tool btn-link"><?php echo '#' . $task['id'] ?></a>
                                        <a href="#" class="btn btn-tool">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <p>
                                <?php echo htmlspecialchars($task['description'] ?? '') ?>
                                    </p>
                            <?php if (!is_null($task['file'])) : ?>
                                        <a href="<?php echo 'downloadDoc.php?file=' . urlencode($task['file']) ?>"
                                           class="btn btn-tool"
                                        >
                                            <i class="fas fa-file"></i>
                                        </a>
                            <?php endif; ?>
                            <?php
                            if (!is_null($task['deadline'])) :
                                echo DateHandler::timeRemains($task['deadline']);
                            endif;
                            ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if ($task['status'] === 'in-progress' && !isset($projectId)) : ?>
                            <div class="card card-info card-outline" data-task-id="<?php echo $task['id'] ?>">
                                <div class="card-header">
                                    <h5 class="card-title"><?php echo htmlspecialchars($task['title']) ?></h5>
                                    <div class="card-tools">
                                        <a href="#" class="btn btn-tool btn-link"><?php echo '#' . $task['id'] ?></a>
                                        <a href="#" class="btn btn-tool">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <p>
                                        <?php echo htmlspecialchars($task['description'] ?? '') ?>
                                    </p>
                                    <?php if (!is_null($task['file'])) : ?>
                                        <a href="<?php echo 'downloadDoc.php?file=' . urlencode($task['file']) ?>"
                                           class="btn btn-tool"
                                        >
                                            <i class="fas fa-file"></i>
                                        </a>
                                    <?php endif; ?>
                                    <?php
                                    if (!is_null($task['deadline'])) :
                                        echo DateHandler::timeRemains($task['deadline']);
                                    endif;
                                    ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="card card-row card-success">
                <div class="card-header">
                    <h3 class="card-title">
                        Готово
                    </h3>
                </div>
                <div class="card-body connectedSortable" data-status="done">
                    <?php foreach ($tasks as $key => $task) : ?>
                        <?php
                        if (
                            $task['status'] === 'done'
                            && isset($projectId)
                            && $task['project_id'] === $projectId
                        ) :
                            ?>
                            <div class="card card-info card-outline" data-task-id="<?php echo $task['id'] ?>">
                                <div class="card-header">
                                    <h5 class="card-title"><?php echo htmlspecialchars($task['title']) ?></h5>
                                    <div class="card-tools">
                                        <a href="#" class="btn btn-tool btn-link"><?php echo '#' . $task['id'] ?></a>
                                        <a href="#" class="btn btn-tool">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <p>
                                    <?php echo htmlspecialchars($task['description'] ?? '') ?>
                                    </p>
                                <?php if (!is_null($task['file'])) : ?>
                                        <a href="<?php echo 'downloadDoc.php?file=' . urlencode($task['file']) ?>"
                                           class="btn btn-tool"
                                        >
                                            <i class="fas fa-file"></i>
                                        </a>
                                <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if ($task['status'] === 'done' && !isset($projectId)) : ?>
                            <div class="card card-info card-outline" data-task-id="<?php echo $task['id'] ?>">
                                <div class="card-header">
                                    <h5 class="card-title"><?php echo htmlspecialchars($task['title']) ?></h5>
                                    <div class="card-tools">
                                        <a href="#" class="btn btn-tool btn-link"><?php echo '#' . $task['id'] ?></a>
                                        <a href="#" class="btn btn-tool">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <p>
                                        <?php echo htmlspecialchars($task['description'] ?? '') ?>
                                    </p>
                                    <?php if (!is_null($task['file'])) : ?>
                                        <a href="<?php echo 'downloadDoc.php?file=' . urlencode($task['file']) ?>"
                                           class="btn btn-tool"
                                        >
                                            <i class="fas fa-file"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
</div>
