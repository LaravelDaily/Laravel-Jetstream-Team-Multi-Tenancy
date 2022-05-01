<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'project_id'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    protected static function boot()
    {
        parent::boot();

        if (auth()->check()) {
            static::addGlobalScope('project_team_id', function (Builder $builder) {
                $builder->whereHas('project', function ($query) {
                    $query->where('projects.team_id', auth()->user()->current_team_id);
                });
            });
        }
    }
}
