<?php

namespace BestIt\OnDemandAssetsBundle\Twig\TokenParser;

use BestIt\OnDemandAssetsBundle\Twig\Node\CollectAssetsNode;
use Twig_Token;
use Twig_TokenParser;

/**
 * Parses the tag include_assets and inserts it to the compiled node.
 * @author lange <lange@bestit-online.de>
 * @package BestIt\OnDemandAssetsBundle
 * @subpackage Twig\TokenParser
 * @version $id$
 */
class IncludeAssets extends Twig_TokenParser
{
    /**
     * Parses the tag.
     * @param Twig_Token $token
     * @return CollectAssetsNode
     */
    public function parse(Twig_Token $token): CollectAssetsNode
    {
        $assets = [];
        $stream = $this->parser->getStream();

        while (!$stream->test(Twig_Token::BLOCK_END_TYPE)) {
            $assets[] = $stream->expect(Twig_Token::STRING_TYPE)->getValue();
        }

        $stream->expect(Twig_Token::BLOCK_END_TYPE);

        return new CollectAssetsNode($assets, $token->getLine(), $this->getTag());
    }

    /**
     * Returns the tag name.
     * @return string
     */
    public function getTag(): string
    {
        return 'include_assets';
    }
}
