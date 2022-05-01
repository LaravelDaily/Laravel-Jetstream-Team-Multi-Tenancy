<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'team_id'];

    protected static function boot()
    {
        parent::boot();

        if (auth()->check()) {
            self::creating(function($model) {
                $model->team_id = auth()->user()->current_team_id;
            });

            static::addGlobalScope('task_team_id', function (Builder $builder) {
                $builder->where('team_id', auth()->user()->current_team_id);
            });
        }
    }
}
