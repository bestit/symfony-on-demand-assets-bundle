<?php

namespace BestIt\OnDemandAssetsBundle\Twig;

use BestIt\OnDemandAssetsBundle\Twig\NodeVisitor\CollectAssetsNodeVisitor;
use BestIt\OnDemandAssetsBundle\Twig\SimpleFunction\OutputCSSCallback;
use BestIt\OnDemandAssetsBundle\Twig\SimpleFunction\OutputJavascriptCallback;
use BestIt\OnDemandAssetsBundle\Twig\TokenParser\ExtendsWithAssets;
use BestIt\OnDemandAssetsBundle\Twig\TokenParser\IncludeAssets;
use Symfony\Bridge\Twig\Extension\AssetExtension;
use Twig_BaseNodeVisitor;
use Twig_Extension;
use Twig_SimpleFunction;
use Twig_TokenParser;

/**
 * Adds some functions and tags to collect assets in child templates.
 * @author lange <lange@bestit-online.de>
 * @package BestIt\OnDemandAssetsBundle
 * @subpackage Twig
 * @version $id$
 */
class AssetHelperExtension extends Twig_Extension
{
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
     * Returns the asset extension.
     * @return AssetExtension
     */
    public function getAssetExtension(): AssetExtension
    {
        return $this->assetExtension;
    }

    /**
     * Returns helping functions.
     * @return Twig_SimpleFunction[]
     */
    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction(
                'output_css',
                new OutputCSSCallback($this->getAssetExtension()),
                ['is_safe' => ['html'], 'needs_context' => true]
            ),
            new Twig_SimpleFunction(
                'output_javascript',
                new OutputJavascriptCallback($this->getAssetExtension()),
                ['is_safe' => ['html'], 'needs_context' => true]
            )
        ];
    }

    /**
     * Returns the name of this extension.
     * @return string
     */
    public function getName(): string
    {
        return 'bh_asset_helper';
    }

    /**
     * Returns the node visitors.
     * @return Twig_BaseNodeVisitor[]
     */
    public function getNodeVisitors(): array
    {
        return [new CollectAssetsNodeVisitor()];
    }

    /**
     * Returns the token parsers.
     * @return Twig_TokenParser[]
     */
    public function getTokenParsers(): array
    {
        return [
            new ExtendsWithAssets(),
            new IncludeAssets()
        ];
    }

    /**
     * Sets the asset extension.
     * @param AssetExtension $assetExtension
     * @return AssetHelperExtension
     */
    protected function setAssetExtension(AssetExtension $assetExtension): AssetHelperExtension
    {
        $this->assetExtension = $assetExtension;

        return $this;
    }
}
