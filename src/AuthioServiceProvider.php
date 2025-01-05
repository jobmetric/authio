<?php

namespace JobMetric\Authio;

use JobMetric\Authio\Models\User;
use JobMetric\PackageCore\Enums\RegisterClassTypeEnum;
use JobMetric\PackageCore\Exceptions\AssetFolderNotFoundException;
use JobMetric\PackageCore\Exceptions\DependencyPublishableClassNotFoundException;
use JobMetric\PackageCore\Exceptions\MigrationFolderNotFoundException;
use JobMetric\PackageCore\Exceptions\RegisterClassTypeNotFoundException;
use JobMetric\PackageCore\Exceptions\ViewFolderNotFoundException;
use JobMetric\PackageCore\PackageCore;
use JobMetric\PackageCore\PackageCoreServiceProvider;
use Tymon\JWTAuth\Providers\LaravelServiceProvider;

class AuthioServiceProvider extends PackageCoreServiceProvider
{
    /**
     * @throws RegisterClassTypeNotFoundException
     * @throws ViewFolderNotFoundException
     * @throws AssetFolderNotFoundException
     * @throws MigrationFolderNotFoundException
     * @throws DependencyPublishableClassNotFoundException
     */
    public function configuration(PackageCore $package): void
    {
        $package->name('authio')
            ->hasConfig()
            ->hasTranslation()
            ->hasMigration()
            ->hasView()
            ->hasAsset()
            ->hasRoute()
            ->registerClass('Authio', Authio::class, RegisterClassTypeEnum::SINGLETON())
            ->registerDependencyPublishable(LaravelServiceProvider::class, 'config');
    }

    /**
     * Before Register Package
     *
     * @return void
     */
    public function beforeRegisterPackage(): void
    {
        $this->app->register(LaravelServiceProvider::class);
    }

    /**
     * After Boot Package
     *
     * @return void
     */
    public function afterBootPackage(): void
    {
        // load authio guard
        config()->set("auth.guards.authio", [
            'driver' => 'jwt',
            'provider' => 'authio',
        ]);

        config()->set("auth.providers.authio", [
            'users' => [
                'driver' => 'eloquent',
                'model' => User::class,
            ],
        ]);
    }
}
