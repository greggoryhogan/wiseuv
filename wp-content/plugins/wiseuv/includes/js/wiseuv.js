(function($) {
    $(document).ready(function() {
        
        //lozad
        //const observer = lozad();
        //observer.observe();

        var call_tip = plugin_js.call_tip;
        if(call_tip != '') {
            $('a[href^="tel:"]').each(function() {
                $(this).attr('data-tooltip',call_tip);
                if($(this).parent().hasClass('menu-item')) {
                    $(this).attr('data-tooltip-position','beneath');
                } else {
                    $(this).attr('data-tooltip-position','above');
                }
            });
        }

        $(document).on('mouseenter','[data-tooltip]', function() {
            var classes = '';
            if($(this).hasClass('exitsite')) {
                classes = 'exitsite';
            }
            var tip = $(this).attr('data-tooltip');
            var tip_position = $(this).attr('data-tooltip-position');
            $('.site').append('<div id="tip" class="'+classes+' tip-'+tip_position+'">'+tip+'</div>');
            var tipheight = $('#tip').outerHeight();
            var eTop = $(this).offset().top; //get the offset top of the element
            var height = $(this).height();
            var left = $(this).offset().left; //get the offset top of the element
            if(tip_position == 'above') {
                var top = eTop - $(window).scrollTop() - height - tipheight + 10;
                $('#tip').css({top:top,left:left});
            } else {
                //call menu item
                var tipwidth = $('#tip').width();
                var buttonpwidth = $(this).outerWidth();
                left = $(window).width() - $(this).offset().left - buttonpwidth; //get the offset top of the element
                var top = eTop - $(window).scrollTop() + height + 35;
                $('#tip').css({top:top,right:left});
            }
            
            
        }).on('mouseleave', '[data-tooltip]', function() {
            $('#tip').remove();
        });
        
    });
})( jQuery );