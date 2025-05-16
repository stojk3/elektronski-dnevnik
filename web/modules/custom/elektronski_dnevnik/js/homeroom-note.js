(function ($, Drupal) {
  Drupal.behaviors.homeroomNote = {
    attach: function (context, settings) {
      const tooltip = $('<div id="tooltip" style="position: absolute; display: none; background-color: white; border: 1px solid black; padding: 5px; z-index: 1000;"></div>').appendTo('body');

      $(context).on('mouseenter', '.comment-column', function(e) {
        const fullText = $(this).data('full');
        tooltip.text(fullText)
          .css({
            top: e.pageY,
            left: e.pageX
          })
          .show();
      });

      $(context).on('mouseleave', '.comment-column', function() {
        tooltip.hide();
      });
    }
  };
})(jQuery, Drupal);
