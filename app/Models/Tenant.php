<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $fillable = [
        'slug',
        'name',
        'phone',
        'email',
        'password',
    ];

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where('slug', $value)->firstOrFail();
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
