<?php

namespace Dkvhin\LaravelModelHistories;

use Dkvhin\LaravelModelHistories\Models\ModelHasHistory;
use Illuminate\Support\Facades\Log;

trait HasHistoriesTrait
{
    /**
     * @var array<mixed>
     */
    private array $__oldValues = [];

    /**
     * @var array<mixed>
     */
    private array $__newValues = [];

    /**
     * Set the value before the recent update
     * @return array<mixed>
     */
    public function setOldValues(mixed $values): void
    {
        $this->__oldValues = $values;
    }

    /**
     * Set the value after the recent update
     * @return array<mixed>
     */
    public function setNewValues(mixed $values): void
    {
        $this->__newValues = $values;
    }

    /**
     * Get the value before the recent update
     * @return array<mixed>
     */
    public function getOldValues(): array
    {
        return $this->__oldValues;
    }

    /**
     * Get the value after the recent update
     * @return array<mixed>
     */
    public function getNewValues(): array
    {
        return $this->__newValues;
    }

    /**
     * @param string $description
     * @param mixed $user
     * @param bool $forceInsert
     */
    public function addHistory(string $description, mixed $user = null, bool $forceInsert = false): void
    {
        $oldValues = json_encode($this->getOldValues());
        $newValues = json_encode($this->getNewValues());

        // no changes detected, by default we will not insert this history
        // however if forceInsert is true, we will proceed adding the history
        if ($oldValues == $newValues && !$forceInsert) {
            return;
        }

        $history = new ModelHasHistory([
            'description'           => $description,
            'old_values'            => $oldValues,
            'new_values'            => $newValues,
            'is_force_insert'       => $forceInsert
        ]);

        if ($user != null) {
            $history->user()->associate($user);
        }

        $this->histories()->save($history);

        // Reset the changes tracking
        $this->setNewValues([]);
        $this->setOldValues([]);
    }

    public function histories()
    {
        return $this->morphMany(ModelHasHistory::class, 'model');
    }

    public static function bootHasHistoriesTrait()
    {
        /**
         * @param \Dkvhin\LaravelModelHistories\HasHistories $model
         */
        static::updating(function ($model) {
            $oldValues = [];
            $newValues = [];
            foreach ($model->getDirty() as $key => $value) {
                $original = $model->getOriginal($key);
                $oldValues[$key] = $original;
                $newValues[$key] = $value;
            }
            $model->setNewValues($oldValues);
            $model->setOldValues($newValues);
        });
    }
}
