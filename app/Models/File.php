<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $slug
 * @property string $path
 */
class File extends Model
{

    protected $guarded = [];

    public function getRealPathAttribute(): string
    {
        return $this->path;
    }
}
