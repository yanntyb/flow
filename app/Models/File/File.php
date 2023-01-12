<?php

namespace App\Models\File;

use App\Models\File\Connector\AbstractFileConnector;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property string $slug
 * @property string $path
 * @property string $connected_with
 * @property boolean $need_connector
 * @property Collection $connected_data
 * @property AbstractFileConnector $connector
 */
class File extends Model
{

    protected $guarded = [];
    protected $casts = [
        'connected_data' => AsCollection::class,
        'need_connector' => 'bool',
    ];

    public function getRealPathAttribute(): string
    {
        return $this->path;
    }

    public function getConnectorAttribute(): AbstractFileConnector
    {
        return new $this->connected_with($this);
    }
}
