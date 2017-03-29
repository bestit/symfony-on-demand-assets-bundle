<?php

namespace BestIt\OnDemandAssetsBundle\Twig\SimpleFunction;

/**
 * Outputs the javascript files.
 *
 * @author lange <lange@bestit-online.de>
 * @package BestIt\OnDemandAssetsBundle
 * @subpackage Twig\SimpleFunction
 * @version $id$
 */
class OutputJavascriptCallback
{
    use CallbackTrait, OutputTrait;

    /**
     * Returns the allowed file ending.
     *
     * @return string
     */
    protected function getAllowedFileEnding(): string
    {
        return 'js';
    }

    /**
     * Returns the asset include template.
     *
     * @return string
     */
    protected function getAssetIncludeTemplate(): string
    {
        return '<script src="%s" type="text/javascript"></script>';
    }
}
