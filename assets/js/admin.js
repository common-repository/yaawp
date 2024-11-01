jQuery(document).ready(function($) {

    $('#SearchIndex').bind('change', yaawp_search);
    $('#yaawp_publish').attr('disabled',true);
    $('.checkall,#sort,#page,#yaawp_doaction,#SearchIndex').attr('disabled',true);

    $('#keyword').live('keypress', function() {

        var field = $(this).val().replace(/ /g,'');

        if ( field.length >= 3 ) {
            $('#SearchIndex').attr('disabled',false);
            $('#SearchIndex option:first').attr('selected',true);
            $('#yaawp_publish').attr('disabled',true).removeClass('button-primary');
            yaawp_clean();
            return;
        }

    });

    $('.upload_image_button').click(function() {

        upload_button = $(this);
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
        return false;

    });

    $('.remove_image_button').click(function(event) {
        event.preventDefault();

        $('#taxonomy_image').val('');
        $(this).parent().siblings('.title').children('img').attr('src', yaawp.pluginUrl + 'assets/img/placeholder.png');
        $('.inline-edit-col :input[name="taxonomy_image"]').val('');

    });

    window.send_to_editor = function(html) {

        imgurl = $('img',html).attr('src');
        if (upload_button.parent().prev().children().hasClass('tax_list')) {
            upload_button.parent().prev().children().val(imgurl);
            upload_button.parent().prev().prev().children().attr('src', imgurl);
        }
        else
        $('#taxonomy_image').val(imgurl);
        tb_remove();

    }

    $('.editinline').live('click', function(event) {
        event.preventDefault();

        var tax_id = $(this).parents('tr').attr('id').substr(4);
        var thumb = $('#tag-'+tax_id+' .thumb img').attr('src');

        if (thumb != yaawp.pluginUrl + 'assets/img/placeholder.png') {
            $('.inline-edit-col :input[name="taxonomy_image"]').val(thumb);
        } else {
            $('.inline-edit-col :input[name="taxonomy_image"]').val('');
        }

        $('.inline-edit-col .title img').attr('src',thumb);

    }); 

    $('form#yaawp_settings.settings').live('change keypress keyup', function(event) {

        $('input[type="submit"]').attr('disabled',false);

    });

    $('form#yaawp_settings.settings').submit(function(event) {
        event.preventDefault();

        $('input[type="submit"]').attr('disabled',true);

        data = new Object();
        data.action = 'Backend';
        data.method = 'UpdateSettings';
        data.yaawp_secret_access_key = $('#yaawp_secret_access_key').val();
        data.yaawp_access_key_id = $('#yaawp_access_key_id').val();
        data.yaawp_associate_id = $('#yaawp_associate_id').val();
        data.nonce = yaawp.nonce;

        $.post(ajaxurl, data, function(response) {

            if ( response.status == 1 ) {

                var html = '';

                $.each(response.msg, function(index, val) {
                    html += val + '<br />';
                });

                $('.notice p').prepend(html);

                $('.notice').addClass('updated').slideDown('slow').delay(5000).slideUp('slow', function() {
                    $(this).removeClass('updated').find('p').empty();
                });

                return;

            }

            $('.notice p').prepend(response.msg);

            $('.notice').addClass('error').slideDown('slow').delay(5000).slideUp('slow', function() {
                $(this).removeClass('error').find('p').empty();
            });

            console.log(response);
        });        
        
    });

    $('#force-delete').click(function(event) {
        event.preventDefault();

        var button = $(this);
        button.attr('disabled',true);

        data = new Object();
        data.action = 'Backend';
        data.method = 'UpdateCache';
        data.nonce = yaawp.nonce;

        $.post(ajaxurl, data, function(response) {

            if ( response.status == 1 ) {

                $('.notice p').prepend(response.msg);

                $('.notice').addClass('updated').slideDown('slow').delay(5000).slideUp('slow', function() {
                    $(this).removeClass('updated').find('p').empty();
                });

                button.attr('disabled',false);

                return;

            }

            $('.notice p').prepend(response.msg);

            $('.notice').addClass('error').slideDown('slow').delay(5000).slideUp('slow', function() {
                $(this).removeClass('error').find('p').empty();
            });

            button.attr('disabled',false);

            console.log(response);
        });        
        
    });

    $('#delete').click(function(event) {
        event.preventDefault();

        var button = $(this);
        button.attr('disabled',true);

        data = new Object();
        data.action = 'Backend';
        data.method = 'UpdateCacheTime';
        data.cron_check = $('#yaawp_cron_check').val();
        data.nonce = yaawp.nonce;

        $.post(ajaxurl, data, function(response) {

            if ( response.status == 1 ) {

                $('.notice p').prepend(response.msg);

                $('.notice').addClass('updated').slideDown('slow').delay(5000).slideUp('slow', function() {
                    $(this).removeClass('updated').find('p').empty();
                });

                button.attr('disabled',false);

                return;

            }

            $('.notice p').prepend(response.msg);

            $('.notice').addClass('error').slideDown('slow').delay(5000).slideUp('slow', function() {
                $(this).removeClass('error').find('p').empty();
            });

            button.attr('disabled',false);

            console.log(response);
        });        
        
    });


    $('.checkall').click(function () {

        var checked = $("#results tbody input.import").length;

        if ( $(this).is(':checked') ) {
            toggleChecked(true);
        } else {
            toggleChecked(false);
        }

    });

    $('form#yaawp_import').submit(function(event) {
        event.preventDefault();
        
        yaawp_import();       
        
    });

    $('#page').change(function(event) {
        event.preventDefault();

        yaawp_sort();      
        
    });

    $('#yaawp_doaction').click(function(event) {
        event.preventDefault();

        if (!$('tbody input.import:checked').length) return;

        var asin = [];

        $('tbody input.import:checked').each( function() {
            asin.push($(this).val());
        });

        var tot = asin.length;

        for (var i = 0; i <= asin.length; i++) {
            var current = parseInt((i/tot)*100);
        };

        tb_show('Import', '/wp-content/plugins/yaawp/ajax.php?popup=' + '&width=' + 800 + '&height=' + 650);

    });

    function yaawp_clean() {

        $('.checkall').attr('checked', false);

        $('#results tbody').empty().html('<tr><td colspan="7">' + yaawp.your_choice + '</td></tr>');

        $('.NoteID').each(function() {
            $(this).remove();
        });

        $('#page').empty().append('<option>' + yaawp.site + '</option>').attr('disabled',true);
        $('#yaawp_doaction').attr('disabled',true);

    }

    function LoadOn() {

        $('#keyword').attr('disabled',true);
        $('#load').toggle();
        $('#yaawp_publish').toggle();
        $('#yaawp_publish').attr('disabled',true).removeClass('button-primary');

    }

    function LoadOff() {

        $('#keyword').attr('disabled',false);
        $('#load').toggle();
        $('#yaawp_publish').toggle();
        $('#yaawp_publish').attr('disabled',false).addClass('button-primary');

    }

    function yaawp_sort() {

        data = new Object();
        data.action = 'Backend';
        data.method = 'ReadImportItems';
        data.suchwort = $('#keyword').val();
        data.kategorie = $('#SearchIndex').val();
        data.NoteId = $('.NoteID:last option:selected').val();
        data.lastBeforeNote = $('.NoteID:last').prev('.NoteID').val();
        if ( data.NoteId == '' && typeof(data.lastBeforeNote) !== 'undefined') { data.NoteId = data.lastBeforeNote; delete data.lastBeforeNote; }
        data.page = $('#page').val();
        data.nonce = yaawp.nonce;

        $.post(ajaxurl, data, function(response) {

            if(response.data != '') {

                $('.checkall').attr('checked', false);
                $('.checkall').attr('disabled',false);

                var totalpages = (response.TotalPages > 10) ? 10 : response.TotalPages;
                var html = '';
                for (var i = 1; i <= totalpages; i++) {
                    html += '<option value="';
                    html += i + '"';
                    if (response.ActivePage == i) html += ' selected>';
                    else html += '>';
                    html += 'Seite ' + i + '</option>';
                }

                $('#page').empty().append(html);

                $('#results tbody').empty().html(response.data); 
                return;
            }

            $('#results tbody').html('<tr><td colspan="7">' + yaawp.no_item + '</td></tr>'); return;
        });  
    }

    function yaawp_import() {

        data = new Object();
        data.action = 'Backend';
        data.method = 'ReadImportItems';
        data.suchwort = $('#keyword').val();
        data.kategorie = $('#SearchIndex').val();
        data.NoteId = $('.NoteID:last option:selected').val();
        data.lastBeforeNote = $('.NoteID:last').prev('.NoteID').val();
        if ( data.NoteId == '' && typeof(data.lastBeforeNote) !== 'undefined') { data.NoteId = data.lastBeforeNote; delete data.lastBeforeNote; }
        data.nodeidoption = $('#SearchIndex option:selected').attr('data-noteid');
        data.nonce = yaawp.nonce;

        $.post(ajaxurl, data, function(response) {

            if(response.data != '') {

                $('.checkall,#page,#yaawp_doaction').attr('disabled',false);

                var totalpages = (response.TotalPages > 10) ? 10 : response.TotalPages;
                var html = '';
                for (var i = 1; i <= totalpages; i++) {
                    html += '<option value="';
                    html += i + '"';
                    if (response.ActivePage == i) html += ' selected>';
                    else html += '>';
                    html += 'Seite ' + i + '</option>';
                }

                $('#page').empty().append(html);

                $('#results tbody').html(response.data).css('display',''); 

                return;
            }

            $('#results tbody').html('<tr><td colspan="7">' + yaawp.no_item + '</td></tr>'); return;
        }); 
    }

    function yaawp_search() {

        LoadOn();

        if ( $(this).attr('class') != 'NoteID' ) {

            yaawp_clean();

        }

        data = new Object();
        data.action = 'Backend';
        data.method = 'ReadNodeId';
        data.NoteId = $(this).find(':selected').attr('data-noteid');
        data.Suchwort = $('#keyword').val();
        data.SearchIndex = $('#SearchIndex option:selected').val();
        data.nonce = yaawp.nonce;

        $.post(yaawp.ajaxurl, data, function(response) {

            if ( response.error == 0 ) {

                var html = '';
                var len = response.DATA.length;

                html += '<select name="NoteID" class="NoteID">';
                html += '<option value="">' + yaawp.live_dropdown + '</option>';
                for (var i = 0; i< len; i++) {
                    html += '<option value="' + response.DATA[i].ID + '" data-noteid="' + response.DATA[i].ID + '">' + response.DATA[i].Name + ' (' + yaawp.live_dropdown_extra + ' ' + response.DATA[i].TotalResults + ')</option>';
                }
                html += '</select>';

                $('#load').before(html);

                $('.NoteID').bind('change', yaawp_search);

            } else {

                yaawp_import();

            }

            LoadOff();

        });

    }

    function toggleChecked(status) {

        $('tbody input.import').each( function() {
            $(this).attr('checked',status);
        })

    }

});