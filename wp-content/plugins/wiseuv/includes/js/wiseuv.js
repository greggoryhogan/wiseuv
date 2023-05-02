(function($) {
    $(document).ready(function() {
        
        //lozad
        /*const observer = lozad('.lozad', {
            loaded: function(el) {
                // Custom implementation on a loaded element
                el.classList.add('loaded');
                //check if this is a lazy loaded tiny mce textarea, and if so, init. Tiny MCE declared further down page
                if(el.classList.contains('is-tiny-mce')) {
                    //alert(el.classList);
                    //let text_id = $(this).attr('id');
                    el.classList.add('has-tiny');
                    tinymce.EditorManager.execCommand('mceAddEditor', true, el.id);
                } else {
                    console.log(el.classList);
                }
            }
        });
        observer.observe();*/
        
        //AOS init
        AOS.init({
            offset: 120,
            duration: 400,
            once: false, //or true
            disable: 'phone' //false, phone, tablet, mobile
        });
        
    });
})( jQuery );