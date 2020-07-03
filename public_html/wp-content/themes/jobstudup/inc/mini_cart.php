<?php if ( class_exists( 'WooCommerce' ) ) { ?>
<?php global $woocommerce; ?>
<div id="cart" class="cart-in-header">
    <!-- Button -->
    <div class="cart-btn">
        <a href="#" class="button adc">&nbsp;</a>
    </div>

    <div class="cart-list">
        <div class="arrow"></div>
        <div class="cart-amount">

             <span><?php echo sprintf(_n('%d item', '%d items', WC()->cart->cart_contents_count, 'workscout'), WC()->cart->cart_contents_count);?> <?php  _e('in the shopping cart','workscout') ?></span>
        </div>
        <ul>
            <?php
            if (sizeof( WC()->cart->get_cart() ) > 0) :
                foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                    $_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                    $product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
                    if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {

                        $product_name  = apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
                        //$thumbnail     = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
                        $product_price = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
                        $thumbnail = get_the_post_thumbnail( $_product->get_id(), 'cart-square-thumb');
                        ?>
                        <li class="cart_list_product">
                            <a href="<?php echo get_permalink( $product_id ); ?>">
                                <?php echo $thumbnail . $product_name; ?>
                            </a>

                            <?php echo wc_get_formatted_cart_item_data( $cart_item ); ?>

                            <?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf( '%s &times; %s', $cart_item['quantity'], $product_price ) . '</span>', $cart_item, $cart_item_key ); ?>
                            <div class="clearfix"></div>
                        </li>
                        <?php
                    }
                }
            ?>
        <?php else : ?>
            <li class="empty"><?php _e( 'No products in the cart.', 'workscout' ); ?></li>
        <?php endif; ?>
        </ul>
        <div class="cart-buttons ">
            <a href="<?php echo wc_get_cart_url(); ?>" class="view-cart" ><span data-hover="<?php _e( 'View Cart &rarr;', 'workscout' ); ?>"><span><?php _e( 'View Cart &rarr;', 'workscout' ); ?></span></span></a>
            <a href="<?php echo wc_get_checkout_url(); ?>" class="checkout"><span data-hover="<?php _e( 'Checkout &rarr;', 'workscout' ); ?>"><?php _e( 'Checkout &rarr;', 'workscout' ); ?></span></a>
        </div>
        <div class="clearfix">
        </div>
    </div>
</div>
<?php } ?>