/**
 * INIT LAZY LOAD.
 */
(function($){
  $(document).ready(function(){
    $("img.lazy").lazyload({
      effect: "fadeIn" 
    });
  });
})(jQuery);
function lazyloadUpdate(){
  jQuery("img.lazy").lazyload();
}