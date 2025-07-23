<?php

namespace frontend\enum\record;

enum RecordTypeEnum: string
{
    case NOTE = 'note';
    case TARGET = 'target';

    /**
     * @return string
     */
    public function label(): string
    {
        return match($this) {
            self::NOTE => 'Заметка',
            self::TARGET => 'Цель'
        };
    }

    /**
     * @return string[]
     */
    public static function labels(): array
    {
        return [
            self::NOTE->value => 'Заметка',
            self::TARGET->value => 'Цель'
        ];
    }

    public function color(): string
    {
        return match($this) {
            self::NOTE => '#d6eaff',
            self::TARGET => '#ffe0e0',
        };
    }

    public function icon(): string
    {
        return match($this) {
            self::NOTE => '📝',
            self::TARGET => '🎯',
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
