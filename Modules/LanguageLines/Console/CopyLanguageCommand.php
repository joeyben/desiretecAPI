<?php

namespace Modules\LanguageLines\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Illuminate\Support\Facades\DB;

class CopyLanguageCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'language:copy {fromTable} {toTable} {fromLocale} {toLocale}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Copy language from one table to another table.';

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

        $this->copyLanguage(
            $this->argument('fromTable'),
            $this->argument('toTable'),
            $this->argument('fromLocale'),
            $this->argument('toLocale')
        );
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['fromTable', InputArgument::REQUIRED, 'A table from argument is required.'],
            ['toTable', InputArgument::REQUIRED, 'A table to argument is required.'],
            ['fromLocale', InputArgument::REQUIRED, 'A locale from argument is required.'],
            ['toLocale', InputArgument::REQUIRED, 'A locale to argument is required.'],
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

    /**
     * @param $fromTable
     * @param $toTable
     * @param $fromLocale
     * @param $toLocale
     *
     * @return bool
     */
    protected function copyLanguage($fromTable, $toTable, $fromLocale, $toLocale) {
        $languageLines = DB::table($fromTable)
            ->select('locale', 'group', 'key', 'text')
            ->where('locale', $fromLocale)
            ->get()
            ->map(function ($languageLine) use ($toLocale) {
                return [
                    'locale' => $toLocale,
                    'group' => $languageLine->group,
                    'key' => $languageLine->key,
                    'text' => $languageLine->text,
                ];
            })
            ->toArray();

        return DB::table($toTable)->insert($languageLines);
    }
}
