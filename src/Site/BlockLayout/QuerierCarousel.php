<?php
namespace ItemCarouselBlock\Site\BlockLayout;

use Omeka\Api\Representation\SiteRepresentation;
use Omeka\Api\Representation\SitePageRepresentation;
use Omeka\Api\Representation\SitePageBlockRepresentation;
use Omeka\Site\BlockLayout\AbstractBlockLayout;
use Laminas\View\Renderer\PhpRenderer;
use ItemCarouselBlock\Form\BasicForm;
use ItemCarouselBlock\Form\AdvancedForm;

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
            'autoSlideDuration' => 0,
            'loop' => 'true',
            'fade' => 'false',
            'query' => '',
        ];

        $data = $block ? $block->data() + $defaults : $defaults;

        // disable fade if more than one item per page since it doesn't display correctly
        if ($data['perPage'] > 1) {
            $disabledFade = true;
            $fade = 'false';
        } else {
            $disabledFade = false;
            $fade = $data['fade'];
        }

        $basicForm = new BasicForm(null, ['queryMode' => true]);
        $advancedForm = new AdvancedForm(null, ['queryMode' => true, 'disabledFade' => $disabledFade]);
        $basicForm->init();
        $advancedForm->init();

        $basicForm->setData([
            'o:block[__blockIndex__][o:data][carouselHeading]' => $data['carouselHeading'],
            'o:block[__blockIndex__][o:data][perPage]' => $data['perPage'],
            'o:block[__blockIndex__][o:data][query]' => $data['query'],
        ]);
        $advancedForm->setData([
            'o:block[__blockIndex__][o:data][slideCSSTextAlign]' => $data['slideCSSTextAlign'],
            'o:block[__blockIndex__][o:data][slideCSSStretch]' => $data['slideCSSStretch'],
            'o:block[__blockIndex__][o:data][autoSlideDuration]' => $data['autoSlideDuration'],
            'o:block[__blockIndex__][o:data][loop]' => $data['loop'],
            'o:block[__blockIndex__][o:data][fade]' => $fade,
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
        if (strlen($query) > 0) {
            parse_str($query, $queryArray);
            // $queryArray['page'] = 1;
        }
        $resources = $api->search('items', $queryArray)->getContent();

        if (!$resources) {
            return '';
        }

        $thumbnailType = $block->dataValue('thumbnail_type', 'large');
        $showTitleOption = $block->dataValue('show_title_option', 'item_title');

        return $view->partial('common/block-layout/item-querier-carousel', [
            'blockID' => $block->id(),
            'resources' => $resources,
            'carouselHeading' => $block->dataValue('carouselHeading'),
            'perPage' => $block->dataValue('perPage'),
            'thumbnailType' => $thumbnailType,
            'showTitleOption' => $showTitleOption,
            'floatCaption' => $block->dataValue('floatCaption'),
            'slideCSSTextAlign' => $block->dataValue('slideCSSTextAlign'),
            'slideCSSStretch' => $block->dataValue('slideCSSStretch'),
            'autoSlideDuration' => $block->dataValue('autoSlideDuration'),
            'loop' => $block->dataValue('loop'),
            'fade' => $block->dataValue('fade'),
        ]);
    }
}
