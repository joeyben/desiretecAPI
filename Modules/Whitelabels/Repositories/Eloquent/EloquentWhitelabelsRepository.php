<?php

/**
 * Created by PhpStorm.
 * User: goldoni
 * Date: 24.09.18
 * Time: 21:18.
 */

namespace Modules\Whitelabels\Repositories\Eloquent;

use App\Repositories\RepositoryAbstract;
use Modules\Whitelabels\Entities\Whitelabel;
use Modules\Whitelabels\Repositories\Contracts\WhitelabelsRepository;

/**
 * Class EloquentPostsRepository.
 */
class EloquentWhitelabelsRepository extends RepositoryAbstract implements WhitelabelsRepository
{
    public function model()
    {
        return Whitelabel::class;
    }

    public function generateFiles(int $id,string $name)
    {
        $this->generateFile(
            base_path('Modules/Master/Http/Controllers/MasterController.stub'),
            base_path("Modules/$name/Http/Controllers/{$name}Controller.php"),
            ['$MODULE$','$MODULESMAL$'],
            [$name, strtolower($name)]
        );

        $this->generateFile(
            base_path('Modules/Master/Http/Controllers/MasterWishesController.stub'),
            base_path("Modules/$name/Http/Controllers/{$name}WishesController.php"),
            ['$MODULE$'],
            [$name]
        );

        if (!file_exists(base_path("Modules/$name/Resources/views/layer"))) {
            mkdir(base_path("Modules/$name/Resources/views/layer"), 0777, true);
            mkdir(base_path("Modules/$name/Resources/views/wish"), 0777, true);
        }

        $this->generateFile(
            base_path('Modules/Master/Resources/views/layer/created.blade.stub'),
            base_path("Modules/$name/Resources/views/layer/created.blade.php")
        );

        $this->generateFile(
            base_path('Modules/Master/Resources/views/layer/popup.blade.stub'),
            base_path("Modules/$name/Resources/views/layer/popup.blade.php")
        );

        $this->generateFile(
            base_path('Modules/Master/Resources/views/layer/popup.blade.stub'),
            base_path("Modules/$name/Resources/views/layer/popup.blade.php")
        );

        $this->generateFile(
            base_path('Modules/Master/Resources/views/layouts/master.blade.stub'),
            base_path("Modules/$name/Resources/views/layouts/master.blade.php")
        );

        $this->generateFile(
            base_path('Modules/Master/Resources/views/wish/details.blade.stub'),
            base_path("Modules/$name/Resources/views/wish/details.blade.php")
        );

        $this->generateFile(
            base_path('Modules/Master/Config/config.stub'),
            base_path("Modules/$name/Config/config.php"),
            [
                '$MODULE$',
                '$ID$'
            ],
            [
                $name,
                $id
            ]
        );
    }

    public function generateFile(string $source, string $destination, array $placeholders = [], array $values = [])
    {
        if (!file_exists($source)) {
            throw new FileNotFoundException($source);
        }

        $file = str_replace($placeholders, $values, file_get_contents($source));
        file_put_contents($destination, $file);
    }
}
