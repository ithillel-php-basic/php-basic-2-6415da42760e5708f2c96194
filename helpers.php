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
 * @deprecated Після того як проєкт перевели на ООП
 */
function isDateValid(string $date) : bool
{
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
 * @throws ErrorException
 * @deprecated Після того як проєкт перевели на ООП
 */
function dbGetPrepareStmt(mysqli $link, string $sql, array $data = []): mysqli_stmt
{
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
            } elseif (is_string($value)) {
                $type = 's';
            } elseif (is_double($value)) {
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
 * @deprecated Після того як проєкт перевели на ООП
 */
function getNounPluralForm(int $number, string $one, string $two, string $many): string
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
 * @deprecated Після того як проєкт перевели на ООП
 */
function renderTemplate(string $name, array $data = []): string
{
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
