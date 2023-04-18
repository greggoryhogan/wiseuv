(function($) {
    $(document).ready(function() {
        $('.accordion__item .accordion__title').on('click',function() {
            $(this).parent().toggleClass('is-open').toggleClass('is-closed');
        });
    });
})( jQuery );