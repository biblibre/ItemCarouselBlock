<?php
namespace ItemCarouselBlock\Site\BlockLayout;

use Laminas\View\Renderer\PhpRenderer;
use Omeka\Api\Representation\SitePageBlockRepresentation;

class Carousel extends AbstractCarousel
{
    public function getLabel(): string
    {
        return 'Item Carousel'; // @translate
    }

    public function getResourcesFromBlock(PhpRenderer $view, SitePageBlockRepresentation $block)
    {
        return $block->attachments();
    }
}
