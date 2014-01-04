(function($) {
    var ResponsiveImages = function() {
        this.loadedIndex = 0;
        this.viewport = $(window).width();
        // add viewport map?
        this.init();
    }
    ResponsiveImages.prototype.init = function() {
        this.images = $('.responsive-image');
        // right now ipad user get big images
        if (this.viewport > 400) {
            if (this.images.length > 0) {
                this.load();
            }
        }
    }
    ResponsiveImages.prototype.load = function() {
        if (this.loadedIndex < this.images.length) {
            var image = new Image();
            image.src = $(this.images[this.loadedIndex]).data('image-large');
            image.onload = function() {
                $(this.images[this.loadedIndex]).css({
                    'background-image': 'url('+image.src+')'
                });
                this.loadedIndex++;
                this.load();
            }.bind(this)
        }
    }

    $(document).ready(function() {
        var resImages = new ResponsiveImages();
    });
})(jQuery);
