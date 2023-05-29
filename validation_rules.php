<?php
    /**
     * Перевіряє форму на присутність даних.
     * Приклад: is_nullable('title');
     *
     * @param string $field
     * @return string[]
     *
     */
    function is_nullable(string $field): array
    {
        $result = [
            'field'     => $field,
            'message'   => 'Це поле не має бути порожнім.',
        ];

        if (empty($_POST["$field"]))
        {
            $result['is_valid'] = false;
            return $result;
        }

        $result['is_valid'] = true;
        return $result;
    }

    /**
     * Перевіряє чи є значення валідною email адресою.
     * Приклад: is_email('email');
     *
     * @param string $field
     * @return string[]
     */
    function is_email(string $field): array
    {
        $result = [
            'field'     => $field,
            'message'   => 'Невірно заданий формат email.'
        ];

        if(!empty($_POST["$field"]) && filter_var($_POST["$field"], FILTER_VALIDATE_EMAIL))
        {
            $result['is_valid'] = true;
            return $result;
        }

        $result['is_valid'] = false;
        return $result;
    }

    /**
     * Перевіряє чи є вказаний email унікальним в БД.
     * Приклад: is_email_unique('email', $data);
     *
     * @param string $field
     * @param array $table
     * @return string[]
     */
    function is_email_unique(string $field, array $table): array
    {
        $result = [
            'field'     => $field,
            'message'   => 'Вказаний email вже використовується.'
        ];

        foreach ($table as $row)
        {
            if ($_POST["$field"] === $row["$field"])
            {
                $result['is_valid'] = false;
                return $result;
            }
        }

        $result['is_valid'] = true;
        return $result;
    }


    /**
     * Робить перевірку чи збігаються паролі у двух формах.
     * Приклад: password_confirmation('password', 'password_confirmation');
     *
     * @param string $field
     * @param string $confirm_field
     * @return string[]
     */
    function password_confirmation(string $field, string $confirm_field): array
    {
        $result = [
            'field' => $confirm_field,
            'message' => 'Поля для паролю не збігаються.'
        ];

        $hash = password_hash($_POST["$field"], PASSWORD_DEFAULT);

        if (password_verify($_POST["$confirm_field"], $hash))
        {
            $result['is_valid'] = true;
            return $result;
        }


        $result['is_valid'] = false;
        return $result;
    }


    /**
     * Перевіряє форму на наявність більшої за $count од. символів
     *
     * @param string $field
     * @param int $count
     * @return string[]
     */
    function string_max(string $field, int $count = 255): array
    {
        $result = [
            'field'     => $field,
            'message'   => 'Строка не повинна бути більше або дорівнювати '.$count.' сим.',
        ];

        if (strlen($_POST["$field"]) <= $count)
        {
            $result['is_valid'] = true;
            return $result;
        }

        $result['is_valid'] = false;
        return $result;
    }

