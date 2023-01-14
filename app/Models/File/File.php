<?php

namespace App\Models\File;

use App\Models\File\Connector\AbstractFileConnector;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

/**
 * @property int $id
 * @property string $slug
 * @property string $path
 * @property Collection $connected_with
 * @property boolean $need_connector
 * @property Collection|null $connected_data
 * @property ?Collection<AbstractFileConnector>|null $connectors
 */
class File extends Model
{

    protected $guarded = [];
    protected $casts = [
        'connected_data' => AsCollection::class,
        'connected_with' => AsCollection::class,
        'need_connector' => 'bool',
    ];

    public function getRealPathAttribute(): string
    {
        return $this->path;
    }

    public function path(): Attribute
    {
        return Attribute::make(
           get: fn($path) => url(Storage::url($path)),
        );
    }

    /**
     * @return ?Collection<AbstractFileConnector>
     */
    public function getConnectorsAttribute(): ?Collection
    {
        if(!$this->connected_with?->count()) return null;
        return $this->connected_with->map(fn(string $class) => new $class($this));
    }

    /**
     * @return Attribute
     */
    public function connectedWith(): Attribute
    {
        return Attribute::make(
            set: fn(string|array|null $classes) =>  Collection::wrap($classes),
        );
    }

    public function connectedData(): Attribute
    {
        return Attribute::make(
            set: fn(array|null $datas) => collect($datas)->mapWithKeys(fn($data) => $data),
        );
    }
}
