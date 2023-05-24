<?php
/**
 * Перевіряє передану дату на відповідність формату 'ГГГГ-ММ-ДД'
 *
 * Приклади використання:
 * isDateValid('2019-01-01'); // true
 * isDateValid('2016-02-29'); // true
 * isDateValid('2019-04-31'); // false
 * isDateValid('10.10.2010'); // false
 * isDateValid('10/10/2010'); // false
 *
 * @param string $date Дата у вигляді рядка
 *
 * @return bool true у разі збігу з форматом 'ГГГГ-ММ-ДД', інакше false
 */
function isDateValid(string $date) : bool {
    $format_to_check = 'Y-m-d';
    $dateTimeObj = date_create_from_format($format_to_check, $date);

    return $dateTimeObj !== false && array_sum(date_get_last_errors()) === 0;
}

/**
 * Створює підготовлений вираз на основі готового SQL запиту і переданих даних
 *
 * @param $link mysqli Ресурс з'єднання
 * @param $sql string SQL запит із плейсхолдерами замість значень
 * @param array $data Дані для вставки на місце плейсхолдерів
 *
 * @return mysqli_stmt Підготовлений вираз
 */
function dbGetPrepareStmt($link, $sql, $data = []) {
    $stmt = mysqli_prepare($link, $sql);

    if ($stmt === false) {
        $errorMsg = 'Не вдалося ініціалізувати підготовлений вираз: ' . mysqli_error($link);
        throw new ErrorException($errorMsg);
    }

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            $type = 's';

            if (is_int($value)) {
                $type = 'i';
            }
            else if (is_string($value)) {
                $type = 's';
            }
            else if (is_double($value)) {
                $type = 'd';
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);

        $func = 'mysqli_stmt_bind_param';
        $func(...$values);

        if (mysqli_errno($link) > 0) {
            $errorMsg = 'Не вдалося пов\'язати підготовлений вираз із параметрами: ' . mysqli_error($link);
            throw new ErrorException($errorMsg);
        }
    }

    return $stmt;
}

/**
 * Повертає коректну форму множини
 * Обмеження: тільки для цілих чисел
 *
 * Приклад використання:
 * $remainingMinutes = 5;
 * echo "Я поставив таймер на {$remainingMinutes} " .
 *     getNounPluralForm(
 *         $remainingMinutes,
 *         'хвилина',
 *         'хвилини',
 *         'хвилин'
 *     );
 * Результат: "Я поставив таймер на 5 хвилин"
 *
 * @param int $number Число, за яким обчислюємо форму множини
 * @param string $one Форма однини: яблуко, година, хвилина
 * @param string $two Форма множини для 2, 3, 4: яблука, години, хвилини
 * @param string $many Форма множини для решти чисел
 *
 * @return string Розрахована форма множини
 */
function getNounPluralForm (int $number, string $one, string $two, string $many): string
{
    $number = (int) $number;
    $mod10 = $number % 10;
    $mod100 = $number % 100;

    switch (true) {
        case ($mod100 >= 11 && $mod100 <= 20):
            return $many;

        case ($mod10 > 5):
            return $many;

        case ($mod10 === 1):
            return $one;

        case ($mod10 >= 2 && $mod10 <= 4):
            return $two;

        default:
            return $many;
    }
}

/**
 * Підключає шаблон, передає туди дані і повертає підсумковий HTML контент
 *
 * @param string $name Шлях до файлу шаблону відносно папки templates
 * @param array $data Асоціативний масив із даними для шаблону
 * @return string Підсумковий HTML
 */
function renderTemplate($name, array $data = []) {
    $name = 'templates/' . $name;
    $result = '';

    if (!is_readable($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
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


/**
 * Виводить дані з таблички згідно з SQL запиту та конвертує їх в асоціативний масив.
 *
 * @param $sql_connect
 * @param $query
 * @return array
 */
function getQuery($sql_connect, $query) : array
{
    $result = mysqli_query($sql_connect, $query);

    if ($result === false)
    {
        die(mysqli_error($sql_connect));
    }

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

/**
 * Виводить назву проєкту згідно з активним пунктом меню.
 *
 * @param array $data
 * @return string
 */
function pageTitle(array $data): string
{
    foreach ($data as $project)
    {
        if (isset($_GET['project_id']) && $project['id'] === $_GET['project_id'])
        {
            return $project['title'];
        }
    }
    return 'Всі';
}

/**
 * Перевірка на наявність проєкту.
 *
 * @param array $data
 * @return bool
 */
function isProjectExists(array $data): bool
{
    foreach ($data as $project)
    {
        if (isset($_GET['project_id']) && $project['id'] === $_GET['project_id'])
        {
            return true;
        }
    }

    if (!isset($_GET['project_id']))
    {
        return true;
    }

    return false;
}