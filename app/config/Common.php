<?php

/**
 * Данные конфигурации.
 */

$config = [
    // Файл с изображениями.
    'file' => [
        // Конец строки.
        'EOL' => "\r\n"
    ],
    // Логирование.
    'log' => [
        // Куда отправлять ошибку (см. ф-ю error_log()).
        'type' => 3,
        // Назначение (см. ф-ю error_log()).
        'destination' => APP_DIR . 'runtime/logs/app.log',
    ],
    // Отладочный режим.
    'debug' => true
];

return $config;