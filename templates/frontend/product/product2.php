<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

    <div id="primary" class="site-content">
        <div id="content" role="main">

            <?php while ( have_posts() ) : the_post();  endwhile; ?>

            <div class="product-view" style="margin: 0; padding: 0;">

                <h1 style="margin: 0 0 15px 0;font: bold 20px/1.35 Arial, Helvetica, sans-serif;"><?php the_title(); ?></h1>

                <div class="product-essential" style="padding: 0 0 8px;">

                    <div class="product-img-box" style="float: left; width: 267px;">

                        <p class="product-image" style="margin: 0 0 8px; border: 1px solid #D5D5D5;" id="img_<?php echo get_post_meta($post->ID, 'ASIN', true); ?>">
                            <a href="<?php echo get_post_meta($post->ID, 'LargeImageUrl', true); ?>" title="<?php the_title(); ?>" class="thickbox"><img src="<?php echo get_post_meta($post->ID, 'LargeImageUrl', true); ?>" alt="<?php the_title(); ?>" style="max-width: 250px; max-height: 350px;"></a>
                        </p>

                        <div class="more-views ma-more-img">
                            <h2 style="font-size: 11px;border-bottom: 1px solid #CCC;margin: 0 0 8px;text-transform: uppercase;">Mehr</h2>
                            <ul style="margin-left: -9px; list-style: none; padding: 0; margin: 0;">
                                <?php
                                    $small = (get_post_meta($post->ID, 'ImageSetTiny0', true)) ? get_post_meta($post->ID, 'ImageSetTiny0', true) : 'http://placehold.it/76x96.png';
                                    $large = (get_post_meta($post->ID, 'ImageSetLarge0', true)) ? get_post_meta($post->ID, 'ImageSetLarge0', true) : 'http://placehold.it/760x960.png';
                                ?>
                                <li style="float: left;margin: 0 0 8px 9px;">
                                    <a href="<?php echo $large; ?>" style="float: left;width: 76px;height: 96px;border: 1px solid #E1E1E1;overflow: hidden;" title="<?php the_title(); ?>" class="thickbox" rel="gallery-<?php echo get_post_meta($post->ID, 'ASIN', true); ?>"><img src="<?php echo $small; ?>" alt="" style="border: 0;vertical-align: top; max-width: 75px; max-height: 95"></a>
                                </li>
                                <?php
                                    $small = (get_post_meta($post->ID, 'ImageSetTiny1', true)) ? get_post_meta($post->ID, 'ImageSetTiny1', true) : 'http://placehold.it/76x96.png';
                                    $large = (get_post_meta($post->ID, 'ImageSetLarge1', true)) ? get_post_meta($post->ID, 'ImageSetLarge1', true) : 'http://placehold.it/760x960.png';
                                ?>
                                <li style="float: left;margin: 0 0 8px 9px;">
                                    <a href="<?php echo $large; ?>" style="float: left;width: 76px;height: 96px;border: 1px solid #E1E1E1;overflow: hidden;" title="<?php the_title(); ?>" class="thickbox" rel="gallery-<?php echo get_post_meta($post->ID, 'ASIN', true); ?>"><img src="<?php echo $small; ?>" alt="" style="border: 0;vertical-align: top; max-width: 75px; max-height: 95"></a>
                                </li>
                                <?php
                                    $small = (get_post_meta($post->ID, 'ImageSetTiny2', true)) ? get_post_meta($post->ID, 'ImageSetTiny2', true) : 'http://placehold.it/76x96.png';
                                    $large = (get_post_meta($post->ID, 'ImageSetLarge2', true)) ? get_post_meta($post->ID, 'ImageSetLarge2', true) : 'http://placehold.it/760x960.png';
                                ?>
                                <li style="float: left;margin: 0 0 8px 9px;">
                                    <a href="<?php echo $large; ?>" style="float: left;width: 76px;height: 96px;border: 1px solid #E1E1E1;overflow: hidden;" title="<?php the_title(); ?>" class="thickbox" rel="gallery-<?php echo get_post_meta($post->ID, 'ASIN', true); ?>"><img src="<?php echo $small; ?>" alt="" style="border: 0;vertical-align: top; max-width: 75px; max-height: 95"></a>
                                </li>
                            </ul>
                        </div>

                    </div>

                    <div style="float: right; width: 350px;">
                    <?php
                        $content = get_the_content();
                        if ( !empty($content) ):
                    ?>
                        <div style="float: left;width: 350px;font-size: 12px;border: 1px solid #D5D5D5;margin-bottom: 10px;"><div style="padding: 5px 10px;">
                            <?php echo $content; ?>
                        </div></div>

                    <?php
                        endif;
                        $amazon = get_post_meta($post->ID, 'AmazonDescription', true);
                        if ( !empty($amazon) ):
                    ?>

                    <div style="float: left;width: 350px;font-size: 12px;border: 1px solid #D5D5D5;margin-bottom: 10px;"><div style="padding: 5px 10px;">
                        <?php echo $amazon; ?>
                    </div></div>

                    <?php endif; ?>
                    </div>

                    <div style="float: right;width: 350px;">
                        <div style="float: left;width: 350px;font-size: 12px; border: 1px solid #D5D5D5">
                            <p style="line-height: 20px; margin: 0 10px; background: url('/wp-content/plugins/yaawp/assets/img/bullet.png') no-repeat scroll 0 11px transparent;border-bottom: 1px solid #DEDEDE;padding: 5px 20px 5px 12px;">
                                Kundenstimmen auf Amazon: <span style="font-weight: bold;"><a style="text-decoration: none;" href="<?php echo get_post_meta($post->ID, 'CustomerReviewsIFrameURL', true); ?>&amp;KeepThis=true&amp;TB_iframe=true&amp;height=400&amp;width=600" title="Kundenstimmen" class="thickbox" rel="nofollow">hier klicken</a></span>
                            </p>
                            <p style="line-height: 20px; margin: 0 10px; background: url('/wp-content/plugins/yaawp/assets/img/bullet.png') no-repeat scroll 0 11px transparent;border-bottom: 1px solid #DEDEDE;padding: 5px 20px 5px 12px;">
                                Amazon ASIN: <span style="font-weight: bold;"><?php echo get_post_meta($post->ID, 'ASIN', true); ?></span>
                            </p>
                            <p style="line-height: 20px; margin: 0 10px; background: url('/wp-content/plugins/yaawp/assets/img/bullet.png') no-repeat scroll 0 11px transparent;border-bottom: 1px solid #DEDEDE;padding: 5px 20px 5px 12px;">
                                Verf&uuml;gbarkeit: <span style="font-weight: bold;"><?php echo get_post_meta($post->ID, 'Availability', true); ?></span>
                            </p>
                            <p style="line-height: 20px; margin: 0 10px; background: url('/wp-content/plugins/yaawp/assets/img/bullet.png') no-repeat scroll 0 11px transparent;border-bottom: 1px solid #DEDEDE;padding: 5px 20px 5px 12px;">
                                Kategorie: <span style="font-weight: bold;"><?php $terms = get_the_terms( $post->ID, 'shop_category' );foreach ($terms as $term){echo '<a href="'.get_term_link($term->slug, 'shop_category').'">'.$term->name.'</a>';} ?></span>
                            </p>
                            <p style="line-height: 20px; margin: 0 10px; background: url('/wp-content/plugins/yaawp/assets/img/bullet.png') no-repeat scroll 0 11px transparent;border-bottom: 1px solid #DEDEDE;padding: 5px 20px 5px 12px;">
                                Preis (<?php echo get_post_meta($post->ID, 'LastCheck', true); ?>): <span style="font-weight: bold;"><?php $preis = (get_post_meta($post->ID, 'LowestOfferFormattedPrice', true)) ? get_post_meta($post->ID, 'LowestOfferFormattedPrice', true) : get_post_meta($post->ID, 'LowestNewOfferFormattedPrice', true); echo $preis; if(get_post_meta($post->ID, 'AmountSavedFormattedPrice', true)): echo '<sub style="font-size: 60%;"> ('.get_post_meta($post->ID, 'AmountSavedFormattedPrice', true).' sparen)</sub>'; endif; ?> </span>
                            </p>
                            <?php if (get_post_meta($post->ID, 'ListPriceFormatted', true) > $preis ): ?>
                            <p style="line-height: 20px; margin: 0 10px; background: url('/wp-content/plugins/yaawp/assets/img/bullet.png') no-repeat scroll 0 11px transparent;border-bottom: 1px solid #DEDEDE;padding: 5px 20px 5px 12px;">
                                Preis UVP (<?php echo get_post_meta($post->ID, 'LastCheck', true); ?>): <span style="font-weight: bold; text-decoration: line-through;"><?php echo get_post_meta($post->ID, 'ListPriceFormatted', true); ?></span>
                            </p>
                            <?php endif; ?>
                            <p style="line-height: 20px; margin: 0;border-bottom: 0px solid #DEDEDE;padding: 5px 20px 5px 12px;">
                                <span style="font-weight: bold;"><a href="<?php echo get_post_meta($post->ID, 'DetailPageURL', true); ?>" style="text-decoration: none;"><img src="/wp-content/plugins/yaawp/assets/img/amazon.png"></a></span>
                            </p>
                        </div><br class="clearfix" />
                    </div><div style="clear: both;"></div>

                </div>

            </div>

        </div>
    </div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>