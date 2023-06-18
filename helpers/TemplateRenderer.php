<?php

namespace helpers;

class TemplateRenderer
{
    /**
     * Підключає шаблон, передає туди дані і повертає підсумковий HTML контент
     *
     * @param string $name Шлях до файлу шаблону відносно папки templates
     * @param array $data Асоціативний масив із даними для шаблону
     * @return string Підсумковий HTML
     */
    public static function execute(string $name, array $data = []): string
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


    /**
     * Рендерить помилку при непройденій валідації.
     * Приклад: TemplateRenderer::errorTemplate($error, 'title')
     *
     */
    public static function errorTemplate(string $error, string $nameId): string
    {
        return <<<HTML
        <span id="{$nameId}-error" class="error invalid-feedback">{$error}</span>
        HTML;
    }
}
