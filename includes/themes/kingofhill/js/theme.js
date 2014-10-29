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

    var twitter = function(){
        !function(d,s,id) {
            var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';
            if(!d.getElementById(id)){
                js=d.createElement(s);
                js.id=id;
                js.src=p+'://platform.twitter.com/widgets.js';
                fjs.parentNode.insertBefore(js,fjs);
            }
        }(document, 'script', 'twitter-wjs');
    };

    var facebook = function(){
        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    };

    var gplus = function(){
        (function() {
            var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
            po.src = 'https://apis.google.com/js/platform.js';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(po, s);
        })();
    };

    twitter();
    facebook();
    gplus();

    var setSliderThumbSize = function(){
        var carousel = $('div.carousel');
        if(carousel.length === 0) return;
        var width = 0;
        var height = 0;
        carousel.find('li').each(function(){
            var image = $(this).find('img');
            width = (image.width() > width) ? image.width() : width;
            height = (image.height() > height) ? image.height() : height;
        });
        carousel.find('li').width(width).height(height)
            .find('a').width(width).height(height);
    };

    window.setTimeout(setSliderThumbSize, 50);

    var setCustomFieldSize = function(){
        var customLabel = $('.pz-custom-label');
        customLabel.css('min-width', 0);
        var minWidth = 0;
        customLabel.each(function(){
            var width = $(this).width();
            if(width > minWidth){
                minWidth = width;
            }
        });
        customLabel.css('min-width', minWidth + 5);
    };

    setCustomFieldSize();

});

/*  TODO: Should refactor this if we build further */
var updateFocus = function (slideId) {
    var $ = jQuery;
    var i = 0;
    $($('#pi-main-pane > div').get().reverse()).each(function (index) {
        var div = $(this);
        var fadeFocusIn = function () {
            var i = 0;
            var newSlide = $('#' + slideId + ' > div');
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

var launchFeatherLight = function(id){
    var $ = jQuery;
    $(id).width('640');
    $(id).height('360');
    $.featherlight($(id), { closeIcon: ''});
};

jQuery(document).ready(function ($) {

    var width = $('div.pi-container').width();

    var thumbs = 5;
    if (width < 935) {
        thumbs = 4;
    }
    if (width < 800) {
        thumbs = 3;
    }

    var thumbsCount = $('.carousel li').length;

    if(thumbsCount < thumbs) {
        $('#carouselControlsAbove').hide();
        $('.carouselControls').hide();
        $(".carousel").jCarouselLite({
            btnNext: "",
            btnPrev: "",
            circular: false,
            visible: thumbsCount
        });
    } else {
        $('#carouselControlsAbove').show();
        $('.carouselControls').show();
        $(".carousel").jCarouselLite({
            btnNext: ".next",
            btnPrev: ".prev",
            visible: thumbs
        });
    }

    var centerCarousel = function(){
        var totalWidth = 0;
        $('.carousel').each(function(){
            totalWidth += $(this).width();
        });
        if(totalWidth !== 0) {
            $('#carouselWrapper').css('width', totalWidth);
        }
    };

    centerCarousel();

});
