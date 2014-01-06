(function($) {
    var init = function() {
        /* setting mobile menu from current menu */
        /* 
         * probabply move this inside if statement for
         * viewport with later on
         */
        if ($('.home-navigation').length > 0) {
            renderMobileMenu('.home-navigation ul');
        }
        else if ($('.allpage').length > 0) {
            renderMobileMenu('.allpage ul');
        }
        frontpageSpecific();
        bindMenuEvents();
    }
    var bindMenuEvents = function() {
        $('.mobile-menu').on('click touchstart', function(e) {
            e.stopPropagation();
            e.preventDefault();
            if (e.allreadyFired !== true) {
                e.allreadyFired = true;
                $('.mobile-home-nav').slideToggle();
                return false;
            }
            else {
                return false;
            }
        });
    }
    var renderMobileMenu = function(menuSelector) {
        var ul = $(menuSelector).clone();
        ul.attr('id', ul.attr('id')+'-mobile');
        ul.append($('.right.corner li').clone().addClass('mobile-menu-secondary'));
        $('.header').after($('<div class="mobile-home-nav"></div>').append(ul));
    }
    var frontpageSpecific = function() {
        /* if front page make space above mobile menu for logo */
        if ($('.home').length > 0) {
            var h = $('.header').height();
            console.log('found home', h);
            $('.mobile-home-nav').css({
                'padding-top': h + 'px'
            });
        }
    }

    $(function() {
        init();
    });

})(jQuery)
