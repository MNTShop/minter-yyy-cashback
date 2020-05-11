<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://mntshop.ru
 * @since      1.0.0
 *
 * @package    Minter_Yyy_Cashback
 * @subpackage Minter_Yyy_Cashback/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Minter_Yyy_Cashback
 * @subpackage Minter_Yyy_Cashback/admin
 * @author     Geman Vereschak <general@mntshop.ru>
 */
class Minter_Yyy_Cashback_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/minter-yyy-cashback-admin.css', array(), $this->version, 'all' );
        wp_enqueue_style( $this->plugin_name.'-datetimepicker' , plugin_dir_url( __FILE__ ) .'js/datetimepicker/jquery.datetimepicker.css');
	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/minter-yyy-cashback-admin.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name.'-datetimepicker', plugin_dir_url( __FILE__ ) . 'js/datetimepicker/build/jquery.datetimepicker.full.min.js', array( 'jquery' ), $this->version, true );

	}

    /**
     * Register the administration menu for this plugin into the WordPress Dashboard menu.
     */

    public function add_plugin_admin_menu() {

        /*
         * Add a settings page for this plugin to the Settings menu.
        */
        add_options_page( __('Minter Push YYY.cash settings',$this->plugin_name), 'Minter Push settings', 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page')
        );
    }
    /**
     * Render the settings page for this plugin.
     */

    public function display_plugin_setup_page() {

        include_once( 'partials/minter-yyy-cashback-admin-display.php' );

    }
    /**
     * Add settings action link to the plugins page.
     */

    public function add_action_links( $links ) {

        $settings_link = array(
            '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __('Settings', $this->plugin_name) . '</a>',
        );
        return array_merge(  $settings_link, $links );

    }
    // Register Custom Post Type
    /**
     * Creates a new custom post type
     *
     * @since 1.0.0
     * @access public
     * @uses register_post_type()
     */
    public static function minter_push_type_generate() {
        $cap_type = 'post';
        $plural = 'Minter Pushes';
        $single = 'Minter Push';
        $capabilities = [
            'create_posts' => 'do_not_allow'
        ];
        $cpt_name = 'minter-push';
        $opts['can_export'] = TRUE;
        $opts['capability_type'] = $cap_type;
        $opts['capabilities'] = $capabilities;
//        $opts['map_meta_cap'] = false;
        $opts['description'] = '';
        $opts['supports'] = array( 'title');
        $opts['exclude_from_search'] = TRUE;
        $opts['has_archive'] = FALSE;
        $opts['hierarchical'] = FALSE;
        $opts['map_meta_cap'] = TRUE;
        $opts['menu_icon'] = 'dashicons-tickets-alt';
        $opts['menu_position'] = 25;
        $opts['public'] = TRUE;
        $opts['publicly_querable'] = TRUE;
        $opts['query_var'] = TRUE;
        $opts['register_meta_box_cb'] = '';
        $opts['rewrite'] = FALSE;
        $opts['show_in_admin_bar'] = TRUE;
        $opts['show_in_menu'] = TRUE;
        $opts['show_in_nav_menu'] = TRUE;

        $opts['labels']['add_new'] = esc_html__( "Add New {$single}", 'wisdom' );
        $opts['labels']['add_new_item'] = esc_html__( "Add New {$single}", 'wisdom' );
        $opts['labels']['all_items'] = esc_html__( $plural, 'wisdom' );
        $opts['labels']['edit_item'] = esc_html__( "Edit {$single}" , 'wisdom' );
        $opts['labels']['menu_name'] = esc_html__( $plural, 'wisdom' );
        $opts['labels']['name'] = esc_html__( $plural, 'wisdom' );
        $opts['labels']['name_admin_bar'] = esc_html__( $single, 'wisdom' );
        $opts['labels']['new_item'] = esc_html__( "New {$single}", 'wisdom' );
        $opts['labels']['not_found'] = esc_html__( "No {$plural} Found", 'wisdom' );
        $opts['labels']['not_found_in_trash'] = esc_html__( "No {$plural} Found in Trash", 'wisdom' );
        $opts['labels']['parent_item_colon'] = esc_html__( "Parent {$plural} :", 'wisdom' );
        $opts['labels']['search_items'] = esc_html__( "Search {$plural}", 'wisdom' );
        $opts['labels']['singular_name'] = esc_html__( $single, 'wisdom' );
        $opts['labels']['view_item'] = esc_html__( "View {$single}", 'wisdom' );
        register_post_type( strtolower( $cpt_name ), $opts );
    } // new_cpt_job()
    // Register Custom Post Type
    /**
     * Creates a new custom post type
     *
     * @since 1.0.0
     * @access public
     * @uses register_post_type()
     */
    public static function minter_rewards_type_generate() {
        $cap_type = 'post';
        $plural = 'Minter Rewards';
        $single = 'Minter Reward';
        $capabilities = [
            'create_posts' => 'do_not_allow'
        ];
        $cpt_name = 'minter-rewards';
        $opts['can_export'] = TRUE;
        $opts['capability_type'] = $cap_type;
        $opts['capabilities'] = $capabilities;
//        $opts['map_meta_cap'] = false;
        $opts['description'] = '';
        $opts['supports'] = array( 'title');
        $opts['exclude_from_search'] = TRUE;
        $opts['has_archive'] = FALSE;
        $opts['hierarchical'] = FALSE;
        $opts['map_meta_cap'] = TRUE;
        $opts['menu_icon'] = 'dashicons-tickets-alt';
        $opts['menu_position'] = 25;
        $opts['public'] = TRUE;
        $opts['publicly_querable'] = TRUE;
        $opts['query_var'] = TRUE;
        $opts['register_meta_box_cb'] = '';
        $opts['rewrite'] = FALSE;
        $opts['show_in_admin_bar'] = TRUE;
        $opts['show_in_menu'] = TRUE;
        $opts['show_in_nav_menu'] = TRUE;

        $opts['labels']['add_new'] = esc_html__( "Add New {$single}", 'wisdom' );
        $opts['labels']['add_new_item'] = esc_html__( "Add New {$single}", 'wisdom' );
        $opts['labels']['all_items'] = esc_html__( $plural, 'wisdom' );
        $opts['labels']['edit_item'] = esc_html__( "Edit {$single}" , 'wisdom' );
        $opts['labels']['menu_name'] = esc_html__( $plural, 'wisdom' );
        $opts['labels']['name'] = esc_html__( $plural, 'wisdom' );
        $opts['labels']['name_admin_bar'] = esc_html__( $single, 'wisdom' );
        $opts['labels']['new_item'] = esc_html__( "New {$single}", 'wisdom' );
        $opts['labels']['not_found'] = esc_html__( "No {$plural} Found", 'wisdom' );
        $opts['labels']['not_found_in_trash'] = esc_html__( "No {$plural} Found in Trash", 'wisdom' );
        $opts['labels']['parent_item_colon'] = esc_html__( "Parent {$plural} :", 'wisdom' );
        $opts['labels']['search_items'] = esc_html__( "Search {$plural}", 'wisdom' );
        $opts['labels']['singular_name'] = esc_html__( $single, 'wisdom' );
        $opts['labels']['view_item'] = esc_html__( "View {$single}", 'wisdom' );
        register_post_type( strtolower( $cpt_name ), $opts );
    } // new_cpt_job()

    /**
     * Validate options
     */
    public function validate($input) {
        $yyy_helper = new YYY_push();
        $options = get_option($this->plugin_name);
        $valid = array();
        $valid['woocommerce_generate_coupons'] = (isset($input['woocommerce_generate_coupons']) && !empty($input['woocommerce_generate_coupons'])) ? $input['woocommerce_generate_coupons'] : '';

        $valid['bip_price'] = (isset($input['bip_price']) && !empty($input['bip_price'])) ? $input['bip_price'] : '';
        $valid['coin'] = (isset($input['coin']) && !empty($input['coin'])) ? $input['coin'] : '';
        $valid['minter_wallet_seed'] =(isset($input['minter_wallet_seed']) && !empty($input['minter_wallet_seed'])) ? $input['minter_wallet_seed'] : '';
        $valid['minter_wallet_mnemonic'] =(isset($input['minter_wallet_mnemonic']) && !empty($input['minter_wallet_mnemonic'])) ? $input['minter_wallet_mnemonic'] : '';
        $valid['minter_wallet_address'] = (isset($input['minter_wallet_address']) && !empty($input['minter_wallet_address'])) ? $input['minter_wallet_address'] : '';
        $valid['minter_wallet_public_key'] = (isset($input['minter_wallet_public_key']) && !empty($input['minter_wallet_public_key'])) ? $input['minter_wallet_public_key'] : '';
        $valid['minter_wallet_private_key'] = (isset($input['minter_wallet_private_key']) && !empty($input['minter_wallet_private_key'])) ? $input['minter_wallet_private_key'] : '';

        $valid['minter_funfasy_project_id'] = (isset($input['minter_funfasy_project_id']) && !empty($input['minter_funfasy_project_id'])) ? $input['minter_funfasy_project_id'] : '';
        $valid['minter_funfasy_project_secret'] = (isset($input['minter_funfasy_project_secret']) && !empty($input['minter_funfasy_project_secret'])) ? $input['minter_funfasy_project_secret'] : '';

        //register reward
        $valid['register_cost'] = (isset($input['register_cost']) && !empty($input['register_cost'])) ? $input['register_cost'] : '';
        $valid['register_switch'] = (isset($input['register_switch']) && !empty($input['register_switch'])) ? $input['register_switch'] : '';
        $valid['register_use_password'] = (isset($input['register_use_password']) && !empty($input['register_use_password'])) ? $input['register_use_password'] : '';

        $valid['register_email_template'] = (isset($input['register_email_template']) && !empty($input['register_email_template'])) ? $input['register_email_template'] : '';
        $valid['register_email_subject'] = (isset($input['register_email_subject']) && !empty($input['register_email_subject'])) ? $input['register_email_subject'] : '';
        $valid['register_email_from'] = (isset($input['register_email_from']) && !empty($input['register_email_from'])) ? $input['register_email_from'] : '';
        $valid['register_email_password_message'] = (isset($input['register_email_password_message']) && !empty($input['register_email_password_message'])) ? $input['register_email_password_message'] : '';
        $valid['register_email_coupon_message'] = (isset($input['register_email_coupon_message']) && !empty($input['register_email_coupon_message'])) ? $input['register_email_coupon_message'] : '';

        $valid['register_customization_id'] = (isset($input['register_customization_id']) && !empty($input['register_customization_id'])) ? $input['register_customization_id'] : '';
        $valid['register_animation_name'] = (isset($input['register_animation_name']) && !empty($input['register_animation_name'])) ? $input['register_animation_name'] : '';
        $valid['register_animation_text'] = (isset($input['register_animation_text']) && !empty($input['register_animation_text'])) ? $input['register_animation_text'] : '';
        $valid['register_background_name'] = (isset($input['register_background_name']) && !empty($input['register_background_name'])) ? $input['register_background_name'] : '';
        $valid['register_head_text'] = (isset($input['register_head_text']) && !empty($input['register_head_text'])) ? $input['register_head_text'] : '';
        $valid['register_logo_image_id'] = (isset($input['register_logo_image_id']) && !empty($input['register_logo_image_id'])) ? $input['register_logo_image_id'] : '';

//        $valid['register_email_body_text'] = (isset($input['register_email_body_text']) && !empty($input['register_email_body_text'])) ? $input['register_email_body_text'] : '';
//        $valid['register_email_button_text'] = (isset($input['register_email_button_text']) && !empty($input['register_email_button_text'])) ? $input['register_email_button_text'] : '';
//        $valid['register_email_head_text'] = (isset($input['register_email_head_text']) && !empty($input['register_email_head_text'])) ? $input['register_email_head_text'] : '';
//        $valid['register_email_image_id'] = (isset($input['register_email_image_id']) && !empty($input['register_email_image_id'])) ? $input['register_email_image_id'] : '';
//        $valid['register_email_subject_text'] = (isset($input['register_email_subject_text']) && !empty($input['register_email_subject_text'])) ? $input['register_email_subject_text'] : '';
//        $valid['register_only_target'] = (isset($input['register_only_target']) && !empty($input['register_only_target'])) ? $input['register_only_target'] : '';
//        $valid['register_target_shop'] = (isset($input['register_target_shop']) && !empty($input['register_target_shop'])) ? $input['register_target_shop'] : '';

        if(empty($valid['register_customization_id'])){

            //create new customization
            $settings = [
                'animation_name'=>$valid['register_animation_name'],
                'animation_text'=>$valid['register_animation_text'],
                'background_name'=>$valid['register_background_name'],
                'head_text'=>$valid['register_head_text'],
            ];
            $newCustomizationId = $yyy_helper->createCustomization($settings);
            $valid['register_customization_id'] = $newCustomizationId;
        }

        //scedule reward
        $valid['schedule_cost'] = (isset($input['schedule_cost']) && !empty($input['schedule_cost'])) ? $input['schedule_cost'] : '';
        $valid['schedule_time'] = (isset($input['schedule_time']) && !empty($input['schedule_time'])) ? $input['schedule_time'] : '';
        $valid['schedule_use_password'] = (isset($input['schedule_use_password']) && !empty($input['schedule_use_password'])) ? $input['schedule_use_password'] : '';

        $valid['schedule_email_template'] = (isset($input['schedule_email_template']) && !empty($input['schedule_email_template'])) ? $input['schedule_email_template'] : '';
        $valid['schedule_email_subject'] = (isset($input['schedule_email_subject']) && !empty($input['schedule_email_subject'])) ? $input['schedule_email_subject'] : '';
        $valid['schedule_email_from'] = (isset($input['schedule_email_from']) && !empty($input['schedule_email_from'])) ? $input['schedule_email_from'] : '';
        $valid['schedule_email_password_message'] = (isset($input['schedule_email_password_message']) && !empty($input['schedule_email_password_message'])) ? $input['schedule_email_password_message'] : '';
        $valid['schedule_email_coupon_message'] = (isset($input['schedule_email_coupon_message']) && !empty($input['schedule_email_coupon_message'])) ? $input['schedule_email_coupon_message'] : '';

        $valid['schedule_customization_id'] = (isset($input['schedule_customization_id']) && !empty($input['schedule_customization_id'])) ? $input['schedule_customization_id'] : '';
        $valid['schedule_animation_name'] = (isset($input['schedule_animation_name']) && !empty($input['schedule_animation_name'])) ? $input['schedule_animation_name'] : '';
        $valid['schedule_animation_text'] = (isset($input['schedule_animation_text']) && !empty($input['schedule_animation_text'])) ? $input['schedule_animation_text'] : '';
        $valid['schedule_background_name'] = (isset($input['schedule_background_name']) && !empty($input['schedule_background_name'])) ? $input['schedule_background_name'] : '';
        $valid['schedule_head_text'] = (isset($input['schedule_head_text']) && !empty($input['schedule_head_text'])) ? $input['schedule_head_text'] : '';
        $valid['schedule_logo_image_id'] = (isset($input['schedule_logo_image_id']) && !empty($input['schedule_logo_image_id'])) ? $input['schedule_logo_image_id'] : '';

//        $valid['register_email_body_text'] = (isset($input['register_email_body_text']) && !empty($input['register_email_body_text'])) ? $input['register_email_body_text'] : '';
//        $valid['register_email_button_text'] = (isset($input['register_email_button_text']) && !empty($input['register_email_button_text'])) ? $input['register_email_button_text'] : '';
//        $valid['register_email_head_text'] = (isset($input['register_email_head_text']) && !empty($input['register_email_head_text'])) ? $input['register_email_head_text'] : '';
//        $valid['register_email_image_id'] = (isset($input['register_email_image_id']) && !empty($input['register_email_image_id'])) ? $input['register_email_image_id'] : '';
//        $valid['register_email_subject_text'] = (isset($input['register_email_subject_text']) && !empty($input['register_email_subject_text'])) ? $input['register_email_subject_text'] : '';
//        $valid['register_only_target'] = (isset($input['register_only_target']) && !empty($input['register_only_target'])) ? $input['register_only_target'] : '';
//        $valid['register_target_shop'] = (isset($input['register_target_shop']) && !empty($input['register_target_shop'])) ? $input['register_target_shop'] : '';
        if(empty($valid['schedule_customization_id'])){

            //create new customization
            $settings = [
                'animation_name'=>$valid['schedule_animation_name'],
                'animation_text'=>$valid['schedule_animation_text'],
                'background_name'=>$valid['schedule_background_name'],
                'head_text'=>$valid['schedule_head_text'],
            ];
            $newCustomizationId = $yyy_helper->createCustomization($settings);
            $valid['schedule_customization_id'] = $newCustomizationId;
        }
        $valid['schedule_switch'] =  $input['schedule_switch'];

        //If Activate
        error_log($input['schedule_switch'].$options['schedule_event']);
        if(isset($input['schedule_switch']) && !empty($input['schedule_switch']) && empty($options['schedule_event'])){
            $valid['schedule_switch'] =  $input['schedule_switch'];
            //setup new cron job
            //convert date schedule to timestamp
            if(!empty($valid['schedule_time'] )){
                $dateobj = DateTime::createFromFormat("Y/m/d H:i", $valid['schedule_time']);
//                $dateobj->setTimeZone(wp_timezone());
                $timestamp_schedule_reward =$dateobj->getTimestamp();
                error_log('$timestamp_schedule_reward '.$timestamp_schedule_reward);
                error_log('currentTimestamp'.time());
                //check if event scheduled before
//                $valid['schedule_event'] =1;
//                $cronjob = new KamaCron([
//                    'id'     => 'myc_schedule_jobs', // не обязательный параметр
//                    'events' => array(
//                        // первая задача
//                        'wpkama_cron_func' => array(
//                            'callback'      => [$this,'start_scheduled_reward_campaign'], // название функции крон-задачи
//                            'interval_name' => '10_min',           // можно указать уже имеющийся интервал: hourly, twicedaily, daily
//                            'interval_desc' => 'Каждые 10 минут',  // не нужен, если задан уже имеющийся интервал
//                        )
//                    ),
//                ]);
//                if(!wp_next_scheduled('schedule_reward_campaign')){
//                     wp_schedule_single_event( $timestamp_schedule_reward,'schedule_reward_campaign');
//                    error_log('HERE in next  '.$valid['schedule_event']);
//
//                error_log('Schedule '.$valid['schedule_event']);
//            }
            }
        }else{
            //set  schedule event to false

//            $valid['schedule_event'] = 0;

//            update_option($this->plugin_name,$options);
        }

        return $valid;
    }


    public function start_scheduled_reward_campaign(){



        //clear event
        $options = get_option($this->plugin_name);
        KamaCron::deactivate('myc_schedule_jobs');
        $options['schedule_event'] = 0;

        if ($options['schedule_switch'] != 0) {
                $dateobj = DateTime::createFromFormat("Y/m/d H:i", $options['schedule_time']);
//                $dateobj->setTimeZone(wp_timezone());
                $timestamp_schedule_reward =$dateobj->getTimestamp();
                error_log('$timestamp_schedule_reward '.$timestamp_schedule_reward);
                error_log('currentTimestamp'.time());
                if($timestamp_schedule_reward >= time()) {

//        get_option($this->plugin_name);
                $options['schedule_switch'] = 0;
                update_option($this->plugin_name, $options);
                // get event settings and start user send emails
                $users = get_users(array('fields' => array('ID', 'user_email')));
                $cost_per_user = $options['schedule_cost'] / count($users);
                foreach ($users as $user_id) {

                    if ($user_id->ID == 278) {
                        if (empty($user_id->user_email)) {
                            //  email for user if not have for dend throw the telegram auto-generated@mntshop.ru
                            error_log('Hey EMPTY set to auto-generated@mntshop.ru' . $user_id->user_email . '  ' . $user_id->ID);
                            $user_email = 'auto-generated@mntshop.ru';
                        } else {
                            error_log('Hey Not Empyty' . $user_id->user_email . '  ' . $user_id->ID);

                            $user_email = $user_id->user_email;
                        }
                        $YYY_push = new YYY_push();
                        $YYY_push
                            ->setUserId($user_id->ID)
                            ->setRecipient($user_email)
                            ->setSender(get_bloginfo())
                            ->setCost($cost_per_user)
                            ->setTicker($options['ticker'])
                            ->setBipPrice($options['bip_price'])
                            ->setTitleAdmin('pay for register ' . $user_email);
                        if ($options['schedule_use_password']) {
                            $YYY_push->setPassword(bin2hex(random_bytes(3)));
                        }
                        if ($options['schedule_customization_id']) {
                            $YYY_push->setCustomizationSettingId($options['schedule_customization_id']);
                        }
                        $YYY_push->save();
                        if ($YYY_push->request_push()) {
                            $minter_helper = new FunFasy_helper();
                            if ($minter_helper->pay_off_push($YYY_push) !== false) {
                                if ($options['woocommerce_generate_coupons']) {
                                    $YYY_push->generate_coupon_for_push();
                                }
                                if (false === $YYY_push->sendEmail('schedule')) {
                                    error_log('Email with minter push are Not send ' . $YYY_push->getTitleAdmin());
                                    //try more
                                }
                            } else {
                                error_log('Push not added balance  ' . $YYY_push->getTitleAdmin());
                            }
                        } else {
                            error_log('YYY.cash not created push');
                        }

                    }
                }
                return;
            }
        }
    }

    /**
     * Update all options
     */
    public function options_update() {
        register_setting($this->plugin_name, $this->plugin_name, array($this, 'validate'));
    }
    public function myc_add_metabox() {
        add_meta_box(
            'myc_metabox',
            __('Minter YYY info',$this->plugin_name),
            [$this, 'myc_screen']
        );
    }
    public function myc_screen($post, $meta ){
        $YYY_Push = new YYY_push($post->ID);

        wp_nonce_field( plugin_basename(__FILE__), 'myc_metabox_noncename' );

        // FORM FIELDS
        echo '<div class="section"><label for="'.$YYY_Push::getCostKey().'">' . __("Push cost", $this->plugin_name ) . '</label> ';
        echo '<input type="text" id="'.$YYY_Push::getCostKey().'" name="'.$YYY_Push::getCostKey().'" value="'. $YYY_Push->getCost() .'" size="25" /></div>';
        echo '<div class="section"><label for="'.$YYY_Push::getUserIdKey().'">' . __("User ID", $this->plugin_name ) . '</label> ';
        echo '<input type="text" id="'.$YYY_Push::getUserIdKey().'" name="'.$YYY_Push::getUserIdKey().'" value="'. $YYY_Push->getUserId() .'" size="25" /></div>';
        echo '<div class="section"><label for="'.$YYY_Push::getRecipientKey().'">' . __("Recipient email", $this->plugin_name ) . '</label> ';
        echo '<input type="text" id="'.$YYY_Push::getRecipientKey().'" name="'.$YYY_Push::getRecipientKey().'" value="'. $YYY_Push->getRecipient() .'" size="25" /></div>';
        echo '<div class="section"><label for="'.$YYY_Push::getSenderKey().'">' . __("Sender", $this->plugin_name ) . '</label> ';
        echo '<input type="text" id="'.$YYY_Push::getRecipientKey().'" name="'.$YYY_Push::getRecipientKey().'" value="'. $YYY_Push->getSender() .'" size="25" /></div>';
        echo '<div class="section"><label for="'.$YYY_Push::getPasswordKey().'">' . __("Password Push", $this->plugin_name ) . '</label> ';
        echo '<input type="text" id="'.$YYY_Push::getPasswordKey().'" name="'.$YYY_Push::getPasswordKey().'" value="'. $YYY_Push->getPassword() .'" size="25" /></div>';
        echo '<div class="section"><label for="'.$YYY_Push::getCustomizationSettingIdKey().'">' . __("Customization id", $this->plugin_name ) . '</label> ';
        echo '<input type="text" id="'.$YYY_Push::getCustomizationSettingIdKey().'" name="'.$YYY_Push::getCustomizationSettingIdKey().'" value="'. $YYY_Push->getCustomizationSettingId() .'" size="25" /></div>';
        echo '<div class="section"><label for="'.$YYY_Push::getLinkIdKey().'">' . __("Push link ID", $this->plugin_name ) . '</label> ';
        echo '<input type="text" id="'.$YYY_Push::getLinkIdKey().'" name="'.$YYY_Push::getLinkIdKey().'" value="'. $YYY_Push->getLinkId() .'" size="25" /></div>';
        echo '<div class="section"><label for="'.$YYY_Push::getAddressKey().'">' . __("Minter push address", $this->plugin_name ) . '</label> ';
        echo '<input type="text" id="'.$YYY_Push::getAddressKey().'" name="'.$YYY_Push::getAddressKey().'" value="'. $YYY_Push->getAddress() .'" size="25" /></div>';
        echo '<div class="section"><label for="'.$YYY_Push::getDeepLinkKey().'">' . __("Deep link push", $this->plugin_name ) . '</label> ';
        echo '<input type="text" id="'.$YYY_Push::getDeepLinkKey().'" name="'.$YYY_Push::getDeepLinkKey().'" value="'. $YYY_Push->getDeepLink() .'" size="25" /></div>';
        echo '<div class="section"><label for="'.$YYY_Push::getHashKey().'">' . __("Hash add balance", $this->plugin_name ) . '</label> ';
        echo '<input type="text" id="'.$YYY_Push::getHashKey().'" name="'.$YYY_Push::getHashKey().'" value="'. $YYY_Push->getHash() .'" size="25" /></div>';
        echo '<div class="section"><label for="'.$YYY_Push::getEmailSendKey().'">' . __("Email send?", $this->plugin_name ) . '</label> ';
        echo '<input type="text" id="'.$YYY_Push::getEmailSendKey().'" name="'.$YYY_Push::getEmailSendKey().'" value="'. $YYY_Push->isEmailSend() .'" size="25" /></div>';
        echo '<div class="section"><label for="'.$YYY_Push::getTickerKey().'">' . __("Push ticker", $this->plugin_name ) . '</label> ';
        echo '<input type="text" id="'.$YYY_Push::getTickerKey().'" name="'.$YYY_Push::getTickerKey().'" value="'. $YYY_Push->getTicker() .'" size="25" /></div>';
        echo '<div class="section"><label for="'.$YYY_Push::getCouponSpendKey().'">' . __("Push pay off coupon", $this->plugin_name ) . '</label> ';
        echo '<input type="text" id="'.$YYY_Push::getCouponSpendKey().'" name="'.$YYY_Push::getCouponSpendKey().'" value="'. $YYY_Push->isCouponSpend() .'" size="25" /></div>';
        echo '<div class="section"><label >' . __("Push URL: ", $this->plugin_name ) . '</label>  <a href="https://yyy.cash/push/'. $YYY_Push->getLinkId() .'">https://yyy.cash/push/'. $YYY_Push->getLinkId() .'</a>';

    }


}
