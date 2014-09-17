jQuery(document).ready(function ($) {

    var initialImageWidth = $('#initialImage').width();

    var containerWidth = $('#pizzazz').width();

    $('div.pi-focus').css('min-width', initialImageWidth + 20 + 'px');

    if ((containerWidth - initialImageWidth) < 350) {
        $('div.pi-meta').css('width', '100%');
        $('div.pi-focus').css('width', '100%');
        $('div.pi-focus img').css('margin', '0 auto');
    }

    window.setTimeout(function () {

        if(!$('#pizzazz').hasClass('mobile')) {

            var main = $('div.pi-container');

            main.css('min-height', main.height() + 'px');

        }

    }, 1000);

    var setSliderThumbSize = function(){

        var carousel = $('div.carousel');

        if(carousel.length === 0) return;

        var width = 0;

        var height = 0;

        carousel.find('li').each(function(){

            width = ($(this).find('img').width() > width) ? $(this).find('img').width() : width;

            height = ($(this).find('img').height() > height) ? $(this).find('img').height() : height;

        });

        carousel.find('li').width(width).height(height);

    };

    setSliderThumbSize();

});

/*  TODO: Should refactor this if we build further */
var updateFocus = function (slideId) {
    var $ = jQuery;
    var i = 0;
    $($('#pi-main-pane div').get().reverse()).each(function (index) {
        var div = $(this);
        var fadeFocusIn = function () {
            var i = 0;
            var newSlide = $('#' + slideId + ' div');
            newSlide.each(function () {
                var myClone = $(this).clone();
                myClone.css('display', 'none').appendTo('#pi-main-pane');
                window.setTimeout(function () {
                    myClone.fadeIn(500)
                }, i);
                i += 500;
            });
        };
        window.setTimeout(function () {
            var deleteAndQueue = function () {
                $(this).remove();
                if (index === 1) {
                    fadeFocusIn();
                }
            };
            div.fadeOut(500, deleteAndQueue)
        }, i);
        i += 300;
    });
};