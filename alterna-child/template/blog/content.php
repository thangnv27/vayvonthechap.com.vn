<?php

/**

 * Image Post Content

 *

 * @since alterna 7.0

 */

global $blog_show_type;

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('entry-post '.(intval($blog_show_type) != 0 ? "blog-show-style-2" : ""));?> itemscope itemtype="http://schema.org/Article">

<div class="row">

<?php if(intval($blog_show_type) == 0){ ?>

    <section class="entry-left-side col-md-4 col-sm-12">

       <?php if(has_post_thumbnail(get_the_ID())) { ?>

        <div class="post-element-content">

            <div class="post-img">

                <?php echo get_the_post_thumbnail(get_the_ID(), "post-thumbnail" , array('alt' => get_the_title(),'title' => '')); ?>

                <?php $full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>

                <div class="post-tip">

                    <div class="bg"></div>

                    <a href="<?php echo get_permalink(); ?>"><div class="link left-link"><i class="big-icon-link"></i></div></a>

                    <a href="<?php echo esc_url($full_image[0]); ?>" class="fancyBox"><div class="link right-link"><i class="big-icon-preview"></i></div></a>

                </div>

            </div>

        </div>

        <?php } ?>

    </section>

    

    <!-- post content -->

    <section class="entry-right-side col-md-8 col-sm-12">

        

        

        <header class="entry-header">

        	<?php the_title( '<h3 class="entry-title" itemprop="name"><a href="' . esc_url( get_permalink() ) . '" itemprop="url">', '</a></h3>' ); ?>

        	<?php edit_post_link(__('Edit', 'alterna'), '<div class="post-edit"><i class="fa fa-edit"></i>', '</div>'); ?>

        	<div class="post-meta">

                <?php alterna_posted_on(); ?>

                <div class="entry-link"><a href="<?php echo the_permalink();?>"><i class="fa fa-link"></i></a></div>

            </div>

        </header><!-- .entry-header -->

        <div class="entry-summary" itemprop="articleSection">

        <?php the_excerpt(); ?>

		</div><!-- .entry-summary -->

        <?php echo '<a class="more-link" href="'.esc_url( get_permalink() ).'">'.__('Read More','alterna').'</a>'; ?>

    </section>

<?php }else{ ?>

    <section class="entry-left-side col-md-6 col-sm-12">

        <?php if(has_post_thumbnail(get_the_ID())) { ?>

        <div class="post-element-content">

            <div class="post-img">

                <a href="<?php echo get_permalink(); ?>"><?php echo get_the_post_thumbnail(get_the_ID(), "post-thumbnail" , array('alt' => get_the_title(),'title' => '')); ?></a>

            </div>

        </div>

        <?php } ?> 

    </section>

    

    <!-- post content -->

    <section class="entry-right-side col-md-6 col-sm-12">

        <header class="entry-header">

            <div class="date entry-date updated" itemprop="datePublished"><?php echo esc_html(get_the_date()); ?></div>

            <?php edit_post_link(__('Edit', 'alterna'), '<div class="post-edit"><i class="fa fa-edit"></i>', '</div>'); ?>

            <?php the_title( '<h3 class="entry-title" itemprop="name"><a href="' . esc_url( get_permalink() ) . '" itemprop="url">', '</a></h3>' ); ?>

            <div class="post-meta">

                <?php alterna_posted_on(); ?>

                <div class="entry-comments"><a href="<?php echo get_permalink(get_the_ID()).'#comments'; ?>"><i class="fa fa-comments"></i><span itemprop="interactionCount"><?php comments_number(0 , 1 , '%'); ?></span></a></div>

            </div>

        </header><!-- .entry-header -->

        <div class="entry-summary" itemprop="articleSection">

        <?php the_excerpt(); ?>

        </div><!-- .entry-summary -->

        <?php echo '<a class="more-link" href="'.esc_url( get_permalink() ).'">'.__('Read More','alterna').'</a>'; ?>

    </section>

<?php } ?>

</div>

</article>

        