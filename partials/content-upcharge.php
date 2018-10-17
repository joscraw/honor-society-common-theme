<div class="nscs-overlay">
    <div class="nscs-overlay__inner">
        <h2 class="nscs-overlay__title">Congratulations on accepting your membership!</h2>
        <div class="nscs-overlay__content">
            Here are a few items that you may want to consider as a new NSCS member.
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
                        <div class="nscs-button"></div>
                    </div>', wp_get_attachment_image_url( $product_meta['_thumbnail_id'][0], 'full' ), round( $product->get_price() ), $product->get_name() );

                }

            ?>

        </div>

        <div class="nscs-cart-total">
            <div class="nscs-cart-total__total">
                Total
            </div>
            <div class="nscs-cart-total__amount">
                <div class="nscs-amount">$29</div>
            </div>
            <div class="nscs-cart-total__checkout nscs-button">
                Make Payment
            </div>
        </div>

<!--        <div class="nscs-products">-->
<!--            <div class="nscs-product">-->
<!--                <div class="nscs-product__inner">-->
<!--                    <div class="nscs-product__image">-->
<!--                        <img src="--><?php //echo get_bloginfo('template_url') ?><!--/assets/images/product-example.png" />-->
<!--                    </div>-->
<!--                    <div class="nscs-product__meta">-->
<!--                        <div class="nscs-amount">$29</div>-->
<!--                        <div class="nscs-product__meta-title">-->
<!--                            University Hoodie-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="nscs-button"></div>-->
<!--            </div>-->
<!--            <div class="nscs-product">-->
<!--                <div class="nscs-product__inner">-->
<!--                    <div class="nscs-product__image">-->
<!--                        <img src="--><?php //echo get_bloginfo('template_url') ?><!--/assets/images/product-example.png" />-->
<!--                    </div>-->
<!--                    <div class="nscs-product__meta">-->
<!--                        <div class="nscs-amount">$29</div>-->
<!--                        <div class="nscs-product__meta-title">-->
<!--                            University Hoodie-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="nscs-button nscs-button--active"></div>-->
<!--            </div>-->
<!--            <div class="nscs-product">-->
<!--                <div class="nscs-product__inner">-->
<!--                    <div class="nscs-product__image">-->
<!--                        <img src="--><?php //echo get_bloginfo('template_url') ?><!--/assets/images/product-example.png" />-->
<!--                    </div>-->
<!--                    <div class="nscs-product__meta">-->
<!--                        <div class="nscs-amount">$29</div>-->
<!--                        <div class="nscs-product__meta-title">-->
<!--                            University Hoodie-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="nscs-button"></div>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="nscs-cart-total">-->
<!--            <div class="nscs-cart-total__total">-->
<!--                Total-->
<!--            </div>-->
<!--            <div class="nscs-cart-total__amount">-->
<!--                <div class="nscs-amount">$29</div>-->
<!--            </div>-->
<!--            <div class="nscs-cart-total__checkout nscs-button">-->
<!--                Make Payment-->
<!--            </div>-->
<!--        </div>-->
    </div>
</div>