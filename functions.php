<?php
function create_post_type() {
	$labels = array(
		'name'                  => _x( 'myproduct', 'Post type general name', 'textdomain' ),
		'singular_name'         => _x( 'myproduct', 'Post type singular name', 'textdomain' ),
		'menu_name'             => _x( 'myproduct', 'Admin Menu text', 'textdomain' ),
		'name_admin_bar'        => _x( 'myproduct', 'Add New on Toolbar', 'textdomain' ),
		'add_new'               => __( 'Add New', 'textdomain' ),
		'add_new_item'          => __( 'Add New Product', 'textdomain' ),
		'new_item'              => __( 'New product', 'textdomain' ),
		'edit_item'             => __( 'Edit product', 'textdomain' ),
		'view_item'             => __( 'View product', 'textdomain' ),
		'all_items'             => __( 'All products', 'textdomain' ),
		'search_items'          => __( 'Search Product', 'textdomain' ),

	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'myproduct' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
	);

	register_post_type( 'products', $args );
}

add_action( 'init', 'create_post_type' );

function product_price_meta_box() {
    add_meta_box(
        'product_price_meta_box', // Meta box ID
        'Price', // Meta box title
        'product_price_meta_box_callback', // Callback function to display the meta box content
        'products', // Custom post type slug
        'normal', // Context (normal, side, advanced)
        'default' // Priority (high, core, default, low)
    );
}
add_action('add_meta_boxes', 'product_price_meta_box');

// Callback function to display the meta box content
function product_price_meta_box_callback($post) {
    // Get the current price value
    $price = get_post_meta($post->ID, '_product_price', true);
    ?>

    <label for="product_price">Price:</label>
    <input type="text" id="product_price" name="product_price" value="<?php echo esc_attr($price); ?>" />

    <?php
}

function add_product_price_meta_box() {
    add_meta_box(
        'product_price_meta_box', // $id
        'Product Price', // $title
        'show_product_price_meta_box', // $callback
        'products', // $screen
        'normal', // $context
        'default' // $priority
    );
}
add_action( 'add_meta_boxes', 'add_product_price_meta_box' );

function show_product_price_meta_box( $post ) {
    $price = get_post_meta( $post->ID, 'product_price', true );
    ?>
    <label for="product_price">Product Price:</label>
    <input type="number" name="product_price" id="product_price" value="<?php echo $price; ?>" step="0.01">
    <?php
}

function save_product_price_meta_box( $post_id ) {
    if ( isset( $_POST['product_price'] ) ) {
        update_post_meta( $post_id, 'product_price', sanitize_text_field( $_POST['product_price'] ) );
    }
}
add_action( 'save_post', 'save_product_price_meta_box' );

