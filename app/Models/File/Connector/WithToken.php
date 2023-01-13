<?php

namespace App\Models\File\Connector;

use Illuminate\Support\Facades\App;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

class WithToken extends AbstractFileConnector
{
    /**
     * @param bool $post Set false if Token has to be query from GET request
     * @return array
     */
    #[ArrayShape(['token' => "string", 'fromGet' => 'boolean'])]
    public static function getConnectedData(bool $post = true): array
    {
        return [
            'token' => [
                'value' => App::make(WithToken::class)->getTokenFromRequest($post),
                'post' => $post,
            ],
        ];
    }

    /**
     * @return bool
     */
    public function canBeAccessed(): bool
    {
        return$this->getFileInstance()->connected_data['token']['value'] ===  $this->getRequestValue('token') ?? false;
    }

    /**
     * @param bool $post
     * @return mixed
     */
    public function getTokenFromRequest(bool $post = true): mixed
    {
        return $this->getRequestValue('token', $post);
    }

    /**
     * Return false if fromGet isnt set in this File instance's connector data
     * @return bool
     */
    public function fromPostData(): bool
    {
        return $this->getFileInstance()->connected_data['token']['post'] ?? false;
    }
}
