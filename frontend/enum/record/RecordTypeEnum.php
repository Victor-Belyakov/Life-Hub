<?php

namespace frontend\enum\record;

use Yii;

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
            self::TARGET => '#ffe0e0'
        };
    }

    public function icon(): string
    {
        return match($this) {
            self::NOTE => file_get_contents(Yii::getAlias('@webroot') . '/icons/record/feather.svg'),
            self::TARGET => file_get_contents(Yii::getAlias('@webroot') . '/icons/record/crosshair2.svg'),
            default => '',
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
