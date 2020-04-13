<?php

/**
 * Fired during plugin activation
 *
 * @link       https://mntshop.ru
 * @since      1.0.0
 *
 * @package    Minter_Yyy_Cashback
 * @subpackage Minter_Yyy_Cashback/includes
 */
use Minter\SDK\MinterWallet;

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Minter_Yyy_Cashback
 * @subpackage Minter_Yyy_Cashback/includes
 * @author     Geman Vereschak <general@mntshop.ru>
 */
class Minter_Yyy_Cashback_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

	    //first generate wallet for site and add some values
        $options = get_option('minter-yyy-cashback');
        if(!isset($options['ticker'])){$options['ticker'] = 'BIP';}
        if(!isset($options['minter_wallet_mnemonic'])){
            $minter_wallet = MinterWallet::create();
            $options['minter_wallet_seed'] = $minter_wallet['seed'];
            $options['minter_wallet_mnemonic']=$minter_wallet['mnemonic'];
            $options['minter_wallet_address']=$minter_wallet['address'];
            $options['minter_wallet_public_key']=$minter_wallet['public_key'];
            $options['minter_wallet_private_key']=$minter_wallet['private_key'];
        }
        if(!isset($options['register_cost'])){$options['register_cost'] = 10;}
        if(!isset($options['bip_price'])){$options['bip_price'] = 1.1;}
        //default customization
        if(!isset($options['register_animation_name'])){$options['register_animation_name'] = 2;}
        if(!isset($options['register_animation_text'])){$options['register_animation_text'] = get_bloginfo().__(' дарит бонусы за регистрацию!','minter-yyy-cashback');}
        if(!isset($options['register_background_name'])){$options['register_background_name'] = 'black';}
        if(!isset($options['register_head_text'])){$options['register_head_text'] = get_bloginfo();}
        if(!isset($options['register_customization_id'])){
            $YYY_push = new YYY_push();
            $options['register_customization_id'] = $YYY_push->createCustomization([
                'animation_name'=>$options['register_animation_name'],
                'animation_text'=>$options['register_animation_text'],
                'background_name'=>$options['register_background_name'],
                'head_text'=>$options['register_head_text'],
            ]);
        }
        if(!isset($options['register_email_template'])){
            $search[] = '#TITLE#';
            $replace['#TITLE#'] = __('We have a present for you! Check this out and spend it!', 'minter-yyy-cashback');
            $options['register_email_template'] =  str_replace($search, $replace, file_get_contents(plugin_dir_path(__FILE__) . '../public/partials/e-mail-register-template.html'));
        }
        if(!isset($options['register_email_subject'])){$options['register_email_subject'] = __('Coupon with true money!', 'minter-yyy-cashback');}
        if(!isset($options['register_email_from'])){$options['register_email_from'] =get_option('admin_email');}
        if(!isset($options['register_email_coupon_message'])){$options['register_email_coupon_message'] = __('Or you can fill on checkout and get discount! <b> coupon code: #PUSH_LINK_ID# </b>', 'minter-yyy-cashback');}
        if(!isset($options['register_email_password_message'])){$options['register_email_password_message'] = __('To open fill  <b> password: #PUSH_PASSWORD# </b> ', 'minter-yyy-cashback');}




        update_option('minter-yyy-cashback',$options);

    }

}
