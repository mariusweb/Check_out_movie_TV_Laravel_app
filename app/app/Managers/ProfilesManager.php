<?php


namespace App\Managers;


use App\Repositories\ProfilesRepository;

class ProfilesManager
{
    public function __construct(private ProfilesRepository $repository)
    {
    }

    public function getUsersAvatar()
    {
        return $this->repository->getUsersAvatar();
    }

    public function updateUser($request):void
    {
        $this->repository->updateUser($request);
    }
}
