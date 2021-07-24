<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreImageRequest;
use App\Models\TemporaryFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function store(StoreImageRequest $request)
    {

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $fileName = $file->getClientOriginalName();
            $folder = uniqid() . '-' . now()->timestamp;
            $file->storeAs('avatars/tmp/' . $folder, $fileName);

            TemporaryFile::create([
                'folder' => $folder,
                'filename' => $fileName
            ]);

            return $folder;
        }
        return '';
    }

    public function delete(Request $request)
    {
        $folder = $request->getContent();

        $temporaryFile = TemporaryFile::where('folder', $folder)->first();
        if ($temporaryFile && Storage::exists('avatars\tmp\\' . $temporaryFile->folder)) {
            Storage::deleteDirectory('avatars\tmp\\' . $temporaryFile->folder);
            $temporaryFile->delete();

        }

    }
}
