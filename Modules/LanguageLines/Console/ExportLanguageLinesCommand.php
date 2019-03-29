<?php

namespace Modules\LanguageLines\Console;

use Illuminate\Console\Command;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Filesystem\Filesystem;
use Modules\LanguageLines\Entities\LanguageLines;
use Symfony\Component\Console\Input\InputArgument;

class ExportLanguageLinesCommand extends Command
{
    const JSON_GROUP = '_json';
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'language:export-db-to-files {group} {table}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export language lines from db (ex. language_lines table) to files.';
    /** @var \Illuminate\Contracts\Foundation\Application */
    protected $app;

    /** @var \Illuminate\Filesystem\Filesystem */
    protected $files;

    /**
     * Create a new command instance.
     *
     * @param $app
     */
    public function __construct(Application $app, Filesystem $files)
    {
        parent::__construct();

        $this->app = $app;
        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $group = $this->argument('group');

        $table = $this->argument('table');

        if (null === $table) {
            $this->warn('Default table language_lines selected.');
            $table = 'language_lines';
        }

        $this->exportTranslations($group, false);

        $this->info('Done writing language files for ' . (('*' === $group) ? 'all groups' : $group . ' group'));
        $this->info('Table ' . $table);
    }

    public function exportTranslations($group = null, $json = false)
    {
        $basePath = $this->app['path.lang'];

        if (null !== $group && !$json) {
            $vendor = false;
            if ('*' === $group) {
                return $this->exportAllTranslations();
            }
            if (starts_with($group, 'vendor')) {
                $vendor = true;
            }

            $languageLines = LanguageLines::where('group', $group)->orderBy('key')->get();
            $tree = $this->makeTree($languageLines);
            foreach ($tree as $locale => $groups) {
                if (isset($groups[$group])) {
                    $translations = $groups[$group];
                    $path = $this->app['path.lang'];
                    $locale_path = $locale . \DIRECTORY_SEPARATOR . $group;
                    if ($vendor) {
                        $path = $basePath . '/' . $group . '/' . $locale;
                        $locale_path = str_after($group, '/');
                    }
                    $subfolders = explode(\DIRECTORY_SEPARATOR, $locale_path);
                    array_pop($subfolders);
                    $subfolder_level = '';
                    foreach ($subfolders as $subfolder) {
                        $subfolder_level = $subfolder_level . $subfolder . \DIRECTORY_SEPARATOR;
                        $temp_path = rtrim($path . \DIRECTORY_SEPARATOR . $subfolder_level, \DIRECTORY_SEPARATOR);
                        if (!is_dir($temp_path)) {
                            mkdir($temp_path, 0777, true);
                        }
                    }
                    $path = $path . \DIRECTORY_SEPARATOR . $locale . \DIRECTORY_SEPARATOR . $group . '.php';
                    $output = "<?php\n\nreturn " . var_export($translations, true) . ';' . \PHP_EOL;
                    $this->files->put($path, $output);
                }
            }

            return true;
        }

        if ($json) {
            $languageLines = LanguageLines::where('group', self::JSON_GROUP)->orderBy('key')->get();
            $tree = $this->makeTree($languageLines);
            foreach ($tree as $locale => $groups) {
                if (isset($groups[self::JSON_GROUP])) {
                    $translations = $groups[self::JSON_GROUP];
                    $path = $this->app['path.lang'] . '/' . $locale . '.json';
                    $output = json_encode($translations, \JSON_PRETTY_PRINT | \JSON_UNESCAPED_UNICODE);
                    $this->files->put($path, $output);
                }
            }
        }

        return true;
    }

    public function exportAllTranslations()
    {
        $groups = LanguageLines::select('group')->distinct()->get();
        foreach ($groups as $group) {
            if (self::JSON_GROUP === $group->group) {
                $this->exportTranslations(null, true);
            } else {
                $this->exportTranslations($group->group);
            }
        }

        return true;
    }

    protected function makeTree($translations, $json = false)
    {
        $array = [];
        foreach ($translations as $translation) {
            if ($json) {
                $this->jsonSet($array[$translation->locale][$translation->group], $translation->key, $translation->text);
            } else {
                array_set($array[$translation->locale][$translation->group], $translation->key, $translation->text);
            }
        }

        return $array;
    }

    public function jsonSet(&$array, $key, $value)
    {
        if (null === $key) {
            return $array = $value;
        }
        $array[$key] = $value;

        return $array;
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['group', InputArgument::REQUIRED, 'The group to export (`*` for all).'],
            ['table', InputArgument::OPTIONAL, 'The table to export.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }
}
