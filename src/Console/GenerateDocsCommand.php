<?php

namespace Cotlet\LaravelSwagger\Console;

use Cotlet\LaravelSwagger\Generator;
use Illuminate\Console\Command;

class GenerateDocsCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'laravel-swagger:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Regenerate docs';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->info('Regenerating docs');
        Generator::generateDocs();
    }
}
