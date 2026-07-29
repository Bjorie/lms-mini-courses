# LMS Мини-курсы

Дипломный проект, представляющий собой систему дистанционного обучения (LMS) для создания и прохождения мини-курсов.

## Технологии

- PHP 8.3
- Laravel 13
- Laravel Breeze
- Livewire 3
- Volt
- Blade
- Tailwind CSS
- Alpine.js
- MySQL
- Laravel Sail
- Docker
- Spatie Laravel Permission
- Vite
- PHPUnit

Для реализации ролей и прав доступа используется пакет **Spatie Laravel Permission**.

## Запуск проекта

```bash
cp .env.example .env
./vendor/bin/sail up -d
./vendor/bin/sail composer install
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate --seed
./vendor/bin/sail npm install
./vendor/bin/sail npm run build
```

После запуска приложение будет доступно по адресу:

```
http://localhost
```

## Тестирование

```bash
./vendor/bin/sail artisan test
```