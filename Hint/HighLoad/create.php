<?php
/**
 * Добавим highload блок с заданными полями
 * обработка ошибок не реализована
 */

/**
 * Используем эту библиотеку
 * https://github.com/darkfriend/hlhelpers#GetValueFieldList as HlBlock
 */
use HlBlock;

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

/** @var HlBlock $instance */
$instance = HlBlock::getInstance();

// создание блока
$blockName = 'HRP1001';
$tableName = 'hrp1001';

$id = $instance->create($blockName, $tableName);

/**
 * условный массив полей
 */
$array = [
    'NAME', // имя
    'LASF_NAME', // фамилия
    'SECOND_NAME', // отчество
    'BIRTHDAY', // др
    // и т.д.
];

foreach ($array as $item) {

    $fields = [
        'FIELD_NAME' => 'UF_' . strtoupper($item), // можно добавить автозамену пробелов на _
        'USER_TYPE_ID' => 'string',
        'XML_ID' => 'UF_' . strtoupper($item),
        'SORT' => 500,
        'MULTIPLE' => 'N',
        'MANDATORY' => 'N',
        'SHOW_IN_LIST' => '',
        /**
         * описание поля, в данном случае стринг
         * если поля разные по сути, то массив с ними следует сделать более сложным и цикл разбирать иначе
         * описание какие данные указывать в $arFields тут https://dev.1c-bitrix.ru/learning/course/?COURSE_ID=43&LESSON_ID=3496
         */
        'SETTINGS' => array(
            /* Значение по умолчанию */
            'DEFAULT_VALUE' => '',
            /* Размер поля ввода для отображения */
            'SIZE' => '20',
            /* Количество строчек поля ввода */
            'ROWS' => '1',
            /* Минимальная длина строки (0 - не проверять) */
            'MIN_LENGTH' => '0',
            /* Максимальная длина строки (0 - не проверять) */
            'MAX_LENGTH' => '0',
            /* Регулярное выражение для проверки */
            'REGEXP' => '',
        ),
        /* Подпись в форме редактирования */
        'EDIT_FORM_LABEL' => array(
            'ru' => 'BEGDA',
            'en' => 'BEGDA',
        ),
        /* Заголовок в списке */
        'LIST_COLUMN_LABEL' => array(
            'ru' => strtoupper($item),
            'en' => strtoupper($item),
        ),
        /* Подпись фильтра в списке */
        'LIST_FILTER_LABEL' => array(
            'ru' => strtoupper($item),
            'en' => strtoupper($item),
        ),
        /* Сообщение об ошибке (не обязательное) */
        'ERROR_MESSAGE' => array(
            'ru' => strtoupper($item),
            'en' => strtoupper($item),
        ),
        /* Помощь */
        'HELP_MESSAGE' => array(
            'ru' => strtoupper($item),
            'en' => strtoupper($item),
        ),
    ];
    $instance->addField($id, $fields);
}
