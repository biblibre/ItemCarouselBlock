<?php
namespace ItemCarouselBlock\Site\BlockLayout;

<<<<<<< Updated upstream
use Laminas\View\Renderer\PhpRenderer;
use Omeka\Api\Representation\SitePageBlockRepresentation;
=======
use Omeka\Api\Representation\SiteRepresentation;
use Omeka\Api\Representation\SitePageRepresentation;
use Omeka\Api\Representation\SitePageBlockRepresentation;
use Omeka\Site\BlockLayout\AbstractBlockLayout;
use Laminas\View\Renderer\PhpRenderer;
use ItemCarouselBlock\Form\BasicForm;
use ItemCarouselBlock\Form\AdvancedForm;
>>>>>>> Stashed changes

class Carousel extends AbstractCarousel
{
    public function getLabel(): string
    {
        return 'Item Carousel'; // @translate
    }

<<<<<<< Updated upstream
    public function getResourcesFromBlock(PhpRenderer $view, SitePageBlockRepresentation $block)
=======
    public function form(PhpRenderer $view, SiteRepresentation $site,
        SitePageRepresentation $page = null, SitePageBlockRepresentation $block = null
    ) {
        $defaults = [
            'carouselHeading' => '',
            'perPage' => 1,
            'showCaption' => 'false',
            'floatCaption' => 'false',
            'slideCSSTextAlign' => 'center',
            'slideCSSStretch' => 'none',
            'autoSlideDuration' => 0,
            'loop' => 'true',
            'fade' => 'false',
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

        $basicForm = new BasicForm();
        $advancedForm = new AdvancedForm(null, ['disabledFade' => $disabledFade]);

        $basicForm->setData([
            'o:block[__blockIndex__][o:data][carouselHeading]' => $data['carouselHeading'],
            'o:block[__blockIndex__][o:data][perPage]' => $data['perPage'],
        ]);
        $advancedForm->setData([
            'o:block[__blockIndex__][o:data][showCaption]' => $data['showCaption'],
            'o:block[__blockIndex__][o:data][floatCaption]' => $data['floatCaption'],
            'o:block[__blockIndex__][o:data][slideCSSTextAlign]' => $data['slideCSSTextAlign'],
            'o:block[__blockIndex__][o:data][slideCSSStretch]' => $data['slideCSSStretch'],
            'o:block[__blockIndex__][o:data][autoSlideDuration]' => $data['autoSlideDuration'],
            'o:block[__blockIndex__][o:data][loop]' => $data['loop'],
            'o:block[__blockIndex__][o:data][fade]' => $fade,
        ]);
        $basicForm->prepare();
        $advancedForm->prepare();

        $html = '';
        $html .= $view->blockAttachmentsForm($block);
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
>>>>>>> Stashed changes
    {
        return $block->attachments();
    }
}
