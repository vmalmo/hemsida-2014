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

        initHomeVideo();
    }

    var initHomeVideo = function() {
        if (document.getElementById('home-video')) {
            var ctr, tag, firstScriptTag;
            
            tag = document.createElement('script');

            tag.src = "http://www.youtube.com/iframe_api";
            firstScriptTag = document.getElementsByTagName('script')[0];
            firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

            ctr = document.createElement('div');
            ctr.id = 'home-video-player';
            document.getElementById('home-video').appendChild(ctr);

            window.onYouTubeIframeAPIReady = function() {
                var player, iframe, onStateChange, playBtn;

                playBtn = document.createElement('a');
                $(playBtn).addClass('play-btn');
                $(playBtn).fadeIn();
                document.getElementById('home-video').appendChild(playBtn);

                onStateChange = function(ev) {
                    if (ev.data == YT.PlayerState.ENDED || ev.data == YT.PlayerState.PAUSED) {
                        hideVideo();
                    }
                    else if (ev.data == YT.PlayerState.PLAYING) {
                        showVideo();
                    }
                };

                player = new YT.Player('home-video-player', {
                    'width': '100%',
                    'height': '100%',
                    'videoId': $('#home-video').data('youtube-id'), 
                    'playerVars': {
                        'hd': 1,
                        'rel': 0,
                        'autohide': 1,
                        'showinfo': 0,
                        'controls': 0
                    },
                    'events': {
                        'onStateChange': onStateChange
                    }
                });

                iframe = document.getElementById('home-video-player');

                var showVideo = function() {
                    $(iframe).fadeIn();
                    $(playBtn).hide();
                };

                var hideVideo = function() {
                    $(iframe).fadeOut();
                    $(playBtn).show();
                };

                $(playBtn).click(function() {
                    $(playBtn).fadeOut();
                    player.seekTo(0);
                    player.playVideo();
                });
            };
        }
    };

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
