<?php

namespace frontend\enum\task;

enum TaskPriorityEnum: string
{
    case LOW = 'low';
    case MEDIUM = 'medium';
    case HIGH = 'high';

    /**
     * @return string
     */
    public function label(): string
    {
        return match($this) {
            self::LOW => 'Низкий',
            self::MEDIUM => 'Средний',
            self::HIGH => 'Высокий',
        };
    }

    /**
     * @return string[]
     */
    public static function labels(): array
    {
        return [
            self::LOW->value => 'Низкий',
            self::MEDIUM->value => 'Средний',
            self::HIGH->value => 'Высокий',
        ];
    }

    /**
     * @param string $value
     * @return self|null
     */
    public static function fromValue(string $value): ?self
    {
        foreach (self::cases() as $case) {
            if ($case->value === $value) {
                return $case;
            }
        }
        return null;
    }

    /**
     * @return string
     */
    public function badgeClass(): string
    {
        return match ($this) {
            self::LOW => 'bg-success',
            self::MEDIUM => 'bg-warning',
            self::HIGH => 'bg-danger',
        };
    }

}
