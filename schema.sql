CREATE
DATABASE `tasks_and_projects`;

CREATE TABLE `tasks_and_projects`.`users`
(
    `id`         INT          NOT NULL AUTO_INCREMENT,
    `name`       VARCHAR(255) NOT NULL,
    `email`      VARCHAR(255) NOT NULL UNIQUE,
    `password`   VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

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

CREATE TABLE `tasks_and_projects`.`projects`
(
    `id`         INT          NOT NULL AUTO_INCREMENT,
    `title`      VARCHAR(255) NOT NULL,
    `user_id`    INT          NOT NULL,
    FOREIGN KEY (`user_id`)   REFERENCES users (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    `created_at` TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    INDEX(`user_id`)
) ENGINE = InnoDB;

INSERT INTO `tasks_and_projects`.`projects`(`title`, `user_id`)
VALUES ('Вхідні', 1),
       ('Навчання', 1),
       ('Робота', 1),
       ('Домашні справи', 1),
       ('Авто', 1);

CREATE TABLE `tasks_and_projects`.`tasks`
(
    `id`          INT          NOT NULL AUTO_INCREMENT,
    `title`       VARCHAR(255) NOT NULL,
    `description` TEXT NULL,
    `project_id`  INT          DEFAULT 1,
    FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    `deadline`    DATE NULL,
    `file`        VARCHAR(255) NULL,
    `status`      VARCHAR(255) NOT NULL DEFAULT 'backlog',
    `user_id`     INT          NOT NULL,
    FOREIGN KEY (`user_id`) REFERENCES users (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    `created_at`  TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    INDEX(`status`)
) ENGINE = InnoDB;

INSERT INTO `tasks_and_projects`.`tasks`(`title`, `project_id`, `deadline`, `status`, `user_id`)
VALUES 	('Співбесіда в компанії', 3, '2023-07-01', 'backlog', 1),
        ('Виконати тестове завдання', 3, '2023-07-25', 'backlog', 1),
        ('Зробити завдання до першого уроку', 2, '2023-04-27', 'done', 1),
        ('Зустрітись з друзями', 1, '2023-05-14', 'to-do', 1),
        ('Купити корм для кота', 4, null, 'in-progress', 1),
        ('Замовити піцу', 4, null, 'to-do', 1);