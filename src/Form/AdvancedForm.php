<?php

namespace ItemCarouselBlock\Form;

use Laminas\Form\Form;
use Laminas\Form\Element;

class AdvancedForm extends Form
{
    protected $options;

    public function __construct($name = null, $options = [])
    {
        parent::__construct($name);
        $this->options = $options;
    }

    public function init()
    {
        $this->add([
            'name' => 'o:block[__blockIndex__][o:data][showCaption]',
            'type' => Element\Checkbox::class,
            'options' => [
                'label' => 'Show attachment caption', // @translate
                'checked_value' => 'true',
                'unchecked_value' => 'false',
            ],
        ]);

        $this->add([
            'name' => 'o:block[__blockIndex__][o:data][floatCaption]',
            'type' => Element\Checkbox::class,
            'options' => [
                'label' => 'Overlay title/caption', // @translate
                'info' => 'Place title/caption over image (may require adjusting theme CSS text settings)', // @translate
                'checked_value' => 'true',
                'unchecked_value' => 'false',
            ],
        ]);

        $this->add([
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

        $this->add([
            'name' => 'o:block[__blockIndex__][o:data][slideCSSStretch]',
            'type' => Element\Select::class,
            'options' => [
                'label' => 'Stretch Image', // @translate
                'value_options' => [
                    'none' => 'None', // @translate
                    'width' => 'Fill width', // @translate
                    'height' => 'Fill height', // @translate
                    'entire' => 'Fill entire slide', // @translate
                ],
            ],
        ]);

        $this->add([
            'name' => 'o:block[__blockIndex__][o:data][autoSlideDuration]',
            'type' => Element\Text::class,
            'options' => [
                'label' => 'Auto slide duration', // @translate
                'info' => 'Time in milliseconds to pause before auto advance (set to 0 to turn off)', // @translate
            ],
        ]);

        $this->add([
            'name' => 'o:block[__blockIndex__][o:data][loop]',
            'type' => Element\Checkbox::class,
            'options' => [
                'label' => 'Infinite loop', // @translate
                'checked_value' => 'true',
                'unchecked_value' => 'false',
            ],
        ]);

        $this->add([
            'name' => 'o:block[__blockIndex__][o:data][fade]',
            'type' => Element\Checkbox::class,
            'options' => [
                'label' => 'Fade between slides', // @translate
                'info' => 'Note: only works with 1 item per slide', // @translate
                'checked_value' => 'true',
                'unchecked_value' => 'false',
            ],
            'attributes' => [
                'disabled' => $this->options['disabledFade'],
            ],
        ]);
    }
}
