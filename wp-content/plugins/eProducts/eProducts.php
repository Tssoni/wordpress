<?php
/*
Plugin Name: eProducts
Description: Plugin to create custom products. Use shortcode [my_products_shortcode] to display products in grid view.
Author: Tanushree 
Version: 1.1
*/

add_action( 'init', 'product_register' );
function product_register() {
    register_post_type( 'products',
        array(
            'labels' => array(
                'name' => _x('Products', 'post type general name'),
				'singular_name' => _x('Product', 'post type singular name'),
				'add_new' => _x('Add New', 'Product'),
				'add_new_item' => __('Add New Product'),
				'edit_item' => __('Edit Product'),
				'new_item' => __('New Product'),
				'all_items' => __('All Products'),
				'view_item' => __('View Products'),
				'search_items' => __('Search Products'),
				'not_found' =>  __('No products found'),
				'not_found_in_trash' => __('No products found in Trash'), 
				'parent_item_colon' => '',
				'menu_name' => 'Products'
				),
 
            'public' => true,
            'menu_position' => 15,
            'supports' => array( 'title', 'editor', 'comments', 'thumbnail', 'custom-fields' ),
            'taxonomies' => array( 'city' ),
            'menu_icon' => plugins_url( 'images/image.png', __FILE__ ),
            'has_archive' => true
        )
    );
}

add_action("admin_init", "price_meta");
 function price_meta(){
  add_meta_box("price", "Price", "Price", "products", "normal", "low");
}
 
 function price(){
  global $post;
  $custom = get_post_custom($post->ID);
  $price = $custom["price"][0];
  ?>
  <label>Price:</label>
  <input id="price" name="price" type="text"  value="<?php echo $price; ?>" />
  <?php
}

add_action('save_post', 'save_meta');
function save_meta(){
  global $post;
  update_post_meta($post->ID, price, $_POST["price"]);
}
$labels = array(
    'name' => _x( 'Product Categories', 'taxonomy general name' ),
    'singular_name' => _x( 'Product Category', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Product Categories' ),
    'all_items' => __( 'All Product Categories' ),
    'parent_item' => __( 'Parent Category' ),
    'parent_item_colon' => __( 'Parent Category:' ),
    'edit_item' => __( 'Edit Product Category' ), 
    'update_item' => __( 'Update Product Category' ),
    'add_new_item' => __( 'Add Product Category' ),
    'new_item_name' => __( 'New Product Category' ),
    'menu_name' => __( 'Product Categories' )
  );    

function product_taxonomy() {  
    register_taxonomy(  
        'product_categories',  //The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces). 
        'products',        //post type name
        array(  
            'hierarchical' => true,  
            'label' => $labels,  //Display name
            'query_var' => true,
            'show_ui' => true
        )  
    );  
}  
add_action( 'init', 'product_taxonomy');

add_filter( 'template_include', 'include_template_function', 1 );
function include_template_function( $template_path ) {
    if ( get_post_type() == 'products' ) {
        if ( is_single() ) {
            // checks if the file exists in the theme first,
            // otherwise serve the file from the plugin
            if ( $theme_file = locate_template( array ( 'eProducts_details.php' ) ) ) {
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path( __FILE__ ) . '/eProducts_details.php';
            }
        }
    }
    return $template_path;
}
 /* Shortcode to be used [my_products_shortcode] */
  
function my_products_shortcode() {
    include dirname( __FILE__ ) . '/taxonomy-products_listing-for-home.php';
} // function my_products_shortcode
add_shortcode( 'my_products_shortcode', 'my_products_shortcode' );
  ?>

