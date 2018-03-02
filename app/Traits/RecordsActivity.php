<?php

namespace App\Traits;

use App\Activity;

trait RecordsActivity
{
    /**
     * Boot the trait.
     */
    protected static function bootRecordsActivity()
    {
        if (auth()->guest()) return;

        foreach (static::getRecordsEvent() as $event) {
            static::$event(function ($model) use($event) {
                $model->recordActivity($event);
            });
        }

        static::deleting(function($model) {
            $model->activity()->delete();
        });
    }

    /**
     * Get all model events that required activity recording.
     *
     * @return array
     */
    protected static function getRecordsEvent()
    {
        return ['created'];
    }

    /**
     * Records new activity for the model.
     *
     * @param string $event
     * @return void
     */
    protected function recordActivity($event)
    {
        $this->activity()->create([
            'user_id' => auth()->id(),
            'type' => $this->getActivityType($event),
        ]);
    }
    /**
     * Fetch the activity relationship.
     *
     * @return Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    /**
     * Determing the activity type.
     *
     * @param string $event
     * @return string
     */
    protected function getActivityType($event)
    {
        $type = strtolower((new \ReflectionClass($this))->getShortName());

        return "{$event}_{$type}";
    }
}
