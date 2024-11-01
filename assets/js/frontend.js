jQuery(document).ready(function ($) {

    $('.preview_small').click(function (event) {
        event.preventDefault();

        $('#preview_large').attr('src',this.href).parent('a.thickbox').attr('href',this.href);

    });

    $('#p4_up,#p4_down').click(function (event) {

        event.preventDefault();
        
    });

});