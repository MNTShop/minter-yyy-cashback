<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://mntshop.ru
 * @since      1.0.0
 *
 * @package    Minter_Yyy_Cashback
 * @subpackage Minter_Yyy_Cashback/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Minter_Yyy_Cashback
 * @subpackage Minter_Yyy_Cashback/public
 * @author     Geman Vereschak <general@mntshop.ru>
 */

class Minter_Yyy_Cashback_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Minter_Yyy_Cashback_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Minter_Yyy_Cashback_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/minter-yyy-cashback-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Minter_Yyy_Cashback_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Minter_Yyy_Cashback_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/minter-yyy-cashback-public.js', array( 'jquery' ), $this->version, false );

	}

	//Create new push reward based on option
    public function pay_for_user_registration($user_id){
	    // I want just create a reward for user like that try new Register_reward($user_id)
        $reward = new Register_reward($user_id);
        $reward->send();
    }



    // This filter allows custom coupon objects to be created on the fly.
    // Accepting two arguments (three possible).
   public function update_coupon_if_YYYPush( bool $value, WC_Coupon $coupon,  WC_Discounts $WC_Discounts)
    {
        if (!empty($coupon)) {
            $transactionQuery = get_posts([
                    'post_type' => 'minter-push',
                    'orderby' => 'date',
                    'post_status' => 'draft',
                    'order' => 'DESC',
                    'posts_per_page' => 1,
                    'meta_query' => array(
                        array(
                            'key' => YYY_push::$link_id_key,
                            'value' => $coupon->get_code(),
                            'compare' => 'IN'
                        )
                    )
                ]
            );
            if (!empty($transactionQuery)) {
                $postIdPush = $transactionQuery[0]->ID;
                $YYY_Push = new YYY_push($postIdPush);
                //check already payed?
                if (!$YYY_Push->isCouponSpend()) {
                    if ($YYY_Push->payOffCoupon($coupon)) {
                        //change to current price
                        return $value;
                    } else {
                        return false;
                    }
                } else {
                    return $value;
                }
            }

        }
        return $value;
    }
}
