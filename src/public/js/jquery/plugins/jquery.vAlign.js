/**
 * Calculate margins to simulate a vertical align.
 * 
 * Copyright (c) 2010 Dual licensed under the MIT and GPL licenses:
 * @version: 1.0
 */
(function($) {
    $.fn.vAlign = function() {
        return this.each(function(i) {
            var ah = $(this).height();
            var ph = $(this).parent().height();
            var mh = Math.ceil((ph - ah) / 2);
            $(this).css('margin-top', mh);
        });
    };
})(jQuery);