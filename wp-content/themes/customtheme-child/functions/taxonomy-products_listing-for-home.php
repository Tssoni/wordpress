<?php
/**
 Template Name: Home Products Template 
 */
get_header(); 
$slug = get_query_var( 'product' );


$args = array(
  'post_type'   => 'products', 'posts_per_page' => 8,
  /*'tax_query'   => array(
  	array(
  		'taxonomy' => 'product_categories',
  		'field'    => 'slug',
  		'terms'    => 'ecatalog'
  	)
  )*/
 );
 
$products = new WP_Query( $args );
if( $products->have_posts() ) :

?>
<div class="row container">
<h1><?php echo get_the_title(); ?></h1>
  <?php
  while( $products->have_posts() ) :
	$products->the_post();
	?>
  <div class="col-sm-6 col-md-3">
    <div class="thumbnail">
      <a href="<?php the_permalink(); ?>" title="<?php get_the_title(); ?>">
				<?php the_post_thumbnail(array(300,300)); // Declare pixel size you need inside the array ?>
			</a>
      <div class="caption">
        <h3><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
        <p><?php html5wp_excerpt('html5wp_custom_post'); // Build your custom callback length in functions.php ?></p>
        <p><strong class='price'><?php if( get_post_meta($post->ID, 'price', true)): echo get_post_meta($post->ID, 'price', true); ?></strong>
		<a href="<?php echo get_page_link(5); ?>" class="cart" role="button">Add to Cart</a> </p>
		
		<!-- The Modal -->
		<div id="myModal" class="modal">
		  <!-- Modal content -->
		  <div class="modal-content">
			<span class="close">&times;</span>
			<h3><?php the_title(); ?></h3>
			<p><?php echo get_the_content();  ?></p>
		  </div>
		</div>
		<?php endif; ?>
      </div>
    </div>
  </div>
  <?php
      endwhile;
      wp_reset_postdata();
    ?>
</div>
<?php
else :
  esc_html_e( 'No Products !', 'text-domain' );
endif;
?>
<!-- Trigger/Open The Modal -->

<script>
// Get the modal
var modal = document.getElementById('myModal');

// Get the button that opens the modal
var btn = document.getElementById("post-40");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>

<?php get_footer(); ?>
