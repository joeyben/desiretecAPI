<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Groups\Entities\Group;
use Symfony\Component\Console\Input\InputArgument;

class CheckGroup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'whitelabel:check-group {group?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cron Job erstellen für automatische Reaktivierung';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['group', InputArgument::OPTIONAL, 'The group to check']
        ];
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $selectedGroup = $this->argument('group');

        if (is_numeric($selectedGroup)) {
            $groups = Group::where('id', $selectedGroup)->whereDate('deactivate_until', '<', Carbon::now()->endOfDay())->get();
        } else {
            $groups = Group::whereDate('deactivate_until', '<', Carbon::now()->endOfDay())->get();
        }

        foreach ($groups as $group) {
            DB::table('groups')
                ->where('id', $group->id)
                ->update([
                    'status'           => true,
                    'deactivate_at'    => null,
                    'deactivate_until' => null
                ]);

            Log::info('Cron Job ( ' . self::class . ' ): active group: ' . $group->display_name . ':' . $group->id);
        }
    }
}
