<?php

namespace BestIt\OnDemandAssetsBundle\Twig\SimpleFunction;

/**
 * Outputs the css files.
 *
 * @author lange <lange@bestit-online.de>
 * @package BestIt\OnDemandAssetsBundle
 * @subpackage Twig\SimpleFunction
 * @version $id$
 */
class OutputCSSCallback
{
    use CallbackTrait, OutputTrait;

    /**
     * Returns the allowed file ending.
     *
     * @return string
     */
    protected function getAllowedFileEnding(): string
    {
        return 'css';
    }

    /**
     * Returns the asset include template.
     *
     * @return string
     */
    protected function getAssetIncludeTemplate(): string
    {
        return '<link rel="stylesheet" href="%s"/>';
    }
}
