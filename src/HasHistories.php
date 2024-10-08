<?php

namespace Dkvhin\LaravelModelHistories;

interface HasHistories
{
    /**
     * @param string $description
     * @param mixed $user
     */
    public function addHistory(string $description, mixed $user = null, bool $forceInsert = false): void;

    /**
     * Get the value before the recent update
     * @return array<mixed>
     */
    public function getOldValues(): array;

    /**
     * Get the value after the recent update
     * @return array<mixed>
     */
    public function getNewValues(): array;


    /**
     * Set the value before the recent update
     * @return array<mixed>
     */
    public function setOldValues(mixed $values): void;

    /**
     * Set the value after the recent update
     * @return array<mixed>
     */
    public function setNewValues(mixed $values): void;

    /**
     * Get columns that are excluded from history
     * @return array<string>
     */
    public function getExcludedColumns(): array;
}
