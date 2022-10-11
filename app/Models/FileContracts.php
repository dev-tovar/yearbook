<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class FileContracts extends Model
{
    /**
     * @param \Symfony\Component\HttpFoundation\File\File $file
     * @return bool
     */
    public function uploadFile($file, $schoolId){
        if ($file->isValid()) {
            $ext = $file->getClientOriginalExtension();
            $fileName = $file->getClientOriginalName();
            $fileSize = $file->getSize();
            $randomName = Str::random(50);

            $path = public_path('uploads/contracts/' . $schoolId);
            $file->move($path, 'contract_' . $randomName . '.' . $ext);

            Contract::create([
                'school_id' => $schoolId,
                'original_name' => $fileName,
                'size' => $fileSize,
                'path' => 'uploads/contracts/' . $schoolId . '/contract_' . $randomName . '.' . $ext
            ]);

            return true;
        }
        return false;
    }
}
