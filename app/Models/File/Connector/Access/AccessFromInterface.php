<?php

namespace App\Models\File\Connector\Access;

use Illuminate\Http\Client\Request;

interface AccessFromInterface
{
    public function canBeAccessed(): bool;

    public function fromPostData(): bool;

    /**
     * @param mixed $key
     * @param bool $post
     * @return mixed $values
     */
    public function getRequestValue(mixed $key, bool $post): mixed;
}
