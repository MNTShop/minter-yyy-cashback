<?php
/**
 * Created by PhpStorm.
 * User: devacc
 * Date: 08.05.2020
 * Time: 00:43
 */

class Reward extends Reward_abstarct
{

    /**
     * Reward constructor. initial values
     * @param $user WP_User
     */
    public function __construct($user)
    {
            //Default values
        $this->plugin_options = get_option($this->plugin_name);
        $this->user = $user;
        $this->user_id = $user->ID;
        $this->use_coupon = $this->plugin_options['woocommerce_generate_coupons'];
        $this->coin = $this->plugin_options['coin'];
        $this->bip_price = $this->plugin_options['bip_price'];
        $this->email_sent = false;
        $this->coupon_spent = false;
        $this->hash = '';
        $this->commission = 0;
        $this->YYY_push = new YYY_push();
//        $this->cost = 0; // in particular set up in particular reward
    }


    public function getReward($post_id)
    {
        $this->post_id = $post_id;
        $this->cost = get_post_meta($this->post_id, self::$cost_key, 1);
        $this->user_id = get_post_meta($this->post_id, self::$user_id_key, 1);
        $this->user = get_user_by('ID',$this->user);
        $this->use_coupon = get_post_meta($this->post_id, self::$have_coupon_key, 1);
        $this->coin = get_post_meta($this->post_id, self::$coin_key, 1);
        $this->bip_price = get_post_meta($this->post_id, self::$bip_price_key, 1);
        $this->email_sent = get_post_meta($this->post_id, self::$email_sent_key, 1);
        $this->coupon_spent = get_post_meta($this->post_id, self::$coupon_spent_key, 1);
        $this->hash = get_post_meta($this->post_id, self::$hash_key, 1);
        $this->commission = get_post_meta($this->post_id, self::$commission_key, 1);
        $this->YYY_push = get_post_meta($this->post_id, self::$YYY_push_key);
        return $this;
    }
    public function save()
    {
        // first add place to save in databse
        if(empty($this->post_id)) {
            $this->post_id = wp_insert_post(
                ['post_title' => $this->title,
                    'post_type' => $this->post_type]
            );
            $this->save();
        }else{
            // update all data
            update_post_meta($this->post_id, self::$hash_key, $this->hash);
            update_post_meta($this->post_id, self::$cost_key, $this->cost);
            update_post_meta($this->post_id, self::$user_id_key, $this->user_id);
            update_post_meta($this->post_id, self::$have_coupon_key, $this->use_coupon);
            update_post_meta($this->post_id, self::$coin_key, $this->coin);
            update_post_meta($this->post_id, self::$bip_price_key, $this->bip_price);
            update_post_meta($this->post_id, self::$email_sent_key, $this->email_sent);
            update_post_meta($this->post_id, self::$coupon_spent_key, $this->coupon_spent);
            update_post_meta($this->post_id, self::$commission_key, $this->commission);
            update_post_meta($this->post_id, self::$YYY_push_key, $this->YYY_push);


//            update_post_meta($this->post_id, self::$recipient_key, $this->recipient);
//            update_post_meta($this->post_id, self::$sender_key, $this->sender);
//            update_post_meta($this->post_id, self::$deep_link_key, $this->deep_link);
//            update_post_meta($this->post_id, self::$password_key, $this->password);
//            update_post_meta($this->post_id, self::$customization_setting_id_key, $this->customization_setting_id);
//            update_post_meta($this->post_id, self::$link_id_key, $this->link_id);
//            update_post_meta($this->post_id, self::$address_key, $this->address);

        }
        return $this;
    }

}