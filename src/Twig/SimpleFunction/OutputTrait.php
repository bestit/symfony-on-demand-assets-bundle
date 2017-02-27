<?php

namespace BestIt\OnDemandAssetsBundle\Twig\SimpleFunction;

trait OutputTrait
{
    /**
     * Which files were allready outputted.
     * @var array
     */
    protected $outputtedFiles = [];

    /**
     * Adds a file to the check-cache.
     * @param string $file
     * @return OutputTrait
     */
    protected function addToOutputtedFiles(string $file)
    {
        $this->outputtedFiles[$file] = true;

        return $this;
    }

    /**
     * Is the given file allready outputted?
     * @param string $file
     * @return bool
     */
    protected function isFileOutputted(string $file)
    {
        return $this->outputtedFiles[$file] ?? false;
    }
}
