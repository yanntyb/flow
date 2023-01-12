<?php

namespace App\Observers;

use App\Models\File\File;

class FileObserver
{
   public function retrieved(File $file)
   {
       if($file->need_connector && !$file?->connector->canBeAccessed()){
           abort(403);
       }
   }
}
