<?php

namespace MatthewPageUK\BittyEnums\Commands;

use Illuminate\Console\Command;

class BittyEnumsCommand extends Command
{
    public $signature = 'laravel-bitty-enums';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
