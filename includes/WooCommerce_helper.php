<?php
/**
 * Created by PhpStorm.
 * User: devacc
 * Date: 08.05.2020
 * Time: 00:47
 */

class WooCommerce_helper
{

    /**
     * Generate Woocommerce coupon for YYY_push
     * @param YYY_push $YYY_push
     * @return string
     */
    public function generateCouponPush(YYY_push $YYY_push){
            //create coupon for variation product
            /**
             * Create a coupon programatically
             */
            $minter_helper = new FunFasy_helper();
            $commission = $minter_helper->getCommission($YYY_push);
            $amount_to_transfer = $this->cost-$commission;
            $coupon_code = $this->link_id; // Code
            //get commission
            //converted from bip to local currency
            if($this->coin==='BIP'){
                $amount = $amount_to_transfer*$this->bip_price;
            }else{
                $TickerPriceBip = $minter_helper->getTickerPriceBip($this->coin);
                $amount = $amount_to_transfer*$this->bip_price*$TickerPriceBip;
            }
            $discount_type = 'fixed_cart'; // Type: fixed_cart, percent, fixed_product, percent_product
            $coupon = array(
                'post_title' => $coupon_code,
                'post_content' => '',
                'post_status' => 'publish',
                'post_author' => 1,
                'post_type' => 'shop_coupon');

            $new_coupon_id = wp_insert_post( $coupon );
            if($new_coupon_id){
                update_post_meta( $new_coupon_id, 'discount_type', $discount_type );
                update_post_meta( $new_coupon_id, 'coupon_amount', $amount );
                update_post_meta( $new_coupon_id, 'individual_use', 'no' );
                update_post_meta( $new_coupon_id, 'product_ids', '' );
                update_post_meta( $new_coupon_id, 'exclude_product_ids', '' );
                update_post_meta( $new_coupon_id, 'usage_limit', 1 );
                update_post_meta( $new_coupon_id, 'expiry_date', '' );
                update_post_meta( $new_coupon_id, 'apply_before_tax', 'yes' );
                update_post_meta( $new_coupon_id, 'free_shipping', 'no' );
                //update only after transaction send
                // amount должен быть меньше на сумму коммиссии
                $this->setHaveCoupon(true);
                $this->save();
                return $coupon_code;

            }else{
                return false;
            }
// Add meta
        }
}