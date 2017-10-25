<?php

return [
    'description' => 'Разработка и техническая поддержка сайта - bavix',
    'http'        => [
        '400' => 'Плохой запрос',
        '404' => 'Страница не найдена',
        '503' => [
            'title'       => 'Мы скоро вернемся!',
            'description' => 'Идет обновление...',
        ]
    ],
    'page' => [
        'empty' => 'В разделе ":Name" ничего не найдено!',
    ],
    'controllers' => [
        'posts' => 'Посты'
    ]
];
