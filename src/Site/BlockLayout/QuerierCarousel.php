<?php
namespace ItemCarouselBlock\Site\BlockLayout;

use Laminas\Form\Element;
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
        $basicForm = new Form();

        $basicForm->add([
            'name' => 'o:block[__blockIndex__][o:data][query]',
            'type' => 'Omeka\Form\Element\Query',
            'options' => [
                'label' => 'Specify resources in query', //@translate
                'info' => 'Build or type a SQL query to select resources', //@translate
            ],
        ]);

        $basicForm->add([
            'name' => 'o:block[__blockIndex__][o:data][carouselHeading]',
            'type' => Element\Text::class,
            'options' => [
                'label' => 'Carousel title', // @translate
            ],
        ]);

        $basicForm->add([
            'name' => 'o:block[__blockIndex__][o:data][perPage]',
            'type' => Element\Number::class,
            'options' => [
                'label' => 'Items per slide', // @translate
                'info' => 'The number of items shown per carousel slide', // @translate
            ],
            'attributes' => [
                'min' => 1,
                'max' => 10,
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
