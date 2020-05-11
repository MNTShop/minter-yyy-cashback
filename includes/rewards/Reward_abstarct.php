<?php
/**
 * Created by PhpStorm.
 * User: devacc
 * Date: 11.05.2020
 * Time: 16:59
 */

abstract class Reward_abstarct
{

    /**
     * WP_Post database key
     * @var string
     */
    public static $user_id_key = 'myc_user_id';

    /**
     * WP_Post database key
     * @var string
     */
    public static $cost_key = 'myc_cost';

    /**
     * WP_Post database key
     * @var string
     */
    public static $have_coupon_key = 'myc_have_coupon';

    /**
     * WP_Post database key
     * @var string
     */
    public static $email_sent_key = 'myc_email_sent';

    /**
     * WP_Post database key
     * @var string
     */
    public static $coupon_spent_key = 'myc_coupon_spent_hash_key';

//    /**
//     * WP_Post database key
//     * @var string
//     */
////    public static $customization_id_key = 'myc_customization_setting_id';

    /**
     * WP_Post database key
     * @var string
     */
    public static $bip_price_key = 'myc_bip_price';

    /**
     * WP_Post database key
     * @var string
     */
    public static $coin_key = 'myc_coin';


    /**
     * WP_Post database key
     * @var string
     */
    public static $commission_key = 'myc_commission';

    /**
     * WP_Post database key
     * @var string
     */
    public static $hash_key = 'myc_hash';
    /**
     * WP_Post database key
     * @var string
     */
    public static $YYY_push_key = 'myc_YYY_push';

    /**
     * WP Post type for store rewards
     * @var string
     */
    protected $post_type = 'minter-rewards';

    /**
     * Just plugin name
     * @var string
     */
    protected $plugin_name = 'minter-yyy-cashback';


    /**
     * Plugin options
     * @var array
     */
    public $plugin_options;

    /**
     * WP_Post id
     * @var int
     */
    protected $post_id;

    /**
     * WP_user object
     * @var WP_User
     */
    public $user;

    /**
     * WP_user id
     * @var int
     */
    public $user_id;


    /**
     * YYY_push used by reward
     * @var YYY_push
     */
    public $YYY_push;

    /**
     * Reward cost
     * @var double
     */
    public $cost;

    /**
     * Which coin to reward?
     * @var string
     */
    public $coin;

    /**
     * Title for WP_post
     * @var string
     */
    public $title;

    /**
     * Is reward generate woocommerce coupon?
     * @var bool
     */
    public $use_coupon;

    /**
     * Have password?
     * @var bool
     */
    protected $use_password;


    /**
     * Bip price when send reward
     * @var double
     */
    protected $bip_price;

    /**
     * Is email sent?
     * @var bool
     */
    protected $email_sent;

    /**
     * Is coupon spent?
     * @var bool
     */
    protected $coupon_spent;

    /**
     * Hash of add balance to YYY address
     * @var string
     */
    protected $hash;

    /**
     * Commission of add balance to YYY push
     * @var double
     */
    protected $commission;

    /**
     * Email subject
     * @var string
     */
    protected $email_subject;

    /**
     * Email Template
     * @var string
     */
    protected $email_template;

    /**
     * Email coupon message
     * @var string
     */
    protected $email_coupon_message;
    /**
     * Email password message
     * @var string
     */
    protected $email_password_message;

    /**
     * Email from
     * @var string
     */
    protected $email_from;


    /**
     * Save whole reward to database
     * @return mixed
     */
    abstract public function save();

    /**
     * Get the reward from WP database
     * @param $post_id int
     * @return mixed
     */
    abstract public function getReward($post_id);


}