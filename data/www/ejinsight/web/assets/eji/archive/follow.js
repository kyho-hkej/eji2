
/*
Simple effect for roll over on grids, where the content slides based on the previous position.

You can see also in use here: http://worldbakingday.com

Libraries: jQuery and jQuery.transit
 */

(function() {
  $(function() {
    var columns, current, easing, grid, hideItem, showItem, time;
    grid = $(".grid");
    current = {
      index: -1,
      column: 0,
      line: 0
    };
    columns = 4;
    easing = "cubic-bezier(0.165, 0.840, 0.440, 1.000)";
    time = 400;
    grid.on("mouseenter", "a", (function(_this) {
      return function(e) {
        var column, el, image, index, info, item, line;
        el = $(e.currentTarget);
        info = el.find(".info");
        image = el.find("img");
        index = el.parent().index();
        column = index % columns;
        line = Math.floor(index / columns);
        console.log(index, column, line);
        item = {
          el: el,
          index: index,
          column: column,
          line: line,
          info: info,
          image: image
        };
        if (current.el && current.index === index) {
          return;
        }
        if (line === current.line && column > current.column) {
          showItem(item, "-100%", 0, "25%", 0);
          hideItem(current, "100%", 0, "-25%", 0);
        } else if (line === current.line && column < current.column) {
          showItem(item, "100%", 0, "-25%", 0);
          hideItem(current, "-100%", 0, "25%", 0);
        } else if (line > current.line && column === current.column) {
          showItem(item, 0, "-100%", 0, "25%");
          hideItem(current, 0, "100%", 0, "-25%");
        } else {
          showItem(item, 0, "100%", 0, "-25%");
          hideItem(current, 0, "-100%", 0, "25%");
        }
        return current = item;
      };
    })(this));
    showItem = function(item, infoX, infoY, imageX, imageY) {
      item.info.stop().css({
        x: infoX,
        y: infoY,
        display: "block"
      }).transition({
        x: 0,
        y: 0,
        duration: time,
        easing: easing
      });
      return item.image.stop().transition({
        x: imageX,
        y: imageY,
        opacity: .5,
        duration: time,
        easing: easing
      });
    };
    return hideItem = function(item, infoX, infoY, imageX, imageY) {
      if (!item.el) {
        return;
      }
      item.info.stop().transition({
        x: infoX,
        y: infoY,
        duration: time,
        easing: easing
      });
      return item.image.stop().css({
        x: imageX,
        y: imageY,
        opacity: .5
      }).transition({
        x: 0,
        y: 0,
        opacity: 1,
        duration: time,
        easing: easing
      });
    };
  });

}).call(this);