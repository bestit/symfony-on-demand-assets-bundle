<?php

namespace BestIt\OnDemandAssetsBundle\Twig\SimpleFunction;

/**
 * Helps to output the assets.
 *
 * @author lange <lange@bestit-online.de>
 * @package BestIt\OnDemandAssetsBundle
 * @subpackage Twig\SimpleFunction
 * @version $id$
 */
trait OutputTrait
{
    /**
     * Which files were already outputted.
     *
     * @var array
     */
    protected $outputtedFiles = [];

    /**
     * Adds a file to the check-cache.
     *
     * @param string $file
     *
     * @return OutputTrait
     */
    protected function addToOutputtedFiles(string $file)
    {
        $this->outputtedFiles[$file] = true;

        return $this;
    }

    /**
     * Is the given file already outputted?
     *
     * @param string $file
     *
     * @return bool
     */
    protected function isFileOutputted(string $file)
    {
        return $this->outputtedFiles[$file] ?? false;
    }
}
