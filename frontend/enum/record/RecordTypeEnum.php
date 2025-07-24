<?php

namespace frontend\enum\record;

enum RecordTypeEnum: string
{
    case NOTE = 'note';
    case TARGET = 'target';
    case WALLPAPER = 'wallpaper';
    case WALLPAPER_PAINTABLE = 'wallpaper_paintable';
    case WALL_PANELS = 'wall_panel';

    /**
     * @return string
     */
    public function label(): string
    {
        return match($this) {
            self::NOTE => 'Заметка',
            self::TARGET => 'Цель',
            self::WALLPAPER => 'Обои',
            self::WALLPAPER_PAINTABLE => 'Обои под покраску',
            self::WALL_PANELS => 'Стеновые панели',
        };
    }

    /**
     * @return string[]
     */
    public static function labels(): array
    {
        return [
            self::NOTE->value => 'Заметка',
            self::TARGET->value => 'Цель',
            self::WALLPAPER->value => 'Обои',
            self::WALLPAPER_PAINTABLE->value => 'Обои под покраску',
            self::WALL_PANELS->value => 'Стеновые панели',
        ];
    }

    public function color(): string
    {
        return match($this) {
            self::NOTE => '#d6eaff',
            self::TARGET => '#ffe0e0',
            self::WALLPAPER => '#fff7d6',
            self::WALLPAPER_PAINTABLE => '#e6ffe6',
            self::WALL_PANELS => '#e0ffe0',
        };
    }

    public function icon(): string
    {
        return match($this) {
            self::NOTE => '📝',
            self::TARGET => '🎯',
            self::WALLPAPER => '🧻',
            self::WALLPAPER_PAINTABLE => '🎨',
            self::WALL_PANELS => '🪟',
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
