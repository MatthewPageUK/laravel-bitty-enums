<?php

namespace MatthewPageUK\BitwiseEnums\Commands;

use Illuminate\Console\Command;

class BitwiseEnumsCommand extends Command
{
    public $signature = 'laravel-bitwise-enums';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
