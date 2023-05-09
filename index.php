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


    /**
     * Підраховує кількість завдань, які належать по певного проєкту.
     *
     * @param array $getData
     * @param string $projectName
     * @return int
     */
    function countTasks(array $getData, string $projectName): int
    {
        $counter = 0;

        foreach ($getData as ['category' => $category])
        {
            if ($category === $projectName)
            {
                $counter++;
            }
        }

        return $counter;
    }


    /**
     * Показує скільки залишилось днів та годин до вказаної дати.
     *
     * @param string $date
     * @return string
     */
    function getTimeRemain(string $date): string
    {
        $diff = strtotime($date) - time();
        $diff = max($diff, 0);

        $days = floor($diff/(60*60*24));
        $hours = floor(($diff-$days*60*60*24)/(60*60));

        if ($diff <= 86400)
        {
            $checkPerDay = ($diff === 86400 ? $hours = 24 : $hours);
            return '<small class="badge badge-danger" title="'.$date.'"><i class="far fa-clock"></i> '. $checkPerDay .' год </small>';
        }

        return '<small class="badge badge-success" title="'.$date.'"><i class="far fa-clock"></i> '. $days .' дн : '.$hours.' год </small>';

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

<?php echo renderTemplate('layout.php', ['title' => $title, 'body' => $body]) ?>
