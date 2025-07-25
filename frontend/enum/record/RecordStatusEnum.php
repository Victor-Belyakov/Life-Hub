<?php

namespace frontend\enum\record;

enum RecordStatusEnum: string
{
    case ACTIVE = 'active';

    case INACTIVE = 'inactive';

    /**
     * @return string
     */
    public function label(): string
    {
        return match($this) {
            self::ACTIVE => 'Активна',
            self::INACTIVE => 'Не активна',
        };
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
}
