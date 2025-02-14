<?php

namespace ItemCarouselBlock\Form;

use Laminas\Form\Form;
use Laminas\Form\Element;

class BasicForm extends Form
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
            'name' => 'o:block[__blockIndex__][o:data][carouselHeading]',
            'type' => Element\Text::class,
            'options' => [
                'label' => 'Carousel title', // @translate
            ],
        ]);

        $this->add([
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
    }
}