(function($) {
    var initResponsiveImage = function(domElement) {
        var heightRatio;

        heightRatio = $(domElement).data('height-ratio');

        if (heightRatio) {
            var resize;

            $(window).resize(resize = function() {
                var h = Math.round(heightRatio * $(window).height());
                $(domElement).css({
                    'height': h + 'px'
                });
            });

            resize();
        }

        // Load bigger image if big
        if ($(window).width() > 400) {
            var image;

            image = new Image();
            image.src = $(domElement).data('image-large');
            image.onload = function() {
                $(domElement).css({
                    'background-image': 'url('+image.src+')'
                });
            }
        }
    };

    $(document).ready(function() {
        $('.responsive-image').each(function() {
            var heightRatio;

            if ($(this).hasClass('home-poster'))
                heightRatio = 0.85;
            
            initResponsiveImage(this, heightRatio);
        });
        //var resImages = new ResponsiveImages();
    });
})(jQuery);
