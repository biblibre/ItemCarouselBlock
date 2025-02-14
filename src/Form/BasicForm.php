<?php

namespace ItemCarouselBlock\Form;

use Laminas\Form\Form;
use Laminas\Form\Element;
use Omeka\Form\Element\Query;

class BasicForm extends Form
{
    public function init()
    {
        if ($this->getOption('queryMode')) {
            $this->add([
            'name' => 'o:block[__blockIndex__][o:data][query]',
            'type' => Query::class,
            'options' => [
                'label' => 'Specify resources in query', //@translate
                'info' => 'Build or type a SQL query to select resources', //@translate
            ],
        ]);
        }

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
