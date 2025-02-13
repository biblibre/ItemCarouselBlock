<?php
namespace ItemCarouselBlock\Site\BlockLayout;

use Laminas\Form\Form;
use Laminas\View\Renderer\PhpRenderer;
use Omeka\Api\Representation\SitePageBlockRepresentation;

class QuerierCarousel extends AbstractCarousel
{
    public function getLabel(): string
    {
        return 'Item Carousel based on query'; // @translate
    }

    protected function shouldIncludeAttachmentsButton(): bool
    {
        return false;
    }

    protected function getTemplate(): string
    {
        return 'common/block-layout/item-querier-carousel';
    }

    protected function getBasicForm(array $data): Form
    {
        $basicForm = parent::getBasicForm($data);

        $basicForm->add([
            'name' => 'o:block[__blockIndex__][o:data][query]',
            'type' => 'Omeka\Form\Element\Query',
            'options' => [
                'label' => 'Specify resources in query', //@translate
                'info' => 'Build or type a SQL query to select resources', //@translate
            ],
        ]);

        return $basicForm;
    }

    public function getResourcesFromBlock(PhpRenderer $view, SitePageBlockRepresentation $block)
    {
        $query = $block->dataValue('query');
        if (strlen($query) == 0) {
            return '';
        }
        parse_str($query, $queryArray);
        $api = $view->plugin('api');
        $items = $api->search('items', $queryArray)->getContent();
        return $items;
    }
}
