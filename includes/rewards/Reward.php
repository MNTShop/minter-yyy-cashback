<?php
/**
 * Created by PhpStorm.
 * User: devacc
 * Date: 08.05.2020
 * Time: 00:43
 */

abstract class Reward
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

    /**
     * WP_Post database key
     * @var string
     */
    public static $customization_id_key = 'myc_customization_setting_id';

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
     * WP_Post id
     * @var int
     */
    protected $post_id;

    /**
     * WP user id
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
     * Id for customization YYY.Push
     * @var int
     */
    protected $customization_id;

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
     * Commission of add ballance to YYY push
     * @var double
     */
    protected $commission;

    /**
     * Reward constructor. Get Reward from database.
     * @param int $post_id
     */
    public function __construct($post_id)
    {
        $this->post_id = $post_id;
        $this->cost = get_post_meta( $this->post_id, self::$cost_key, 1 );
        $this->user_id = get_post_meta( $this->post_id, self::$user_id_key, 1 );
        $this->customization_id = get_post_meta( $this->post_id, self::$customization_id_key, 1 );
        $this->use_coupon = get_post_meta( $this->post_id, self::$have_coupon_key, 1 );
        $this->coin = get_post_meta( $this->post_id, self::$coin_key, 1 );
        $this->bip_price = get_post_meta( $this->post_id, self::$bip_price_key, 1 );
        $this->email_sent = get_post_meta( $this->post_id, self::$email_sent_key, 1 );
        $this->coupon_spent = get_post_meta( $this->post_id, self::$coupon_spent_key, 1 );
        $this->hash = get_post_meta( $this->post_id, self::$hash_key, 1 );
        $this->commission = get_post_meta( $this->post_id, self::$commission_key, 1 );
        $this->YYY_push = get_post_meta($this->post_id,self::$YYY_push_key);
    }


    /**
     * Send reward to user
     * @return mixed
     */
    abstract public function send();

    /**
     * Save reward to database
     * @return mixed
     */
    abstract protected function save();

    /**
     * Get reward from database
     * @param $post_id
     */
    public function getReward($post_id){

    }
}