<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

// Conventions et règles de nommages implites de Laravel (8)
// Les tables sont toujours au pluriel (categories, tasks, ...)
// Les Models sont au singulier (Category, Task, ...)
// Les relations sont au singulier ou au pluriel en fonction du type de relation
// belongsTo -> la relation est au singulier (tasks)
// hasMany -> La relation est au pluriel (categories)
class Category extends Model
{
    // Si on veut limiter les attributs exposés en API
    // On utilise la variable de config '$visible'
    protected $visible = ['id', 'name'];

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
