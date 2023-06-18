<?php
namespace helpers;

use Carbon\Carbon;

class ProjectHandler
{
    /**
     * Виводить назву проєкту згідно з активним пунктом меню.
     *
     * @param array $data
     * @param string $key
     * @return string
     */
    public static function showTitle(array $data, string $key): string
    {
        $intGetProjectId = GlobalArrayHandler::getStringToInt('project_id');

        foreach ($data as $project) {
            if (isset($_GET[$key]) && $project['id'] === $intGetProjectId) {
                return $project['title'];
            }
        }
        return 'Всі';
    }


    /**
     * Перевірка на наявність проєкту.
     *
     * @param array $data
     * @param string $key
     * @return bool
     */
    public static function isExists(array $data, string $key): bool
    {
        foreach ($data as $project) {
            if (isset($_GET[$key]) && $project['id'] === (int) $_GET[$key]) {
                return true;
            }
        }

        if (!isset($_GET[$key])) {
            return true;
        }

        return false;
    }
}
