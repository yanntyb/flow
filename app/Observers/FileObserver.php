<?php

namespace App\Observers;

use App\Models\File\Connector\AbstractFileConnector;
use App\Models\File\File;

class FileObserver
{
   public function retrieved(File $file)
   {
       $connectorAuthorized = $file->connectors?->filter(fn(AbstractFileConnector $connector) => !$connector->canBeAccessed());
       if($file->need_connector && !$connectorAuthorized->count()) {
           abort(403);
       }
   }

    public function creating(File $file)
    {
        $file->need_connector = (bool)$file->connected_data;
   }
}
