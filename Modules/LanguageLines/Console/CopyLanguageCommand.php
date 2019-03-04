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
    protected $name = 'language:copy {table} {locale}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Copy language from language_lines to another table.';

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

        $this->copyLanguage($this->argument('table'), $this->argument('locale'));
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['table', InputArgument::REQUIRED, 'A table argument is required.'],
            ['locale', InputArgument::REQUIRED, 'A locale argument is required.'],
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
     * @param string $table
     * @param string $locale
     */
    protected function copyLanguage($table, $locale) {
        $this->info('Table rr' . $table);
        $this->info('Locale rr' . $locale);

        $languageLines = DB::table('language_lines')
            ->select('locale', 'group', 'key', 'text')
            ->where('locale', $locale)
            ->get()
            ->map(function ($languageLine) {
                return [
                    'locale' => $languageLine->locale,
                    'group' => $languageLine->group,
                    'key' => $languageLine->key,
                    'text' => $languageLine->text,
                ];
            })
            ->toArray();

//        $this->info($languageLines);

        DB::table('language_lines_test')->insert($languageLines);

//        foreach ($language_lines as $lang) {
//            $this->info($lang->group);
//        }
    }
}
