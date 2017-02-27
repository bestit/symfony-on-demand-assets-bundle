<?php

namespace BestIt\OnDemandAssetsBundle\Twig\NodeModule;

use Twig_Compiler;
use Twig_Node;
use Twig_Node_Module;

/**
 * Compiles the asset methods into the "template-class".
 * @author lange <lange@bestit-online.de>
 * @package BestIt\OnDemandAssetsBundle
 * @subpackage Twig\NodeModule
 * @version $id$
 */
class CollectAssetsCompiler extends Twig_Node_Module
{
    /**
     * CollectAssetsCompiler constructor.
     * @param Twig_Node_Module $originalNode
     */
    public function __construct(Twig_Node_Module $originalNode)
    {
        Twig_Node::__construct(
            $originalNode->nodes,
            $originalNode->attributes,
            $originalNode->lineno,
            $originalNode->tag
        );
    }

    /**
     * Adds the new api to the compiled class footer.
     * @param Twig_Compiler $compiler
     * @return void
     */
    protected function compileClassFooter(Twig_Compiler $compiler)
    {
        $this->compileCollectDataMethod($compiler);

        parent::compileClassFooter($compiler);
    }

    /**
     * Adds the new api to the compiled class footer.
     * @param Twig_Compiler $compiler
     * @return void
     */
    protected function compileCollectDataMethod(Twig_Compiler $compiler)
    {
        $assets = $this->getAttribute('bh_assets');
        $includes = $this->getAttribute('bh_includes_for_assets');

        $compiler
            ->write("\n", 'public function getCollectedBHAssets(array $context)', "\n", "{\n")
            ->indent()
            ->write('$data = ')
            ->repr($assets)
            ->raw(";\n");

        $compiler
            ->write('if (isset($context["bh_assets"])) {', "\n")
            ->indent()
            ->write('$data = array_merge($data, $context["bh_assets"]);', "\n")
            ->outdent()
            ->write("}\n");

        array_walk($includes, function ($includedTemplate) use ($compiler) {
            // BSL: Dirty hack to use embed; TODO: Still no real functionality for the assets
            if ($includedTemplate !== 'not_used') {
                $compiler
                    ->write("\n", '$data = array_merge($data, $this->env->loadTemplate(')
                    ->repr($includedTemplate)
                    ->raw(')->getCollectedBHAssets($context));')
                    ->raw("\n");
            }
        });

        $compiler
            ->raw("\n")
            ->write('return array_unique($data);', "\n")
            ->outdent()
            ->write("}\n");
    }
}
