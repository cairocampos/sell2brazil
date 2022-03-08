<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeRepositoryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {repository}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
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
        $repositoryName = $this->argument('repository');
        $html = file_get_contents(resource_path('stubs/Repository.stub'));
        $html = str_replace('{{RepositoryName}}', $repositoryName, $html);
        $path = base_path("app/Repositories/");
        if(!is_dir($path)) {
            mkdir($path, 0775);
        }

        file_put_contents("{$path}{$repositoryName}.php", $html);
    }
}
