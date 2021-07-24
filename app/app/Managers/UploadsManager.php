<?php


namespace App\Managers;


use App\Repositories\UploadsRepository;

class UploadsManager
{

    public function __construct(private UploadsRepository $repository)
    {
    }

    public function deleteOldAll(): void
    {
        $this->repository->deleteOldAll();
    }
}
