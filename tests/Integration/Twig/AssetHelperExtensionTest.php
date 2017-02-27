<?php

namespace BestIt\OnDemandAssetsBundle\Tests\Integration\Twig;

use BestIt\OnDemandAssetsBundle\Twig\AssetHelperExtension;
use Symfony\Bridge\Twig\Extension\AssetExtension;
use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\Packages;
use Symfony\Component\Asset\VersionStrategy\VersionStrategyInterface;
use Twig_Test_IntegrationTestCase;

/**
 * Class AssetHelperExtensionTest
 * @author blange <lange@bestit-online.de>
 * @category Tests
 * @package BestIt\OnDemandAssetsBundle
 * @subpackage Integration\Twig
 * @version $id$
 */
class AssetHelperExtensionTest extends Twig_Test_IntegrationTestCase
{
    /**
     * Returns the used extensions.
     * @return array
     */
    public function getExtensions()
    {
        return [
            new AssetHelperExtension(
                new AssetExtension(
                    new Packages(
                        new Package(
                            static::createMock(VersionStrategyInterface::class)
                        )
                    )
                )
            )
        ];
    }

    /**
     * Returns the fixtures dir.
     * @return string
     */
    public function getFixturesDir()
    {
        return __DIR__ . DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR;
    }
}
