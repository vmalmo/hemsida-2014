(function($) {
    if (!window.vm14)
        window.vm14 = {};

    vm14.FilterWidget = (function() {
        var FilterWidget = function(list) {
            this.listElement = list;
            this.panes = [];
            this.items = [];
            this.headers = [];

            var items = this.items,
                headers = this.headers,
                curHeader = null;

            $(list).find('li').each(function() {
                // Add items with references to DOM element
                if ($(this).hasClass('filterable')) {
                    var item = new FilterWidgetItem(this);
                    items.push(item);
                    if (curHeader) {
                        curHeader.add(item);
                    }
                }
                else {
                    curHeader = new FilterWidgetHeader(this);
                    headers.push(curHeader);
                }
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
            var pane;

            switch (style) {
                case FilterWidget.TAG_CLOUD:
                    pane = new TagCloudPane(title, key, this);
                    break;
                default:
                    pane = new ListPane(title, key, this);
                    break;
            }

            pane.addCallback(this.update);
            this.panes.push(pane);

            buildFilterIndex(this.items, key, multiple);
        };

        FilterWidget.prototype.update = function(pane) {
            var i;

            for (i=0; i<this.items.length; i++) {
                var item;

                item = this.items[i];
                item.update(pane);
            }

            for (i=0; i<this.headers.length; i++) {
                this.headers[i].updateVisibility();
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


        var buildFilterIndex = function(items, key, serialized) {
            var i;

            for (i=0; i<items.length; i++) {
                var item, value;

                item = items[i];
                value = $(item.domElement).data(key);
                if (serialized) {
                    value = value.split(/(?!\\),/);
                    value.forEach(function(val, idx) {
                        value[idx] = val.replace('\\,', ',');
                    });
                }
                else {
                    value = [value];
                }

                item.filterContent[key] = value;
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
                h3.setAttribute('class', 'widgettitle');
                domElement.appendChild(h3);
            }

            input = document.createElement('input');
            input.setAttribute('placeholder', 'Start typing to search...');
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


        var ListPane = function(title, key, widget) {
            PaneBase.call(this, title, widget);
            this.filterKey = key;
            this.domElement = null;
        };

        ListPane.prototype = new PaneBase();
        ListPane.prototype.constructor = ListPane;

        ListPane.prototype.matches = function(item) {
            var elements, len;

            elements = $(this.domElement).find('.selected a');
            len = elements.length;

            if (len > 0) {
                var i, content;

                content = item.filterContent[this.filterKey];
                for (i=0; i<content.length; i++) {
                    var e;
                
                    for (e=0; e<len; e++) {
                        var elem = elements.get(e);
                        console.log(elem.innerText, content[i]);
                        if (elem.innerText == content[i])
                            return true;
                    }
                }
                
                return false;
            }
            else {
                return true;
            }
        };

        ListPane.prototype.render = function(ctr) {
            var i, content, ul, pane;

            this.domElement = document.createElement('div');
            ctr.appendChild(this.domElement);

            if (this.title) {
                var h3;

                h3 = document.createElement('h3');
                h3.innerText = this.title;
                h3.setAttribute('class', 'widgettitle');
                this.domElement.appendChild(h3);
            }

            content = [];
            for (i=0; i<this.widget.items.length; i++) {
                var item;
                
                item = this.widget.items[i];
                item.filterContent[this.filterKey].forEach(function(value) {
                    if (content.indexOf(value)<0 && value.length > 0) {
                        content.push(value);
                    }
                });
            }

            ul = document.createElement('ul');

            for (i=0; i<content.length; i++) {
                var li, a;

                li = document.createElement('li');
                ul.appendChild(li);

                a = document.createElement('a');
                a.innerText = content[i];
                li.appendChild(a);
            }
            this.domElement.appendChild(ul);

            pane = this;
            $(ul).find('li').click(function() {
                for (i=0; i<pane.callbacks.length; i++) {
                    var cb = pane.callbacks[i];

                    $(this).toggleClass('selected');

                    cb.call(pane.widget, pane);
                }
            });
        };



        var TagCloudPane = function(title, key, widget) {
            ListPane.call(this, title, key, widget);
        };

        TagCloudPane.prototype = new ListPane();
        TagCloudPane.prototype.constructor = TagCloudPane;



        var FilterWidgetHeader = function(domElement) {
            this.domElement = domElement;
            this.items = [];
        };

        FilterWidgetHeader.prototype.add = function(item) {
            this.items.push(item);
        };

        FilterWidgetHeader.prototype.hasVisibleItems = function() {
            var i, len = this.items.length;
            for (i=0; i<len; i++) {
                var item = this.items[i];
                if (item.visible)
                    return true;
            }

            return false;
        };

        FilterWidgetHeader.prototype.updateVisibility = function() {
            $(this.domElement).toggle(this.hasVisibleItems());
        };

        var FilterWidgetItem = function(domElement) {
            this.domElement = domElement;
            this.filterContent = {};
            this.searchIndex = [];
            this.visible = true;
        };

        FilterWidgetItem.prototype.update = function(pane) {
            this.visible = pane.matches(this);
            $(this.domElement).toggle(this.visible);
        };


        return FilterWidget;
    })();


})(jQuery);
