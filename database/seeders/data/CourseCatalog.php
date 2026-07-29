<?php

namespace Database\Seeders\Data;

final class CourseCatalog
{
    /**
     * @return array<int, array<string, mixed>>
     */
    public static function courses(): array
    {
        return [
            [
                'category' => 'Laravel',
                'title' => 'Laravel 13 с нуля',
                'short_description' => 'Практическое знакомство с Laravel: от установки до готового веб-приложения.',
                'description' => 'Курс знакомит с основными возможностями Laravel 13. Вы изучите структуру проекта, маршрутизацию, контроллеры, Blade, Eloquent ORM и основы авторизации.',
                'level' => 'beginner',
                'status' => 'published',
                'price' => 0,
                'sections' => [
                    [
                        'title' => 'Знакомство с Laravel',
                        'lessons' => [
                            [
                                'title' => 'Что такое Laravel',
                                'duration' => 540,
                                'type' => 'article',
                                'is_free' => true,
                            ],
                            [
                                'title' => 'Установка нового проекта',
                                'duration' => 720,
                                'type' => 'video',
                                'is_free' => true,
                            ],
                            [
                                'title' => 'Структура Laravel-приложения',
                                'duration' => 840,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                        ],
                    ],
                    [
                        'title' => 'Маршрутизация и контроллеры',
                        'lessons' => [
                            [
                                'title' => 'Основы маршрутизации',
                                'duration' => 780,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'Контроллеры и внедрение зависимостей',
                                'duration' => 900,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'Route Model Binding',
                                'duration' => 660,
                                'type' => 'article',
                                'is_free' => false,
                            ],
                        ],
                    ],
                    [
                        'title' => 'Blade и работа с данными',
                        'lessons' => [
                            [
                                'title' => 'Шаблоны и макеты Blade',
                                'duration' => 780,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'Модели и миграции',
                                'duration' => 960,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'Основы Eloquent ORM',
                                'duration' => 1080,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                        ],
                    ],
                ],
            ],

            [
                'category' => 'Laravel',
                'title' => 'Построение LMS на Laravel',
                'short_description' => 'Создание обучающей платформы с курсами, уроками, записями и прогрессом.',
                'description' => 'Практический курс по разработке LMS. Вы спроектируете структуру курсов, добавите роли пользователей, запись на обучение и отслеживание прогресса.',
                'level' => 'intermediate',
                'status' => 'published',
                'price' => 1990,
                'sections' => [
                    [
                        'title' => 'Проектирование LMS',
                        'lessons' => [
                            [
                                'title' => 'Требования к обучающей платформе',
                                'duration' => 600,
                                'type' => 'article',
                                'is_free' => true,
                            ],
                            [
                                'title' => 'Проектирование базы данных',
                                'duration' => 960,
                                'type' => 'video',
                                'is_free' => true,
                            ],
                            [
                                'title' => 'Роли и права пользователей',
                                'duration' => 840,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                        ],
                    ],
                    [
                        'title' => 'Курсы и учебные материалы',
                        'lessons' => [
                            [
                                'title' => 'Управление курсами',
                                'duration' => 1080,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'Конструктор разделов и уроков',
                                'duration' => 1200,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'Публикация учебного контента',
                                'duration' => 720,
                                'type' => 'article',
                                'is_free' => false,
                            ],
                        ],
                    ],
                    [
                        'title' => 'Обучение и прогресс',
                        'lessons' => [
                            [
                                'title' => 'Запись студента на курс',
                                'duration' => 900,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'Отслеживание завершённых уроков',
                                'duration' => 1020,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'Завершение курса',
                                'duration' => 840,
                                'type' => 'assignment',
                                'is_free' => false,
                            ],
                        ],
                    ],
                ],
            ],

            [
                'category' => 'Laravel',
                'title' => 'REST API на Laravel',
                'short_description' => 'Разработка безопасного REST API с ресурсами, валидацией и авторизацией.',
                'description' => 'Вы создадите REST API на Laravel, научитесь проектировать endpoints, использовать API Resources, токены доступа и автоматические тесты.',
                'level' => 'intermediate',
                'status' => 'published',
                'price' => 1490,
                'sections' => [
                    [
                        'title' => 'Проектирование API',
                        'lessons' => [
                            [
                                'title' => 'Принципы REST',
                                'duration' => 600,
                                'type' => 'article',
                                'is_free' => true,
                            ],
                            [
                                'title' => 'Маршруты API',
                                'duration' => 720,
                                'type' => 'video',
                                'is_free' => true,
                            ],
                            [
                                'title' => 'HTTP-коды ответов',
                                'duration' => 540,
                                'type' => 'quiz',
                                'is_free' => false,
                            ],
                        ],
                    ],
                    [
                        'title' => 'Ресурсы и валидация',
                        'lessons' => [
                            [
                                'title' => 'API Resources',
                                'duration' => 840,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'Form Request Validation',
                                'duration' => 900,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'Обработка ошибок',
                                'duration' => 720,
                                'type' => 'article',
                                'is_free' => false,
                            ],
                        ],
                    ],
                    [
                        'title' => 'Безопасность и тестирование',
                        'lessons' => [
                            [
                                'title' => 'Аутентификация API',
                                'duration' => 960,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'Политики доступа',
                                'duration' => 780,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'Feature-тесты API',
                                'duration' => 1080,
                                'type' => 'assignment',
                                'is_free' => false,
                            ],
                        ],
                    ],
                ],
            ],

            [
                'category' => 'PHP',
                'title' => 'PHP для начинающих',
                'short_description' => 'Основы PHP: синтаксис, функции, массивы и объектно-ориентированное программирование.',
                'description' => 'Курс подходит начинающим разработчикам. Вы освоите синтаксис PHP, работу с данными, функции, классы, исключения и Composer.',
                'level' => 'beginner',
                'status' => 'published',
                'price' => 0,
                'sections' => [
                    [
                        'title' => 'Основы языка PHP',
                        'lessons' => [
                            [
                                'title' => 'Установка PHP',
                                'duration' => 480,
                                'type' => 'article',
                                'is_free' => true,
                            ],
                            [
                                'title' => 'Переменные и типы данных',
                                'duration' => 720,
                                'type' => 'video',
                                'is_free' => true,
                            ],
                            [
                                'title' => 'Условия и циклы',
                                'duration' => 840,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                        ],
                    ],
                    [
                        'title' => 'Функции и массивы',
                        'lessons' => [
                            [
                                'title' => 'Создание функций',
                                'duration' => 660,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'Индексированные массивы',
                                'duration' => 720,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'Ассоциативные массивы',
                                'duration' => 780,
                                'type' => 'assignment',
                                'is_free' => false,
                            ],
                        ],
                    ],
                    [
                        'title' => 'Введение в ООП',
                        'lessons' => [
                            [
                                'title' => 'Классы и объекты',
                                'duration' => 900,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'Наследование и интерфейсы',
                                'duration' => 960,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'Автозагрузка и Composer',
                                'duration' => 840,
                                'type' => 'article',
                                'is_free' => false,
                            ],
                        ],
                    ],
                ],
            ],

            [
                'category' => 'PHP',
                'title' => 'Современный ООП на PHP',
                'short_description' => 'Классы, интерфейсы, композиция, исключения и современный дизайн PHP-кода.',
                'description' => 'Углублённый курс по объектно-ориентированному программированию и проектированию поддерживаемого PHP-кода.',
                'level' => 'intermediate',
                'status' => 'published',
                'price' => 1290,
                'sections' => [
                    [
                        'title' => 'Объектная модель PHP',
                        'lessons' => [
                            [
                                'title' => 'Инкапсуляция',
                                'duration' => 660,
                                'type' => 'article',
                                'is_free' => true,
                            ],
                            [
                                'title' => 'Наследование',
                                'duration' => 780,
                                'type' => 'video',
                                'is_free' => true,
                            ],
                            [
                                'title' => 'Полиморфизм',
                                'duration' => 840,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                        ],
                    ],
                    [
                        'title' => 'Интерфейсы и композиция',
                        'lessons' => [
                            [
                                'title' => 'Проектирование интерфейсов',
                                'duration' => 900,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'Композиция вместо наследования',
                                'duration' => 960,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'Dependency Injection',
                                'duration' => 1020,
                                'type' => 'article',
                                'is_free' => false,
                            ],
                        ],
                    ],
                    [
                        'title' => 'Надёжный PHP-код',
                        'lessons' => [
                            [
                                'title' => 'Исключения',
                                'duration' => 720,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'Неизменяемые объекты',
                                'duration' => 780,
                                'type' => 'article',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'Практический рефакторинг',
                                'duration' => 1200,
                                'type' => 'assignment',
                                'is_free' => false,
                            ],
                        ],
                    ],
                ],
            ],

            [
                'category' => 'Livewire',
                'title' => 'Livewire 3 от А до Я',
                'short_description' => 'Интерактивные Laravel-интерфейсы без создания отдельного SPA.',
                'description' => 'Курс охватывает компоненты Livewire, свойства, действия, формы, события, загрузку файлов и тестирование.',
                'level' => 'intermediate',
                'status' => 'published',
                'price' => 1490,
                'sections' => [
                    [
                        'title' => 'Основы Livewire',
                        'lessons' => [
                            [
                                'title' => 'Первый Livewire-компонент',
                                'duration' => 720,
                                'type' => 'video',
                                'is_free' => true,
                            ],
                            [
                                'title' => 'Публичные свойства',
                                'duration' => 660,
                                'type' => 'video',
                                'is_free' => true,
                            ],
                            [
                                'title' => 'Действия компонента',
                                'duration' => 780,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                        ],
                    ],
                    [
                        'title' => 'Формы и валидация',
                        'lessons' => [
                            [
                                'title' => 'Привязка полей формы',
                                'duration' => 840,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'Livewire Form Objects',
                                'duration' => 960,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'Отображение ошибок',
                                'duration' => 600,
                                'type' => 'article',
                                'is_free' => false,
                            ],
                        ],
                    ],
                    [
                        'title' => 'Продвинутые возможности',
                        'lessons' => [
                            [
                                'title' => 'События компонентов',
                                'duration' => 780,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'Навигация без перезагрузки',
                                'duration' => 720,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'Тестирование Livewire',
                                'duration' => 1080,
                                'type' => 'assignment',
                                'is_free' => false,
                            ],
                        ],
                    ],
                ],
            ],

            [
                'category' => 'JavaScript',
                'title' => 'Современный JavaScript',
                'short_description' => 'Практическое изучение современного JavaScript и работы с браузером.',
                'description' => 'Курс охватывает переменные, функции, массивы, объекты, DOM, события, асинхронность и работу с API.',
                'level' => 'beginner',
                'status' => 'published',
                'price' => 990,
                'sections' => [
                    [
                        'title' => 'Основы JavaScript',
                        'lessons' => [
                            [
                                'title' => 'Переменные и типы',
                                'duration' => 660,
                                'type' => 'video',
                                'is_free' => true,
                            ],
                            [
                                'title' => 'Функции',
                                'duration' => 720,
                                'type' => 'video',
                                'is_free' => true,
                            ],
                            [
                                'title' => 'Массивы и объекты',
                                'duration' => 900,
                                'type' => 'assignment',
                                'is_free' => false,
                            ],
                        ],
                    ],
                    [
                        'title' => 'Работа с браузером',
                        'lessons' => [
                            [
                                'title' => 'Поиск элементов DOM',
                                'duration' => 720,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'События',
                                'duration' => 780,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'Создание интерактивной формы',
                                'duration' => 960,
                                'type' => 'assignment',
                                'is_free' => false,
                            ],
                        ],
                    ],
                    [
                        'title' => 'Асинхронный JavaScript',
                        'lessons' => [
                            [
                                'title' => 'Promise',
                                'duration' => 780,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'Async и Await',
                                'duration' => 840,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'Получение данных через Fetch API',
                                'duration' => 960,
                                'type' => 'assignment',
                                'is_free' => false,
                            ],
                        ],
                    ],
                ],
            ],

            [
                'category' => 'TypeScript',
                'title' => 'TypeScript с нуля',
                'short_description' => 'Типизация JavaScript-приложений и создание надёжного клиентского кода.',
                'description' => 'Вы освоите базовые типы, интерфейсы, generics, классы и настройку TypeScript-проекта.',
                'level' => 'beginner',
                'status' => 'published',
                'price' => 990,
                'sections' => [
                    [
                        'title' => 'Основы типизации',
                        'lessons' => [
                            [
                                'title' => 'Зачем нужен TypeScript',
                                'duration' => 480,
                                'type' => 'article',
                                'is_free' => true,
                            ],
                            [
                                'title' => 'Базовые типы',
                                'duration' => 720,
                                'type' => 'video',
                                'is_free' => true,
                            ],
                            [
                                'title' => 'Union и Literal Types',
                                'duration' => 780,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                        ],
                    ],
                    [
                        'title' => 'Интерфейсы и классы',
                        'lessons' => [
                            [
                                'title' => 'Интерфейсы',
                                'duration' => 780,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'Типизация классов',
                                'duration' => 840,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'Модификаторы доступа',
                                'duration' => 660,
                                'type' => 'article',
                                'is_free' => false,
                            ],
                        ],
                    ],
                    [
                        'title' => 'Generics и практика',
                        'lessons' => [
                            [
                                'title' => 'Введение в Generics',
                                'duration' => 900,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'Generic Constraints',
                                'duration' => 780,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'Типизация API-клиента',
                                'duration' => 1080,
                                'type' => 'assignment',
                                'is_free' => false,
                            ],
                        ],
                    ],
                ],
            ],

            [
                'category' => 'Vue.js',
                'title' => 'Vue.js 3 для начинающих',
                'short_description' => 'Создание интерактивных интерфейсов на Vue 3 и Composition API.',
                'description' => 'Вы познакомитесь с компонентами Vue, реактивностью, событиями, формами и маршрутизацией.',
                'level' => 'beginner',
                'status' => 'published',
                'price' => 1190,
                'sections' => [
                    [
                        'title' => 'Первые компоненты',
                        'lessons' => [
                            [
                                'title' => 'Создание Vue-приложения',
                                'duration' => 600,
                                'type' => 'video',
                                'is_free' => true,
                            ],
                            [
                                'title' => 'Шаблоны и директивы',
                                'duration' => 780,
                                'type' => 'video',
                                'is_free' => true,
                            ],
                            [
                                'title' => 'Свойства компонентов',
                                'duration' => 840,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                        ],
                    ],
                    [
                        'title' => 'Реактивность',
                        'lessons' => [
                            [
                                'title' => 'Ref и Reactive',
                                'duration' => 840,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'Computed',
                                'duration' => 720,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'Watch и WatchEffect',
                                'duration' => 780,
                                'type' => 'article',
                                'is_free' => false,
                            ],
                        ],
                    ],
                    [
                        'title' => 'Формы и навигация',
                        'lessons' => [
                            [
                                'title' => 'Работа с формами',
                                'duration' => 900,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'Vue Router',
                                'duration' => 960,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'Итоговое приложение',
                                'duration' => 1200,
                                'type' => 'assignment',
                                'is_free' => false,
                            ],
                        ],
                    ],
                ],
            ],

            [
                'category' => 'Tailwind CSS',
                'title' => 'Tailwind CSS на практике',
                'short_description' => 'Создание адаптивных интерфейсов с помощью utility-классов Tailwind CSS.',
                'description' => 'Курс научит создавать современную вёрстку, адаптивные компоненты и полноценные страницы приложения.',
                'level' => 'beginner',
                'status' => 'published',
                'price' => 790,
                'sections' => [
                    [
                        'title' => 'Основы Tailwind CSS',
                        'lessons' => [
                            [
                                'title' => 'Подключение Tailwind CSS',
                                'duration' => 540,
                                'type' => 'article',
                                'is_free' => true,
                            ],
                            [
                                'title' => 'Размеры, отступы и цвета',
                                'duration' => 720,
                                'type' => 'video',
                                'is_free' => true,
                            ],
                            [
                                'title' => 'Flexbox и Grid',
                                'duration' => 900,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                        ],
                    ],
                    [
                        'title' => 'Адаптивный интерфейс',
                        'lessons' => [
                            [
                                'title' => 'Контрольные точки',
                                'duration' => 660,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'Адаптивная навигация',
                                'duration' => 840,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'Карточки каталога',
                                'duration' => 900,
                                'type' => 'assignment',
                                'is_free' => false,
                            ],
                        ],
                    ],
                    [
                        'title' => 'Компоненты приложения',
                        'lessons' => [
                            [
                                'title' => 'Формы',
                                'duration' => 780,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'Таблицы и состояния',
                                'duration' => 840,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'Страница Dashboard',
                                'duration' => 1080,
                                'type' => 'assignment',
                                'is_free' => false,
                            ],
                        ],
                    ],
                ],
            ],

            [
                'category' => 'MySQL',
                'title' => 'MySQL для разработчиков',
                'short_description' => 'Проектирование таблиц, SQL-запросы, индексы и оптимизация базы данных.',
                'description' => 'Курс посвящён практической работе с MySQL: от базовых запросов до индексов, транзакций и анализа производительности.',
                'level' => 'beginner',
                'status' => 'published',
                'price' => 990,
                'sections' => [
                    [
                        'title' => 'Основы SQL',
                        'lessons' => [
                            [
                                'title' => 'Создание базы данных',
                                'duration' => 540,
                                'type' => 'article',
                                'is_free' => true,
                            ],
                            [
                                'title' => 'SELECT и фильтрация',
                                'duration' => 720,
                                'type' => 'video',
                                'is_free' => true,
                            ],
                            [
                                'title' => 'INSERT, UPDATE и DELETE',
                                'duration' => 780,
                                'type' => 'assignment',
                                'is_free' => false,
                            ],
                        ],
                    ],
                    [
                        'title' => 'Связи и объединения',
                        'lessons' => [
                            [
                                'title' => 'Внешние ключи',
                                'duration' => 660,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'INNER JOIN',
                                'duration' => 840,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'LEFT JOIN',
                                'duration' => 780,
                                'type' => 'assignment',
                                'is_free' => false,
                            ],
                        ],
                    ],
                    [
                        'title' => 'Производительность',
                        'lessons' => [
                            [
                                'title' => 'Индексы',
                                'duration' => 900,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'EXPLAIN',
                                'duration' => 840,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'Транзакции',
                                'duration' => 960,
                                'type' => 'article',
                                'is_free' => false,
                            ],
                        ],
                    ],
                ],
            ],

            [
                'category' => 'Docker',
                'title' => 'Docker для Laravel',
                'short_description' => 'Контейнеризация Laravel-приложений с Docker Compose и Laravel Sail.',
                'description' => 'Вы научитесь собирать локальное окружение Laravel, работать с контейнерами и подготавливать приложение к развёртыванию.',
                'level' => 'intermediate',
                'status' => 'published',
                'price' => 1490,
                'sections' => [
                    [
                        'title' => 'Основы Docker',
                        'lessons' => [
                            [
                                'title' => 'Контейнеры и образы',
                                'duration' => 600,
                                'type' => 'article',
                                'is_free' => true,
                            ],
                            [
                                'title' => 'Основные команды Docker',
                                'duration' => 780,
                                'type' => 'video',
                                'is_free' => true,
                            ],
                            [
                                'title' => 'Создание Dockerfile',
                                'duration' => 900,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                        ],
                    ],
                    [
                        'title' => 'Docker Compose',
                        'lessons' => [
                            [
                                'title' => 'Файл compose.yaml',
                                'duration' => 840,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'Сеть контейнеров',
                                'duration' => 720,
                                'type' => 'article',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'Volumes и сохранение данных',
                                'duration' => 840,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                        ],
                    ],
                    [
                        'title' => 'Laravel в контейнерах',
                        'lessons' => [
                            [
                                'title' => 'Laravel Sail',
                                'duration' => 780,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'Очереди и планировщик',
                                'duration' => 900,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'Подготовка production-сборки',
                                'duration' => 1200,
                                'type' => 'assignment',
                                'is_free' => false,
                            ],
                        ],
                    ],
                ],
            ],

            [
                'category' => 'Git',
                'title' => 'Git и GitHub',
                'short_description' => 'Контроль версий, ветки, Pull Request и командная разработка.',
                'description' => 'Курс знакомит с ежедневной работой в Git и GitHub: коммиты, ветки, слияние и совместная разработка.',
                'level' => 'beginner',
                'status' => 'published',
                'price' => 0,
                'sections' => [
                    [
                        'title' => 'Начало работы с Git',
                        'lessons' => [
                            [
                                'title' => 'Установка Git',
                                'duration' => 420,
                                'type' => 'article',
                                'is_free' => true,
                            ],
                            [
                                'title' => 'Создание репозитория',
                                'duration' => 600,
                                'type' => 'video',
                                'is_free' => true,
                            ],
                            [
                                'title' => 'Первый commit',
                                'duration' => 660,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                        ],
                    ],
                    [
                        'title' => 'Ветки и слияние',
                        'lessons' => [
                            [
                                'title' => 'Создание веток',
                                'duration' => 720,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'Merge и конфликты',
                                'duration' => 900,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'Rebase',
                                'duration' => 840,
                                'type' => 'article',
                                'is_free' => false,
                            ],
                        ],
                    ],
                    [
                        'title' => 'Работа с GitHub',
                        'lessons' => [
                            [
                                'title' => 'Удалённые репозитории',
                                'duration' => 660,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'Pull Request',
                                'duration' => 780,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'Командный GitHub Flow',
                                'duration' => 960,
                                'type' => 'assignment',
                                'is_free' => false,
                            ],
                        ],
                    ],
                ],
            ],

            [
                'category' => 'DevOps',
                'title' => 'Основы DevOps',
                'short_description' => 'CI/CD, автоматизация, окружения и эксплуатация веб-приложений.',
                'description' => 'Обзорный практический курс по процессам DevOps и автоматизации доставки приложений.',
                'level' => 'intermediate',
                'status' => 'published',
                'price' => 1690,
                'sections' => [
                    [
                        'title' => 'Культура DevOps',
                        'lessons' => [
                            [
                                'title' => 'Что такое DevOps',
                                'duration' => 540,
                                'type' => 'article',
                                'is_free' => true,
                            ],
                            [
                                'title' => 'Жизненный цикл приложения',
                                'duration' => 660,
                                'type' => 'video',
                                'is_free' => true,
                            ],
                            [
                                'title' => 'Окружения разработки',
                                'duration' => 720,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                        ],
                    ],
                    [
                        'title' => 'Непрерывная интеграция',
                        'lessons' => [
                            [
                                'title' => 'Основы CI',
                                'duration' => 780,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'Автоматический запуск тестов',
                                'duration' => 900,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'Проверка качества кода',
                                'duration' => 840,
                                'type' => 'assignment',
                                'is_free' => false,
                            ],
                        ],
                    ],
                    [
                        'title' => 'Доставка приложения',
                        'lessons' => [
                            [
                                'title' => 'Основы CD',
                                'duration' => 720,
                                'type' => 'article',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'Переменные окружения и секреты',
                                'duration' => 840,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'Стратегия развёртывания',
                                'duration' => 960,
                                'type' => 'assignment',
                                'is_free' => false,
                            ],
                        ],
                    ],
                ],
            ],

            [
                'category' => 'Архитектура ПО',
                'title' => 'SOLID и Clean Architecture',
                'short_description' => 'Принципы проектирования поддерживаемых PHP-приложений.',
                'description' => 'Курс помогает перейти от работающего кода к понятной и масштабируемой архитектуре.',
                'level' => 'advanced',
                'status' => 'published',
                'price' => 1990,
                'sections' => [
                    [
                        'title' => 'Принципы SOLID',
                        'lessons' => [
                            [
                                'title' => 'Single Responsibility Principle',
                                'duration' => 720,
                                'type' => 'article',
                                'is_free' => true,
                            ],
                            [
                                'title' => 'Open Closed Principle',
                                'duration' => 780,
                                'type' => 'video',
                                'is_free' => true,
                            ],
                            [
                                'title' => 'Dependency Inversion Principle',
                                'duration' => 900,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                        ],
                    ],
                    [
                        'title' => 'Слои приложения',
                        'lessons' => [
                            [
                                'title' => 'Разделение ответственности',
                                'duration' => 840,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'Сервисы и варианты использования',
                                'duration' => 960,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'DTO и границы слоёв',
                                'duration' => 900,
                                'type' => 'article',
                                'is_free' => false,
                            ],
                        ],
                    ],
                    [
                        'title' => 'Практический рефакторинг',
                        'lessons' => [
                            [
                                'title' => 'Поиск архитектурных проблем',
                                'duration' => 780,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'Выделение доменной логики',
                                'duration' => 1020,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'Рефакторинг учебного проекта',
                                'duration' => 1500,
                                'type' => 'assignment',
                                'is_free' => false,
                            ],
                        ],
                    ],
                ],
            ],

            [
                'category' => 'Тестирование',
                'title' => 'Тестирование Laravel',
                'short_description' => 'Unit-, Feature- и Livewire-тесты для надёжных Laravel-приложений.',
                'description' => 'Курс учит проверять бизнес-логику, HTTP-интерфейсы, базу данных и Livewire-компоненты.',
                'level' => 'intermediate',
                'status' => 'published',
                'price' => 1490,
                'sections' => [
                    [
                        'title' => 'Основы автоматического тестирования',
                        'lessons' => [
                            [
                                'title' => 'Зачем нужны тесты',
                                'duration' => 480,
                                'type' => 'article',
                                'is_free' => true,
                            ],
                            [
                                'title' => 'Настройка тестовой базы',
                                'duration' => 720,
                                'type' => 'video',
                                'is_free' => true,
                            ],
                            [
                                'title' => 'Структура теста',
                                'duration' => 660,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                        ],
                    ],
                    [
                        'title' => 'Feature-тесты',
                        'lessons' => [
                            [
                                'title' => 'Тестирование маршрутов',
                                'duration' => 780,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'Проверка базы данных',
                                'duration' => 840,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'Фабрики и состояния моделей',
                                'duration' => 900,
                                'type' => 'assignment',
                                'is_free' => false,
                            ],
                        ],
                    ],
                    [
                        'title' => 'Тестирование Livewire',
                        'lessons' => [
                            [
                                'title' => 'Первый тест компонента',
                                'duration' => 720,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'Вызов действий',
                                'duration' => 780,
                                'type' => 'video',
                                'is_free' => false,
                            ],
                            [
                                'title' => 'Проверка валидации',
                                'duration' => 960,
                                'type' => 'assignment',
                                'is_free' => false,
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }
}