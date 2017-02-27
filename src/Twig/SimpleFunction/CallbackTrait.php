<?php

namespace BestIt\OnDemandAssetsBundle\Twig\SimpleFunction;

use Symfony\Bridge\Twig\Extension\AssetExtension;

/**
 * Helps to output the assets.
 * @author lange <lange@bestit-online.de>
 * @package BestIt\OnDemandAssetsBundle
 * @subpackage Twig\SimpleFunction
 * @version $id$
 */
trait CallbackTrait
{
    /**
     * The used file ending.
     * @var string
     */
    protected $allowedFileEnding = '';

    /**
     * The asset extension.
     * @var AssetExtension
     */
    protected $assetExtension = null;

    /**
     * AssetHelperExtension constructor.
     * @param AssetExtension $assetExtension
     */
    public function __construct(AssetExtension $assetExtension)
    {
        $this->setAssetExtension($assetExtension);
    }

    /**
     * Invoke-Magic.
     * @param array $context
     * @return string
     */
    public function __invoke(array $context): string
    {
        return $this->outputFiles($context['bh_assets'] ?? []);
    }

    /**
     * Returns the allowed assets.
     * @param array $assets
     * @return array
     */
    protected function getAllowedAssets(array $assets): array
    {
        return array_filter($assets, function ($asset) {
            if ($valid = $this->isAllowedFile($asset)) {
                $this->addToOutputtedFiles($asset);
            }

            return $valid;
        });
    }

    /**
     * Returns the allowed file ending.
     * @return string
     */
    protected abstract function getAllowedFileEnding(): string;

    /**
     * Returns the asset extension.
     * @return AssetExtension
     */
    protected function getAssetExtension(): AssetExtension
    {
        return $this->assetExtension;
    }

    /**
     * Get the possible asset include.
     * @param string $asset
     * @return string
     */
    protected function getAssetInclude(string $asset): string
    {
        return sprintf(
            $this->getAssetIncludeTemplate(),
            $this->getAssetExtension()->getAssetUrl($asset)
        );
    }

    /**
     * Returns the asset include template.
     * @return string
     */
    protected abstract function getAssetIncludeTemplate(): string;

    /**
     * Is the given file allowed to be outputted?
     * @param string $asset
     * @return bool
     */
    protected function isAllowedFile(string $asset): bool
    {
        return preg_match('/\\.' . $this->getAllowedFileEnding() . '$/', $asset) && !$this->isFileOutputted($asset);
    }

    /**
     * Returns the string which can be used to include the file in the html output.
     * @param array $assets
     * @return string
     */
    protected function outputFiles(array $assets): string
    {
        $assets = $this->getAllowedAssets($assets);

        return implode("\n", array_map(function ($asset) {
            return $this->getAssetInclude($asset);
        }, $assets));
    }


    /**
     * Sets the asset extension.
     * @param AssetExtension $assetExtension
     * @return CallbackTrait
     */
    protected function setAssetExtension(AssetExtension $assetExtension)
    {
        $this->assetExtension = $assetExtension;

        return $this;
    }
}
