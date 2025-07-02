<?php

namespace frontend\enum\task;

enum TaskStatusEnum: string
{
    case NEW = 'new';
    case IN_PROGRESS = 'in_progress';
    case DONE = 'done';
    case CANCELED = 'canceled';

    public function label(): string
    {
        return match($this) {
            self::NEW => 'Новая',
            self::IN_PROGRESS => 'В работе',
            self::DONE => 'Выполнена',
            self::CANCELED => 'Отменена',
        };
    }

    public static function labels(): array
    {
        return [
            self::NEW->value => 'Новая',
            self::IN_PROGRESS->value => 'В работе',
            self::DONE->value => 'Выполнена',
            self::CANCELED->value => 'Отменена',
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
}
