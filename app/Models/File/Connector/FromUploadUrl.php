<?php

namespace App\Models\File\Connector;

use Illuminate\Support\Facades\App;
use JetBrains\PhpStorm\ArrayShape;

class FromUploadUrl extends AbstractFileConnector
{

    /**
     * $url to set a different url than the upload one
     * @param string|null $url
     * @return array
     */
    #[ArrayShape(['url' => "string"])]
    public static function getConnectedData(string $url = null): array
    {
        App::make(FromUploadUrl::class)->getClientUrl();
        return [
            'url' => $url ?: App::make(FromUploadUrl::class)->getClientUrl(),
        ];
    }

    /**
     * @return bool
     */
    public function canBeAccessed(): bool
    {
        return $this->getFileInstance()->connected_data['url'] === $this->getClientUrl();
    }

    /**
     * Url set is incoming request client url
     * @return string|null
     */
    public function getClientUrl(): ?string
    {
        return request()->header('referer');
    }

    public function fromPostData(): bool
    {
        return false;
    }
}
