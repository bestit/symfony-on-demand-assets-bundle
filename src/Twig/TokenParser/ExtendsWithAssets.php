<?php

namespace BestIt\OnDemandAssetsBundle\Twig\TokenParser;

use BestIt\OnDemandAssetsBundle\Twig\Node\CollectAssetsNode;
use Twig_Token;
use Twig_TokenParser_Extends;

/**
 * The assets are not collected between template<->block<->extends<->template wihtout the include_tag, so force it!
 * @author lange <lange@bestit-online.de>
 * @package BestIt\OnDemandAssetsBundle
 * @subpackage Twig\TokenParser
 * @todo Remove this. But did not found another solution than this and adding an additional tag for every template.
 * @version $id$
 */
class ExtendsWithAssets extends Twig_TokenParser_Extends
{
    /**
     * Parses the token.
     * @param Twig_Token $token
     * @return CollectAssetsNode
     */
    public function parse(Twig_Token $token)
    {
        parent::parse($token);

        return new CollectAssetsNode([], $token->getLine(), $this->getTag());
    }
}
