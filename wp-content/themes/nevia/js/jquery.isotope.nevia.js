(function($){
  "use strict";
  $(document).ready(function(){
    /*----------------------------------------------------*/
/*  Isotope Portfolio Filter
/*----------------------------------------------------*/

$(window).load(function(){
    $('#portfolio-wrapper').isotope({
        itemSelector : '.isotope-item',
        layoutMode : 'fitRows'
    });
});
$('#filters a').click(function(e){
    e.preventDefault();

    var selector = $(this).attr('data-option-value');
    $('#portfolio-wrapper').isotope({ filter: selector });

    $(this).parents('ul').find('a').removeClass('selected');
    $(this).addClass('selected');
});
//shop isotope
$(window).load(function(){
    $('#shop-wrapper').isotope({
        itemSelector : '.isotope-item',
        layoutMode : 'fitRows'
    }, window.resizesidebar );
});

});

})(this.jQuery);
