(function($) {
  window.vm14 = window.vm14 || {};
  window.vm14.InfiniteScroll = (function() {
    /***
     * String @type - post type that are going to be rendered
     * String @selecter - queryselector for html-element to append html to
     * Object @params - object that are passed as queries in the http request
     **/

    var InfiniteScroll = function(type, selector, params) {
      this.type = type;
      this.$appendEl = $(selector);
      this.offset = 150;
      this.fancy = false;
      this.params = params || {};
      this.params['html'] = true;
      this.params['posts_per_page'] = this.params['posts_per_page'] || 200;
      this.params['page'] = this.params['size'] || 2; //start on page 2
      this.pageSize = this.params['size'] || 200;
      this.API_URL = '/?__vm14_api&custom_type='+type;
      this.position = 0;
      this.init();
    }
    InfiniteScroll.prototype.init = function() {
      this.startIfScroll();
    }
    InfiniteScroll.prototype.startIfScroll = function() {
      $(window).on('scroll', function() {
        this.checkPosition();
        $(window).off('scroll');
      }.bind(this))

    }
    InfiniteScroll.prototype.checkPosition = function() {
      var bottomOfAppend = $(document).height() - (this.$appendEl.height() + this.$appendEl.offset().top);
      var position = ($(window).height() + $(window).scrollTop()) -  $(document).height();
      if (this.position === position) {
        this.startIfScroll();
      }
      else {
        this.position = position;
        if (position+bottomOfAppend > -this.offset) {
          this.nextPage();
        }
        else {
          setTimeout(function() {
            this.checkPosition()
          }.bind(this), 200);
        }
      }
    }

    InfiniteScroll.prototype.nextPage = function() {
      var self = this;
      $.ajax({
        dataType: 'JSON',
        data: this.params, 
        url: this.API_URL,
        success: function(data) {
          self.params['page']++;
          self.latestPage = data;
          self.renderIndex = 0;
          self.rendering = true;
          self.renderResult();
        },
        error: function(err) {
          console.log('errror', err);
        }
      })
    }
    InfiniteScroll.prototype.renderResult = function() {
      var self = this;
      if (!this.fancy) {
        this.$appendEl.append(this.latestPage.join(''));
        if (this.latestPage.length === this.params['posts_per_page']) {
          this.checkPosition();
        }
        return;
      }
      if (this.latestPage.length > this.renderIndex) {
        this.$appendEl.append(this.latestPage[this.renderIndex]);
        this.renderIndex++;
        // render on at the time to make fancy stuff
        setTimeout(function() {
          self.renderResult();
        }, 300);
      }
      else if (this.latestPage.length === this.params['posts_per_page']) {
        this.checkPosition();
      }
      // else all fetched

    }
    return InfiniteScroll;
  })()
})(jQuery);
console.log('got file');
