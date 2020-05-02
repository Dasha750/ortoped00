<?php
/**
* Основные параметры WordPress.
*
* Этот файл содержит следующие параметры: настройки MySQL, префикс таблиц,
* секретные ключи, язык WordPress и ABSPATH. Дополнительную информацию можно найти
* на странице {@link http://codex.wordpress.org/Editing_wp-config.php Editing
* wp-config.php} Кодекса. Настройки MySQL можно узнать у хостинг-провайдера.
*
* Этот файл используется сценарием создания wp-config.php в процессе установки.
* Необязательно использовать веб-интерфейс, можно скопировать этот файл
* с именем "wp-config.php" и заполнить значения.
*
* @package WordPress
*/

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define('DB_NAME', 'ortope00_db');

/** Имя пользователя MySQL */
define('DB_USER', 'ortope00_db');

/** Пароль к базе данных MySQL */
define('DB_PASSWORD', 'ZHfdL8Cw');

/** Имя сервера MySQL */
define('DB_HOST', 'ortope00.mysql.ukraine.com.ua');

/** Кодировка базы данных для создания таблиц. */
define('DB_CHARSET', 'utf8');

/** Схема сопоставления. Не меняйте, если не уверены. */
define('DB_COLLATE', '');

/**#@+
* Уникальные ключи и соли для аутентификации.
*
* Смените значение каждой константы на уникальную фразу.
* Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
* Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется снова авторизоваться.
*
* @since 2.6.0
*/
define('AUTH_KEY',         'sU:&kERU@{_0mHqmDG#NRn16ea$(/%QuKhp *7#z)602a`O0or9e!-+(xPRwZC9p');
define('SECURE_AUTH_KEY',  'naSq]ZDLf))>$8edkdYOj-qz=0`}aEwZWOyosK9I]u*OW1?Urc0/v-hQ^r?DRl2R');
define('LOGGED_IN_KEY',    'i>!0*Xe):0IxQm#jVJ+Ch*33rAp !-dHw7CNW`%z%,l7{L~,,+ IU6?&#;J0$+Au');
define('NONCE_KEY',        'zo;J~z0v}8:-xME%hI`|^gtQrz~N4X-@9&sHg1e1/Zumd]F1fl,lAh9~m!f@+5fP');
define('AUTH_SALT',        '$#4y_5n?Y=6/cg~g}=5c0[_-P5J} #+0GaFAytR$$49K;O`:1Vwm3q]a[6 T00g?');
define('SECURE_AUTH_SALT', '@D}L2R4)n|{!n0JqeBQI8hDtR~h1o{C-ryGT`v)ZAn+Xaj|gX(^D+EIGGfmfC bV');
define('LOGGED_IN_SALT',   'CTfO}NwdbZ3~`FZMc+ACP^xyijIQ$ 7w&0@{x7/kq_KgCq;J3xO:VMws:./Xh1s*');
define('NONCE_SALT',       '|hdR)s-fVR[]A63S{f7zT/%Z,~?tAM-RN|86-xt+74+suz_Ob~*}_o.VjTj^!/yu');

/**#@-*/

/**
* Префикс таблиц в базе данных WordPress.
*
* Можно установить несколько блогов в одну базу данных, если вы будете использовать
* разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
*/
$table_prefix  = 'rtpd_';

/**
* Язык локализации WordPress, по умолчанию английский.
*
* Измените этот параметр, чтобы настроить локализацию. Соответствующий MO-файл
* для выбранного языка должен быть установлен в wp-content/languages. Например,
* чтобы включить поддержку русского языка, скопируйте ru_RU.mo в wp-content/languages
* и присвойте WPLANG значение 'ru_RU'.
*/
define('WPLANG', 'ru_RU');

/**
* Для разработчиков: Режим отладки WordPress.
*
* Измените это значение на true, чтобы включить отображение уведомлений при разработке.
* Настоятельно рекомендуется, чтобы разработчики плагинов и тем использовали WP_DEBUG
* в своём рабочем окружении.
*/
define('WP_DEBUG', false);

define('WP_AUTO_UPDATE_CORE', false);

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( !defined('ABSPATH') )
define('ABSPATH', dirname(__FILE__) . '/');

/** Инициализирует переменные WordPress и подключает файлы. */
require_once(ABSPATH . 'wp-settings.php');

