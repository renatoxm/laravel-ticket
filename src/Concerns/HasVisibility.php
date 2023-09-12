<?php

namespace Renatoxm\LaravelTicket\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Renatoxm\LaravelTicket\Enums\Visibility;

trait HasVisibility
{
    /**
     * Determine whether if the model is visible.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeVisible(Builder $builder)
    {
        return $builder->where($this->qualifyColumn('is_visible'), Visibility::VISIBLE->value);
    }

    /**
     * Determine whether if the model is hidden.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeHidden(Builder $builder)
    {
        return $builder->where($this->qualifyColumn('is_visible'), Visibility::HIDDEN->value);
    }
}
