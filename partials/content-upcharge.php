<?php global $current_user; ?>

<div class="nscs-overlay">
    <div class="nscs-overlay__inner">

        <form id="nscs-auth__upcharge-form">

            <h2 class="nscs-overlay__title">Congratulations on accepting your membership!</h2>
            <div class="nscs-overlay__content">
                Here are a few items that you may want to consider as a new NSCS member.
            </div>

            <div class="nscs-auth__constrict">
                <div class="nscs-auth__message"></div>
            </div>

            <div class="nscs-products">

                <?php

                    $upcharge_products = get_field('purchase_upgrades');

                    foreach( $upcharge_products as $product_id ) {

                        $product = wc_get_product( $product_id );
                        $product_meta = get_post_meta($product_id);

                        if( empty($product_meta['_thumbnail_id']) ) continue;

                        printf('<div class="nscs-product">
                            <div class="nscs-product__inner">
                                <div class="nscs-product__image" style="background-image: url(%s)"></div>
                                    <div class="nscs-product__meta">
                                        <div class="nscs-amount">$%s</div>
                                        <div class="nscs-product__meta-title">
                                            %s
                                        </div>
                                    </div>
                                </div>
                                <div class="nscs-button add-to-cart" data-product-id="%s" data-product-name="%s" data-product-price="%s"></div>
                            </div>',
                            wp_get_attachment_image_url( $product_meta['_thumbnail_id'][0], 'full' ),
                            round( $product->get_price() ),
                            $product->get_name(),
                            $product->get_id(),
                            $product->get_name(),
                            round( $product->get_price() )
                        );

                    }

                ?>

            </div>

            <div class="nscs-cart-total">
                <div class="nscs-cart-total__total">
                    Total
                </div>
                <div class="nscs-cart-total__amount">
                    <div class="nscs-amount">$0</div>
                </div>
                <input type="submit" class="nscs-cart-total__checkout nscs-button" value="Make Payment" />
            </div>

            <input type="hidden" name="action" value="upcharge" />
            <?php wp_nonce_field( 'upcharge', 'nonce' ); ?>

        </form>

        <div class="nscs-confirmation">

            <div class="nscs-confirmation__check"></div>
            <h2 class="nscs-confirmation__title">Congratulations, <?php echo $current_user->user_firstname ?></h2>
            <div class="nscs-confirmation__subtitle">
                You have completed your registration as a member of NSCS.
            </div>

            <div class="nscs-confirmation__product-confirmation"></div>

            <a class="nscs-button nscs-button__continue-to-home">Continue</a>
        </div>
    </div>
</div>

<script type="text/javascript">

    var nscsUpchargeFormSubmitting = false;

    jQuery(document).ready(function($) {

        /*
         * Add or remove from cart
         */
        $('.add-to-cart').click(function() {

            // Toggle the product in the cart
            $(this).toggleClass('added');

            // Get the order total
            var order_total = 0;

            $('.add-to-cart.added').each(function( index, value ) {
                order_total += parseFloat( $(this).attr('data-product-price') );
            });

            // Show the new order total
            $('.nscs-cart-total__amount .nscs-amount').text('$' + order_total)
        });

        /*
         * Checkout
         */
        $( "#nscs-auth__upcharge-form" ).submit(function( e ) {

            e.preventDefault();

            if( !nscsUpchargeFormSubmitting) {

                nscsPaymentFormSubmitting = true;
                $('#nscs-auth__upcharge-form input[type=submit]').addClass('loading');

                // Get the product IDs the customer wants to purchase
                var product_ids = $('.add-to-cart.added').map(function(){
                    return $(this).attr('data-product-id');
                }).get();

                if( product_ids.length ) {

                    // Create a form object we can actually use
                    var UpchargeForm = $(this).serialize();

                    // Submit the order
                    $.ajax({
                        type   : "POST",
                        url    : "<?php echo admin_url( 'admin-ajax.php' ) ?>",
                        data   : UpchargeForm + "&product_ids=" + product_ids.join(','),
                        error: function() {
                            $('.nscs-auth__message').html('There was an issue processing the form, please refresh the page and try again.')
                        },
                        success: function(data) {

                            data = JSON.parse(data);

                            if( !!data.success ) {

                                // Add products to the confirmation page
                                $('.nscs-confirmation__product-confirmation').append('<p>The following items will be emailed to you within 3 business days.</p><ul></ul>');
                                $.each(product_ids, function(index, value) {
                                    $('.nscs-confirmation__product-confirmation ul').append('<li>' + $('.add-to-cart[data-product-id='+value+']').attr('data-product-name') + '</li>');
                                });

                                // Show the confirmation page
                                $('#nscs-auth__upcharge-form').hide();
                                $('.nscs-confirmation').show();
                            } else {
                                $('.nscs-auth__message').html(data.message);
                            }
                        },
                        complete: function() {
                            nscsUpchargeFormSubmitting = false;
                            $('#nscs-auth__upcharge-form input[type=submit]').removeClass('loading');
                        }
                    });
                } else {
                    // continue the user to the confirmation screen
                    $('#nscs-auth__upcharge-form').hide();
                    $('.nscs-confirmation').show();
                }

            }

        });

        /*
         * User can continue to homepage
         */
        $('.nscs-button__continue-to-home').click(function() {

            <?php
            $student_profile = get_page_by_template_filename( 'template-student-profile.php' );
            if( !empty( $student_profile ) ) {
                $str = "type=success&message=Please finish filling out your profile so we can learn more about you and help tailor your experience";
                $redirect_url = get_permalink( $student_profile[0]->ID ) . "?$str";
            }
            ?>
            window.location = "<?php echo $redirect_url; ?>"
        })
    });
</script>
