<?php

namespace App\Enums;

enum CourseStatus: string
{
    case Draft = 'draft';
    case Review = 'review';
    case Published = 'published';
    case Archived = 'archived';

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Черновик',
            self::Review => 'На проверке',
            self::Published => 'Опубликован',
            self::Archived => 'Архив',
        };
    }
    public function color(): string
    {
        return match ($this) {
            self::Draft => 'gray',
            self::Review => 'yellow',
            self::Published => 'green',
            self::Archived => 'red',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::Draft =>
                'bg-gray-100 text-gray-800',

            self::Review =>
                'bg-yellow-100 text-yellow-800',

            self::Published =>
                'bg-green-100 text-green-800',

            self::Archived =>
                'bg-red-100 text-red-800',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $case) => [
                $case->value => $case->label(),
            ])
            ->all();
    }
}