<?php

namespace BestIt\OnDemandAssetsBundle\Twig;

use BestIt\OnDemandAssetsBundle\Twig\SimpleFunction\OutputCSSCallback;
use BestIt\OnDemandAssetsBundle\Twig\SimpleFunction\OutputJavascriptCallback;
use BestIt\OnDemandAssetsBundle\Twig\TokenParser\IncludeAssets;
use Symfony\Bridge\Twig\Extension\AssetExtension;
use Twig_Extension;
use Twig_SimpleFunction;
use Twig_TokenParser;

/**
 * Adds some functions and tags to collect assets in child templates.
 *
 * @author lange <lange@bestit-online.de>
 * @package BestIt\OnDemandAssetsBundle
 * @subpackage Twig
 * @version $id$
 */
class AssetHelperExtension extends Twig_Extension
{
    /**
     * The asset extension.
     *
     * @var AssetExtension
     */
    protected $assetExtension;
    /**
     * @var string $cssPath Path to compiled css file.
     */
    private $cssPath;
    /**
     * @var string $jsPath Path to compiled js file.
     */
    private $jsPath;

    /**
     * AssetHelperExtension constructor.
     *
     * @param AssetExtension $assetExtension
     * @param string $cssPath Path to compiled css file.
     * @param string $jsPath Path to compiled js file.
     */
    public function __construct(AssetExtension $assetExtension, string $cssPath, string $jsPath)
    {
        $this
            ->setAssetExtension($assetExtension)
            ->setCssPath($cssPath)
            ->setJsPath($jsPath);
    }

    /**
     * Returns the asset extension.
     *
     * @return AssetExtension
     */
    public function getAssetExtension(): AssetExtension
    {
        return $this->assetExtension;
    }

    /**
     * @return string
     */
    public function getCssPath(): string
    {
        return $this->cssPath;
    }

    /**
     * Returns helping functions.
     *
     * @return Twig_SimpleFunction[]
     */
    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction(
                'output_css',
                new OutputCSSCallback($this->getAssetExtension(), $this->getCssPath()),
                ['is_safe' => ['html'], 'needs_context' => true]
            ),
            new Twig_SimpleFunction(
                'output_javascript',
                new OutputJavascriptCallback($this->getAssetExtension(), $this->getJsPath()),
                ['is_safe' => ['html'], 'needs_context' => true]
            )
        ];
    }

    /**
     * @return string
     */
    public function getJsPath(): string
    {
        return $this->jsPath;
    }

    /**
     * Returns the name of this extension.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'best_it_asset_helper';
    }

    /**
     * Returns the token parsers.
     *
     * @return Twig_TokenParser[]
     */
    public function getTokenParsers(): array
    {
        return [
            new IncludeAssets()
        ];
    }

    /**
     * Sets the asset extension.
     *
     * @param AssetExtension $assetExtension
     *
     * @return AssetHelperExtension
     */
    protected function setAssetExtension(AssetExtension $assetExtension): AssetHelperExtension
    {
        $this->assetExtension = $assetExtension;

        return $this;
    }

    /**
     * @param string $cssPath
     *
     * @return AssetHelperExtension
     */
    public function setCssPath(string $cssPath): AssetHelperExtension
    {
        $this->cssPath = $cssPath;
        return $this;
    }

    /**
     * @param string $jsPath
     *
     * @return AssetHelperExtension
     */
    public function setJsPath(string $jsPath): AssetHelperExtension
    {
        $this->jsPath = $jsPath;
        return $this;
    }
}
