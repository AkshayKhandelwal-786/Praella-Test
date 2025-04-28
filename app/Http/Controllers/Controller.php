<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;

abstract class Controller extends BaseController
{
    public function uploadFile($file, $path)
    {
        $fileName = time() . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
        $filePath = $path . $fileName;
        Storage::disk('public')->put($filePath, file_get_contents($file));
        
        return ['filePath' => 'storage/'.$filePath];
    }
    public function unlinkFile($filePath)
    {
        if (!empty($filePath)) {
            $path = str_replace('storage/', '', $filePath);
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }       
    }
}
