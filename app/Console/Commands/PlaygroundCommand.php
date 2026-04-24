<?php

namespace App\Console\Commands;

use App\Repo\MessageRepo;
use App\Services\DynamoDBService;
use Exception;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

#[Signature('pg')]
#[Description('Command for testing')]
class PlaygroundCommand extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (config('app.env') != 'local') {
            throw new Exception('Only for local env');
        }

        $rm = new MessageRepo();
        
        $rm->createNewMessage(Str::uuid(), 1, 1, 'new mess');
    }
}
