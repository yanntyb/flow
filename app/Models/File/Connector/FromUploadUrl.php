<?php

namespace App\Models\File\Connector;

use Illuminate\Support\Facades\App;
use JetBrains\PhpStorm\ArrayShape;

class FromUploadUrl extends AbstractFileConnector
{

    /**
     * @return array
     */
    #[ArrayShape(['url' => "string"])]
    public static function getConnectedData(): array
    {
        return [
            'url' => App::make(FromUploadUrl::class)->getClientUrl(),
        ];
    }

    /**
     * @return bool
     */
    public function canBeAccessed(): bool
    {
        return $this->getFileInstance()->connected_data->first('url') === $this->getClientUrl();
    }

    /**
     * Url set is incoming request client url
     * @return string
     */
    public function getClientUrl(): string
    {
        return request()->header('referer');
    }
}
