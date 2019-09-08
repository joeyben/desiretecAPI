<?php

/**
 * Created by PhpStorm.
 * User: goldoni
 * Date: 24.09.18
 * Time: 21:18.
 */

namespace Modules\Whitelabels\Repositories\Eloquent;

use App\Repositories\RepositoryAbstract;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManager;
use Modules\Whitelabels\Entities\Whitelabel;
use Modules\Whitelabels\Repositories\Contracts\WhitelabelsRepository;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

/**
 * Class EloquentPostsRepository.
 */
class EloquentWhitelabelsRepository extends RepositoryAbstract implements WhitelabelsRepository
{
    public function model()
    {
        return Whitelabel::class;
    }

    public function generateFiles(int $id, string $name)
    {
        $smallName = mb_strtolower($name);

        $this->generateFile(
            base_path('Modules/Master/Http/Controllers/MasterController.stub'),
            base_path("Modules/$name/Http/Controllers/{$name}Controller.php"),
            ['$MODULE$', '$MODULESMAL$'],
            [$name, mb_strtolower($name)]
        );

        $this->generateFile(
            base_path('Modules/Master/Http/Controllers/MasterWishesController.stub'),
            base_path("Modules/$name/Http/Controllers/{$name}WishesController.php"),
            ['$MODULE$', '$MODULESMAL$'],
            [$name, mb_strtolower($name)]
        );

        $this->generateFile(
            base_path('Modules/Master/Http/Requests/StoreWishRequest.stub'),
            base_path("Modules/$name/Http/Requests/StoreWishRequest.php"),
            ['$MODULE$'],
            [$name]
        );

        if (!file_exists(base_path("Modules/$name/Resources/views/layer"))) {
            mkdir(base_path("Modules/$name/Resources/views/layer"), 0777, true);
            mkdir(base_path("Modules/$name/Resources/views/wish"), 0777, true);
            mkdir(base_path("Modules/$name/Resources/lang/de"), 0777, true);
            mkdir(base_path("Modules/$name/Resources/lang/en"), 0777, true);
            mkdir(base_path("Modules/$name/Resources/assets/sass/layer"), 0777, true);
            mkdir(base_path("Modules/$name/Resources/assets/sass/wish"), 0777, true);
            mkdir(base_path("Modules/$name/Resources/assets/images/layer"), 0777, true);
            mkdir(base_path("Modules/$name/Resources/assets/svg"), 0777, true);
            mkdir(base_path("Modules/$name/Resources/assets/js/layer"), 0777, true);
        }

        $this->copyImage(
            'Modules/Master/Resources/assets/images/layer',
            "Modules/$name/Resources/assets/images/layer"
        );

        $this->copyImageSvg(
            'Modules/Master/Resources/assets/svg',
            "Modules/$name/Resources/assets/svg"
        );

        $this->generateFile(
            base_path('Modules/Master/Resources/assets/sass/layer/_bootstrap-select.scss'),
            base_path("Modules/$name/Resources/assets/sass/layer/_bootstrap-select.scss")
        );

        $this->generateFile(
            base_path('Modules/Master/Resources/assets/sass/wish/details.scss'),
            base_path("Modules/$name/Resources/assets/sass/wish/details.scss")
        );

        $this->generateFile(
            base_path('Modules/Master/Resources/assets/sass/_variables.scss'),
            base_path("Modules/$name/Resources/assets/sass/_variables.scss")
        );

        $this->generateFile(
            base_path('Modules/Master/Resources/assets/sass/layer/_rangeslider.scss'),
            base_path("Modules/$name/Resources/assets/sass/layer/_rangeslider.scss")
        );

        $this->generateFile(
            base_path('Modules/Master/Resources/assets/sass/layer/_utils.scss'),
            base_path("Modules/$name/Resources/assets/sass/layer/_utils.scss")
        );

        $this->generateFile(
            base_path('Modules/Master/Resources/assets/sass/layer/bootstrap-select.css.map'),
            base_path("Modules/$name/Resources/assets/sass/layer/bootstrap-select.css.map")
        );

        $this->generateFile(
            base_path('Modules/Master/Resources/assets/sass/layer/layer.scss'),
            base_path("Modules/$name/Resources/assets/sass/layer/layer.scss")
        );

        $this->generateFile(
            base_path('Modules/Master/Resources/assets/sass/app.scss'),
            base_path("Modules/$name/Resources/assets/sass/app.scss")
        );

        $this->generateFile(
            base_path('Modules/Master/Resources/lang/de/layer.php'),
            base_path("Modules/$name/Resources/lang/de/layer.php")
        );

        $this->generateFile(
            base_path('Modules/Master/Resources/lang/en/layer.php'),
            base_path("Modules/$name/Resources/lang/en/layer.php")
        );

        $this->generateFile(
            base_path('Modules/Master/Resources/views/layer/created.blade.stub'),
            base_path("Modules/$name/Resources/views/layer/created.blade.php"),
            ['$MODULESMAL$'],
            [mb_strtolower($name)]
        );

        $this->generateFile(
            base_path('Modules/Master/webpack.mix.stub'),
            base_path("Modules/$name/webpack.mix.js"),
            ['$MODULESMAL$'],
            [mb_strtolower($name)]
        );

        $this->generateFile(
            base_path('Modules/Master/Resources/views/layer/popup.blade.stub'),
            base_path("Modules/$name/Resources/views/layer/popup.blade.php"),
            ['$MODULESMAL$'],
            [mb_strtolower($name)]
        );

        $this->generateFile(
            base_path('Modules/Master/Resources/views/layouts/master.blade.stub'),
            base_path("Modules/$name/Resources/views/layouts/master.blade.php"),
            ['$MODULESMAL$'],
            [mb_strtolower($name)]
        );

        $this->generateFile(
            base_path('Modules/Master/Resources/views/layouts/footer.blade.stub'),
            base_path("Modules/$name/Resources/views/layouts/footer.blade.php")
        );

        $this->generateFile(
            base_path('Modules/Master/Resources/views/wish/details.blade.stub'),
            base_path("Modules/$name/Resources/views/wish/details.blade.php"),
            ['$MODULESMAL$'],
            [mb_strtolower($name)]
        );

        $this->generateFile(
            base_path('Modules/Master/Resources/views/wish/wish.blade.stub'),
            base_path("Modules/$name/Resources/views/wish/wish.blade.php"),
            ['$MODULESMAL$'],
            [mb_strtolower($name)]
        );

        $this->generateFile(
            base_path('Modules/Master/Resources/views/wish/index.blade.stub'),
            base_path("Modules/$name/Resources/views/wish/index.blade.php"),
            ['$MODULESMAL$'],
            [mb_strtolower($name)]
        );

        $this->generateFile(
            base_path('Modules/Master/Resources/assets/js/layer/layer.stub'),
            base_path("Modules/$name/Resources/assets/js/layer/layer.js"),
            ['$MODULESMAL$'],
            [mb_strtolower($name)]
        );

        $this->generateFile(
            base_path('Modules/Master/Resources/views/index.blade.stub'),
            base_path("Modules/$name/Resources/views/index.blade.php"),
            ['$MODULESMAL$'],
            [mb_strtolower($name)]
        );

        $whitelabelLangTable = 'language_lines_' . mb_strtolower($name);
        $this->generateFile(
            base_path('Modules/Master/Config/config.stub'),
            base_path("Modules/$name/Config/config.php"),
            [
                '$MODULE$',
                '$ID$',
                '$TABLE$',
                '$MODULESMAL$'
            ],
            [
                $name,
                $id,
                $whitelabelLangTable,
                mb_strtolower($name)
            ]
        );

        $slug = mb_strtolower($name);
        $datePrefix = date('Y_m_d_His');
        $this->generateFile(
            base_path('Modules/Master/Database/Migrations/create_language_lines_master_table.stub'),
            base_path("Modules/$name/Database/Migrations/{$datePrefix}_create_language_lines_{$slug}_table.php"),
            ['$MODULE$', '$SLUG$'],
            [$name, $slug]
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

    public function copyImage(string $source, string $destination)
    {
        if (!file_exists(base_path($source))) {
            throw new FileNotFoundException($source);
        }

        if (!file_exists(base_path($destination))) {
            throw new FileNotFoundException($source);
        }

        $manager = new ImageManager();
        $images = glob(base_path($source . '/*'));

        foreach ($images as $image) {
            $manager->make($image)
                ->save(base_path($destination  . '/' . pathinfo($image, PATHINFO_BASENAME)));
        }
    }

    public function copyImageSvg(string $source, string $destination)
    {
        if (!file_exists(base_path($source))) {
            throw new FileNotFoundException($source);
        }

        if (!file_exists(base_path($destination))) {
            throw new FileNotFoundException($source);
        }

        $images = glob(base_path($source . '/*'));

        foreach ($images as $image) {
            copy($image, base_path($destination  . '/' . basename($image)));
        }
    }

    public function copyLanguage(string $table, string $locale)
    {
        $languageLines = DB::table('language_lines')
            ->select('locale', 'description', 'group', 'key', 'text')
            ->where('locale', $locale)
            ->get()
            ->map(function ($languageLine) use ($locale) {
                return [
                    'locale'      => $locale,
                    'description' => $languageLine->description,
                    'group'       => $languageLine->group,
                    'key'         => $languageLine->key,
                    'text'        => $languageLine->text,
                ];
            })
            ->toArray();

        return DB::table($table)->insert($languageLines);
    }
}
