<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class WhitelabelMakeRouteCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'whitelabel:make-route {domain} {module}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to make route for Whitelabel';

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
     * @return mixed
     */
    public function handle()
    {
        $this->route($this->argument('domain'), $this->argument('module'));
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['domain', InputArgument::REQUIRED, 'An domain argument is required.'],
            ['module', InputArgument::REQUIRED, 'An module argument is required.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
        ];
    }

    private function route($domain, $module)
    {
        $template = str_replace(
            [
                '$DOMAIN$',
                '$MODULE$',
            ],
            [
                $domain,
                $module
            ],
            $this->getStub()
        );

        if (!file_exists($path = base_path("Modules/{$module}/Http"))) {
            throw new FileNotFoundException('Whitelabel not exists!');
        }

        file_put_contents("$path/routes.php", $template);
        $this->info("Created : {$path}/routes.php");
    }
    private function getStub()
    {
        return file_get_contents(base_path('Modules/Whitelabels/Stubs/routes.stub'));
    }

}
