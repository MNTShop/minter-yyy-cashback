<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://mntshop.ru
 * @since      1.0.0
 *
 * @package    Minter_Yyy_Cashback
 * @subpackage Minter_Yyy_Cashback/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://mntshop.ru
 * @since      1.0.0
 *
 * @package    Minter_Woocomerce_Coupon
 * @subpackage Minter_Woocomerce_Coupon/admin/partials
 */

$options = get_option($this->plugin_name);
$minter_helper = new FunFasy_helper();
$balanceBipConverted=$minter_helper->getBalanceTicker(0,$options['ticker']);


?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->




<!-- lets recreate butifull ui-->

<div class="wrap" id="myc-settings-page">
    <div class="settings-banner">


        <h1><?php echo esc_html( get_admin_page_title() ); ?> </h1> <a href="https://github.com/MNTShop/minter-yyy-cashback"><?php echo 'MNTSHOP PLUGINS';?></a>



    </div>
    <ul class="settings-nav">
        <li><a href="#welcome" id="tab-welcome"><?php esc_html_e( 'Welcome',$this->plugin_name) ?></a></li>
        <li><a href="#funfasy_section" id="tab-funfasy"><?php echo __('FunFasy',$this->plugin_name ) ?></a></li>
        <?php
        /** * Check if WooCommerce is active **/
        if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) :?>
        <li><a href="#woocommerce_section" id="tab-woocommerce"><?php echo __('Woocommerce',$this->plugin_name ) ?></a></li>
        <?php endif;?>
        <li><a href="#wallet_section" id="tab-wallet"><?php echo __('Minter Wallet',$this->plugin_name ) ?></a></li>
        <li><a href="#reward_section" id="tab-reward"><?php echo __('Rewards',$this->plugin_name ) ?></a></li>
    </ul>



    <form method="post" name="myc_options" action="options.php">
        <?php

        settings_fields( $this->plugin_name );
        do_settings_sections( $this->plugin_name );


        ?>
        <div id="myc-settings-sections">

            <div id="myc-settings-section-reward_section" class="myc-settings-section" data-section="reward_section">
                <h1><?php echo __('Register on site',$this->plugin_name); ?></h1>

                <table class="form-table">
                    <tbody>
                    <tr class="myc-setting">
                        <th scope="row"><label for="<?php echo $this->plugin_name;?>-register_switch"
                            ><?php  _e('Active reward?', $this->plugin_name)?></label></th>
                        <td>
                            <label class="widefat">
                                <input id="<?php echo $this->plugin_name;?>-register_switch"
                                       name="<?php echo $this->plugin_name;?>[register_switch]"
                                       type="checkbox"
                                    <?php checked( ! empty( $options['register_switch'] ) ) ?> />
                                    <?php  echo  __( 'Enabled',$this->plugin_name ); ?>
                            </label>
                        </td>
                    </tr>
                    <tr class="myc-setting">
                        <th scope="row"><label for="<?php echo $this->plugin_name;?>-register_use_password"
                            ><?php  _e('Use password in push?', $this->plugin_name)?></label></th>
                        <td>
                            <label class="widefat">
                                <input id="<?php echo $this->plugin_name;?>-register_use_password"
                                       name="<?php echo $this->plugin_name;?>[register_use_password]"
                                       type="checkbox"
                                    <?php checked( ! empty( $options['register_use_password'] ) ) ?>
                                />
                                <?php  echo  __( 'Enabled',$this->plugin_name ); ?>
                            </label>
                            <small class="description">
                                <?php  _e('Impossible if active WooCommerce generate coupons',$this->plugin_name); ?>
                            </small>
                        </td>
                    </tr>
                    <tr class="myc-setting">
                        <th scope="row"><label for="<?php echo $this->plugin_name;?>-register_cost"
                            ><?php  _e('How many coins do you want to reward?', $this->plugin_name)?></label></th>
                        <td>
                            <input id="<?php echo $this->plugin_name;?>-register_cost"
                                   name="<?php echo $this->plugin_name;?>[register_cost]"
                                   class="myc-setting-text" type="text"
                                   value="<?php if(!empty($options['register_cost'])) esc_attr_e($options['register_cost']);?>" />
                            <small class="description">
                                <?php  _e('In Minter Wallet section you can add custom ticker',$this->plugin_name); ?>
                            </small>
                        </td>
                    </tr>
                    <tr class="myc-setting">
                        <th scope="row"><label
                            ><?php  _e('Customization push settings', $this->plugin_name)?></label></th>
                        <td>
                            <label for="<?php echo $this->plugin_name;?>-register_customization_id">
                                <span><?php esc_attr_e('Customization id', $this->plugin_name);?></span>
                            </label>
                            <input id="<?php echo $this->plugin_name;?>-register_customization_id"
                                   name="<?php echo $this->plugin_name;?>[register_customization_id]"
                                   class="myc-setting-text" type="text"
                                   value="<?php if(!empty($options['register_customization_id'])) esc_attr_e($options['register_customization_id']);?>" />
                            <label for="<?php echo $this->plugin_name;?>-register_animation_name">
                                <span><?php esc_attr_e('Animation type', $this->plugin_name);?></span>
                            </label>
                            <select name="<?php echo $this->plugin_name;?>[register_animation_name]">
                                    <option
                                            value="0" <?php selected( 0, $options['register_animation_name'] ) ?>><?php _e('Without animation',$this->plugin_name);?></option>
                                    <option
                                        value="1" <?php selected( 1, $options['register_animation_name'] ) ?>><?php _e('Papper plane',$this->plugin_name);?></option>
                                    <option
                                        value="2" <?php selected( 2, $options['register_animation_name'] ) ?>><?php _e('Gift sending',$this->plugin_name);?></option>
                                    <option
                                        value="3" <?php selected( 3, $options['register_animation_name'] ) ?>><?php _e('Milos time',$this->plugin_name);?></option>
                            </select>
                            <label for="<?php echo $this->plugin_name;?>-register_head_text">
                                <span><?php esc_attr_e('Head text push', $this->plugin_name);?></span>
                            </label>
                            <input id="<?php echo $this->plugin_name;?>-register_head_text"
                                   name="<?php echo $this->plugin_name;?>[register_head_text]"
                                   class="myc-setting-text" type="text"
                                   value="<?php if(!empty($options['register_head_text'])) esc_attr_e($options['register_head_text']);?>" />
                            <label for="<?php echo $this->plugin_name;?>-register_animation_text">
                                <span><?php esc_attr_e('Animation text', $this->plugin_name);?></span>
                            </label>
                            <input id="<?php echo $this->plugin_name;?>-register_animation_text"
                                   name="<?php echo $this->plugin_name;?>[register_animation_text]"
                                   class="myc-setting-text" type="text"
                                   value="<?php if(!empty($options['register_animation_text'])) esc_attr_e($options['register_animation_text']);?>" />

                            <label for="<?php echo $this->plugin_name;?>-register_background_name">
                                <span><?php esc_attr_e('Background', $this->plugin_name);?></span>
                            </label>
                            <select name="<?php echo $this->plugin_name;?>[register_background_name]">
                                <option value="" <?php selected( '', $options['register_background_name'] ) ?>><?php _e('Standard',$this->plugin_name);?></option>
                                <option value="black" <?php selected( 'black', $options['register_background_name'] ) ?>><?php _e('Black',$this->plugin_name);?></option>
                                <option value="purple" <?php selected( 'purple', $options['register_background_name'] ) ?>><?php _e('Purple',$this->plugin_name);?></option>
                                <option value="beige" <?php selected( 'beige', $options['register_background_name'] ) ?>><?php _e('Beige',$this->plugin_name);?></option>
                                <option value="pink" <?php selected( 'pink', $options['register_background_name'] ) ?>><?php _e('Pink',$this->plugin_name);?></option>
                                <option value="blue" <?php selected( 'blue', $options['register_background_name'] ) ?>><?php _e('Blue',$this->plugin_name);?></option>
                                <option value="green" <?php selected( 'green', $options['register_background_name'] ) ?>><?php _e('Green',$this->plugin_name);?></option>
                            </select>
                        </td>
                    </tr>
                    <tr class="myc-setting">
                        <th scope="row"><label
                            ><?php  _e('E-mail notification', $this->plugin_name)?></label></th>
                        <td>


                            <label for="<?php echo $this->plugin_name;?>-register_email_from">
                                <span><?php esc_attr_e('E-mail from', $this->plugin_name);?></span>
                            </label>
                            <input id="<?php echo $this->plugin_name;?>-register_email_from"
                                   name="<?php echo $this->plugin_name;?>[register_email_from]"
                                   class="myc-setting-text" type="text"
                                   value="<?php if(!empty($options['register_email_from'])) esc_attr_e($options['register_email_from']);?>" />

                            <label for="<?php echo $this->plugin_name;?>-register_email_subject">
                                <span><?php esc_attr_e('E-mail subject', $this->plugin_name);?></span>
                            </label>
                            <input id="<?php echo $this->plugin_name;?>-register_email_subject"
                                   name="<?php echo $this->plugin_name;?>[register_email_subject]"
                                   class="myc-setting-text" type="text"
                                   value="<?php if(!empty($options['register_email_subject'])) esc_attr_e($options['register_email_subject']);?>" />


                            <label for="<?php echo $this->plugin_name;?>-register_email_password_message">
                                <span><?php esc_attr_e('HTML E-mail #PASSWORD_MESSAGE#', $this->plugin_name);?></span>
                            </label>
                            <textarea id="<?php echo $this->plugin_name;?>-register_email_password_message"
                                   name="<?php echo $this->plugin_name;?>[register_email_password_message]"
                                   class="myc-setting-textarea widefat"
                                   rows="2">
                                <?php if(!empty($options['register_email_password_message'])) esc_attr_e($options['register_email_password_message']);?>
                                </textarea>

                            <label for="<?php echo $this->plugin_name;?>-register_email_coupon_message">
                                <span><?php esc_attr_e('HTML E-mail #COUPON_MESSAGE#', $this->plugin_name);?></span>
                            </label>
                            <textarea id="<?php echo $this->plugin_name;?>-register_email_coupon_message"
                                   name="<?php echo $this->plugin_name;?>[register_email_coupon_message]"
                                   class="myc-setting-textarea widefat"
                                   rows="2">
                                <?php if(!empty($options['register_email_coupon_message'])) esc_attr_e($options['register_email_coupon_message']);?>
                                </textarea>
                            <label for="<?php echo $this->plugin_name;?>-register_email_template">
                                <span><?php esc_attr_e('HTML E-mail template', $this->plugin_name);?></span>
                            </label>
                    <textarea name="<?php echo $this->plugin_name;?>[register_email_template]"
                              class="myc-setting-textarea widefat"
                              rows="20"><?php echo esc_textarea(  $options['register_email_template']  ) ?></textarea>
                            <small class="description">
                                <?php  _e('You can use template vars:<br>
                                #COUPON_MESSAGE# - If you check generate coupon, in woocommerce settings, you can tell it to your customers in custom message<br>
                                #PASSWORD_MESSAGE# - If you check generate push password , you can tell also it to your customers in custom message<br>
                                #PUSH_URL# - Generated push url<br>
                                #PUSH_LINK_ID# - Generated Link ID push also coupon code for woocommerce<br>
                                #PUSH_PASSWORD# - Generated push password<br>
                                #SITE_NAME# - returned from get_bloginfo() (Your default site name)
                                ',$this->plugin_name); ?>
                            </small>
                        </td>
                    </tr>

                    </tbody>
                </table>
            </div>

            <div id="myc-settings-section-wallet_section" class="myc-settings-section" data-section="wallet_section">
                <table class="form-table">
                    <tbody>

                    <tr class="myc-setting">
                        <th scope="row"><label for="<?php echo $this->plugin_name;?>-ticker"
                            ><?php  _e('Wallet ticker', $this->plugin_name)?></label></th>
                        <td>
                            <input id="<?php echo $this->plugin_name;?>-ticker"
                                   name="<?php echo $this->plugin_name;?>[ticker]"
                                   class="myc-setting-text" type="text"
                                   value="<?php if(!empty($options['ticker'])) esc_attr_e($options['ticker']);?>" />
                            <small class="description">
                                <?php  _e('Which coin use for pushes? example BIP',$this->plugin_name); ?>
                            </small>
                        </td>
                    </tr>
                    <tr class="myc-setting">
                        <th scope="row"><label for="<?php echo $this->plugin_name;?>-minter_wallet_address"
                            ><?php  _e('Addres which send Push for clients', $this->plugin_name)?></label></th>
                        <td>
                            <input id="<?php echo $this->plugin_name;?>-minter_wallet_address"
                                   name="<?php echo $this->plugin_name;?>[minter_wallet_address]"
                                   class="myc-setting-text" type="text"
                                   value="<?php if(!empty($options['minter_wallet_address'])) esc_attr_e($options['minter_wallet_address']);?>" />

                        </td>
                    </tr>
                    <tr class="myc-setting">
                        <th scope="row"><label for="<?php echo $this->plugin_name;?>-minter_wallet_mnemonic"
                            ><?php _e('Minter wallet mnemonic', $this->plugin_name);?></label></th>
                        <td>
                            <input id="<?php echo $this->plugin_name;?>-minter_wallet_mnemonic"
                                   name="<?php echo $this->plugin_name;?>[minter_wallet_mnemonic]"
                                   class="myc-setting-text" type="text"
                                   value="<?php if(!empty($options['minter_wallet_mnemonic'])) esc_attr_e($options['minter_wallet_mnemonic']);?>" />
                        </td>
                    </tr>
                    <tr class="myc-setting">
                        <th scope="row"><label for="<?php echo $this->plugin_name;?>-minter_wallet_public_key"
                            ><?php _e('Minter wallet public key', $this->plugin_name);?></label></th>
                        <td>
                            <input id="<?php echo $this->plugin_name;?>-minter_wallet_public_key"
                                   name="<?php echo $this->plugin_name;?>[minter_wallet_public_key]"
                                   class="myc-setting-text" type="text"
                                   value="<?php if(!empty($options['minter_wallet_public_key'])) esc_attr_e($options['minter_wallet_public_key']);?>" />
                        </td>
                    </tr>
                    <tr class="myc-setting">
                        <th scope="row"><label for="<?php echo $this->plugin_name;?>-minter_wallet_private_key"
                            ><?php _e('Minter wallet private key', $this->plugin_name);?></label></th>
                        <td>
                            <input id="<?php echo $this->plugin_name;?>-minter_wallet_private_key"
                                   name="<?php echo $this->plugin_name;?>[minter_wallet_private_key]"
                                   class="myc-setting-text" type="text"
                                   value="<?php if(!empty($options['minter_wallet_private_key'])) esc_attr_e($options['minter_wallet_private_key']);?>" />
                        </td>
                    </tr>
                    <tr class="myc-setting">
                        <th scope="row"><label for="<?php echo $this->plugin_name;?>-minter_wallet_seed"
                            ><?php _e('Minter Wallet seed', $this->plugin_name);?></label></th>
                        <td>
                            <input id="<?php echo $this->plugin_name;?>-minter_wallet_seed"
                                   name="<?php echo $this->plugin_name;?>[minter_wallet_seed]"
                                   class="myc-setting-text" type="text"
                                   value="<?php if(!empty($options['minter_wallet_seed'])) esc_attr_e($options['minter_wallet_seed']);?>" />
                        </td>
                    </tr>
                    <tr> <h3>Balance : <?php echo $balanceBipConverted ;?> </h3>
                        <h3> QR address: <img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=<?php echo $minter_helper->getMinterWalletAddress(); ?>"  title="Address BIP Wallet" />
                        </h3>
                    </tr>
                    </tbody>
                </table>
            </div>

            <?php
            /** * Check if WooCommerce is active **/
            if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
                ?>
            <div id="myc-settings-section-woocommerce_section" class="myc-settings-section" data-section="woocommerce_section">
                <table class="form-table">
                    <tbody>
                        <tr class="myc-setting">
                            <th scope="row"><label for="<?php echo $this->plugin_name;?>-woocommerce_generate_coupons"
                                ><?php  _e('Use Coupons?', $this->plugin_name)?></label></th>
                            <td>
                                <label class="widefat">
                                    <input id="<?php echo $this->plugin_name;?>-woocommerce_generate_coupons"
                                           name="<?php echo $this->plugin_name;?>[woocommerce_generate_coupons]"
                                           type="checkbox" <?php checked( ! empty( $options['woocommerce_generate_coupons'] ) ) ?> />
                                    <?php echo  __( 'Enabled',$this->plugin_name ) ?>
                                </label>
                            </td>
                        </tr>
                        <tr class="myc-setting">
                            <th scope="row"><label for="<?php echo $this->plugin_name;?>-bip_price"
                                ><?php  _e('Bip cost', $this->plugin_name)?></label></th>
                            <td>
                                <input id="<?php echo $this->plugin_name;?>-bip_price"
                                       name="<?php echo $this->plugin_name;?>[bip_price]"
                                       class="myc-setting-text" type="text"
                                       value="<?php if(!empty($options['bip_price'])) esc_attr_e($options['bip_price']);?>" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <?php
            }
            ?>

            <div id="myc-settings-section-funfasy_section" class="myc-settings-section" data-section="funfasy_section">
                <table class="form-table">
                    <tbody>
                        <tr class="myc-setting">
                            <th scope="row"><label for="<?php echo $this->plugin_name;?>-minter_funfasy_project_id"
                                ><?php  _e('PROJECT ID', $this->plugin_name)?></label></th>
                            <td>
                                <input id="<?php echo $this->plugin_name;?>-minter_funfasy_project_id"
                                        name="<?php echo $this->plugin_name;?>[minter_funfasy_project_id]"
                                       class="myc-setting-text" type="text"
                                       value="<?php if(!empty($options['minter_funfasy_project_id'])) esc_attr_e($options['minter_funfasy_project_id']);?>" />

                            </td>
                        </tr>
                        <tr class="myc-setting">
                            <th scope="row"><label for="<?php echo $this->plugin_name;?>-minter_funfasy_project_secret"
                                ><?php _e('PROJECT SECRET', $this->plugin_name);?></label></th>
                            <td>
                                <input id="<?php echo $this->plugin_name;?>-minter_funfasy_project_secret"
                                        name="<?php echo $this->plugin_name;?>[minter_funfasy_project_secret]"
                                       class="myc-setting-text" type="text"
                                       value="<?php if(!empty($options['minter_funfasy_project_secret'])) esc_attr_e($options['minter_funfasy_project_secret']);?>" />
                                    <small class="description">
                                        <?php  _e('more info how to get it on <a target="_blank" href="https://funfasy.dev/">https://funfasy.dev/</a>',$this->plugin_name); ?>
                                    </small>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>


            <!--                            2 second panel -->


            <div id="myc-settings-section-welcome" class="myc-settings-section" data-section="welcome">
                <table class="form-table">
                    <tbody>
                    <?php _e( '
                    <h1> Welcome To Minter YYY Cashback plugin! </h1>
                    <h2>Description</h2>
                        <p>Plugin created for <code> #MinterPush 0.2 – Rewards Hackathon–Subscriptions</code></p>
                        <p>EVERY question about this plugin asked here <a href="https://t.me/mntshop_official_group" rel="nofollow">[Official Telegram group]</a> would be answered.</p>
                        <p>Wordpress Plugin gives you the power of rewards your client! example for registration.
                            Use FunFasy.dev to send minter transaction and YYY.cash to generate containers with money.</p>
                            <p>Throw next to walkthrough setup</p>
                        <h3>In plugin settings</h3>
                        <h4>FUNFASY Settings section</h4>
                        <p>Register at <a href="https://funfasy.dev/" rel="nofollow">https://funfasy.dev/</a> and get your API keys and input your:
                            <code>PROJECT ID</code>
                            <code>PROJECT SECRET</code></p>
                        <h4>Minter Wallet Settings section</h4>
                        <blockquote>
                            <p>When you install a plugin that generates a new empty wallet to send rewards.</p>
                        </blockquote>
                        <p>Input your ticker here. All generated rewards will be sent in that ticker.</p>
                        <p>The balance would be displayed in the ticker</p>
                        <blockquote>
                            <p>Also in this section contain all information about wallet. Such as wallet mnemonic phrase, just copy and paste in your wallet app for example here <a href="https://wallet.bip.to" title="BIP Wallet" rel="nofollow">BIP Wallet</a>. And you can administrate wallet your new wallet.</p>
                        </blockquote>
                        <h4 >Rewards Settings section</h4>
                        <blockquote>
                            <p>In this section we have all predefined events like <code>Register on site </code>. You can customize it, but first, activate and some setup.</p>
                        </blockquote>
                        <p>Available options:</p>
                        <ul>
                            <li>Active (Activate reward)</li>
                            <li>Generate password (If you want to generate random password for reward)</li>
                            <li>How many coins do you want to reward? (how many coins will be sent for this reward)</li>
                            <li>Customization push settings (Customize reward)</li>
                            <li>Email notification settings (Customize Email notification such as from, template and some conditional message)</li>
                        </ul>
                        <blockquote>
                            <p>Feel free to use default settings like a template</p>
                        </blockquote>
                        <h4>Woocommerce Settings section</h4>
                        <blockquote>
                            <p>In this section store params for woocommerce.</p>
                        </blockquote>
                        <p>Available options:</p>
                        <ul>
                            <li>BIP price ( First of all tell the plugin how many cost BIP in your local currency )</li>
                            <li>Coupon generate ( You can activate coupon generator. After activated all rewards will generate woocommerce coupons basically on BIP cost )</li>
                        </ul>
                        <h2>Frequently Asked Questions</h2>
                        <h3>Which services do you use?</h3>
                        <p>We use:</p>
                        <ul>
                            <li>FunFasy api to connect Minter Blockchain here more info <a href="https://funfasy.dev/" title="https://funfasy.dev/" rel="nofollow">FunFasy</a></li>
                            <li>YYY.cash api to generate containers with money here more info <a href="https://push.money/swagger" title="https://push.money/swagger" rel="nofollow">YYY.cash</a></li>
                        </ul>
                        <h3></a>What about woocomerce?</h3>
                        <p>Currently, you can create cupon with minter push id and also add your price for BIP.
                            That means when push creates woocommerce generate a coupon with a fixed discount with the amount in a push.</p>
                        <h2>Changelog</h2>
                        <h3>1.0</h3>
                        <ul>
                            <li>Add language: Russian.</li>
                            <li>Add support to generate coupons.</li>
                            <li>Add FunFasy_helper (send transaction) .</li>
                            <li>Add YYY_push (the object that has all info about the push and working with it).</li>
                            <li>Add Admin Interface.</li>
                            <li>Add New Post type: minter-push. (You can view all generated pushes)</li>
                        </ul>
', $this->plugin_name );?>
                    </tbody>
                </table>
            </div>

        </div>


        <?php submit_button(__('Save all changes', $this->plugin_name), 'primary','submit', TRUE); ?>

    </form>

</div>
