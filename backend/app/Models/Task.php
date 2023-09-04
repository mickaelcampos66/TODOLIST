<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Task extends Model
{
    protected $visible = ['id', 'title', 'category', 'tags'];

    // Conventions et règles de nommages implites de Laravel (8)
    // Les tables sont toujours au pluriel (categories, tasks, ...)
    // Les Models sont au singulier (Category, Task, ...)
    // Les relations sont au singulier ou au pluriel en fonction du type de relation
    // belongsTo -> la relation est au singulier (tasks)
    // hasMany -> La relation est au pluriel (categories)
    public function category(): BelongsTo
    {
        // Une tache n'a qu'une seule catégorie
        // -> belongsTo
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }
}
