<?php

/**
 * Created by PhpStorm.
 * User: emere
 * Date: 10/05/2018
 * Time: 20:49.
 */

namespace Modules\Components\Repositories;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Translation\Translator;
use Nwidart\Modules\Laravel\LaravelFileRepository;

/**
 * Class ComponentsRepository.
 */
class ComponentsRepository
{
    /**
     * @var \Nwidart\Modules\Laravel\Repository
     */
    private $module;
    /**
     * @var \Illuminate\Contracts\Console\Kernel
     */
    private $artisan;
    /**
     * @var \Illuminate\Support\Str
     */
    private $str;
    /**
     * @var \Illuminate\Translation\Translator
     */
    private $translator;

    /**
     * ComponentsRepository constructor.
     *
     * @param \Nwidart\Modules\Laravel\LaravelFileRepository $module
     * @param \Illuminate\Contracts\Console\Kernel           $artisan
     * @param \Illuminate\Translation\Translator             $translator
     * @param \Illuminate\Support\Str                        $str
     */
    public function __construct(LaravelFileRepository $module, Kernel $artisan, Translator $translator, Str $str)
    {
        $this->module = $module;
        $this->artisan = $artisan;
        $this->str = $str;
        $this->translator = $translator;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getModules(): Collection
    {
        $modules = collect($this->module->all());

        $except = ['Components', 'Tui', 'Master', 'Nmviajes', 'Activities', 'Permissions', 'Roles', 'Users'];

        return $modules->map(function ($module) use ($except) {
            if (!\in_array($module->getStudlyName(), $except, true)) {
                return [
                    'id'          => $module->get('order'),
                    'name'        => $module->getStudlyName(),
                    'alias'       => $module->getAlias(),
                    'package'     => $module->get('package'),
                    'version'     => $module->get('version'),
                    'description' => $module->getDescription(),
                    'status'      => $module->isStatus(1),
                    'requires'    => implode(', ', $module->getRequires())
                ];
            }
        })->filter();
    }

    public function uninstall(string $key, bool $keep): array
    {
        $module = $this->module->findOrFail($key);

        if ($module->enabled() && 'Components' !== $module->getStudlyName()) {
            $module->disable();
            $result['message'] = $this->translator->get('messages.uninstall', ['attribute' => $module->getStudlyName()]) . ":\n";

            if (!$keep) {
                $this->artisan->call('module:migrate-rollback', ['module' => $this->str->studly($key), '--force' => true]);
                $result['message'] .= $this->artisan->output();
            }
        } else {
            $result['message'] = $module->getStudlyName() . ' cannot be uninstalled';
        }

        return $result;
    }

    public function install(string $key): array
    {
        $module = $this->module->findOrFail($this->str->studly($key));
        ini_set('max_execution_time', 300);

        if ($module->disabled()) {
            $module->enable();
            $result['message'] = $this->translator->get('messages.install', ['attribute' => $module->getStudlyName()]) . ":\n";
            $this->artisan->call('module:migrate', ['module' => $this->str->studly($key), '--force' => true]);
            $result['message'] .= $this->artisan->output();
        } else {
            $result['message'] = $module->getStudlyName() . ' cannot be installed';
        }
        $result['module'] = $module->getStudlyName();

        return $result;
    }

    /**
     * @param string $key
     *
     * @throws \Exception
     *
     * @return string
     */
    public function migrate(string $key)
    {
        $module = $this->module->findOrFail($this->str->studly($key));
        ini_set('max_execution_time', 300);

        if ($module->enabled()) {
            $this->artisan->call('module:migrate', ['module' => $this->str->studly($key), '--force' => true]);
            $message = $this->artisan->output();
        } else {
            throw new \Exception('Required module ' . $module->getStudlyName() . ' are not installed');
        }

        return $message;
    }

    /**
     * @param string $key
     *
     * @throws \Exception
     *
     * @return string
     */
    public function refresh(string $key)
    {
        $module = $this->module->findOrFail($this->str->studly($key));
        ini_set('max_execution_time', 300);

        if ($module->enabled()) {
            $this->artisan->call('module:migrate-refresh', ['module' => $this->str->studly($key), '--force' => true]);
            $message = $this->artisan->output();
        } else {
            throw new \Exception('Required module ' . $module->getStudlyName() . ' are not installed');
        }

        return $message;
    }

    public function rollback($key)
    {
        $module = $this->module->findOrFail($this->str->studly($key));
        ini_set('max_execution_time', 300);

        if ($module->enabled()) {
            $this->artisan->call('module:migrate-rollback', ['module' => $this->str->studly($key), '--force' => true]);
            $message = $this->artisan->output();
        } else {
            throw new \Exception('Required module ' . $module->getStudlyName() . ' are not installed');
        }

        return $message;
    }

    public function seed($key)
    {
        $module = $this->module->findOrFail($this->str->studly($key));
        ini_set('max_execution_time', 300);

        if ($module->enabled()) {
            $this->artisan->call('module:seed', ['module' => $this->str->studly($key), '--force' => true]);
            $message = $this->artisan->output();
        } else {
            throw new \Exception('Required module ' . $module->getStudlyName() . ' are not installed');
        }

        return $message;
    }
}
