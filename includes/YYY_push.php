<?php

use GuzzleHttp\Exception\RequestException;

/**
 *      * @var      string    $password    password of created push.
 * @var      int    $user_id    WP user_id that get push.
 * @var      string    $sender    push sender field on YYY.cash.
 * @var      string    $customization_setting_id    setting_id field on YYY.cash.
 * @var      string    $link_id    link_id field on YYY.cash.
 * @var      string    $address    Minter address of generated push on YYY.cash.
 * @var      string    $deep_link    deep_link of generated push on YYY.cash.
 * @var      string    $hash     add balance transaction hash of generated push on YYY.cash. If have money transferred
 * @var      int    $post_id     WP Post id
 * The file that defines the push object
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://mntshop.ru
 * @since      1.0.0
 *
 * @package    Minter_Yyy_Cashback
 * @subpackage Minter_Yyy_Cashback/includes
 */
class YYY_push
{
    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $plugin_name    The string used to uniquely identify this plugin.
     */
    private $plugin_name;

    public $post_type='minter-push';
    private $node_address = 'https://mnt.funfasy.dev/';

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      /GuzzleHttp/Client $client    Guzzle client.
     */
    private $client;
    protected $post_id;

    protected $title_admin;
    protected $cost;
    protected $user_id;
    protected $sender;
    protected $password;
    protected $customization_setting_id;
    protected $link_id;
    protected $address;
    protected $deep_link;
    protected $hash;
    protected $recipient;
    protected $have_coupon;
    protected $bip_price;
    protected $ticker;
    protected $email_send;
    protected $coupon_spend;
    protected $commission;


    // define additional keys for WP_Post
    private static $bip_price_key = 'myc_bip_price';
    private static $ticker_key = 'myc_ticker';
    private static $cost_key = 'myc_cost';
    private static $commission_key = 'myc_commission';
    private static $user_id_key = 'myc_user_id';
    private static $coupon_spend_key = 'myc_coupon_spend_hash_key';
    private static $hash_key = 'myc_hash';


    private static $customization_setting_id_key = 'myc_customization_setting_id';
    private static $recipient_key = 'myc_recipient';
    private static $sender_key = 'myc_sender';
    private static $password_key = 'myc_password';
    private static $link_id_key = 'myc_link_id';
    private static $address_key = 'myc_address';
    private static $deep_link_key = 'myc_deep_link' ;
    //

    private static $have_coupon_key = 'myc_have_coupon';
    private static $email_send_key = 'myc_email_send';

    //define push settings




    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     */

    public function __construct($post_id=0) {
        $this->client =new GuzzleHttp\Client();
        $this->plugin_name = 'minter-yyy-cashback';
        if($post_id!=0 ){
            $this->post_id = $post_id;
            // set push object from database
            $this->cost = get_post_meta( $this->post_id, self::$cost_key, 1 );
            $this->user_id = get_post_meta( $this->post_id, self::$user_id_key, 1 );
            $this->sender = get_post_meta( $this->post_id, self::$sender_key, 1 );
            $this->password = get_post_meta( $this->post_id, self::$password_key, 1 );
            $this->customization_setting_id = get_post_meta( $this->post_id, self::$customization_setting_id_key, 1 );
            $this->link_id = get_post_meta( $this->post_id, self::$link_id_key, 1 );
            $this->address = get_post_meta( $this->post_id, self::$address_key, 1 );
            $this->deep_link = get_post_meta( $this->post_id,self::$deep_link_key, 1 );
            $this->hash = get_post_meta( $this->post_id, self::$hash_key, 1 );
            $this->recipient = get_post_meta( $this->post_id, self::$recipient_key, 1 );
            $this->have_coupon = get_post_meta( $this->post_id, self::$have_coupon_key, 1 );
            $this->ticker = get_post_meta( $this->post_id, self::$ticker_key, 1 );
            $this->bip_price = get_post_meta( $this->post_id, self::$bip_price_key, 1 );
            $this->email_send = get_post_meta( $this->post_id, self::$email_send_key, 1 );
            $this->coupon_spend = get_post_meta( $this->post_id, self::$coupon_spend_key, 1 );
            $this->coupon_spend = get_post_meta( $this->post_id, self::$commission_key, 1 );
        }else{
            $options = get_option($this->plugin_name);
            $this->ticker = false;
            $this->email_send = false;
            $this->have_coupon = false;
            $this->cost = $options['register_cost'];
            $this->user_id = get_current_user_id();
            $this->sender = get_bloginfo();
            $this->password = false;
            $this->customization_setting_id = 0;
            $this->hash = false;
            $this->recipient = get_post_meta( $this->post_id, self::$recipient_key, 1 );
            $this->have_coupon = false;
            $this->ticker = $options['ticker'];
            $this->bip_price = $options['bip_price'];
            $this->email_send = false;
            $this->coupon_spend = false;

        }
    }

    public function save(){
        // get all data and save to WordPress
        if(empty($this->getPostId())) {
            $new_post_id = wp_insert_post(
                ['post_title' => $this->getTitleAdmin(),
                    'post_type' => $this->post_type]
            );
            if ($new_post_id) {
                $this->setPostId($new_post_id);
            }
            //generate first
        }else{
            update_post_meta($this->getPostId(), self::$hash_key, $this->hash);
            update_post_meta($this->getPostId(), self::$cost_key, $this->cost);
            update_post_meta($this->getPostId(), self::$user_id_key, $this->user_id);
            update_post_meta($this->getPostId(), self::$recipient_key, $this->recipient);
            update_post_meta($this->getPostId(), self::$sender_key, $this->sender);
            update_post_meta($this->getPostId(), self::$deep_link_key, $this->deep_link);
            update_post_meta($this->getPostId(), self::$password_key, $this->password);
            update_post_meta($this->getPostId(), self::$customization_setting_id_key, $this->customization_setting_id);
            update_post_meta($this->getPostId(), self::$link_id_key, $this->link_id);
            update_post_meta($this->getPostId(), self::$address_key, $this->address);
            update_post_meta($this->getPostId(), self::$have_coupon_key, $this->isHaveCoupon());
            update_post_meta($this->getPostId(), self::$ticker_key, $this->ticker);
            update_post_meta($this->getPostId(), self::$bip_price_key, $this->bip_price);
            update_post_meta($this->getPostId(), self::$email_send_key, $this->isEmailSend());
            update_post_meta($this->getPostId(), self::$coupon_spend_key, $this->isCouponSpend());
            update_post_meta($this->getPostId(), self::$commission_key, $this->commission);

        }
        return $this->getPostId();

    }

    public function request_push($tries=0){
        $newPush = [
            "amount"=> $this->cost,
            "recipient"=> $this->recipient,
            "sender"=> $this->sender,
            "customization_setting_id"=> $this->customization_setting_id,
        ];

        if(!empty($this->password)){
            $newPush['password']=$this->password;
        }
        try {
            $responseNewPush = $this->getClient()->post('https://push.money/api/push/create',[
                GuzzleHttp\RequestOptions::JSON => $newPush // or 'json' => [...]
            ]);
            if($responseNewPush->getStatusCode() ==200) {
                $pushObj = json_decode($responseNewPush->getBody());
                //fill our object
                $this->setAddress($pushObj->address);
                $this->setDeepLink($pushObj->deeplink);
                $this->setLinkId($pushObj->link_id);
                $this->save();
                return $this;
            }else{
                return false;
            }

        }catch (RequestException $exception) {

            $content = $exception->getResponse()
                ->getBody()
                ->getContents();

            $error = json_decode($content, true);
            error_log('Can not create push for user '.print_r($error,1));
            if($tries == 3){
                return false;
            }else{
                //try retry 3 times
                $tries=$tries+1;
                $this->request_push($tries);
            }
        }
        return $this;
    }
    public function payOffCoupon(  $tries=2){
        //first get balance push
//        $minterHelper = new FunFasy_helper();
//        $tickerCostBip = $minterHelper->getTickerPriceBip($this->$this->ticker);
        $options = get_option($this->plugin_name);
        $newPush=[];
        $balance = $this->getlinkBalance();
        if(!empty($balance)){
//            error_log(print_r($balance->balance->value,1));

//            $cost_bip = $this->$this->cost*$tickerCostBip-1.7; //minus commision
//            error_log('try this '.$cost_bip/$tickerCostBip);

            $value_to_get = $balance->balance->value;
            error_log(print_r($value_to_get,1));
            error_log('getCost'.print_r($this->cost,1));


            $newPush = [
                "option"=> "transfer-minter" ,
                "params"=> [
                    "amount"=>$value_to_get,
                    "to"=>$options['minter_wallet_address']
                ]

            ];
        }
        if(!empty($this->password)){
            $newPush['password']=$this->password;
        }
        try {
            $responseNewPush = $this->getClient()->post('https://push.money/api/spend/'.$this->link_id,[
                GuzzleHttp\RequestOptions::JSON => $newPush // or 'json' => [...]
            ]);
            if($responseNewPush->getStatusCode() ==200) {
                $pushObj = json_decode($responseNewPush->getBody());
                //sucssess spend
                    $this->setCouponSpend(true);
                    $this->save();
                return true;
            }else{
                return false;
            }

        }catch (RequestException $exception) {

            $content = $exception->getResponse()
                ->getBody()
                ->getContents();

            $error = json_decode($content, true);
            error_log('Can not pay off coupon '.print_r($content,1));
            if($tries == 2){
                return false;
            }else{
                //try retry 3 times
                $tries=$tries+1;
                $this->payOffCoupon($tries);
            }
        }
    }


    public function getSettingsInfo($tries=0){
        ///api/custom/get-setting/{setting_id}
        try {
            $responseNewPush = $this->getClient()->get('https://push.money/api/custom/get-setting/'.$this->customization_setting_id);
            if($responseNewPush->getStatusCode() ==200) {
                $pushObj = json_decode($responseNewPush->getBody());
                return $pushObj;
            }else{
                return false;
            }

        }catch (RequestException $exception) {

            $content = $exception->getResponse()
                ->getBody()
                ->getContents();

            $error = json_decode($content, true);
            error_log('Can not get settings info '.print_r($error,1));
            if($tries == 3){
                return false;
            }else{
                //try retry 3 times
                $tries=$tries+1;
                $this->getSettingsInfo($tries);
            }
        }

    }

    public function getlinkInfo($tries=0){
            ///api/push/{link_id}/info
        try {
            $responseNewPush = $this->getClient()->get('https://push.money/api/push/'.$this->link_id.'/info');
            if($responseNewPush->getStatusCode() ==200) {
                $pushObj = json_decode($responseNewPush->getBody());
                return $pushObj;
            }else{
                return false;
            }

        }catch (RequestException $exception) {

            $content = $exception->getResponse()
                ->getBody()
                ->getContents();

            $error = json_decode($content, true);
            error_log('Can not get link info '.print_r($error,1));
            if($tries == 3){
                return false;
            }else{
                //try retry 3 times
                $tries=$tries+1;
                $this->getlinkInfo($tries);
            }
        }
    }

    public function getlinkBalance($tries=0){
            ///api/push/{link_id}/info
        try {$newPush = [];
            if($this->password){
                $newPush =['password'=>$this->password];
            }
            $responseNewPush = $this->getClient()->post('https://push.money/api/push/'.$this->link_id.'/balance',[
                GuzzleHttp\RequestOptions::JSON => $newPush // or 'json' => [...]
            ]);
            if($responseNewPush->getStatusCode() ==200) {
                $pushObj = json_decode($responseNewPush->getBody());
                return $pushObj;
            }else{
                return false;
            }

        }catch (RequestException $exception) {

            $content = $exception->getResponse()
                ->getBody()
                ->getContents();

            $error = json_decode($content, true);
            error_log('Can not get link info '.print_r($error,1));
            if($tries == 3){
                return false;
            }else{
                //try retry 3 times
                $tries=$tries+1;
                $this->getlinkInfo($tries);
            }
        }
    }
    public function createCustomization($customizationArr,$tries=0){
        try {
            $responseNewPush = $this->getClient()->post('https://push.money/api/custom/create-setting',[
                GuzzleHttp\RequestOptions::JSON => $customizationArr // or 'json' => [...]
            ]);

            if($responseNewPush->getStatusCode() ==200) {
                $pushObj = json_decode($responseNewPush->getBody());
                return $pushObj->id;
            }else{
                error_log('Can not create Customization '.print_r($responseNewPush->getStatusCode(),1));

                return false;
            }

        }catch (RequestException $exception) {

            $content = $exception->getResponse()
                ->getBody()
                ->getContents();

            $error = json_decode($content, true);
            error_log('Can not create Customization '.print_r($error,1));
            if($tries == 3){
                return false;
            }else{
                //try retry 3 times
                $tries=$tries+1;
                $this->createCustomization($tries);
            }
        }

    }
    public function sendEmail($emailType=''){
        switch ($emailType) {
            case 'register':
                if(!empty($this->user_id) && !empty($this->link_id)){
                if($this->send_e_mail_register_to_user()){
                    $this->setEmailSend(true);
                    $this->save();
                }
            }
                break;
            default:
                return $this;
                break;
        }
    }
    public function wps_set_content_type(){
        return "text/html";
    }
    public function send_e_mail_register_to_user(){

        $options = get_option($this->plugin_name);

        $search = [];
        $replace = [];
        if (empty($this->recipient)) {
            $user_info = get_userdata($this->user_id);
            $recipient = $user_info->user_email;
        } else {
            $recipient = $this->recipient;
        }

        add_filter( 'wp_mail_content_type',[$this,'wps_set_content_type'] );

        $headers = "From: " . $options['register_email_from'] . "\r\n";
        //message param

        $subject = __('Coupon with true money!', $this->plugin_name);

        $htmlMessage = $options['register_email_template'];
        //Search and replace
        $password_message = '';
        if($this->isHaveCoupon()){
            $coupon_message =$options['register_email_coupon_message'];
        }else{
            $coupon_message ='';
            $password_message =($this->password)? $options['register_email_password_message']:'';
        }

        $search[] = '#COUPON_MESSAGE#';
        $replace['#COUPON_MESSAGE#'] =  $coupon_message ;

        $search[] = '#PASSWORD_MESSAGE#';
        $replace['#PASSWORD_MESSAGE#'] = $password_message;

        $search[] = '#PUSH_URL#';
        $replace['#PUSH_URL#'] = 'https://yyy.cash/push/' . $this->link_id . '/';

        $search[] = '#PUSH_LINK_ID#';
        $replace['#PUSH_LINK_ID#'] = $this->link_id;

        $search[] = '#PUSH_PASSWORD#';
        $replace['#PUSH_PASSWORD#'] = $this->password;

        $search[] = '#SITE_NAME#';
        $replace['#SITE_NAME#'] = get_bloginfo();

        $htmlMessage = str_replace($search, $replace, $htmlMessage);

        //send to user
        $status = wp_mail($recipient, $subject, $htmlMessage, $headers);
        return $status;
    }




    public function generate_coupon_for_push(){
        //create coupon for variation product
        /**
         * Create a coupon programatically
         */
        $minter_helper = new FunFasy_helper();
        $coupon_code = $this->link_id; // Code
        //get commission
        $commission = $minter_helper->getCommission($this);

        //converted from bip to local currency
        if($this->ticker=='BIP'){
            $amount = $this->cost-$commission*$this->bip_price; // Amount fixed in local currency
        }else{
            $amount = $this->cost-$commission*$this->bip_price*$minter_helper->getTickerPriceBip($this->ticker);
         // Amount fixed in local currency
        }
        error_log('getCost'.$this->cost);
        error_log('generate_coupon_for_push getBipPrice'.$this->bip_price);
        error_log('generate_coupon_for_push $minter_helper->getTickerPriceBip($this->$this->ticker'.$minter_helper->getTickerPriceBip($this->ticker));
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

    public function testEmail(){
        $this->send_e_mail_register_to_user();
    }
    /*
     * Getters AND Setters section
     *
     * */



    /**
     * @return /GuzzleHttp/Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param mixed /GuzzleHttp/Client
     * @return YYY_push $this
     */
    public function setClient(\GuzzleHttp\Client $client )
    {
        $this->client = $client;
        return $this;
    }



    /**
     * @return mixed
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * @param mixed $cost
     * @return YYY_push $this
     */
    public function setCost($cost)
    {
        $this->cost = $cost;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     * @return YYY_push $this
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
        return $this;
    }

    /**
     * @return string
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * @param string|void $sender
     * @return YYY_push $this
     */
    public function setSender($sender)
    {
        $this->sender = $sender;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     * @return YYY_push $this
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;

    }

    /**
     * @return mixed
     */
    public function getCustomizationSettingId()
    {
        return $this->customization_setting_id;
    }

    /**
     * @param mixed $customization_setting_id
     * @return YYY_push $this
     */
    public function setCustomizationSettingId($customization_setting_id)
    {
        $this->customization_setting_id = $customization_setting_id;
        return $this;

    }

    /**
     * @return mixed
     */
    public function getLinkId()
    {
        return $this->link_id;
    }

    /**
     * @param mixed $link_id
     * @return YYY_push $this
     */
    public function setLinkId($link_id)
    {
        $this->link_id = $link_id;
        return $this;

    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     * @return YYY_push $this
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;

    }

    /**
     * @return mixed
     */
    public function getDeepLink()
    {
        return $this->deep_link;
    }

    /**
     * @param mixed $deep_link
     * @return YYY_push $this
     */
    public function setDeepLink($deep_link)
    {
        $this->deep_link = $deep_link;
        return $this;

    }

    /**
     * @return mixed
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @param mixed $hash
     * @return YYY_push $this
     */
    public function setHash($hash)
    {
        $this->hash = $hash;
        return $this;

    }


    /**
     * @return int
     */
    public function getPostId(): int
    {
        if($this->post_id == null){
            $this->post_id=0;
        }
        return $this->post_id;
    }

    /**
     * @param int $post_id
     * @return YYY_push $this
     */
    public function setPostId(int $post_id)
    {
        $this->post_id = $post_id;
        return $this;

    }

    /**
     * @return mixed
     */
    public function getTitleAdmin()
    {
        return $this->title_admin;
    }

    /**
     * @param mixed $title_admin
     * @return YYY_push $this
     */
    public function setTitleAdmin($title_admin)
    {
        $this->title_admin = $title_admin;
        return $this;

    }

    /**
     * @return mixed
     */
    public function getRecipient()
    {
        return $this->recipient;
    }

    /**
     * @param mixed $recipient
     * @return YYY_push $this
     */
    public function setRecipient($recipient)
    {
        $this->recipient = $recipient;
        return $this;

    }

    /**
     * @return string
     */
    public function getNodeAddress(): string
    {
        return $this->node_address;
    }

    /**
     * @return bool
     */
    public function isHaveCoupon(): bool
    {
        return $this->have_coupon;
    }

    /**
     * @param bool $have_coupon
     * @return YYY_push $this
     */
    public function setHaveCoupon(bool $have_coupon)
    {
        $this->have_coupon = $have_coupon;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBipPrice()
    {
        return $this->bip_price;
    }

    /**
     * @param mixed $bip_price
     * @return YYY_push $this
     */
    public function setBipPrice($bip_price)
    {
        $this->bip_price = $bip_price;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTicker()
    {
        return $this->ticker;
    }

    /**
     * @param mixed $ticker
     * @return YYY_push $this
     */
    public function setTicker($ticker)
    {
        $this->ticker = $ticker;
        return $this;
    }


    /**
     * @return bool
     */
    public function isEmailSend(): bool
    {
        return $this->email_send;
    }
    /**
     * @param mixed $email_send
     * @return YYY_push $this

     */
    public function setEmailSend($email_send)
    {
        $this->email_send = $email_send;
        return $this;
    }

    /**
     * @return bool
     */
    public function isCouponSpend(): bool
    {
        return $this->coupon_spend;
    }

    /**
     * @param bool $coupon_spend
     */
    public function setCouponSpend(bool $coupon_spend)
    {
        $this->coupon_spend = $coupon_spend;
    }



//STATIC METHODS


     /**
     * @return string
     */
    public static function getCostKey(): string
    {

        return self::$cost_key;
    }


    /**
     * @return string
     */
    public static function getUserIdKey(): string
    {
        return self::$user_id_key;
    }

    /**
     * @return string
     */
    public static function getSenderKey(): string
    {
        return self::$sender_key;
    }

    /**
     * @return string
     */
    public static function getPasswordKey(): string
    {
        return self::$password_key;
    }

    /**
     * @return string
     */
    public static function getCustomizationSettingIdKey(): string
    {
        return self::$customization_setting_id_key;
    }

    /**
     * @return string
     */
    public static function getLinkIdKey(): string
    {
        return self::$link_id_key;
    }

    /**
     * @return string
     */
    public static function getAddressKey(): string
    {
        return self::$address_key;
    }

    /**
     * @return string
     */
    public static function getDeepLinkKey(): string
    {
        return self::$deep_link_key;
    }

    /**
     * @return string
     */
    public static function getHashKey(): string
    {
        return self::$hash_key;
    }

    /**
     * @return string
     */
    public static function getHaveCouponKey(): string
    {
        return self::$have_coupon_key;
    }

    /**
     * @return string
     */
    public static function getRecipientKey(): string
    {
        return self::$recipient_key;
    }

    /**
     * @return string
     */
    public static function getBipPriceKey(): string
    {
        return self::$bip_price_key;
    }


    /**
     * @return string
     */
    public static function getTickerKey(): string
    {
        return self::$ticker_key;
    }

    /**
     * @return string
     */
    public static function getEmailSendKey(): string
    {
        return self::$email_send_key;
    }

    /**
     * @return string
     */
    public static function getCouponSpendKey(): string
    {
        return self::$coupon_spend_key;
    }


    //STATIC ENDS



}