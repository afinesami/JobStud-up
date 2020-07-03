<?php

function workscout_pricing_woo_tables($atts, $content) {
    extract(shortcode_atts(array(
        "products"  =>  'job_packages,job_package_subscription',
        "from_vs"   => 'no',
        'orderby'                   => 'date', /* price*/
        'redirect_url'      => '',
        'order'                     => 'DESC',
        'limit'                     => 99,
        ), $atts));

    if ( !class_exists( 'WC_Paid_Listings' ) ) { 
        return;
    }
    ob_start();

    global $wp_query;

    $products_type = explode(",",$products);
    $query_args = array(
        'post_type'  => 'product',
        'limit'      => $limit,
        'orderby'    => $orderby,
        'order'      => $order,
        'tax_query'  => array(
            array(
                'taxonomy' => 'product_type',
                'field'    => 'slug',
                'terms'    => $products_type
            )
        ));
    
    if (  $orderby == 'price' ) {
        unset($query_args['orderby']);
        $query_args[] = array(
            'orderby'   => 'meta_value_num',
            'meta_key'  => '_price',
            'order'     => $order,
        );
    }
  
   $wp_query = new WP_Query( $query_args );

    switch ($wp_query->found_posts) {
        case 2:
            $columns = "eight";
            break;      
        case 3:
            $columns = "one-third";
            break;          
        case 4:
            $columns = "four";
            break;
        
        default:
            $columns = "one-third";
            break;
    }
    $counter = 0; ?>
    <div class="woo_pricing_tables">
    <?php
    while ( $wp_query->have_posts() ) : $wp_query->the_post(); 
            switch ($counter) {
                case '0':
                    $place_class = " alpha";
                    break;
                case $wp_query->found_posts:
                    $place_class = " omega";
                    break;
                
                default:
                    # code...
                    break;
            }
            $counter++;
            
            $job_package = wc_get_product( get_post()->ID ); ?>
        
            <div class="plan <?php if($job_package->is_featured()) { echo "color-2 "; } else { echo "color-1 "; } echo esc_attr($columns);  echo esc_attr($place_class); ?>  columns">
                <div class="plan-price">

                    <h3><?php the_title(); ?></h3>
                    <?php echo '<div class="plan-price-wrap">'.$job_package->get_price_html().'</div>'; ?>

                </div>

                <div class="plan-features">
                    <ul>
                        <?php 
                        $jobslimit = $job_package->get_limit();
                        if(!$jobslimit){
                            echo "<li>";
                             esc_html_e('Unlimited number of jobs','workscout_core'); 
                             echo "</li>";
                        } else { ?>
                            <li>
                                <?php esc_html_e('This plan includes ','workscout_core'); printf( _n( '%d job', '%s jobs', $jobslimit, 'workscout' ) . ' ', $jobslimit ); ?>
                            </li>
                        <?php } ?>
                        <li>
                            <?php esc_html_e('Jobs are posted ','workscout'); printf( _n( 'for %s day', 'for %s days', $job_package->get_duration(), 'workscout_core' ), $job_package->get_duration() ); ?>
                        </li>

                    </ul>
                    <?php 
                        the_content(); 
                        if(!empty($redirect_url)){
                            $link   = $redirect_url;
                        } else {
                            $link   = $job_package->add_to_cart_url();    
                        }
                        
                        $label  = apply_filters( 'add_to_cart_text', esc_html__( 'Add to cart', 'workscout_core' ) );
                
                    ?>
                    <a href="<?php echo esc_url( $link ); ?>" class="button"><i class="fa fa-shopping-cart"></i> <?php echo esc_html($label); ?></a>
                    
                </div>
            </div>
        <?php endwhile; ?>
        </div>
    <?php $pricing__output =  ob_get_clean();
    wp_reset_postdata();
    wp_reset_query();
    return $pricing__output;
}

?>