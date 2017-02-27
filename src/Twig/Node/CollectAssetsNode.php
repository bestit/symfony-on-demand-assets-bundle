<?php

namespace BestIt\OnDemandAssetsBundle\Twig\Node;

use Twig_Compiler;
use Twig_Node;

/**
 * Creates a compiled php row in which the assets are saved and collected.
 * @author lange <lange@bestit-online.de>
 * @package BestIt\OnDemandAssetsBundle
 * @subpackage Twig\Node
 * @version $id$
 */
class CollectAssetsNode extends Twig_Node
{
    /**
     * CollectAssets constructor.
     * @param array $assets
     * @param int $line
     * @param string $tag
     */
    public function __construct(array $assets, int $line, string $tag)
    {
        parent::__construct([], ['assets' => $assets], $line, $tag);
    }

    /**
     * The method which writes the php code into the compiled template.
     * @param Twig_Compiler $compiler
     * @return void
     */
    public function compile(Twig_Compiler $compiler)
    {
        $compiler->write('$context["bh_assets"] = $this->getCollectedBHAssets($context);', "\n\n");
    }
}
