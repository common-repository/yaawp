<?php

get_header(); ?>

    <section id="primary" class="site-content">
        <div id="content" role="main">

        <?php if ( have_posts() ) : ?>
            <header class="archive-header">
                <h1 class="archive-title"><?php

                    global $wp_query;
                    $term = $wp_query->queried_object;
                    echo $term->name;

                ?></h1>

                <?php
                    if ( class_exists('yaawp') ):
                        $image = yaawp::yaawp_taxonomy_image_url();
                        if ( $image ):
                            $image = '/wp-content/plugins/yaawp/classes/timthumb.php?src='.$image.'&h=180&w=624';
                            echo '<img class="rounded shadow" style="margin-top: 10px;" src="'.$image.'" />';
                        endif;
                    endif;
                    if ( $term->description ):
                        echo '<p style="margin: 20px 0 0 0;">'.$term->description.'</p>';
                    endif;
                ?>

            </header>

            <?php while ( have_posts() ) : the_post(); ?>

            <div style="width: 192px; position: relative; float: left; margin: 0 16.3px 8px 0;">

                <div style="height: 300px; width: 180px; float: left; box-shadow: 0 0 5px #CCC; padding: 5px; overflow: visible !important;"><?php if(get_post_meta($post->ID, 'AmountSavedFormattedPrice', true)): ?><div class="special_promo"></div><?php endif; ?>

                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" rel="nofollow" style="border-radius: 3px; box-shadow: 0 1px 4px rgba(0, 0, 0, 0.2); float: left; text-align: center; width: 180px; height: 180px; vertical-align: middle; display: block;" id="img_<?php echo get_post_meta($post->ID, 'ASIN', true); ?>">
                        <img src="<?php echo get_post_meta($post->ID, 'LargeImageUrl', true); ?>" alt="<?php the_title(); ?>" style="max-width: 150px; max-height: 175px;display:block; margin: 2px auto">
                    </a>

                    <div style="position: relative; top: 10px;">
                        <a href="<?php the_permalink(); ?>" style="display: block;font-weight: 700;font-size: 12px;margin: 0 0 8px 0;" title="<?php the_title(); ?>"><?php $title = get_the_title(); if(strlen($title)>70): echo substr($title,0,70).' ...'; else: echo $title; endif; ?></a>
                    </div>

                    <p class="price" style="bottom: 40px; text-align: left;position: absolute;left: 10px;height: 30px;margin: 0;">
                    <span class="price"><?php $preis = (get_post_meta($post->ID, 'LowestOfferFormattedPrice', true)) ? get_post_meta($post->ID, 'LowestOfferFormattedPrice', true) : get_post_meta($post->ID, 'LowestNewOfferFormattedPrice', true); echo $preis; if(get_post_meta($post->ID, 'AmountSavedFormattedPrice', true)): echo '<sub style="font-size: 50%; bottom: 0;"> ('.get_post_meta($post->ID, 'AmountSavedFormattedPrice', true).' '.__('sparen', 'yaawp').')</sub>'; endif; ?>
                    </span></p>

                    <span style="font-weight: bold; position: absolute; bottom: 10px;"><a href="<?php echo get_post_meta($post->ID, 'DetailPageURL', true); ?>" style="text-decoration: none;" data-id="<?php echo get_post_meta($post->ID, 'ASIN', true); ?>"><img src="/wp-content/plugins/yaawp/assets/img/amazon.png"></a></span>

                </div>

            </div>

            <?php 
            endwhile;
            twentytwelve_content_nav( 'nav-below' );
            else :
            get_template_part( 'content', 'none' );
            endif;
            ?>

        </div><!-- #content -->
    </section><!-- #primary -->


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