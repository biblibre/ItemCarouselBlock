<?php
namespace ItemCarouselBlock\Site\BlockLayout;

use Laminas\Form\Element;
use Laminas\Form\Form;
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
