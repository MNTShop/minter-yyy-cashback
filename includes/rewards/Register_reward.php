<?php
/**
 * Created by PhpStorm.
 * User: devacc
 * Date: 06.05.2020
 * Time: 18:15
 */

class Register_reward extends Reward
{

    //Create new push reward based on option

    /**
     * Register_reward constructor. create push and set up that
     * @param $user WP_User
     * @throws MYC_Exception
     */
    public function __construct($user)
    {
        parent::__construct($user);
        $this->cost = $this->plugin_options['register_cost'];
        $this->use_password = $this->plugin_options['register_use_password'];
        $this->title = 'Reward for register '.$this->user->user_email;
        //setup email settings
        $this->email_subject = $this->plugin_options['register_email_subject'];
        $this->email_template = $this->plugin_options['register_email_template'];
        $this->email_coupon_message = $this->plugin_options['register_email_coupon_message'];
        $this->email_password_message = $this->plugin_options['register_email_password_message'];
        $this->email_from = $this->plugin_options['register_email_from'];
        //setup YYY push
        $this->YYY_push
            ->setRecipient($this->user->user_email)
            ->setSender($this->plugin_options['register_email_from'])
            ->setCost($this->cost)
            ->setTicker($this->coin)
            ->setBipPrice($this->bip_price)
            ->setTitlePost($this->title );
        if($this->use_password){
            $this->YYY_push->setPassword(bin2hex(random_bytes(3)));
        }
        if($this->plugin_options['register_customization_id']){
        $this->YYY_push->setCustomizationSettingId( $this->plugin_options['register_customization_id']);
        }

        $this->YYY_push->save();

        if( $this->YYY_push->request_push()){
            $minter_helper = new FunFasy_helper();
            if($minter_helper->pay_off_push($this->YYY_push)!==false){
                if($this->use_coupon){
                    $this->YYY_push->generate_coupon_for_push();
                }
            }else{
                throw new MYC_Exception('can not add balance to YYY push '.$this->title);
            }
        }else{
            throw new MYC_Exception('can not request push from YYY.cash ');

        }

    }

    /**
     *Save reward to database
     */
    protected function save(){
        if(empty($this->post_id)) {
            $new_post_id = wp_insert_post(
                ['post_title' => $this->title,
                    'post_type' => $this->post_type]
            );
            if ($new_post_id) {
                $this->post_id = $new_post_id;
            }
        }
        else{
            update_post_meta($this->post_id, self::$cost_key, $this->cost);
            update_post_meta($this->post_id, self::$user_id_key, $this->user_id);
            update_post_meta($this->post_id, self::$recipient_key, $this->recipient);
            update_post_meta($this->post_id, self::$sender_key, $this->sender);
            update_post_meta($this->post_id, self::$deep_link_key, $this->deep_link);
            update_post_meta($this->post_id, self::$password_key, $this->password);
            update_post_meta($this->post_id, self::$customization_setting_id_key, $this->customization_setting_id);
            update_post_meta($this->post_id, self::$link_id_key, $this->link_id);
            update_post_meta($this->post_id, self::$address_key, $this->address);
            update_post_meta($this->post_id, self::$have_coupon_key, $this->isHaveCoupon());
            update_post_meta($this->post_id, self::$ticker_key, $this->coin);
            update_post_meta($this->post_id, self::$bip_price_key, $this->bip_price);
            update_post_meta($this->post_id, self::$email_sent_key, $this->isEmailSent());
            update_post_meta($this->post_id, self::$coupon_spent_key, $this->isCouponSpend());
            update_post_meta($this->post_id, self::$commission_key, $this->commission);

        }
    }
    /**
     * Set content type for Email WP filter
     * @return string
     */
    public function wps_set_content_type(){
        return "text/html";
    }
    /**
     * send reward Email to user
     * @param int $tries
     * @return bool
     * @throws MYC_Exception
     */
    public function send($tries=1)
    {
        if(!empty($this->user) && !empty($this->YYY_push->link_id)){
            //send Email
            add_filter( 'wp_mail_content_type',[$this,'wps_set_content_type'] );
            $search = [];
            $replace = [];
            $recipient = $this->user->user_email;
            $password_message = '';
            $coupon_message ='';
            if($this->use_coupon){
                $coupon_message =$this->email_coupon_message;
            }
            if($this->use_password) {
                $password_message = $this->email_password_message;
            }
            //Search and replace
            $search[] = '#COUPON_MESSAGE#';
            $replace['#COUPON_MESSAGE#'] =  $coupon_message ;

            $search[] = '#PASSWORD_MESSAGE#';
            $replace['#PASSWORD_MESSAGE#'] = $password_message;

            $search[] = '#PUSH_URL#';
            $replace['#PUSH_URL#'] = 'https://yyy.cash/push/' . $this->YYY_push->link_id . '/';

            $search[] = '#PUSH_LINK_ID#';
            $replace['#PUSH_LINK_ID#'] = $this->YYY_push->link_id;

            $search[] = '#PUSH_PASSWORD#';
            $replace['#PUSH_PASSWORD#'] = $this->YYY_push->password;

            $search[] = '#SITE_NAME#';
            $replace['#SITE_NAME#'] = get_bloginfo();

            $htmlMessage = str_replace($search, $replace, $this->email_template);

            $headers = "";
            $headers .= "From: ".$this->email_from." <".$this->email_from."> \r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

            //send to user
            $status = wp_mail($recipient, $this->email_subject, $htmlMessage, $headers);

            if($status){
                $this->email_sent = true;
                $this->save();
                return true;
            }else{
                //repeat maybe something wrong with SMTP server
                if($tries!==2){
                    $tries = $tries+1;
                    $this->send($tries);
                }else{
                    throw new MYC_Exception('Email with Minter Reward are Not sent '.$this->title);
                }
            }
        }
        throw new MYC_Exception('Email with Minter Reward are Not sent missing user or push link id');
    }



}