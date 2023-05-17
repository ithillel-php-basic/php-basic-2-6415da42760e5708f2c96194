## Заповнення БД
## Створення нових користувачів
INSERT INTO `tasks_and_projects`.`users`(`name`, `email`, `password`)
VALUES ('Володимир',
        'volodymyr.d@hillel.pro',
        '$2y$10$.njCk46/UKLYzs6OQhi3i.HzKFHuGXfeGRWswAhF4i5kjcIlKdB2O'),
       ('Сергій',
        'a@a.com',
        '$2y$10$68gSu7Jbdba1pSC9T24Gg.8iQG5PE/ZMa1VyB3Ib3mn3e0.w31a9S'),
       ('Анна',
        'anna2133@gmail.com',
        '$2y$10$gwQb5IyStAHd/AfLOTd5seHXb6CT4z/ABHMxX/aWEIpVEM2RWCgWm');

## Внесення існуючих проєктів у табличку
INSERT INTO `tasks_and_projects`.`projects`(`title`, `user_id`)
VALUES ('Вхідні', 1),
       ('Навчання', 1),
       ('Робота', 1),
       ('Домашні справи', 1),
       ('Авто', 1),
       ('Подорожі', 2),
       ('Відпочинок', 3);

## Заповнення таблички зі списком наявних завдань
INSERT INTO `tasks_and_projects`.`tasks`(`title`, `project_id`, `deadline`, `status`, `user_id`)
VALUES 	('Співбесіда в компанії', 3, '2023-07-01', 'backlog', 1),
        ('Виконати тестове завдання', 3, '2023-07-25', 'backlog', 1),
        ('Зробити завдання до першого уроку', 2, '2023-04-27', 'done', 1),
        ('Зустрітись з друзями', 1, '2023-05-14', 'to-do', 1),
        ('Купити корм для кота', 4, null, 'in-progress', 1),
        ('Замовити піцу', 4, null, 'to-do', 1),
        ('Поїхати в Норвегію', 6, null, 'to-do', 2),
        ('Поїхати на море', 6, '2023-06-24', 'to-do', 3);


## Запити в БД
## Виводить список усіх проєктів для одного користувача
SELECT p.id, p.title, u.name
FROM `tasks_and_projects`.`projects` as p
LEFT JOIN `tasks_and_projects`.`users` as u
ON p.user_id = u.id
WHERE p.user_id = 1;

## Отримання списку всіх завдань для для одного проєкту
SELECT t.id, t.title, t.description, p.title, t.deadline, t.file, t.status
FROM `tasks_and_projects`.`tasks` AS t
LEFT JOIN `tasks_and_projects`.`projects` AS p
ON t.project_id = p.id
WHERE p.id = 4 AND t.user_id = 1;

## Оновлено статус завдання на "to-do"
UPDATE `tasks_and_projects`.`tasks`
SET `status` = 'to-do'
WHERE id = 1;

## Оновлено статус завдання на "done"
UPDATE `tasks_and_projects`.`tasks`
SET `status` = 'done'
WHERE id = 4;

## Оновлена назва завдання на "Зробити завдання до сьомого уроку" по id
UPDATE `tasks_and_projects`.`tasks`
SET `title` = 'Зробити завдання до сьомого уроку'
WHERE id = 3;