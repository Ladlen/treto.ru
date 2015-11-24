<?php

/**
 * Class AjaxHelper
 *
 * Функции для работы с ajax.
 * Для унификации желательно все операции с ajax проводить через этот класс.
 */
class AjaxHelper
{
    /**
     * Является ли текущий запрос ajax запросом.
     */
    public static function whetherAjaxQuery()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH'])
        && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }

    /**
     * Отправить сообщение(я) об ошибках.
     *
     * @param mixed $messages сообщения (массив) или сообщение (строка) об ошибке
     */
    public static function sendErrorMessages($messages)
    {
        die(json_encode(['success' => false, 'messages' => (array)$messages]));
    }

    /**
     * Отправить результат клиенту (предполагает успех операции).
     *
     * @param array $result результат, который необходимо отправить
     */
    public static function sendResult($result)
    {
        die(json_encode(['success' => true, 'result' => $result]));
    }

}