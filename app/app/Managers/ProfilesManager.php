<?php


namespace App\Managers;


use App\Http\Requests\SearchRequest;
use App\Repositories\ProfilesRepository;

class ProfilesManager
{
    public function __construct(private ProfilesRepository $repository)
    {
    }

    public function getUserData($id)
    {
        return $this->repository->getUserData($id);
    }

    public function updateUser($request):void
    {
        $this->repository->updateUser($request);
    }

    public function getUsersPosts($id)
    {
        return $this->repository->getUsersPosts($id);
    }

    public function getAuthUserData()
    {
        return $this->repository->getAuthUserData();
    }

    public function searchForUsers(SearchRequest $request)
    {
        return $this->repository->searchForUsers($request);
    }
}
