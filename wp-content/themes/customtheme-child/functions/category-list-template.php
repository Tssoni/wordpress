<?php
/**
 Template Name: category list 
 */
 
get_header(); 

$args=array(
    'hide_empty'        => 0,
    'parent'        => 0,
    'taxonomy'      => 'product_categories');
	$categories=get_categories($args);
         
foreach($categories as $category) {
    echo '<div class="product-cat">'; 
 
    $thumb_url = get_option('taxonomy_image_plugin');
    $product_cat_url = get_term_link( $category->slug, 'product_categories' );
                 
   // echo '<a href="'.$product_cat_url.'"><img src="'.get_template_directory_uri().'/timthumb.php?src='.wp_get_attachment_url( $thumb_url[$category->term_taxonomy_id]).'&h=200&w=200" /></a>';
    echo '<a class="cat-title" href="' . $product_cat_url .'">' . $category->name.'</a>';
    echo '</div> <!--end product cat-->';
}
	get_template_part('loop'); 

get_footer();
?>