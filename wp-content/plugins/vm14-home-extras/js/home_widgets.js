(function($) {
    $(document).ready(function() {
        $('.vm14-news-widget').each(function() {
            var nav,
                cur,
                items = [];

            nav = document.createElement('ul');
            $(nav).addClass('vm14-news-widget-nav');
            this.appendChild(nav);

            $(this).find('.vm14-news-widget-item-list li').each(function() {
                var nav_item;

                if (items.length==0) {
                    cur = this;
                }
                else {
                    $(this).hide();
                }

                items.push(this);

                nav_item = document.createElement('li');
                nav.appendChild(nav_item);
                $(nav_item).click((function(item) {
                    return function() {
                        if (cur)
                            $(cur).hide();

                        cur = item;
                        $(cur).show();
                    }
                })(this));
            });
        });
    });
})(jQuery);

