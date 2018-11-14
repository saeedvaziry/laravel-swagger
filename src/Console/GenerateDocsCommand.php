<?php

namespace SaeedVaziry\LaravelSwagger\Console;

use SaeedVaziry\LaravelSwagger\Generator;
use Illuminate\Console\Command;

class GenerateDocsCommand extends Command
{
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'laravel-swagger:generate {--source=} {--output=}';

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
    	if($this->option('source')) {		
	        $this->info('Regenerating docs');
	        Generator::generateDocs($this->option('source'), $this->option('output'));
    	} else {
    		$this->error('--source option is required');
    	}
    }
}
