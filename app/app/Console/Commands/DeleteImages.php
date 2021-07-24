<?php

namespace App\Console\Commands;

use App\Models\TemporaryFile;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Managers\UploadsManager;

class DeleteImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:deleteimages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete images hourly in storage directory';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(private UploadsManager $uploadManager)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->uploadManager->deleteOldAll();

    }
}
