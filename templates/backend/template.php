<div class="wrap">  
	<div id="icon-themes" class="icon32"></div>  
	<h2><?php echo __('Yet Another Amazon Wordpress Plugin', $this->var_sTextdomain); ?></h2>
	<div class="notice"><p></p></div>

	<?php
		if ( get_option('yaawp_news') ):

		echo '<h2>';
		foreach ( $links as $link ) : echo $link; endforeach;
		echo '</h2>';

		include('yaawp-admin_'.$active_tab.'.php');

		if ( get_option('yaawp_news') == 1 ):
			echo '<div style="width: 55%; float: left;">';
			echo '<iframe src="http://www.yaawp-plugin.com/remote_server" width="100%" height="600px" style="border-style: solid; border-width: 1px 1px 0; border-color: #dfdfdf #dfdfdf #fff; margin-left: 15px;">A page about learning iFrames</iframe>';
			echo '</div>';
		endif;
		
		else:
			include('yaawp-admin_setup.php');
    	endif;
	?>

</div><!-- /.wrap -->  