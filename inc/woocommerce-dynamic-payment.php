<?php
/*
 * WooCommerce Process Dynamic Order
 * Requires Plugins: WooCommerce & WooCommerce Stripe API
 */

define('NSCS_WOOCOMMERCE_ACTIVE', class_exists('WC_Stripe_Customer') );
define('NSCS_WOOSTRIPE_ACTIVE', class_exists('WC_Gateway_Stripe') );

function nscs_woocommerce_dynamic_order( $customer_id, $shipping_information, $products ) {

    if ( !NSCS_WOOCOMMERCE_ACTIVE || !NSCS_WOOSTRIPE_ACTIVE ) {
        return array(
            "success" => false,
            "message" => "We are having issues with our payment vendor. Please contact support."
        );
    }

    $customer_id = $customer_id ?: get_current_user_id();

    // Validate the customer account
    if ( gettype( $customer_id ) !== "integer" || $customer_id === 0 ) {
        return array(
            "success" => false,
            "message" => "We were unable to find your user account. Please contact support."
        );
    }

    // Ensure we have a payment source waiting for account creation
    $stripe_customer_source = get_user_meta( $customer_id, '_stripe_payment_source', true );
    if ( !$stripe_customer_source ) {
        return array(
            "success" => false,
            "message" => "We were unable to retrieve your payment source. Please contact support."
        );
    }

    // Find a customer account on stripe, or create a new one for the user
    $stripe_customer_id = nscs_stripe_create_customer( $customer_id );
    if ( $stripe_customer_id === 0 ) {
        return array(
            "success" => false,
            "message" => "We were unable to create a credit card profile for you. Please contact support."
        );
    }

    // Connect the customer payment source to customer
    $connected_source = nscs_stripe_connect_payment_source( $customer_id, $stripe_customer_source );
    if ( $connected_source === 0 ) {
        return array(
            "success" => false,
            "message" => "We were unable to connect your payment method to your credit card profile. Please contact support."
        );
    }

    // Check that we have products to create an order
    if ( empty( $products ) ) {
        return array(
            "success" => false,
            "message" => "We were unable to add products to process the order. Please contact support."
        );
    }

    // Create the dynamic order
    $order_id = nscs_woocommerce_create_order( $customer_id, $products, $shipping_information );

    // Charge the customer
    if ( !nscs_stripe_charge_customer( $order_id, $stripe_customer_source ) ) {
        return array(
            "success" => false,
            "message" => "We were unable to charge your credit card. Please contact support."
        );
    }

    // Clear the processing order from the user meta
    delete_user_meta( $customer_id, '_stripe_order_processing' );

    // If the user bought access to the site, give them proper access
    if ( in_array( "32719", $products ) ) {
        update_user_meta( $customer_id, 'registered', 1 );
    }

    return array(
        "success" => true,
        "message" => "Your order was processed successfully."
    );
}

function nscs_stripe_create_customer( $user_id ) {

    $stripe_customer_id = get_user_meta( $user_id, '_stripe_customer_id', true );

    if ( !$stripe_customer_id ) {
        try {
            $stripe_customer_api = new WC_Stripe_Customer( $user_id );
            return $stripe_customer_api->create_customer();
        } catch (Exception $e) {
            return 0;
        }
    }

    return $stripe_customer_id;
}

function nscs_stripe_connect_payment_source( $user_id, $source_id) {

    $stripe_source = get_user_meta( $user_id, '_stripe_payment_source', true );

    try {
        $stripe_customer_api = new WC_Stripe_Customer( $user_id );
        $stripe_customer_api->add_source( $source_id, true );
    } catch (Exception $e) {
        return 0;
    }

    return $stripe_source;
}

function nscs_stripe_charge_customer( $order_id, $stripe_customer_source ) {

    try {
        $tmp = isset( $_POST['stripe_source'] ) ? $_POST['stripe_source'] : null;
        $_POST['stripe_source'] = $stripe_customer_source;
        $stripe = new WC_Gateway_Stripe();
        $payment = $stripe->process_payment( $order_id, true, false );
        $_POST['stripe_source'] = $tmp;
        return $payment["result"] === "success";
    } catch (Exception $e) {
        return false;
    }

}

function nscs_woocommerce_create_order( $user_id, $products, $shipping_address ) {

    global $woocommerce;

    if ( $processing_order = get_user_meta( $user_id, '_stripe_order_processing' ) ) {
        return $processing_order;
    }

    $shipping_address = array_merge(array(
        'first_name' => "Valued",
        'last_name'  => "Customer",
        'company'    => '',
        'email'      => '',
        'phone'      => '',
        'address_1'  => '',
        'address_2'  => '',
        'city'       => '',
        'state'      => '',
        'postcode'   => '',
        'country'    => 'US'
    ), $shipping_address );

    // Now we create the order
    $order = wc_create_order();

    // Add the products to our order
    foreach ($products as $product_id) {
        $order->add_product( wc_get_product( $product_id ), 1);
    }

    // Set addresses
    $order->set_address( $shipping_address, 'billing' );
    $order->set_address( $shipping_address, 'shipping' );

    // Set payment gateway
    $payment_gateways = WC()->payment_gateways->payment_gateways();
    $order->set_payment_method( $payment_gateways['stripe'] );

    // Calculate totals
    $order->calculate_totals();
    $order->update_status( 'Pending payment', 'Order created dynamically - ', TRUE );

    return $order;
}

/*
 * Stripe get source created client side
 */
function nscs_ajax_student_payment() {

    check_ajax_referer( 'student_payment', 'nonce' );

    $user = wp_get_current_user();
    $user_info = get_userdata( $user->ID );
    $product_ids = explode( ',', $_REQUEST['product_ids'] );
    $stripe_source = $_REQUEST['stripe_source'] ?: get_user_meta( $user->ID, '_stripe_payment_source', true );

    update_user_meta( $user->ID, '_stripe_payment_source', $stripe_source );

    try {
        $stripe_customer_api = new WC_Stripe_Customer( $user->ID );
        $stripe_customer_api->add_source( $stripe_source, true );
    } catch (Exception $e) {
        echo json_encode( array(
            "success" => false,
            "message" => "We were unable to create a Stripe Payment source. Please contact support."
        ));
        die();
    }

    echo json_encode( nscs_woocommerce_dynamic_order( $user->ID, [
        'first_name' => $user->first_name ?: "Valued",
        'last_name'  => $user->last_name ?: "Customer",
        'email'      => $user_info->user_email,
        'address_1'  => $_REQUEST['shipping_address'],
        'city'       => $_REQUEST['shipping_city'],
        'state'      => $_REQUEST['shipping_state'],
        'postcode'   => $_REQUEST['shipping_zip'],
        'country'    => 'US'
    ], $product_ids ) );

    die();
}
add_action('wp_ajax_student_payment', 'nscs_ajax_student_payment');
add_action('wp_ajax_nopriv_student_payment', 'nscs_ajax_student_payment');

