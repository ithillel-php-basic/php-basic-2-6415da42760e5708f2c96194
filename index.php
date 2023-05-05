<?php
    require_once 'helpers.php';

    $categories = ['Вхідні', 'Навчання', 'Робота', 'Домашні справи', 'Авто'];

    $data = [
        [
                'title'     => 'Співбесіда в компанії',
                'deadline'  => '01.07.2023',
                'category'  => $categories[2],
                'status'    => 'backlog'
        ],
        [
                'title'     => 'Виконати тестове завдання',
                'deadline'  => '25.07.2023',
                'category'  => $categories[2],
                'status'    => 'backlog'
        ],
        [
                'title'     => 'Зробити завдання до першого уроку',
                'deadline'  => '27.04.2023',
                'category'  => $categories[1],
                'status'    => 'done'
        ],
        [
                'title'     => 'Зустрітись з друзями',
                'deadline'  => '14.05.2023',
                'category'  => $categories[0],
                'status'    => 'to-do'
        ],
        [
                'title'     => 'Купити корм для кота',
                'deadline'  => null,
                'category'  => $categories[3],
                'status'    => 'in-progress'
        ],
        [
                'title'     => 'Замовити піцу',
                'deadline'  => null,
                'category'  => $categories[3],
                'status'    => 'to-do'
        ],
    ];

    function countTasks(array $getData, string $projectName): int
    {
        $sortedData = [];

        foreach ($getData as ['category' => $category])
        {
            if ($category === $projectName)
            {
                $sortedData[] = $projectName;
            }
        }

        return count($sortedData);
    }

    $userName = 'Володимир';
    $userPhoto = 'static/img/user2-160x160.jpg';

    $kanbanTemplate = renderTemplate('kanban.php', [
        'data'          => $data,
        'categories'    => $categories,
    ]);

    $title = 'Завдання та проекти | Дошка';
    $body = renderTemplate('main.php', [
        'kanbanTemplate'    => $kanbanTemplate,
        'categories'        => $categories,
        'userName'          => $userName,
        'userPhoto'         => $userPhoto,
        'data'              => $data,
    ]);
?>

<?= renderTemplate('layout.php', ['title' => $title, 'body' => $body]) ?>
