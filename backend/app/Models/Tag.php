<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    protected $visible = ['id', 'label'];

    public function tasks(): BelongsToMany
    {
        // dans le 'belongsToMany, on peut préciser le nom de la table pivot, et le nom des chaps id
        return $this->belongsToMany(Task::class /*, table_pivot, tag_id, task_id */);
    }
}
