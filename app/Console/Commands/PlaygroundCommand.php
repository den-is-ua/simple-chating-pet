<?php

namespace App\Console\Commands;

use App\Repo\MessageRepo;
use App\Services\DynamoDBService;
use Exception;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use function dd;

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
        
        $r = $rm->getMessages('cc06efee-61e5-4d36-ac0b-b3067cd3ac3e');
        dd($r);
    }
}
