<?php

get_header(); ?>
<section id="primary" class="site-content">
    <div id="content" role="main">

    <?php

    $mylinks_categories = get_terms('shop_category', 'orderby=count&hide_empty=0&parent=0');
	$count = count($mylinks_categories);

	if ( $count > 0 ){

        echo '<div style="float: left;">';
		foreach ( $mylinks_categories as $k => $term ) {

            echo '<div style="float: left; height: 260px;"><div style="height: 32px;width: 302px;background-image: url(/wp-content/plugins/yaawp/assets/img/bg_home_nav.png);background-repeat: no-repeat; margin-right: 10px;" class="shadow">';
                echo '<div style="padding: 10px"><a href="'.get_term_link($term->slug, 'shop_category').'" title="'.$term->name.'" style="font-weight: bold;">'.$term->name.'</a></div>';
                echo '<a href="'.get_term_link($term->slug, 'shop_category').'" title="'.$term->name.'"><img src="/wp-content/plugins/yaawp/classes/timthumb.php?src='.yaawp::yaawp_taxonomy_image_url($term->term_id, TRUE).'&h=212&w=300" alt="'.$term->name.'" style="border: 1px solid #c1c1c1" class="rounded shadow" /></a>';
            echo '</div></div>';

            if ( $k % 2 == 1 ) echo '<div class="clearfix"></div>';

		}

        echo '</div>';

	}

    ?>

    </div>
</section>
<?php wp_reset_query(); ?>

<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
    <div id="secondary" class="widget-area" role="complementary">
        <aside id="yaawp_widget_categ-3" class="widget yaawp_widget_categ">
            <h3 class="widget-title">Kategorien</h3>

            <?php yaawp_sidebar_terms(); ?>
            
        </aside>
        <?php dynamic_sidebar( 'sidebar-1' ); ?>
    </div><!-- #secondary -->
<?php endif; ?>

<?php get_footer(); ?>