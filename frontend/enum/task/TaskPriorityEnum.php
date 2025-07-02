<?php

namespace frontend\enum\task;

enum TaskPriorityEnum: string
{
    case LOW = 'low';
    case MEDIUM = 'medium';
    case HIGH = 'high';

    public function label(): string
    {
        return match($this) {
            self::LOW => 'Низкий',
            self::MEDIUM => 'Средний',
            self::HIGH => 'Высокий',
        };
    }

    public static function labels(): array
    {
        return [
            self::LOW->value => 'Низкий',
            self::MEDIUM->value => 'Средний',
            self::HIGH->value => 'Высокий',
        ];
    }

    public static function fromValue(string $value): ?self
    {
        foreach (self::cases() as $case) {
            if ($case->value === $value) {
                return $case;
            }
        }
        return null;
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::LOW => 'bg-success',   // Зеленый
            self::MEDIUM => 'bg-warning', // Желтый
            self::HIGH => 'bg-danger',   // Красный
        };
    }

}
