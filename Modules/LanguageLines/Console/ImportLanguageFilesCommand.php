<?php

namespace Modules\LanguageLines\Console;

use Illuminate\Console\Command;
use Modules\LanguageLines\Entities\LanguageLines;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Filesystem\Filesystem;

class ImportLanguageFilesCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'language:import-files-db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import language locales to db (language_lines table).';

    const JSON_GROUP = '_json';

    /** @var \Illuminate\Contracts\Foundation\Application */
    protected $app;

    /** @var \Illuminate\Filesystem\Filesystem */
    protected $files;

    /**
     * Create a new command instance.
     *
     * @param $app
     * @param  $files
     *
     * @return void
     */
    public function __construct(Application $app, Filesystem $files)
    {
        parent::__construct();

        $this->app            = $app;
        $this->files          = $files;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $replace = $this->option('replace');
        $counter = $this->importTranslations($replace);
        $this->info('Done importing, processed ' . $counter . ' items!');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
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
            ['replace', 'R', InputOption::VALUE_NONE, 'Replace existing keys'],
        ];
    }

    public function importTranslations($replace = false, $base = null)
    {
        $counter = 0;
        //allows for vendor lang files to be properly recorded through recursion.
//        $vendor = true;
        if ($base == null) {
            $base = $this->app['path.lang'];
            $vendor = false;
        }
        foreach ($this->files->directories($base) as $langPath) {
            $locale = basename($langPath);
            //import langfiles for each vendor
//            if ($locale == 'vendor') {
//                foreach ($this->files->directories($langPath) as $vendor) {
//                    $counter += $this->importTranslations($replace, $vendor);
//                }
//                continue;
//            }
//            $vendorName = $this->files->name($this->files->dirname($langPath));
            foreach ($this->files->allfiles($langPath) as $file) {
                $info = pathinfo($file);
                $group = $info['filename'];

                $subLangPath = str_replace($langPath . DIRECTORY_SEPARATOR, '', $info['dirname']);
                $subLangPath = str_replace(DIRECTORY_SEPARATOR, '/', $subLangPath);
                $langPath = str_replace(DIRECTORY_SEPARATOR, '/', $langPath);
//                if ($subLangPath != $langPath) {
//                    $group = $subLangPath . '/' . $group;
//                }
                if (!$vendor) {
                    $translations = \Lang::getLoader()->load($locale, $group);
                }

                if ($translations && is_array($translations)) {
                    foreach (array_dot($translations) as $key => $value) {
                        $importedTranslation = $this->importTranslation($key, $value, $locale, $group, $replace);
                        $counter += $importedTranslation ? 1 : 0;
                    }
                }
            }
        }
        foreach ($this->files->files($this->app['path.lang']) as $jsonTranslationFile) {
            if (strpos($jsonTranslationFile, '.json') === false) {
                continue;
            }
            $locale = basename($jsonTranslationFile, '.json');
            $group = self::JSON_GROUP;
            $translations =
                \Lang::getLoader()->load($locale, '*', '*'); // Retrieves JSON entries of the given locale only
            if ($translations && is_array($translations)) {
                foreach ($translations as $key => $value) {
                    $importedTranslation = $this->importTranslation($key, $value, $locale, $group, $replace);
                    $counter += $importedTranslation ? 1 : 0;
                }
            }
        }
        return $counter;
    }

    public function importTranslation($key, $text, $locale, $group, $replace = false)
    {
        $this->info('Key ' . $key);
        $this->info('Text ' . $text);
        $this->info('Locale ' . $locale);
        $this->info('Group ' . $group);
        // process only string values
        if (is_array($text)) {
            return false;
        }

        LanguageLines::create([
            'locale' => $locale,
            'group' => $group,
            'key' => $key,
            'text' => $text
        ]);

        return true;
    }
}
