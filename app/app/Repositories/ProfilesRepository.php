<?php


namespace App\Repositories;

use App\Models\TemporaryFile;
use App\Models\User;
class ProfilesRepository
{

    public function getUsersAvatar()
    {
        $userImage = User::find(auth()->user()->getAuthIdentifier());
        $userImage->getMedia();
        $avatar = [];
        foreach ($userImage['media'] as $media)
        {
            $avatar['id'] = $media->id;
            $avatar['file_name'] = $media->file_name;
        }
        return $avatar;
    }

    public function updateUser($request):void
    {
        auth()->user()->update($request->only('name', 'email'));

        $temporaryFile = TemporaryFile::where('folder', $request->avatar)->first();
        $user = User::find(auth()->user()->id);
        if($temporaryFile){
            $user->clearMediaCollection('avatars');
            $user->addMedia(storage_path('app\avatars\tmp\\' . $request->avatar. '\\' . $temporaryFile->filename))
                ->toMediaCollection('avatars');
            rmdir(storage_path('app\avatars\tmp\\' . $request->avatar));
            $temporaryFile->delete();
        }
    }
}
