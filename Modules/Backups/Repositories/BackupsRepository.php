<?php

/**
 * Created by PhpStorm.
 * User: goldoni
 * Date: 19.08.18
 * Time: 23:40.
 */

namespace Modules\Backups\Repositories;

use App\Services\Flag\Src\Flag;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Log\Logger;
use Illuminate\Support\Carbon;
use Illuminate\Translation\Translator;

/**
 * Class BackupsRepository.
 */
class BackupsRepository
{
    /**
     * @var \Illuminate\Filesystem\FilesystemManager
     */
    private $adapter;
    /**
     * @var \Illuminate\Contracts\Console\Kernel
     */
    private $artisan;
    /**
     * @var \Illuminate\Log\Logger
     */
    private $log;
    /**
     * @var \Illuminate\Support\Carbon
     */
    private $carbon;
    /**
     * @var \Illuminate\Filesystem\FilesystemManager
     */
    private $storage;
    /**
     * @var \Illuminate\Translation\Translator
     */
    private $lang;

    /**
     * BackupsRepository constructor.
     */
    public function __construct(FilesystemManager $adapter, Kernel $artisan, Logger $log, Carbon $carbon, FilesystemManager $storage, Translator $lang)
    {
        $this->adapter = $adapter;
        $this->artisan = $artisan;
        $this->log = $log;
        $this->carbon = $carbon;
        $this->storage = $storage;
        $this->lang = $lang;
    }

    /**
     * @return string
     */
    public function humanFileSize(int $bytes, int $decimals = 2)
    {
        if ($bytes < 1024) {
            return $bytes . ' B';
        }
        $factor = floor(log($bytes, 1024));

        return sprintf("%.{$decimals}f ", $bytes / pow(1024, $factor)) . ['B', 'KB', 'MB', 'GB', 'TB', 'PB'][$factor];
    }

    /**
     * @param $date
     *
     * @return string
     */
    private function diffTimeStamp($date)
    {
        $this->carbon->setLocale(session('locale'));

        return $this->carbon->createFromTimestamp($date)->diffForHumans();
    }

    /**
     * @param $date
     *
     * @return string
     */
    public function getDate($date)
    {
        $this->carbon->setLocale(session('locale'));

        return $this->carbon->createFromTimestamp($date)->format('d, M Y H:i');
    }

    public function getBackup()
    {
        $disk = $this->adapter->disk(config('backup.backup.destination.disks')[0]);
        $files = $disk->files(str_slug(config('backup.backup.name')));
        $backups = [];

        foreach ($files as $k => $f) {
            if ('.zip' === mb_substr($f, -4) && $disk->exists($f)) {
                $backups[] = [
                    'id'            => $k,
                    'file_path'     => $f,
                    'file_name'     => str_replace(config('backup.backup.name') . '/', '', $f),
                    'file_size'     => $this->humanFileSize($disk->size($f)),
                    'last_modified' => $this->getDate($disk->lastModified($f)),
                    'file_age'      => $this->diffTimeStamp($disk->lastModified($f))
                ];
            }
        }

        return $backups;
    }

    public function create()
    {
        $this->artisan->call('backup:run');
        $this->log->info("Backpack\BackupManager -- new backup started from admin interface \r\n");

        return $this->artisan->output();
    }

    public function download(string $file): Filesystem
    {
        return $this->storage->disk(config('backup.backup.destination.disks')[0])->getDriver();
    }

    public function delete(string $file): array
    {
        $disk = $this->storage->disk(config('backup.backup.destination.disks')[0]);

        if ($disk->exists(config('backup.backup.name') . '/' . $file)) {
            $disk->delete(config('backup.backup.name') . '/' . $file);

            $result['message'] = $this->lang->get('messages.delete', ['attribute' => 'Backup']);

            $result['success'] = true;
            $result['status'] = Flag::STATUS_CODE_SUCCESS;
        } else {
            $result['success'] = false;
            $result['message'] = "The backup file doesn't exist.";
            $result['status'] = Flag::STATUS_CODE_FORBIDDEN;
        }

        return $result;
    }
}
