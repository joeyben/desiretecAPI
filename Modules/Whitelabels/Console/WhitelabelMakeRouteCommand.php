<?php

namespace Modules\Whitelabels\Console;

use Illuminate\Console\Command;

class WhitelabelMakeRouteCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'whitelabel:make-route {domain} {module}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to make route for Whitelabel';

    /**
     * Create a new command instance.
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
}
