<?php

namespace App\Models\File\Connector\Access;

interface AccessFromInterface
{
    public function canBeAccessed(): bool;
}
