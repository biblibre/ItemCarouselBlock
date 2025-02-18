function initializeCarousel(carouselId, options) {
    const $carousel = $(`.${carouselId}`);

    const baseConfig = {
        slidesToShow: options.perPage || 1,
        slidesToScroll: 1,
        infinite: options.loop || false,
        draggable: true,
        pauseOnHover: true,
        centerMode: false,
        arrows: true,
        dots: true,
        adaptiveHeight: true
    };

    if (options.fade) {
        baseConfig.fade = options.fade;
    }

    if (options.autoSlideDuration > 0) {
        baseConfig.autoplay = true;
        baseConfig.autoplaySpeed = options.autoSlideDuration;
    }

    $carousel.slick(baseConfig);

    applyCarouselStyles(carouselId, options);
}

function applyCarouselStyles(carouselId, options) {
    const $carousel = $(`.${carouselId}`);

    $carousel.find('.slick-slide').css({
        'text-align': options.slideCSSTextAlign || 'left'
    });

    switch (options.slideCSSStretch) {
        case 'width':
            $carousel.find('.slick-slide > div').css({
                width: '100%'
            });
            $carousel.find('.slick-slide img').css({
                width: '100%',
                'object-fit': 'cover'
            });
            break;

        case 'height':
            $carousel.find('.slick-slide > div').css({
                height: '100%'
            });
            $carousel.find('.slick-slide img').css({
                height: '100%',
                'object-fit': 'cover'
            });
            break;

        case 'entire':
            $carousel.find('.slick-slide > div').css({
                width: '100%',
                height: '100%'
            });
            $carousel.find('.slick-slide img').css({
                width: '100%',
                height: '100%',
                'object-fit': 'cover'
            });
            break;
    }
    if (options.floatCaption) {
        $carousel.find('.slick-slide > div').css({
            position: 'relative'
        });
        $carousel.find('.slick-slide .slide-text').css({
            position: 'absolute',
            top: '50%',
            width: '100%'
        });
    }

    if (options.thumbnailType !== 'large') {
        $carousel.find('.slick-track .slick-slide').css({
            'align-items': 'center'
        });
    }

    if (options.perPage > 1) {
        $carousel.find('.slick-track').css({
            'align-items': 'center'
        });
    }
}