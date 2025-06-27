<?php
namespace common\behaviors;

use DateTime;
use yii\base\Behavior;
use yii\base\Model;

class DateFormatBehavior extends Behavior
{
    /**
     * @var array
     */
    public array $attributes = [];

    /**
     * @var string
     */
    public string $inputFormat = 'd-m-Y';

    /**
     * @var string
     */
    public string $outputFormat = 'Y-m-d';

    /**
     * @return string[]
     */
    public function events(): array
    {
        return [
            Model::EVENT_BEFORE_VALIDATE => 'formatDates',
        ];
    }

    /**
     * @return void
     */
    public function formatDates(): void
    {
        foreach ($this->attributes as $attribute) {
            if (is_string($this->owner->$attribute)) {
                $date = DateTime::createFromFormat($this->inputFormat, $this->owner->$attribute);
                if ($date) {
                    $this->owner->$attribute = $date->format($this->outputFormat);
                } else {
                    $this->owner->$attribute = null;
                }
            }
        }
    }
}
