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
        if ($('#home-video-player').length == 1) {
            var f = $('#home-video-player'),
                url = f.attr('src').split('?')[0],
                vw, vh;

            // Handle messages received from the player
            function onMessageReceived(e) {
                if (e.origin.indexOf('vimeo')>0) {
                    var data = JSON.parse(e.data);
                    
                    if (data.event) {
                        switch (data.event) {
                            case 'ready':
                                onReady();
                                break;
                               
                            case 'pause':
                                onPause();
                                break;
                               
                            case 'finish':
                                onFinish();
                                break;
                        }
                    }
                    else if (data.method) {
                        switch (data.method) {
                            case 'getVideoWidth':
                                vw = data.value;
                                repositionVideo();
                                break;
                            case 'getVideoHeight':
                                vh = data.value;
                                repositionVideo();
                                break;
                        }
                    }
                }
            }

            // Listen for messages from the player
            if (window.addEventListener){
                window.addEventListener('message', onMessageReceived, false);
            }
            else {
                window.attachEvent('onmessage', onMessageReceived, false);
            }
            
            
            // Helper function for sending a message to the player
            function post(action, value) {
                var data = { method: action };
                
                if (value) {
                    data.value = value;
                }
                
                var str = JSON.stringify(data);
                f[0].contentWindow.postMessage(str, url);
            }
            
            function onReady() {
                post('addEventListener', 'pause');
                post('addEventListener', 'finish');
                post('addEventListener', 'playProgress');

                post('getVideoWidth');
                post('getVideoHeight');
                $(window).resize(repositionVideo);
            }
            
            function onPause() {
                hideVideo();
            }
            
            function onFinish() {
                hideVideo();
            }

            function repositionVideo() {
                if (vw && vh) {
                    var ww = $('#home-video').width(),
                        wh = $('#home-video').height(),
                        aw = vw,
                        ah = vh,
                        scale;

                    // Calculate scale with 10px bleed
                    scale = Math.max((ww+10) / vw, (wh+10) / vh);

                    // Adjusted width/height
                    aw = Math.ceil(scale * vw);
                    ah = Math.ceil(scale * vh);

                    $('#home-video-player').css({
                        'width': aw,
                        'height': ah,
                        'left': ww/2 - Math.ceil(aw/2)+'px',
                        'top': wh/2 - Math.ceil(ah/2)+'px'
                    });
                }
            }

            function showVideo() {
                repositionVideo();

                $('#home-video-player').fadeIn();
                $('#menu-header').fadeOut();
                $(playBtn).fadeOut();
            }

            function hideVideo() {
                $('#home-video-player').fadeOut();
                $('#menu-header').fadeIn();
                $(playBtn).fadeIn();
            }

            playBtn = document.createElement('a');
            $(playBtn).addClass('play-btn');
            $(playBtn).fadeIn();
            document.getElementById('home-video').appendChild(playBtn);

            $(playBtn).click(function() {
                post('play');
                showVideo();
            });
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
