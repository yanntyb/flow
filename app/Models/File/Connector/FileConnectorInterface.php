<?php

namespace App\Models\File\Connector;

use App\Models\File\File;

interface FileConnectorInterface
{
    public function __construct(File $file);

    public function setFileInstance(File $file): static;

    public function getFileInstance(): File;

    public function canBeAccessed(): bool;

}
