<?php

namespace JobMetric\Authio;

use JobMetric\PackageCore\Enums\RegisterClassTypeEnum;
use JobMetric\PackageCore\Exceptions\AssetFolderNotFoundException;
use JobMetric\PackageCore\Exceptions\RegisterClassTypeNotFoundException;
use JobMetric\PackageCore\Exceptions\ViewFolderNotFoundException;
use JobMetric\PackageCore\PackageCore;
use JobMetric\PackageCore\PackageCoreServiceProvider;

class AuthioServiceProvider extends PackageCoreServiceProvider
{
    /**
     * @throws RegisterClassTypeNotFoundException
     * @throws ViewFolderNotFoundException
     * @throws AssetFolderNotFoundException
     */
    public function configuration(PackageCore $package): void
    {
        $package->name('authio')
            ->hasConfig()
            ->hasTranslation()
            ->hasView()
            ->hasAsset()
            ->hasRoute()
            ->registerClass('Authio', Authio::class, RegisterClassTypeEnum::SINGLETON());
    }
}
