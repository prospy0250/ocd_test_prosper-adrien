<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Person extends Model
{
    protected $fillable = [
        'created_by',
        'first_name',
        'last_name',
        'birth_name',
        'middle_names',
        'date_of_birth',
    ];
    //relation between a person and its children
    public function children():BelongsToMany{
        return $this->belongsToMany(Person::class, 'relationships', 'parent_id', 'child_id');
    }
    //relation between a person and its parents
    public function parents():BelongsToMany{
        return $this->belongsToMany(Person::class, 'relationships', 'child_id', 'parent_id');
    }

    //relation between a person and its user creator
    public function user():BelongsTo{
        return $this->belongsTo(User::class, 'created_by');
    }
}
