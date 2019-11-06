<?php


namespace ApiV3;


class Mapping
{
    const MAP = [
        'user' => array(
            'class' => 'User',
            'module' => 'main',
            'ormNamespace' => 'Bitrix\Main\UserTable', // таблица ORM
            'custom' => true,
        ),
    ];
}