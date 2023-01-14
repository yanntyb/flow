<?php

namespace App\Models\File\Connector;

use App\Models\File\Connector\Access\AccessFromInterface;
use App\Models\File\File;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Gate;

abstract class AbstractFileConnector implements FileConnectorInterface, AccessFromInterface
{
    private File $file;


    public function __construct(File $file)
    {
        $this->setFileInstance($file);
    }

    public function setFileInstance(File $file): static
    {
        $this->file = $file;
        return $this;
    }

    public function getFileInstance(): File
    {
        return $this->file;
    }

    public function canAccess(): bool
    {
        return Gate::allows('access-file',$this->getFileInstance());
    }

    abstract public function fromPostData(): bool;

    public function getRequestValue(mixed $key,bool $post = null): mixed
    {
        if(!is_null($post)){
            $methode = $post ? 'post': 'get';
        }
        else{
            $methode = $this->fromPostData() ? 'post' : 'get';
        }
        return request()->{$methode}($key);
    }

}
