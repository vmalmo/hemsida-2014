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
        initMarquees();
        // run infinite scroll only on contact and calendare
        if ($('#calendar-list').length > 0) {
          var infiniteScroll = new vm14.InfiniteScroll('calendar_event', '#calendar-list');
        }
        if ($('#contact-list').length > 0){
          var infiniteScroll = new vm14.InfiniteScroll('contact_person', '#contact-list');
        }
    }

    var initMarquees = function() {
        $('.cycling-marquee').each(function() {
            var marquee = $(this),
                cur_idx = 0,
                children;

            children = marquee.children();
            children.hide();

            children.eq(0).fadeIn();

            setInterval(function() {
                children.eq(cur_idx).fadeOut(400);
                cur_idx++;
                if (cur_idx >= children.length)
                    cur_idx = 0;

                children.eq(cur_idx).delay(400).fadeIn();
            }, 5000);
        });
    };

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
                var player, iframe, onStateChange, playBtn, hasPlayed;

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

                var updateSize = function() {
                    var w, h;

                    w = $(iframe).parent().width() + 16;
                    h = $(iframe).parent().height() + 9;

                    if (w/16 > h/9) {
                        h = Math.ceil(w/16*9);
                    }
                    else if (w/16 < h/9) {
                        w = Math.ceil(h/9*16);
                    }

                    player.setSize(w, h);
                    $(iframe).css({
                        'margin-left': -Math.ceil(w/2)+'px',
                        'margin-top': -Math.ceil(h/2)+'px'
                    });
                };

                updateSize();
                $(window).resize(updateSize);

                var showVideo = function() {
                    $(iframe).fadeIn();
                    $(playBtn).hide();
                    $('#menu-header').fadeOut();
                    $('#home-intro').animate({
                        'opacity': 0
                    }, 400);
                };

                var hideVideo = function() {
                    $(iframe).fadeOut();
                    $(playBtn).show();
                    $('#menu-header').fadeIn();
                    $('#home-intro').stop(true).animate({
                        'opacity': 100
                    }, 400);
                };

                $(playBtn).click(function() {
                    if (!hasPlayed && $(iframe).parent().height() > 480) {
                        player.setPlaybackQuality('large');
                    }

                    $(playBtn).fadeOut();
                    player.seekTo(0);
                    player.playVideo();
                    $('#home-intro').delay(300).stop(true).animate({
                        'opacity': 0
                    }, 400);

                    hasPlayed = true;
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
            $('.mobile-home-nav').css({
                'padding-top': h + 'px'
            });
        }
    }
    $(function() {
        init();
    });

})(jQuery)
