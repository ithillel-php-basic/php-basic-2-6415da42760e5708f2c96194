CREATE DATABASE `tasks_and_projects`;

CREATE TABLE `tasks_and_projects`.`users`
(
    `id`         INT          NOT NULL AUTO_INCREMENT,
    `name`       VARCHAR(255) NOT NULL,
    `email`      VARCHAR(255) NOT NULL UNIQUE,
    `password`   VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

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
