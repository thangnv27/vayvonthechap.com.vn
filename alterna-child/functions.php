<?php
/**
 * alterna child theme functions and definitions
 *
 * @since alterna 9.4
 */

function child_shortcode() {
	return get_bloginfo('stylesheet_directory');
}

add_shortcode('dirTheme', 'child_shortcode');

function searchform_shortcode() {
	$output = "";
	//$output .= '<div class="alterna-nav-form-container">';
	/*$output .= '<div class="top_search">';
    $output .=                '<form role="search" class="sidebar-searchform" method="get" action="' . esc_url( home_url( '/' ) ) . '">';
    $output .=                   '<div>';
                            if (class_exists( 'woocommerce' ) && penguin_get_options_key('shop-product-search') == "on") {
    $output .=                            '<input class="sf-type" name="post_type" type="hidden" value="product" />';
                            }
    $output .=              '<input id="sidebar-s" name="s" type="text" placeholder="'. __('Search','alterna') .'" />';
    $output .=                       '<input id="sidebar-searchsubmit" type="submit" value="" />';
    $output .=                   '</div>';
    $output .=                '</form>';
    $output .=            '</div>';*/
    //$output .=            '</div>';

    $output .= '<div class="top_search">';
    $output .=                '<form role="search" class="form-group has-feedback" method="get" action="' . esc_url( home_url( '/' ) ) . '">';
    $output .=                   '<div>';
                            if (class_exists( 'woocommerce' ) && penguin_get_options_key('shop-product-search') == "on") {
    $output .=                            '<input class="sf-type" name="post_type" type="hidden" value="product" />';
                            }
    $output .=              '<input class="form-control search-input" name="s" type="text" placeholder="'. __('Search','alterna') .'" />';
    $output .=                       '<span class="glyphicon glyphicon-search form-control-feedback"></span>';
    $output .=                   '</div>';
    $output .=                '</form>';
    $output .=            '</div>';


	return $output;
}
add_shortcode('searchform', 'searchform_shortcode');

function content_page($atts)
{

    $string = '';
    // Attributes
    extract( shortcode_atts(
        array(
            'page_id' => '',
            'title'  => '',
            'excerpt_length' => '80',
        ), $atts )
    );
    $the_query = new WP_Query( 'page_id=' . $page_id );

    if($the_query->have_posts())
    {
        while ($the_query->have_posts())
        {
            $the_query->the_post();
            $excerpt = wp_trim_words( get_the_content(), $excerpt_length, '...' );
            $string .= '<div class="intro">';
            /*$string .= '    <div class="title-post">';
            $string .= '    <h3>Giới thiệu</h3>';
            $string .= '    </div>';*/

            $string .= '    <div class="content-post">';
            $string .= '        <div class="imagesContent">';
            $string .= '        <a href="' . get_the_permalink() . '">';
            $string .=             get_the_post_thumbnail();
            $string .= '        </a>';
            $string .= '        </div>';

            $string .= '        <div class="inner-content">';
            $string .= ' 			<h3 class="title"><a href="' . get_the_permalink() . '">'. $title .'</a></h3>';
            $string .=  '<p>' .           $excerpt . '</p>';
            $string .= '        </div>';
            //$string .= '        <p class="link-more"><a href="' . get_the_permalink() . '">Đọc tiếp </a></p>';
            $string .= '    </div>';
            $string .= '</div>';
        }
    }

    wp_reset_postdata();
    return $string;
}

 add_shortcode('contentPage', 'content_page');

  function list_category_news($atts)
{
    global $string1;
   extract( shortcode_atts( array (
        'title' => 'Tin tức',
    ), $atts ) );

    $args = array(
    'cat' => $atts['cat_id'],
    'orderby' => 'date',
    'order'   => 'DESC',
    'posts_per_page' => $atts['per_page'],
);
    // Get the ID of a given category
    //$category_id = get_cat_ID( $atts['name'] );

    // Get the URL of this category
    $category_link = get_home_url(). '/tin-tuc'; //get_category_link( $atts['cat_id'] );
    $string = "";
    $string2 = "";
    if(get_bloginfo( 'language' )  == 'vi'){
        $string2 .= "Xem thêm";
    }else {
         $string2 .= "Read More";
    }
    $the_query = new WP_Query( $args );

    if($the_query->have_posts())
    {
        $string .= '<div class="cat-box">';

        while ($the_query->have_posts())
        {
            $the_query->the_post();$count ++ ;
           if($count == 1) :
            $string .= '<div class="first-news">';
             if ( function_exists("has_post_thumbnail") && has_post_thumbnail() ) :
                            $string .= '<div class="post-thumbnail">';
                            $string .= '<a href="'.get_the_permalink() .'" rel="bookmark">';
                            $string .=            get_the_post_thumbnail();
                            $string .=  '</a>';
                            $string .= '</div><!-- post-thumbnail /-->';
              endif;
                        $string .= '<div class="title_wrapper">';
                        $string .= '<h2 class="post-box-title"><a href="'.get_the_permalink().'" rel="bookmark">'.get_the_title().'</a></h2>';


                        $string .= '<div class="entry">';
                        $string .= '<p>'. wp_trim_words(get_the_excerpt() , 40).'</p>';
                        $string .=   '</div>';
                        $string .=  '<div class="more-link"><a href="'.get_the_permalink().'">'.$string2.'</a>';
                        $string .=  '</div>';
                         $string .=  '</div>';
            $string .= '</div><!-- .first-news -->';
            $string .= '<ul class="box-other">';
            else:
            $string .= '<li class="other-news">';
            $string .=           '<h3 class="post-box-title"><a href="'.get_the_permalink().'" rel="bookmark">'.get_the_title(). '</a></h3>';


             wp_reset_query();
            $string .='</li>';

           endif;

        }
        $string .= '</ul>';
        //$string .= '<p class="link-more grey"><a href="' . $category_link . '">Xem tất cả</a></p>';
        $string .= '</div>';


    }
    else
    {

    }
    return $string;

}

 add_shortcode('listCategorynews', 'list_category_news');

 function create_testimonials_custom_post_type() {

    $label = array(

        'name' => 'Testimonials',

        'singular_name' => 'Testimonials'

    );

    $args = array(

        'labels' => $label,

        'description' => 'Post type testimonials',

        'supports' => array(

            'title',

            'editor',

            'excerpt',

            'author',

            'thumbnail',

            'comments',

            'trackbacks',

            'revisions',

            'custom-fields'

        ),

        'taxonomies' => array('post_tag' ),

        'hierarchical' => false,

        'public' => true,

        'show_ui' => true,

        'show_in_menu' => true,

        'show_in_nav_menus' => true,

        'show_in_admin_bar' => true,

        'menu_position' => 5,

        'menu_icon' => 'dashicons-format-quote',

        'can_export' => true,

        'has_archive' => true,

        'exclude_from_search' => false,

        'publicly_queryable' => true,

        'capability_type' => 'post'

    );

    register_post_type( 'testimonials' , $args );

}

add_action( 'init', 'create_testimonials_custom_post_type' );

register_taxonomy('groups', 'testimonials',  array(

    'hierarchical' => true,

    'label' => 'Group',

    'query_var' =>  true,

    'rewrite' => true)

);

add_action( 'init', 'fastwp_create_custom_post_types' );
function fastwp_create_custom_post_types() {
   register_post_type( 'fwp_bank',
      array(
         'labels' => array(
            'name' => __( 'DS ngân hàng' ,'fastwp'),
            'singular_name' => __( 'Ngân hàng' ,'fastwp')
         ),
      'public'             => true,
      'menu_icon'          =>'dashicons-admin-multisite',
      'has_archive'        => false,
      'exclude_from_search'   => true,
      'show_in_nav_menus'     => false,
      'rewrite'            => array( 'slug' => _x( 'bank', 'URL slug', 'fastwp' ) ),
      'supports'           => array( 'title', 'editor', 'thumbnail' ),
      )
   );


}

add_action( 'init', 'fastwp_create_bank_taxonomy' );
function fastwp_create_bank_taxonomy(){

  $labels = array(
    'name'                => _x( 'Category', 'taxonomy general name','fastwp' ),
    'singular_name'       => _x( 'Category', 'taxonomy singular name','fastwp' ),
    'search_items'        => __( 'Search Categories','fastwp' ),
    'all_items'           => __( 'All Categories','fastwp' ),
    'parent_item'         => __( 'Parent Category','fastwp' ),
    'parent_item_colon'   => __( 'Parent Category:','fastwp' ),
    'edit_item'           => __( 'Edit Category','fastwp' ),
    'update_item'         => __( 'Update Category','fastwp' ),
    'add_new_item'        => __( 'Add New Category','fastwp' ),
    'new_item_name'       => __( 'New Category','fastwp' ),
    'menu_name'           => __( 'Categories','fastwp' )
  );

  $args = array(
    'hierarchical'        => true,
    'labels'              => $labels,
    'show_ui'             => true,
    'show_admin_column'   => true,
    'query_var'           => true,
   'show_in_nav_menus'     => false,
    'rewrite'             => array( 'slug' => 'bank-category' )
  );

  register_taxonomy( 'bank-category', 'fwp_bank', $args );

}

function testimonials($atts)

{

    $string1 = "";

    $string2 = "";

    if(get_bloginfo( 'language' )  == 'vi'){

        $string2 .= "Tất cả";

        $string1 .= "Đọc tiếp";

    }else {

         $string2 .= "View all";

         $string1 .= "Readmore";

    }
   extract( shortcode_atts( array (

        'title' => 'Tin tức',

    ), $atts ) );

    $taxonomy = 'groups';
    $post_type = 'testimonials';
    $tax_terms = get_terms( $taxonomy);

    $args = array(

    'post_type' => $post_type,

    'orderby' => 'date',

    'order'   => 'DESC',

    'posts_per_page' => $atts['per_page'],

);

    //$category_link =  get_category_link( $atts['cat_id'] );

    $string = "";

    $the_query = new WP_Query( $args );

    if($the_query->have_posts())
    {
        $string .= '<ul class="testimonials-box-2">';
        $string .= '<div class="testimonials-content">';

        while ($the_query->have_posts())

        {

            $the_query->the_post();$count ++ ;



            $string .= '<li class="item-news">';

             if ( function_exists("has_post_thumbnail") && has_post_thumbnail() ) :

                            $string .= '<div class="post-thumbnail">';

                            $string .= '<a href="'.get_the_permalink() .'" rel="bookmark">';

                            $string .=            get_the_post_thumbnail();

                            $string .=  '</a>';

                            $string .= '</div><!-- post-thumbnail /-->';

              endif;

                        $string .= '<div class="title_wrapper">';

                        $string .= '<h3 class="post-box-title"><a href="'.get_the_permalink().'" rel="bookmark">'.get_the_title().'</a></h3>';

                       $string .=  '</div>';

                        $string .= '<div class="entry">';

                        $string .= '<p>'. wp_trim_words(get_the_excerpt() , 8).'</p>';

                        $string .=   '</div>';

                         $string .= '<p class="link-more grey readmore"><a href="' . get_the_permalink(). '">'.$string1.'</a></p>';

            $string .= '</li><!-- .first-news -->';

        }

        $string .= '</div>';

        $string .= '</ul>';

    }
    else
    {

    }
    return $string;

}
 add_shortcode('testimonial', 'testimonials');
 add_shortcode('tin_dung_form', 'tin_dung_form');
function tin_dung_form($atts, $content){
        extract(shortcode_atts(array(
            'title'         => '',
            'id'        => '',
            'class'         => 'panel-pt-vay-von',
            'form'      => 'suport_deposits',
            'delay'     => 50,
            'icon'      => '',
            'col'       => 'col-md-8 col-md-offset-2',
        ), $atts));

        $module_wrap    = '<div class="%s">%s</div>';
        $item_wrap      = '<div class="note animated panel %s" data-animation="%s" data-animation-delay="%s"><div class="panel-heading"><span class="icon"></span><h4 class="panel-title">%s</h4></div><div class="panel-body">%s</div></div>';

        $items = '';
        $delay          += 50;
        $listRepayment = false;
        switch ($form) {
            case 'find_loan':
                $content = get_find_loan_form();

                break;

            case 'calculate_deposit':
                $content = get_calculate_form('deposit');
                break;

            case 'calculate_loan':
                $content = get_custom_calculate_form();
                $listRepayment = true;
                break;

            default:
                $content = get_suport_deposits_content();
                break;
        }


        $items          .= sprintf($item_wrap, $class, $class, $delay, $title, $content);

        if($listRepayment){
            $items .= '<div  id="listRepayment"></div>';
        }

        if($items != ''){
            return sprintf($module_wrap, $col, $items);
        }
        return;
    }

function get_suport_deposits_content(){
    ob_start();
        ?>
            <form action="" method="POST" class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="col-sm-4">Số tiền cần gửi</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text" name="amount" onkeyup="formatNumber(this);" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Kỳ hạn</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text" name="ky_han" onkeyup="formatMonth(this);" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Lãi suất</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="lai_suat" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-4">
                            <button type="submit" class="btn">Gửi</button>
                        </div>
                    </div>
            </form>


        <?php
        return ob_get_clean();
}

function get_find_loan_form(){
    global $bank_list;

    ob_start();
        ?>
            <form action="" method="POST" class="form-horizontal" role="form" id="calculate_loan">

                    <div class="form-group">
                        <div class="col-sm-8 col-sm-offset-4">
                            <label class="radio-inline">
                                <input class="calculate_loan" type="radio" name="loan_currency" id="loan_currency_vnd" value="vnd" checked="checked"> VND
                            </label>
                            <label class="radio-inline">
                                <input type="radio" class="calculate_loan" name="loan_currency" id="loan_currency_usd" value="usd"> USD
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Ngân hàng</label>
                        <div class="col-sm-8">
                            <select class="form-control calculate_loan" name="bank">
                            <?php
                                $args = array(
                           'post_type'   => 'fwp_bank',
                           'order'               => 'DESC',
                           'orderby'             => 'date',
                           'posts_per_page'         => -1,

                        );
                        $bank_list = get_posts( $args );
                            ?>
                                <?php foreach ($bank_list as $bank) { ?>
                                    <option value="<?php echo $bank->ID ?>"><?php echo $bank->post_title; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Kỳ hạn</label>
                        <div class="col-sm-8">
                            <select class="form-control calculate_loan" name="timeout">
                                <?php //foreach ($ky_han_gui_tien as $key=>$val) { ?>
                                    <!-- <option value="<?php echo $key ?>"><?php echo $val; ?></option> -->
                                <?php //} ?>

                                <option value="0">Không kỳ hạn</option>
                                <option selected="selected" value="1">1 tháng</option>
                                <option value="2">2 tháng</option>
                                <option value="3">3 tháng</option>
                                <option value="6">6 tháng</option>
                                <option value="9">9 tháng</option>
                                <option value="12">12 tháng</option>
                                <option value="18">18 tháng</option>
                                <option value="24">24 tháng</option>
                                <option value="36">36 tháng</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Lãi suất</label>
                        <div class="col-sm-8">
                            <?php
                                $first_bank = array_shift($bank_list);
                                $value = get_post_meta( $first_bank->ID, '_fastwp_meta', true );
                                $lai_suat = '';
                                if(isset($value['interest_rate_personal_vnd'][1])){
                                    $lai_suat = $value['interest_rate_personal_vnd'][1];
                                }

                            ?>
                            <input type="text" class="form-control" name="lai_suat" value="<?php echo $lai_suat; ?>" readonly="readonly">
                        </div>
                    </div>
                    <input type="hidden" name="do_job" value="calculate_loan">
            </form>
        <?php
        return ob_get_clean();
}

function get_calculate_form($type){
    // global $bank_list;

    ob_start();

        $args = array(
         'post_type'   => 'fwp_bank',
         'order'               => 'DESC',
         'orderby'             => 'date',
         'posts_per_page'         => -1,

      );
    $bank_list = get_posts( $args );
    ?>
            <form action="" method="POST" class="form-horizontal" role="form" id="calculate_<?php echo $type ?>_form">
                    <div class="form-group">
                        <label class="col-sm-4"><?php echo ($type=='deposit') ? "Số tiền gửi":"Số tiền vay"; ?></label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control number" name="amount" value="" >
                        </div>
                    </div>
                    <?php if($type=='deposit'){ ?>
                    <div class="form-group">
                            <label class="col-sm-4">Loại tiền</label>
                            <div class="col-sm-8">
                                <label class="radio-inline">
                                    <input class="calculate_deposit" type="radio" name="loan_currency" id="loan_currency_vnd" value="vnd" checked="checked"> VND
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" class="calculate_deposit" name="loan_currency" id="loan_currency_usd" value="usd"> USD
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" class="calculate_deposit" name="loan_currency" id="loan_currency_gold" value="gold"> VÀNG
                                </label>
                            </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Kỳ hạn</label>
                        <div class="col-sm-8">
                            <select class="form-control calculate_deposit" name="time">
                                <?php //foreach ($ky_han_gui_tien as $key=>$val) { ?>
                                    <!-- <option value="<?php echo $key ?>"><?php echo $val; ?></option> -->
                                <?php //} ?>

                                <option value="0">Không kỳ hạn</option>
                                <option selected="selected" value="1">1 tháng</option>
                                <option value="2">2 tháng</option>
                                <option value="3">3 tháng</option>
                                <option value="6">6 tháng</option>
                                <option value="9">9 tháng</option>
                                <option value="12">12 tháng</option>
                                <option value="18">18 tháng</option>
                                <option value="24">24 tháng</option>
                                <option value="36">36 tháng</option>
                            </select>
                        </div>
                        <input type="hidden" name="loan_type" value="loan_type_fixed">
                    </div>

                    <?php }else{ ?>

                    <div class="form-group">
                        <label class="col-sm-4">
                            <input class="calculate_deposit" type="radio" name="loan_currency" id="loan_currency_mua_xe" value="mua_xe" checked="checked"> Mua xe
                        </label>
                        <label class="col-sm-4">
                            <input type="radio" class="calculate_deposit" name="loan_currency" id="loan_currency_mua_nha" value="mua_nha"> Mua nhà
                        </label>
                        <label class="col-sm-4">
                            <input type="radio" class="calculate_deposit" name="loan_currency" id="loan_currency_tieu_dung" value="tieu_dung"> Tiêu dùng
                        </label>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-6">
                            <input class="calculate_deposit" type="radio" name="loan_type" id="loan_type_down" value="loan_type_down" checked="checked"> Trả góp theo tháng
                        </label>
                        <label class="col-sm-6">
                            <input type="radio" class="calculate_deposit" name="loan_type" id="loan_type_fixed" value="loan_type_fixed"> Trả lãi
                        </label>
                    </div>

                    <?php } ?>

                    <div class="form-group">
                            <label class="col-sm-6">
                                <input class="calculate_deposit" type="radio" name="calculate_type"  value="max" checked="checked"> <?php echo ($type=='deposit') ? "Lãi suất cao nhất":"Lãi suất thấp nhất"; ?>
                            </label>
                            <label class="col-sm-6">
                                <input type="radio" class="calculate_deposit" name="calculate_type"  value="bank"> Ngân hàng
                            </label>
                    </div>
                    <div class="form-group bank_list" style="display: none;">
                        <label class="col-sm-4">Ngân hàng</label>
                        <div class="col-sm-8">
                            <select class="form-control calculate_deposit" name="bank">
                                <?php foreach ($bank_list as $bank) { ?>
                                    <option value="<?php echo $bank->ID ?>"><?php echo $bank->post_title; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-4">
                            <a href="#" class="btn btn-red calculate_result" data-type="<?php echo $type; ?>">Kết quả</a>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Lãi suất</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="lai_suat" value="" readonly="readonly">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4"><?php echo ($type=='deposit') ? "Lãi":"Lãi trả"; ?></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control number" name="lai" value="" readonly="readonly">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4"><?php echo ($type=='deposit') ? "Tổng lãnh":"Tổng trả"; ?></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control number" name="lanh" value="" readonly="readonly">
                        </div>
                    </div>
                    <i class="return_string"  class="alert bg-danger"></i>
                    <input type="hidden" name="do_job" value="calculate_<?php echo $type?>">
            </form>

        <?php
        return ob_get_clean();
}

function get_custom_calculate_form(){
    // global $bank_list;

    ob_start();

        $args = array(
         'post_type'   => 'fwp_bank',
         'order'               => 'DESC',
         'orderby'             => 'date',
         'posts_per_page'         => -1,

      );
    $bank_list = get_posts( $args );
    ?>
            <form action="" method="POST" class="form-horizontal" role="form" id="custom_calculate_loan_form">
                    <div class="form-group">
                        <label class="col-sm-4">Số tiền vay</label>
                        <div class="col-sm-8">
                            <input onkeyup="formatNumber(this);" type="text" class="form-control number" name="amount" value="" placeholder="VND">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Thời gian vay</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="number" min="1" max="100" name="time" value="" placeholder="tháng">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Lãi suất</label>
                        <div class="col-sm-8">
                            <input type="number" min="1" max="50"class="form-control" name="lai_xuat_nam" value="" placeholder="% năm">
                        </div>
                    </div>

                    <div class="form-group du-no">
                        <label class="col-sm-6">
                            <input class="calculate_deposit" type="radio" name="loan_type" id="loan_type_down" value="loan_type_down" checked="checked"> Trả góp theo tháng
                        </label>
                        <label class="col-sm-6">
                            <input type="radio" class="calculate_deposit" name="loan_type" id="loan_type_fixed" value="loan_type_fixed"> Trả lãi
                        </label>
                    </div>


                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-4">
                            <a href="#" class="btn btn-red calculate_custom_loan">Kết quả</a>
                        </div>
                    </div>
				<div class="result">
                    <div class="form-group">
                        <label class="col-sm-4">Lãi trả</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control number" name="lai" value="" readonly="readonly">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4">Tổng trả</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control number" name="lanh" value="" readonly="readonly">
                        </div>
                    </div>
				</div>
                    <i class="return_string"  class="alert bg-danger"></i>
                    <input type="hidden" name="do_job" value="calculate_custom">
            </form>

        <?php
        return ob_get_clean();
}

function do_calculate_custom(){
    global $bank_list;
    $posted            = $_POST;
    $json              = array();
    $table             = '';
    $amount            = str_replace(',', '', $posted['amount']);
    $time              = $posted['time'];
    $type_calculate    = $posted['type_calculate'];
    $ls_nam            = $posted['lai_xuat_nam'];

    $deposit_per_month = $ls_nam/1200;//12 thang %

    $ls = round(($ls_nam/12), 3).'%(1 tháng)';

    if($type_calculate == 'loan_type_down'){

        $json['text']     = '';
        $goc_con = $amount;
        $goc_tra = ($amount/$time);
        $tong_lai = 0;
        $table .= '<div class="table-responsive"><table class="table table-bordered">
                        <thead>
                            <tr><th align="center">Kỳ trả nợ</th><th align="center">Số gốc còn</th><th align="center">Gốc trả</th><th align="center">Lãi trả</th><th align="center">Tổng trả</th></tr>
                        </thead>
                        <tbody>';
                            for ($i=1; $i <= $time ; $i++) {
                                $lai_down   = $deposit_per_month*$goc_con;
                                $tong_lai = ($tong_lai + $lai_down);
                                $total_tra_per_month = ($goc_tra + $lai_down);
                                $goc_con = ($goc_con - $goc_tra);
                                if($goc_con <= 0){
                                    $goc_con = 0;
                                }

                                $table .= '<tr>';
                                $table .= '<td>'.$i.'</td>';
                                $table .= '<td>'.number_format($goc_con).'</td>';
                                $table .= '<td>'.number_format($goc_tra).'</td>';
                                $table .= '<td>'.number_format($lai_down).'</td>';
                                $table .= '<td>'.number_format($total_tra_per_month).'</td>';
                                $table .= '</tr>';
                            }
                            $total_pay         = $tong_lai + $amount;

        $table .= '</tbody>';
        $table .= '<tfooter>';
        $table .= '<tr><td colspan="2"><b>Tổng Lãi trả</b></td><td colspan="3"><b>'.number_format($tong_lai).' VNĐ</b></td></tr>';
        $table .= '</tfooter>';
        $table .= '</table></div>';
        $lai = $tong_lai;


    }else{
        /*$money_per_month = round($deposit_per_month*$amount, 0);
        $lai             = round($money_per_month*$time);
        $total_pay       = round($lai + $amount);
        $json['text']    = 'Số tiền vay là '.number_format($amount).', lãi suất '.$ls.', lãi phải trả mỗi tháng là '.number_format($money_per_month).' VNĐ .Tổng tiền góc và lãi phải trả: '.number_format($total_pay).' VNĐ';*/

        $json['text']     = '';
        $goc_con = $amount;
        $goc_tra = ($amount/$time);
        $tong_lai = 0;
        $table .= '<table class="table table-bordered table-hover table-responsive">
                        <thead>
                            <tr><th width="30%" align="center">Kỳ trả lãi</th><th width="30%" align="center">Lãi trả</th></tr>
                        </thead>
                        <tbody>';
                            for ($i=1; $i <= $time ; $i++) {
                                $money_per_month = $deposit_per_month*$amount;


                                $table .= '<tr>';
                                $table .= '<td>'.$i.'</td>';
                                $table .= '<td>'.number_format($money_per_month).'</td>';
                                /*$table .= '<td>'.number_format($goc_tra).'</td>';
                                $table .= '<td>'.number_format($lai_down).'</td>';
                                $table .= '<td>'.number_format($total_tra_per_month).'</td>';*/
                                $table .= '</tr>';
                            }
                            $lai             = $money_per_month*$time;
                            $total_pay       = $lai + $amount;

        $table .= '</tbody>';
        $table .= '<tfooter>';
        //$table .= '<tr><td colspan="2"><b>Tổng</b></td><td><b>'.number_format($amount).'</b></td><td><b>'.number_format($tong_lai).'</b></td><td><b>'.number_format($total_pay).'</b></td></tr>';
        $table .= '<tr><td><b>Tổng</b></td><td><b>'.number_format($money_per_month * $time).' VNĐ</b></td></tr>';
		$table .= '</tfooter>';
        $table .= '</table>';
        //$table .= 'Tổng lãi phải trả: ' .number_format($money_per_month * $time) . ' VNĐ';

//$json['text']    = 'Số tiền vay là '.number_format($amount).', lãi suất '.$ls.', lãi phải trả mỗi tháng là '.number_format($money_per_month).' VNĐ .Tổng tiền gốc và lãi phải trả: '.number_format($total_pay).' VNĐ';

    }

    $json['status']   = "success";
    $json['lai_suat'] = $ls;
    $json['lai']      = $lai;
    $json['lanh']     = $total_pay;
    $json['table']    = $table;


    //header("Content-Type: application/json", true);
    echo  json_encode($json);
   die();
}

function do_calculate_loan(){
    global $bank_list;
    $posted = $_POST;
    $json = array();
    $table = '';

    $amount = str_replace(',', '', $posted['amount']);
    $type = $posted['type'];
    $type_calculate = $posted['type_calculate'];
    $time = 0;
    $key_personal = 'interest_rate_personal_'.$posted['currency'];
    $deposit = 0;
    if($type == 'bank'){
        $value = get_post_meta( $posted['bank'], '_fastwp_meta', true );
        $ls = $value[$key_personal]['loan_rate'];
        $time = $value[$key_personal]['month'];

        if(isset($ls) && $ls > 0){
            $deposit = $ls;
            $bank_code = $value['bank_code'];
        }


    }else{
        foreach ($bank_list as $bank) {
            $value = get_post_meta( $bank->ID, '_fastwp_meta', true );
            $new_deposit = $value[$key_personal]['loan_rate'];
            $month = $value[$key_personal]['month'];

            if(isset($new_deposit) && !empty($new_deposit)){
                if($deposit == 0 || $new_deposit < $deposit && $month > 0){
                    $deposit = $new_deposit;
                    $bank_code = $value['bank_code'];
                    $time = $month;
                }
            }
        }
    }

    if($deposit > 0 && $time > 0){
        if($type_calculate == 'loan_type_down'){
            $json['text']     = '';
            $goc_con = $amount;
            $goc_tra = ($amount/$time);
            $tong_lai = 0;
            $table .= '<table class="table table-bordered table-hover">
                            <thead>
                                <tr><th width="20%" align="center">Kỳ trả nợ</th><th width="20%" align="center">Số gốc còn</th><th width="20%" align="center">Gốc trả</th><th width="20%" align="center">Lãi trả</th><th width="20%" align="center">Tổng trả</th></tr>
                            </thead>
                            <tbody>';
                                for ($i=1; $i <= $time ; $i++) {
                                    $lai_down   = round(round(($deposit/$time/100), 3)*$goc_con, 0);
                                    $tong_lai = ($tong_lai + $lai_down);
                                    $total_tra_per_month = ($goc_tra + $lai_down);
                                    $goc_con = ($goc_con - $goc_tra);

                                    $table .= '<tr>';
                                    $table .= '<td>'.$i.'</td>';
                                    $table .= '<td>'.number_format($goc_con).'</td>';
                                    $table .= '<td>'.number_format($goc_tra).'</td>';
                                    $table .= '<td>'.number_format($lai_down).'</td>';
                                    $table .= '<td>'.number_format($total_tra_per_month).'</td>';
                                    $table .= '</tr>';
                                }
                                $total_pay         = round($tong_lai + $amount);

            $table .= '</tbody>';
            $table .= '<tfooter>';
            $table .= '<tr><td colspan="2"><b>Tổng</b></td><td><b>'.number_format($amount).'</b></td><td><b>'.number_format($tong_lai).'</b></td><td><b>'.number_format($total_pay).'</b></td></tr>';
            $table .= '</tfooter>';
            $table .= '</table>';
            $lai = $tong_lai;
            $ls = $deposit.'%('.$time.' tháng)';

        }else{
            $ls = round(($deposit/$time/100), 3);
            $money_per_month   = round($ls*$amount, 0);
            $lai               = round($money_per_month*$time);
            $total_pay         = round($lai + $amount);
            $json['text']     = 'Số tiền vay là '.number_format($amount).', lãi suất '.$ls.'% ('.$bank_code.')/ 1 tháng, lãi phải trả mỗi tháng là '.number_format($money_per_month).'VNĐ .Tổng tiền góc và lãi phải trả: '.number_format($total_pay).' VNĐ';

        }

        $json['status']   = "success";
        $json['lai_suat'] = $ls;
        $json['lai']      = $lai;
        $json['lanh']     = $total_pay;
        $json['table'] = $table;


    }else{

        $json['status'] = "error";
        $json['text'] = "Đang cập nhật vui lòng thử lại sau!";
    }
    //header("Content-Type: application/json", true);
    echo  json_encode($json);
   die();
}

function do_calculate_deposit(){
    global $bank_list;
    $posted = $_POST;
    $json = array();

    $amount = str_replace(',', '', $posted['amount']);
    $type = $posted['type'];
    $time = $posted['time'];
    $key_personal = 'interest_rate_personal_'.$posted['currency'];
    $deposit = 0;
    if($type == 'bank'){
        $value = get_post_meta( $posted['bank'], '_fastwp_meta', true );
        $ls = $value[$key_personal][$time];

        if(isset($ls) && $ls > 0){
            $deposit = $ls;
            $bank_code = $value['bank_code'];
        }

    }else{
        foreach ($bank_list as $bank) {
            $value = get_post_meta( $bank->ID, '_fastwp_meta', true );
            $new_deposit = $value[$key_personal][$time];

            if(isset($new_deposit) && $new_deposit > $deposit){
                $deposit = $new_deposit;
                $bank_code = $value['bank_code'];
            }
        }
    }

    if($deposit > 0){
        $deposit = ($deposit/100);
        $json['status'] = "success";
        $json['lai_suat'] = $deposit;
        $lai = ($deposit*$amount);
        $lanh = ($lai + $amount);

        if($time> 0){
            $lai = ($lai*$time);
            $lanh = ($lai + $amount);
        }
        $json['lai'] = $lai;
        $json['lanh'] = $lanh;
        $json['text'] = 'Số tiền gửi là '.number_format($amount).' kỳ hạn '.$time.' tháng , lãi suất '.$deposit.'/ tháng ('.$bank_code.') tiền lãi sẽ nhận là '.number_format($lai).' VNĐ .Khi đáo hạn, tiền gốc và lãi là '.number_format($lanh).' VNĐ ';
    }else{
        $json['status'] = "error";
        $json['text'] = "Đang cập nhật vui lòng thử lại sau!";
    }

    echo  json_encode($json);
   die();
}

function get_page_list($atts) {
    extract(shortcode_atts(array(
            'title'         => '',
            'p_ids'        => '',
            'class'         => 'panel-page',
            'col'       => 'col-md-4',
        ), $atts));
    $args = array(
      'post_type' => 'page',
      'post__in' => array($p_ids),
      );

    $the_query = new WP_Query( $args );

    if($the_query->have_posts())
    {
        $string .= '<div class="row">';
        $string .= '<ul class="grid-page">';

        while ($the_query->have_posts())
        {
            $the_query->the_post();
            $string .= '<li class="'.$col.'">';
            $string .= '<a href="'.get_the_permalink() .'" rel="bookmark">';
            if ( function_exists("has_post_thumbnail") && has_post_thumbnail() ) :
                            $string .= '<div class="post-thumbnail">';

                            $string .=            get_the_post_thumbnail();

                            $string .= '</div><!-- post-thumbnail /-->';
            else :
                 $string .= '<div class="post-thumbnail no-img">';
                $string .= '<img src="http://placehold.it/300x250">';
                $string .= '</div><!-- post-thumbnail /-->';
            endif;
              $string .= '<div class="post-cover"></div>';
              $string .= '<h5 class="post-element-title">'.get_the_title().'</h5>';
              $string .=  '</a>';
              $string .= '</li>';

        }
        $string .= '</ul>';
        $string .= '</div>';
    }
    return $string;
}

add_shortcode('get_page_list','get_page_list');


add_action("wp_ajax_shortcode_action", "do_shortcode_action");
add_action("wp_ajax_nopriv_shortcode_action", "do_shortcode_action");

function do_shortcode_action() {
    $posted = $_POST;
    $do_job = $posted['do_job'];

    switch ($do_job) {
        case 'calculate_loan':
                do_calculate_loan();
            break;
        case 'calculate_deposit':
                do_calculate_deposit();
            break;
        case 'calculate_custom':
                do_calculate_custom();
            break;

        default:
            # code...
            break;
    }
}

  function diemnhan_styles() {
  wp_enqueue_script( "shortcodes", get_stylesheet_directory_uri() .'/js/shortcodes.js', 'jquery', '1.0', true );
   wp_enqueue_script('shortcodes');
  wp_localize_script( 'shortcodes', 'Ajax_var', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));

	wp_enqueue_script( "jquery.number", get_stylesheet_directory_uri() .'/js/jquery.number.js', 'jquery', '1.0', true );


 }
  add_action( 'wp_enqueue_scripts', 'diemnhan_styles' );
function admin_style() {
  wp_enqueue_style('admin-styles', get_stylesheet_directory_uri().'/admin.css');
}
add_action('admin_enqueue_scripts', 'admin_style');
  function add_widgets() {
  register_sidebar(array(
    'id'            => 'category-widget',
    'name'          =>  __( 'Category Widget Menu', 'dt_themes' ),
    'description'   =>  __( 'Used for home category widget area', 'dt_themes' ),
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget'  => '</div>',
    'before_title'  => '<h3 class="category-module-title">',
    'after_title'   => '</h3>',
  ));


}
add_action('widgets_init', 'add_widgets');

function custom_login_logo() {
    echo '<style type="text/css">
        h1 a { background-image:url('.get_stylesheet_directory_uri().'/images/logo_admin.png) !important; width:280px !important; margin: 0 auto 5px !important; background-size: contain !important;}
    </style>';
}
add_action('login_head', 'custom_login_logo');

function my_login_logo_url() {
    return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

function my_login_logo_url_title() {
    return 'Your Site Name and Info';
}
add_filter( 'login_headertitle', 'my_login_logo_url_title' );