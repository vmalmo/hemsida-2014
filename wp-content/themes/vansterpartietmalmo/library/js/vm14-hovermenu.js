(function($) {
  var HoverMenu = function() {
    this.$moreBtn = $('.top-more');
    this.$menu = $('#menu-top-corner').clone();
    this.$menu.attr('id', 'menu-top-hover-menu');
    this.$menu.prepend('<div class="triangle"></div>');
    $('#menu-top-corner').after(this.$menu);
    this.timeoutThreshold = 500;
    this.timeout = -1;
    this.isVisible = false;
    this.init();
  }
  HoverMenu.prototype.init = function() {
    var self = this;
    this.$moreBtn.on('mouseenter', function() {
      this.isVisible = true;
      self.$menu.show();
      clearTimeout(self.timeout);
    });
    this.$moreBtn.on('touchstart', function() {
      if (this.isVisible) {
        self.$menu.hide();
      }
      else {
        self.$menu.show();
      }
      this.isVisible = !this.isVisible;
    });
    this.$moreBtn.on('mouseleave', function() {
      clearTimeout(self.timeout);
      self.startClear();
    });
    this.$menu.on('mouseenter', 'a', function() {
      clearTimeout(self.timeout);
    });
    this.$menu.on('mouseleave', function() {
      self.startClear();
    });

  }
  HoverMenu.prototype.startClear = function() {
    var self = this;
    this.timeout = setTimeout(function() {
        self.isVisible = true;
        self.$menu.hide();
    }, this.timeoutThreshold);
  }

  $(function() {
    var hovermenu = new HoverMenu();

  });

})(jQuery);
