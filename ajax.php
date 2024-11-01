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

  $('#yaawp_total').text($("tbody input.import:checked").length);

  $('#i_progressbar').hide();

  $('#new').click(function(event) {
    event.preventDefault();

    var name = $('#tag-name').val();
    if (name == '') return;
    var slug = $('#tag-slug').val();
    var parent = $('#parent option:selected').val();
    var description = $('#tag-description').val();

    $.ajax({
      url: ajaxurl,
      type: 'POST',
      dataType: 'json',
      data: {
        action: 'Backend',
        method: 'CreateImportTerm',
        name: name,
        slug: slug,
        parent: parent,
        description: description,
        nonce: yaawp.nonce
      },
      success: function(data, textStatus, xhr) {
        yaawp_add(data.id);
      }
    });
    
  });

  $('#add').click(function(event) {
    event.preventDefault();

    var post_category = $('#term-id option:selected').val();
    
    yaawp_add(post_category);
    
  });

function yaawp_add(term_id) {

  var post_category = term_id;

  $('#i_total').text($("tbody input.import:checked").length);
  $('#i_progressbar').show();

  var $promises = [];

  $('tbody input.import:checked').each(function(){
    var $this = $(this);

    $promises.push(
      $.ajax({
        url: ajaxurl,
        type: 'POST',
        dataType: 'json',
        data: {
          action: 'Backend',
          method: 'CreateImportItem',
          post_category: post_category,
          asin: $this.val(),
          nonce: yaawp.nonce
        },
        complete: function(xhr, textStatus) {
        },
        success: function(data, textStatus, xhr) {
          if (data.status == 1) {
            var alt = parseInt($('#i_current').text())+1;
            $('#i_current').text(alt);
          } else {
            var alt = parseInt($('#i_fail').text())+1;
            $('#i_fail').text(alt);
          }
        },
        error: function(xhr, textStatus, errorThrown) {
        }
      })
    );
  });

  $.when.apply($, $promises).then(function(){
    alert(<?php echo __('Fertig', 'yaawp'); ?>);
  }); 

}


});
</script>

</head>
<body>

  <div class="form-wrap" style="-webkit-border-radius: 3px;border-radius: 3px;border-width: 1px;border-style: solid;border-color: #dfdfdf;background-color: #f9f9f9;padding: 5px; margin-top: 15px;">
    <h2><?php echo __('Artikel gesammt', 'yaawp'); ?></h2>
    <div class="form-field" style="margin: 0; padding: 3px 0;" id="yaawp_total"></div>
  </div>

  <hr style="margin: 10px 0;" />

  <div class="form-wrap" style="-webkit-border-radius: 3px;border-radius: 3px;border-width: 1px;border-style: solid;border-color: #dfdfdf;background-color: #f9f9f9;padding: 5px;">
    <h2><?php echo __('Neue Kategorie', 'yaawp'); ?></h2>
    <form id="addtag" method="post" action="edit-tags.php" class="validate">
    <input type="hidden" name="action" value="add-tag">
    <input type="hidden" name="screen" value="edit-shop_category">
    <input type="hidden" name="taxonomy" value="shop_category">
    <input type="hidden" name="post_type" value="shop">
    <div class="form-field form-required">
      <label for="tag-name"><?php echo __('Name', 'yaawp'); ?></label>
      <input name="tag-name" id="tag-name" type="text" value="" size="40" aria-required="true" style="width: 100%">
    </div>
    <div class="form-field" style="margin: 0; padding: 3px 0;">
      <label for="tag-slug">Slug</label>
      <input name="slug" id="tag-slug" type="text" value="" size="40" style="width: 100%">
      <p><?php echo __('Die "Titelform (in URLs)" ist die URL-Variante des Namens. Sie besteht normalerweise nur aus Kleinbuchstaben, Zahlen und Bindestrichen.', 'yaawp'); ?></p>
    </div>
    <div class="form-field" style="margin: 0; padding: 3px 0;">
      <label for="parent"><?php echo __('&Uuml;bergeordnet', 'yaawp'); ?></label>
      <select name="parent" id="parent" class="postform">
        <option value="-1" selected="selected"><?php echo __('Keine', 'yaawp'); ?></option>
        <?php 
        echo yaawp_terms_dropdown_options();
        ?>
      </select>
      </div>
    <div class="form-field" style="margin: 0; padding: 3px 0;">
      <label for="tag-description"><?php echo __('Beschreibung', 'yaawp'); ?></label>
      <textarea name="description" id="tag-description" rows="2" cols="40"></textarea>
      <p><?php echo __('Die Beschreibung wird nicht immer angezeigt. Bei dem ein oder anderen Theme mag sie angezeigt werden.', 'yaawp'); ?></p>
    </div>

    <p class="submit"><input type="submit" name="submit" id="new" class="button button-primary" value="<?php echo __('Kategorie erstellen und Artikel importieren.', 'yaawp'); ?>"></p></form>
  </div>

  <hr style="margin: 10px 0;" />

  <div class="form-wrap" style="-webkit-border-radius: 3px;border-radius: 3px;border-width: 1px;border-style: solid;border-color: #dfdfdf;background-color: #f9f9f9;padding: 5px;">
    <h2><?php echo __('bestehende Kategorie', 'yaawp'); ?></h2>
    <form id="addtag" method="post" action="edit-tags.php" class="validate">

      <div class="form-field" style="margin: 0; padding: 3px 0;">
        <select name="term-id" id="term-id" class="postform">
        <?php 
        echo yaawp_terms_dropdown_options();
        ?>
        </select>
      </div>

      <p class="submit"><input type="submit" name="submit" id="add" class="button button-primary" value="<?php echo __('Artikel in diese Kategorie importieren.', 'yaawp'); ?>"></p>

    </form>
  </div>

  <div id="i_progressbar" style="margin-top: 10px; -webkit-border-radius: 3px;border-radius: 3px;border-width: 1px;border-style: solid;border-color: #dfdfdf;background-color: #f9f9f9;padding: 5px;"><strong><?php echo __('Status', 'yaawp'); ?>:</strong> <span id="i_current">0</span> / <span id="i_total"></span> <?php echo __('Artikel importiert. Fehlgeschlagen:', 'yaawp'); ?> <span id="i_fail">0</span>.</div>

</div>
</body>
</html>