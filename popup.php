<?php
ini_set('display_errors', '1');

global $wpdb,$wp_query;

if(!isset($wpdb)) {
  require_once($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');
}

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />

<?php wp_head('admin-header'); ?>

<script>
jQuery(document).ready(function($) {

  $('#TB_ajaxContent').css({
    'width': '90%',
    'padding': '5px 10px',
    'margin': '0 auto'
  });

  $('#ASIN,#template').bind('change keyup input', function() {

    $('#insert').hide();

    var ASIN = $('#ASIN').val();
    var option = $('#template option:selected').val();

    if ( ASIN.length == 10 && option != '' ) {

      $.post(yaawp.ajaxurl, {
          action: 'Backend',
          ASIN: $('#ASIN').val(),
          method: 'ReadItem',
          nonce: yaawp.nonce
      }, function(response) {

        if ( response.ASIN ==  '' ) {
          $('.response').text('(<?php echo __('Keine Daten vorhanden', 'yaawp'); ?>)').closet('#ASIN').addClass('error');
          return;
        }

        if ( $('#ASIN').hasClass('error') ) {
          $('#ASIN').removeClass('error');
        }

        $('.response').empty();
        $('#insert').show();

        if ( response.Title.length > 30 ) var Title = response.Title.substring(0,30) + ' ...';

        var html = '';

        switch(parseInt(option)) {
          case 1:
            html += '<div class="asin" id="' + response.ASIN + '" style="width: 320px;">';
            html += '<img width="32" style="float: left; padding-right: 5px; width: 35px; height: 43px" id="' + response.ASIN + '" src="' + response.SmallImageUrl + '">';
            html += '<a href="' + response.DetailPageURL + '" title="' +  response.Title + '" target="_blank">' +  Title + '</a><br />';
            html += response.Director + ' (' + response.Binding + ')';
            html += '</div>';
          break;
          case 2:
            html += '<div class="asin" id="' + response.ASIN + '" style="width: 320px;">';
            html += '<a href="' + response.DetailPageURL + '" title="' +  response.Title + '" target="_blank">' +  Title + '</a><br />';
            html += response.Director + ' (' + response.Binding + ')';
            html += '</div>';
          break;
          case 3:
            html += response.DetailPageURL;
          break;
        }

        $('#preview').empty().html(html).css('padding-bottom','20px');
        $('#preview_code').empty().text(html);

        console.log(response);

        return;

      });

    }

    $('#ASIN').addClass('error');

  });

  $('#tt-insert').click(function() {

    var ASIN = $('#ASIN').val();
    var option = $('#template option:selected').val();

    if(window.tinyMCE)
    {

      var shortcode = '';
      shortcode += '[yaawp_asin ';
      shortcode += 'ASIN=\''+ASIN+'\' ';
      shortcode += 'TEMPLATE=\''+option+'\' ';
      shortcode += ']';
      
      tinyMCE.activeEditor.selection.setContent(shortcode);

    }
    tb_remove();
  });

});
</script>

</head>
<body>

  <div class="form-wrap" style="-webkit-border-radius: 3px;border-radius: 3px;border-width: 1px;border-style: solid;border-color: #dfdfdf;background-color: #f9f9f9;padding: 5px;">
    
    <div class="form-field form-required">
      <label for="ASIN"><?php echo __('ASIN', 'yaawp'); ?><span class="response"></span></label>
      <input name="ASIN" id="ASIN" type="text" size="40" aria-required="true" style="width: 100%">
    </div>

    <div class="form-field" style="margin: 0; padding: 3px 0;">
      <label for="parent"><?php echo __('Template', 'yaawp'); ?></label>
        <select name="template" id="template" aria-required="true" style="width: 100%">
        <option value="1" selected><?php echo __('Produkt mit Bild', 'yaawp'); ?></option>
        <option value="2"><?php echo __('Produkt ohne Bild', 'yaawp'); ?></option>
        <option value="3"><?php echo __('Produktlink', 'yaawp'); ?></option>
      </select>
    </div>

    <div class="form-field form-required" style="display: none;" id="insert">
      <a href="#" id="tt-insert" class="button button-primary" style="color: #FFF;"><?php echo __('Shortcode ein&uuml;gen', 'yaawp'); ?></a>
    </div>
  
  </div>

  <hr style="margin: 10px 0;" />

  <div class="form-wrap" style="-webkit-border-radius: 3px;border-radius: 3px;border-width: 1px;border-style: solid;border-color: #dfdfdf;background-color: #f9f9f9;padding: 5px;">
    <h2><?php echo __('Vorschau', 'yaawp'); ?></h2>
    
      <div class="form-field" style="margin: 0; padding: 3px 0;" id="preview">
        <?php echo __('Keine vorhanden', 'yaawp'); ?>
      </div>

    </form>
  </div>

  <hr style="margin: 10px 0;" />

  <div class="form-wrap" style="-webkit-border-radius: 3px;border-radius: 3px;border-width: 1px;border-style: solid;border-color: #dfdfdf;background-color: #f9f9f9;padding: 5px;">
    <h2><?php echo __('Quellcode Vorschau', 'yaawp'); ?></h2>
    
      <div class="form-field" style="margin: 0; padding: 3px 0;" id="preview_code">
        <?php echo __('Keine vorhanden', 'yaawp'); ?>
      </div>

    </form>
  </div>

</div>
</body>
</html>