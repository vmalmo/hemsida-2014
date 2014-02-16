(function($) {
    if (!window.vm14)
        window.vm14 = {};

    vm14.FilterWidget = (function() {
        var FilterWidget = function(list) {
            this.listElement = list;
            this.panes = [];
            this.items = [];

            var items = this.items;
            $(list).find('li.filterable').each(function() {
                // Add items with references to DOM element
                items.push(new FilterWidgetItem(this));
            });
        };

        FilterWidget.LIST = 1;
        FilterWidget.TAG_CLOUD = 2;

        FilterWidget.prototype.enableSearch = function(title, selectors) {
            var pane;

            pane = new SearchPane(title, this);
            pane.addCallback(this.update);
            this.panes.push(pane);

            buildSearchIndex(this.items, selectors, true);
        };

        FilterWidget.prototype.addFilter = function(title, key, style, multiple) {
            // TODO: Implement filters
        };

        FilterWidget.prototype.update = function(pane) {
            var i;

            for (i=0; i<this.items.length; i++) {
                var item;

                item = this.items[i];
                $(item.domElement).toggle(pane.matches(item));
            }
        };

        FilterWidget.prototype.render = function(ctr) {
            var domElement, i;

            domElement = document.createElement('div');
            domElement.setAttribute('class', 'filter-widget');

            for (i=0; i<this.panes.length; i++) {
                this.panes[i].render(domElement);
            };

            ctr.appendChild(domElement);
        };


        var buildSearchIndex = function(items, selectors, clear) {
            var i;

            // Build index
            for (i=0; i<items.length; i++) {
                var item = items[i];

                selectors.forEach(function(selector, idx) {
                    $(item.domElement).find(selector).each(function() {
                        var text = $(this).text().toLowerCase();
                        item.searchIndex.push(text);
                    });
                });
            }
        };



        var PaneBase = function(title, widget) {
            this.title = title;
            this.widget = widget;
            this.callbacks = [];
        };

        PaneBase.prototype.matches = function(item) {
            return false;
        };

        PaneBase.prototype.addCallback = function(callback) {
            if (this.callbacks.indexOf(callback)<0)
                this.callbacks.push(callback);
        };

        PaneBase.prototype.removeCallback = function(callback) {
            var idx = this.callbacks.indexOf(callback);
            if (idx>=0)
                this.callbacks.splice(idx, 1)
        };



        var SearchPane = function(title, widget) {
            PaneBase.call(this, title, widget);
            this.query = '';
        };

        SearchPane.prototype = new PaneBase();
        SearchPane.prototype.constructor = SearchPane;

        SearchPane.prototype.matches = function(item) {
            if (this.query) {
                var i;

                for (i=0; i<item.searchIndex.length; i++) {
                    if (item.searchIndex[i].indexOf(this.query)>=0)
                        return true;
                }

                return false;
            }
            else {
                return true;
            }
        };

        SearchPane.prototype.render = function(ctr) {
            var domElement, input, pane;

            domElement = document.createElement('div');
            domElement.setAttribute('class', 'search-pane');
            ctr.appendChild(domElement);

            if (this.title) {
                var h3;
                
                h3 = document.createElement('h3');
                h3.innerText = this.title;
                domElement.appendChild(h3);
            }

            input = document.createElement('input');
            domElement.appendChild(input);

            pane = this;
            input.onkeyup = function() {
                var i;

                pane.query = input.value.toLowerCase();

                for (i=0; i<pane.callbacks.length; i++) {
                    var cb = pane.callbacks[i];

                    cb.call(pane.widget, pane);
                }
            };
        };


        var ListPane = function(title, widget) {
            PaneBase.call(this, title, widget);
        };

        ListPane.prototype = new PaneBase();
        ListPane.prototype.constructor = ListPane;


        var TagCloudPane = function(title, widget) {
            ListPane.call(this, title, widget);
        };

        TagCloudPane.prototype = new ListPane();
        TagCloudPane.prototype.constructor = TagCloudPane;



        var FilterWidgetItem = function(domElement) {
            this.domElement = domElement;
            this.filterContent = [];
            this.searchIndex = [];
        };


        return FilterWidget;
    })();


})(jQuery);
