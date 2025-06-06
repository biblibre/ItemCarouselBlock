<?php
namespace ItemCarouselBlock\Site\BlockLayout;

use Omeka\Api\Representation\SiteRepresentation;
use Omeka\Api\Representation\SitePageRepresentation;
use Omeka\Api\Representation\SitePageBlockRepresentation;
use Omeka\Site\BlockLayout\AbstractBlockLayout;
use Laminas\View\Renderer\PhpRenderer;
use Laminas\Form\Element;
use Laminas\Form\Form;
use Omeka\Form\Element\Query;

class QuerierCarousel extends AbstractBlockLayout
{
    public function getLabel()
    {
        return 'Item Carousel based on query'; // @translate
    }

    public function form(PhpRenderer $view, SiteRepresentation $site,
        SitePageRepresentation $page = null, SitePageBlockRepresentation $block = null
    ) {
        $defaults = [
            'carouselHeading' => '',
            'perPage' => 1,
            'slideCSSTextAlign' => 'center',
            'slideCSSStretch' => 'none',
            'breakPoint' => 820,
            'autoSlideDuration' => 0,
            'loop' => 'true',
            'fade' => 'false',
            'query' => '',
            'minResources' => 0,
            'maxResources' => 5,
        ];

        $data = $block ? $block->data() + $defaults : $defaults;

        $basicForm = new Form();
        $advancedForm = new Form();

        $basicForm->add([
            'name' => 'o:block[__blockIndex__][o:data][carouselHeading]',
            'type' => Element\Text::class,
            'options' => [
                'label' => 'Carousel title', // @translate
            ],
        ]);

        $basicForm->add([
            'name' => 'o:block[__blockIndex__][o:data][query]',
            'type' => Query::class,
            'options' => [
                'label' => 'Specify resources in query', //@translate
                'info' => 'Build or type a SQL query to select resources', //@translate
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

        $advancedForm->add([
            'name' => 'o:block[__blockIndex__][o:data][slideCSSTextAlign]',
            'type' => Element\Select::class,
            'options' => [
                'label' => 'Text align', // @translate
                'value_options' => [
                    'left' => 'Left', // @translate
                    'center' => 'Center', // @translate
                    'right' => 'Right', // @translate
                ],
            ],
        ]);

        $advancedForm->add([
            'name' => 'o:block[__blockIndex__][o:data][slideCSSStretch]',
            'type' => Element\Select::class,
            'options' => [
                'label' => 'Stretch image', // @translate
                'value_options' => [
                    'none' => 'None', // @translate
                    'width' => 'Fill width', // @translate
                    'height' => 'Fill height', // @translate
                    'entire' => 'Fill entire slide', // @translate
                ],
            ],
        ]);

        $advancedForm->add([
            'name' => 'o:block[__blockIndex__][o:data][breakPoint]',
            'type' => Element\Text::class,
            'options' => [
                'label' => 'Breakpoint', // @translate
                'info' => 'Display one item per slide when carousel width drops below given pixel width. Adjust for mobile display, carousels with many items per page, etc.', // @translate
            ],
        ]);

        $advancedForm->add([
            'name' => 'o:block[__blockIndex__][o:data][autoSlideDuration]',
            'type' => Element\Text::class,
            'options' => [
                'label' => 'Auto slide duration', // @translate
                'info' => 'Time in milliseconds to pause before auto advance (set to 0 to turn off)', // @translate
            ],
        ]);

        $advancedForm->add([
            'name' => 'o:block[__blockIndex__][o:data][loop]',
            'type' => Element\Checkbox::class,
            'options' => [
                'label' => 'Infinite loop', // @translate
                'checked_value' => 'true',
                'unchecked_value' => 'false',
            ],
        ]);

        // disable fade if more than one item per page since it doesn't display correctly
        if ($data['perPage'] > 1) {
            $disabledFade = true;
            $fade = 'false';
        } else {
            $disabledFade = false;
            $fade = $data['fade'];
        }

        $advancedForm->add([
            'name' => 'o:block[__blockIndex__][o:data][fade]',
            'type' => Element\Checkbox::class,
            'options' => [
                'label' => 'Fade between slides', // @translate
                'info' => 'Note: only works with 1 item per slide', // @translate
                'checked_value' => 'true',
                'unchecked_value' => 'false',
            ],
            'attributes' => [
                'disabled' => $disabledFade,
            ],
        ]);

        $advancedForm->add([
            'name' => 'o:block[__blockIndex__][o:data][minResources]',
            'type' => Element\Number::class,
            'options' => [
                'label' => 'Minimal number of resources to display carousel', // @translate
            ],
            'attributes' => [
                'required' => true,
                'min' => 0,
            ],
        ]);

        $advancedForm->add([
            'name' => 'o:block[__blockIndex__][o:data][maxResources]',
            'type' => Element\Number::class,
            'options' => [
                'label' => 'Maximum number of resources to display carousel', // @translate
            ],
            'attributes' => [
                'required' => true,
                'min' => 0,
            ],
        ]);

        $basicForm->setData([
            'o:block[__blockIndex__][o:data][carouselHeading]' => $data['carouselHeading'],
            'o:block[__blockIndex__][o:data][perPage]' => $data['perPage'],
            'o:block[__blockIndex__][o:data][query]' => $data['query'],
        ]);
        $advancedForm->setData([
            'o:block[__blockIndex__][o:data][slideCSSTextAlign]' => $data['slideCSSTextAlign'],
            'o:block[__blockIndex__][o:data][slideCSSStretch]' => $data['slideCSSStretch'],
            'o:block[__blockIndex__][o:data][breakPoint]' => $data['breakPoint'],
            'o:block[__blockIndex__][o:data][autoSlideDuration]' => $data['autoSlideDuration'],
            'o:block[__blockIndex__][o:data][loop]' => $data['loop'],
            'o:block[__blockIndex__][o:data][fade]' => $fade,
            'o:block[__blockIndex__][o:data][minResources]' => $data['minResources'],
            'o:block[__blockIndex__][o:data][maxResources]' => $data['maxResources'],
        ]);
        $basicForm->prepare();
        $advancedForm->prepare();

        $html = '';
        $html .= $view->formCollection($basicForm);
        $html .= '<a href="#" class="expand" aria-label="expand"><h4>' . $view->translate('Advanced Options') . '</h4></a>';
        $html .= '<div class="collapsible">';
        $html .= $view->blockThumbnailTypeSelect($block);
        $html .= $view->blockShowTitleSelect($block);
        $html .= $view->formCollection($advancedForm);
        $html .= '</div>';
        return $html;
    }

    public function render(PhpRenderer $view, SitePageBlockRepresentation $block)
    {
        $query = $block->dataValue('query');
        $api = $view->plugin('api');
        $queryArray = [];
        if (!empty($query)) {
            parse_str($query, $queryArray);
        }
        $queryArray['limit'] = $block->dataValue('maxResources');
        $resources = $api->search('items', $queryArray)->getContent();

        $thumbnailType = $block->dataValue('thumbnail_type', 'large');
        $showTitleOption = $block->dataValue('show_title_option', 'item_title');
        if (!empty($resources) && (count($resources) >= $block->dataValue('minResources'))) {
            return $view->partial('common/block-layout/item-querier-carousel', [
            'blockID' => $block->id(),
            'resources' => $resources,
            'carouselHeading' => $block->dataValue('carouselHeading'),
            'perPage' => $block->dataValue('perPage'),
            'thumbnailType' => $thumbnailType,
            'showTitleOption' => $showTitleOption,
            'slideCSSTextAlign' => $block->dataValue('slideCSSTextAlign'),
            'slideCSSStretch' => $block->dataValue('slideCSSStretch'),
            'breakPoint' => $block->dataValue('breakPoint'),
            'autoSlideDuration' => $block->dataValue('autoSlideDuration'),
            'loop' => $block->dataValue('loop'),
            'fade' => $block->dataValue('fade'),
        ]);
        }
    }
}
