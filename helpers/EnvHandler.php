<?php
namespace helpers;

class EnvHandler
{
    /**
     * Переводить env файл у масив.
     *
     * @return array
     */
    public static function parseFile(): array
    {
        $env = realpath("."). "\\.env";

        $fileContent = file_get_contents($env);
        $lines = explode(PHP_EOL, $fileContent);

        $data = [];
        foreach ($lines as $line) {
            $line = trim($line);
            if (!empty($line) && str_contains($line, '=')) {
                [$key, $value] = explode('=', $line, 2);
                $data[$key] = $value;
            }
        }

        return $data;
    }

    /**
     * Допомагає взяти значення з env файлу.
     * Приклад: EnvHandler::getConfig('SQL_DB_DATABASE')
     * @param string $key
     * @return string|null
     */
    public static function getConfig(string $key): string|null
    {
        $envs = self::parseFile();

        foreach ($envs as $const => $value) {
            if ($const === $key) {
                return $value;
            }
        }

        return null;
    }
}
