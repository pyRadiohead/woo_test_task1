<?php


function prod_number_of_views() {
  global $post;
  $views_args = array(
    'label' => 'Number of views', // Text in the label in the editor.
    'placeholder' => '0', // Give examples or suggestions as placeholder
    'class' => '',
    'style' => '',
    'wrapper_class' => '',
    'id' => 'number_of_views', // required, will be used as meta_key
    'name' => '', // name will be set automatically from id if empty
    'type' => '',
    'desc_tip' => '',
    'data_type' => 'text',
    'custom_attributes' => '', // array of attributes you want to pass 
    'description' => ''
  );
if(get_post_meta($post->ID,'last_buy_date')){
  $buy_date_args = array(
      'label' => 'Last buy date', // Text in the label in the editor.
      'placeholder' => '', // Give examples or suggestions as placeholder
      'class' => '',
      'style' => '',
      'wrapper_class' => '',
      'id' => 'last_buy_date', // required, will be used as meta_key
      'name' => '', // name will be set automatically from id if empty
      'type' => '',
      'desc_tip' => '',
      'data_type' => '',
      'custom_attributes' => '', // array of attributes you want to pass 
      'description' => ''
    );
    
    woocommerce_wp_text_input( $buy_date_args );
  }
    $meta = get_post_meta( $post->ID, 'number_of_views', TRUE );
    // $meta = '' !== $meta ? explode( ',', $meta ) : [];
    $meta = '' !== $meta ? count( array_unique( $meta )): 0;
    $views_args['value'] = $meta;
    woocommerce_wp_text_input( $views_args );
}
add_action( 'woocommerce_product_options_pricing', 'prod_number_of_views' );



function get_last_buy_date($order_id){
$order = new WC_Order( $order_id );
$items = $order->get_items();
$buy_date = current_time( 'Y/m/d g:i:s' );
foreach ( $items as $item ) {

  $product_id = $item->get_product_id();

  update_post_meta($product_id,'last_buy_date', $buy_date);

}
}

 add_action('woocommerce_order_status_completed', 'get_last_buy_date');

 add_action('wp', function() {

  global $post;
  if (is_product()){

  
  $user_ip = $_SERVER['REMOTE_ADDR'];
  $meta = get_post_meta( $post->ID, 'number_of_views', TRUE );

  $meta = '' !== $meta ? $meta : [];
  
    if ( ! in_array($user_ip,$meta)){
      array_push( $meta, $user_ip );
      update_post_meta( $post->ID, 'number_of_views', $meta );
    }
  }
  });