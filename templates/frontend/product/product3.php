<?php

get_header(); ?>

    <div id="primary" class="site-content">
        <div id="content" role="main">

            <?php while ( have_posts() ) : the_post(); endwhile; ?>

            <div style="font-size: 150%;font-family: 'Arial Narrow', 'LeagueGothicRegular', Arial, Helvetica, sans-serif;padding-top: 5px;padding-bottom: 3px;background-color: #d3d3d3;vertical-align: middle;padding: 4px 10px;position: relative;">
                <h1 style="margin: 0;font-family: 'LeagueGothicRegular', 'Arial Narrow', Arial, Helvetica, sans-serif;font-size: 120%;font-weight: 400;text-transform: uppercase;">
                    <?php $title = get_the_title(); if (strlen($title) > 80): echo substr($title,0,80).' ...'; else: echo $title; endif; ?>
                </h1>
            </div>

            <div style="position: relative;background: transparent url('/wp-content/plugins/yaawp/assets/img/HeCoSep.png') bottom left repeat-x;padding-bottom: 20px;margin-bottom: 20px;color: #444;">

                <div style="padding: 6px;border: #a8a8a8 solid 1px;display: block;">

                    <div style="width: 55px;min-height: 200px;text-align: center;margin-right: 5px; float: left;">

                        <div style="height: 15px;background-color: #d3d3d3;">
                            <a href="#" style="color: #FFF;padding: 3px 20px;background: transparent;text-decoration: none;" id="p4_up">▲</a>
                        </div>

                        <ul style="max-height: 250px;height: auto;margin-top: 3px;overflow: hidden;position: relative;margin: 0;list-style: none;">
                            <?php
                                $small = (get_post_meta($post->ID, 'ImageSetTiny0', true)) ? get_post_meta($post->ID, 'ImageSetTiny0', true) : 'http://placehold.it/76x96.png';
                                $large = (get_post_meta($post->ID, 'ImageSetLarge0', true)) ? get_post_meta($post->ID, 'ImageSetLarge0', true) : 'http://placehold.it/760x960.png';
                            ?>
                            <li style="width: 55px;margin-bottom: 5px; margin-top: 5px;">
                                <a href="<?php echo $large; ?>" style="color: #006291;background: transparent;text-decoration: none;" class="preview_small">
                                    <img src="<?php echo $small; ?>" style="border: 0 solid;margin: 0;padding: 0;max-width: 55px;max-height: 55px;">
                                </a>
                            </li>
                            <?php
                                $small = (get_post_meta($post->ID, 'ImageSetTiny1', true)) ? get_post_meta($post->ID, 'ImageSetTiny1', true) : 'http://placehold.it/76x96.png';
                                $large = (get_post_meta($post->ID, 'ImageSetLarge1', true)) ? get_post_meta($post->ID, 'ImageSetLarge1', true) : 'http://placehold.it/760x960.png';
                            ?>
                            <li style="width: 55px;margin-bottom: 5px;">
                                <a href="<?php echo $large; ?>" style="color: #006291;background: transparent;text-decoration: none;" class="preview_small">
                                    <img src="<?php echo $small; ?>" style="border: 0 solid;margin: 0;padding: 0;max-width: 55px;max-height: 55px;">
                                </a>
                            </li>
                            <?php
                                $small = (get_post_meta($post->ID, 'ImageSetTiny2', true)) ? get_post_meta($post->ID, 'ImageSetTiny2', true) : 'http://placehold.it/76x96.png';
                                $large = (get_post_meta($post->ID, 'ImageSetLarge2', true)) ? get_post_meta($post->ID, 'ImageSetLarge2', true) : 'http://placehold.it/760x960.png';
                            ?>
                            <li style="width: 55px;margin-bottom: 5px;">
                                <a href="<?php echo $large; ?>" style="color: #006291;background: transparent;text-decoration: none;" class="preview_small">
                                    <img src="<?php echo $small; ?>" style="border: 0 solid;margin: 0;padding: 0;max-width: 55px;max-height: 55px;">
                                </a>
                            </li>
                        </ul>

                        <div style="height: 15px;background-color: #d3d3d3;">
                            <a href="#" style="color: #FFF;padding: 3px 20px;background: transparent;text-decoration: none;" id="p4_down">▼</a>
                        </div>

                    </div>

                    <div style="width: 290px;overflow: hidden;position: relative;margin-right: 5px;float: left;">
                        <div class="wraptocenter product4"><span></span>
                            <p style="line-height: 1.5em;margin: 0 0 1em 0;" id="img_<?php echo get_post_meta($post->ID, 'ASIN', true); ?>">
                                <a href="<?php echo get_post_meta($post->ID, 'LargeImageUrl', true); ?>" class="thickbox" title="<?php the_title(); ?>"><img src="<?php echo get_post_meta($post->ID, 'LargeImageUrl', true); ?>" alt="<?php the_title(); ?>" style="max-width: 290px;max-height: 290px;" id="preview_large"></a>
                            </p>
                        </div>
                    </div>

                    <div style="margin-top: 10px;width: 250px;float: left;">

                        <!-- Verfuegbarkeit -->
                        <div style="height: 65px;background: transparent url('/wp-content/plugins/yaawp/assets/img/HeCoSep.png') bottom left repeat-x;padding-bottom: 10px;margin-bottom: 10px;">
                            <div style="padding-left: 10px;width: 230px; float: left;">
                                <div style="line-height: 1.5em;font-weight: 700;">Verf&uuml;gbarkeit:</div>
                                <div style="margin-top: 5px;line-height: 1.5em;font-weight: 700;">
                                    <?php if ( get_post_meta($post->ID, 'Availability', true) == 'verf&uuml;gbar' ): ?>
                                    <div style="line-height: 1.5em;background-position: 0 0;background-repeat: no-repeat;padding-left: 28px;float: left;background-image: url('/wp-content/plugins/yaawp/assets/img/verfuegbar.png');min-height: 28px;padding: 2px 0 2px 30px;color: #95CD00;">
                                         <?php echo get_post_meta($post->ID, 'Availability', true); ?>
                                    </div>
                                    <?php else: ?>
                                    <div style="line-height: 1.5em;background-position: 0 0;background-repeat: no-repeat;padding-left: 28px;float: left;background-image: url('/wp-content/plugins/yaawp/assets/img/nicht_verfuegbar.png');min-height: 28px;padding: 2px 0 2px 30px;color: #b94a48;">
                                         <?php echo get_post_meta($post->ID, 'Availability', true); ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <br style="clear: both;">
                        </div>

                        <!-- Produktinfo -->
                        <div style="height: 65px;margin-bottom: 20px;">
                            <div style="padding-left: 10px;width: 110px;float: left;">
                                <div style="line-height: 1.5em;font-weight: 700;">Informationen:</div>
                            </div>
                            <div style="width: 230px;float: left;margin-bottom: 20px;padding-left:10px;">
                                <ul style="margin: 0;list-style: none; font-size: 12px">
                                    <li style="line-height: 1.5em;">Kategorie: <span style="font-style:italic;"><?php $terms = get_the_terms( $post->ID, 'shop_category' );foreach ($terms as $term){echo '<a href="'.get_term_link($term->slug, 'shop_category').'">'.$term->name.'</a>';} ?></span></li>
                                    <li style="line-height: 1.5em;">Asin: <span style="font-style:italic;"><?php echo get_post_meta($post->ID, 'ASIN', true); ?></span></li>
                                    <li style="line-height: 1.5em;">Gesamtpreis: <span style="font-style:italic;"><?php $preis = (get_post_meta($post->ID, 'LowestOfferFormattedPrice', true)) ? get_post_meta($post->ID, 'LowestOfferFormattedPrice', true) : get_post_meta($post->ID, 'LowestNewOfferFormattedPrice', true); echo $preis; ?></span></li>
                                </ul>
                            </div>
                            <br style="clear: both;">
                        </div>

                        <!-- Preis -->

                        <div style="width: 100%;float: left;">

                            <!-- Sparen -->
                            <?php if(get_post_meta($post->ID, 'AmountSavedFormattedPrice', true)): ?>
                            <div style="background: #e60000 url('/wp-content/plugins/yaawp/assets/img/preis_naht.png') bottom left repeat-x;color: #fff;min-width: 155px;height: 45px;padding: 10px;text-align: center;font-family: 'LeagueGothicRegular', sans-serif;">
                                <div style="font-size: 110%;float: right;text-align: left;text-transform: uppercase;">
                                    <div style="top: 2px;position: relative;">Euro</div>
                                    <div style="top: 2px;position: relative;">Sparen</div>
                                </div>
                                <div style="line-height: .9em;margin-right: 8px;font-size: 300%;float: right;margin-bottom: 1px;text-transform: uppercase;">
                                    <?php echo str_replace('EUR ','',get_post_meta($post->ID, 'AmountSavedFormattedPrice', true)); ?>
                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if ( get_post_meta($post->ID, 'Availability', true) == 'verf&uuml;gbar' ): ?>
                            <div style="height: 18px;text-transform: uppercase;font-size: 140%;padding: 10px;text-align: center;font-family: 'LeagueGothicRegular', sans-serif;background-color: #CCE0E9;color: #006291;">
                                <a href="<?php echo get_post_meta($post->ID, 'DetailPageURL', true); ?>" style="color: #006291;background-position: 0 0;background-repeat: no-repeat;padding-left: 28px;float: left;line-height: 26px;vertical-align: middle;background-image: url('/wp-content/plugins/yaawp/assets/img/in_den_warenkorb.gif');text-decoration: none; float: right;" class="wc">Produkt Kaufen</a>
                            </div><span class="productPrice" style="display: none;"><?php $preis = (get_post_meta($post->ID, 'LowestOfferFormattedPrice', true)) ? get_post_meta($post->ID, 'LowestOfferFormattedPrice', true) : get_post_meta($post->ID, 'LowestNewOfferFormattedPrice', true); echo $preis; ?></span>
                            <?php endif; ?>
                        </div>

                    </div><br style="clear: both;">

                </div>

            </div>

             <?php
                $content = get_the_content();
                if ( !empty($content) ):
            ?>
            <div style="padding: 10px;line-height: 1.5em;margin-bottom: 20px;border: #a8a8a8 solid 1px;">
                <span style="line-height: 1.5em;margin: 0 0 1em 0;"><?php echo $content; ?></span>
            </div><br style="clear: both;">

            <?php
                endif;
                $amazon = get_post_meta($post->ID, 'AmazonDescription', true);
                if ( !empty($amazon) ):
            ?>

            <div style="padding: 10px;line-height: 1.5em;margin-bottom: 20px;border: #a8a8a8 solid 1px;">
                <span style="line-height: 1.5em;margin: 0 0 1em 0;"><?php echo $amazon; ?></span>
            </div><br style="clear: both;">

            <?php endif; ?>

        </div>
    </div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>