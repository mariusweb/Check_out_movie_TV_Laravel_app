<?php


namespace App\Repositories;


use App\Models\TemporaryFile;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class UploadsRepository
{

    public function deleteOldAll()
    {
        $oldImages = TemporaryFile::where('created_at', '<', Carbon::now()->subMinutes(3))
            ->select('folder', 'filename')
            ->get();

        foreach ($oldImages as $oldImage){
            $temporaryFile = TemporaryFile::where('folder', $oldImage->folder)->first();

            if(Storage::exists('avatars\tmp\\' . $temporaryFile->folder)){
                Storage::deleteDirectory('avatars\tmp\\' . $temporaryFile->folder);
                $temporaryFile->delete();
            }
        }
    }
}
