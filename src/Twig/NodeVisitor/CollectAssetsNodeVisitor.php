<?php

namespace BestIt\OnDemandAssetsBundle\Twig\NodeVisitor;

use BestIt\OnDemandAssetsBundle\Twig\Node\CollectAssetsNode;
use BestIt\OnDemandAssetsBundle\Twig\NodeModule\CollectAssetsCompiler;
use Twig_BaseNodeVisitor;
use Twig_Environment;
use Twig_Node;
use Twig_Node_Include;
use Twig_Node_Module;

/**
 * Iterates over nodes and collects the assets.
 * @author lange <lange@bestit-online.de>
 * @package BestIt\OnDemandAssetsBundle
 * @subpackage Twig\NodeModule
 * @version $id$
 */
class CollectAssetsNodeVisitor extends Twig_BaseNodeVisitor
{
    /**
     * The collected assets.
     * @var array
     */
    protected $collectedAssets = [];

    /**
     * The found includes in this node.
     * @var array
     */
    protected $includes = [];

    /**
     * Adds some assets to collect.
     * @param array $assets
     * @return CollectAssetsNodeVisitor
     */
    protected function addAssets(array $assets): CollectAssetsNodeVisitor
    {
        $this->collectedAssets = array_unique(array_merge($this->collectedAssets, $assets));

        return $this;
    }

    /**
     * Called before child nodes are visited.
     * @param Twig_Node $node The node to visit
     * @param Twig_Environment $env The Twig environment instance
     * @return Twig_Node The modified node
     */
    protected function doEnterNode(Twig_Node $node, Twig_Environment $env): Twig_Node
    {
        if ($node instanceof CollectAssetsNode) {
            $this->addAssets($node->getAttribute('assets'));
        }

        if ($node instanceof Twig_Node_Include) {
            $this->includes[] = $node->getNode('expr')->getAttribute('value');
        }

        return $node;
    }

    /**
     * Called after child nodes are visited.
     *
     * @param Twig_Node $node The node to visit
     * @param Twig_Environment $env The Twig environment instance
     *
     * @return Twig_Node|false The modified node or false if the node must be removed
     */
    protected function doLeaveNode(Twig_Node $node, Twig_Environment $env): Twig_Node
    {
        if ($node instanceof Twig_Node_Module) {
            $node->setAttribute('bh_assets', $this->getCollectedAssets());
            $node->setAttribute('bh_includes_for_assets', $this->getIncludes());

            $node = new CollectAssetsCompiler($node);

            $this->resetIncludes();
        }

        return $node;
    }

    /**
     * Returns the collected assets.
     * @return array
     */
    protected function getCollectedAssets(): array
    {
        return $this->collectedAssets;
    }

    /**
     * Returns the collected includes.
     * @return array
     */
    protected function getIncludes(): array
    {
        return $this->includes;
    }

    /**
     * Returns the priority for this visitor.
     *
     * Priority should be between -10 and 10 (0 is the default).
     *
     * @return int The priority level
     */
    public function getPriority(): int
    {
        return 0;
    }

    /**
     * Resets the found includes.
     * @return CollectAssetsNodeVisitor
     */
    protected function resetIncludes(): CollectAssetsNodeVisitor
    {
        $this->includes = [];

        return $this;
    }
}
