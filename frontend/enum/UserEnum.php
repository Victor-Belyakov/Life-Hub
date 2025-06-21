<?php

namespace frontend\enum;

enum UserEnum: int
{
    case STATUS_DELETED = 0;
    case STATUS_INACTIVE = 9;
    case STATUS_ACTIVE = 10;

    public function label(): string
    {
        return match($this) {
            self::STATUS_DELETED => 'Удалён',
            self::STATUS_INACTIVE => 'Не активен',
            self::STATUS_ACTIVE => 'Активен',
        };
    }

    public static function labels(): array
    {
        return [
            self::STATUS_DELETED->value => 'Удалён',
            self::STATUS_INACTIVE->value => 'Не активен',
            self::STATUS_ACTIVE->value => 'Активен',
        ];
    }

    public static function fromValue(int $value): ?self
    {
        foreach (self::cases() as $case) {
            if ($case->value === $value) {
                return $case;
            }
        }
        return null;
    }
}
