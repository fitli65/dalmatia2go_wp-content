<?php
/**
 * Plugin Name: Directorist - Paypal Payment Gateway
 * Plugin URI: https://directorist.com/product/directorist-paypal
 * Description: You can accept payment via PayPal using this extension on any website powered by the Directorist WordPress Plugin.
 * Version: 1.4.2
 * Author: wpWax
 * Author URI: https://wpwax.com
 * License: GPLv2 or later
 * Text Domain: directorist-paypal
 * Domain Path: /languages
 */
// prevent direct access to the file
defined('ABSPATH') || die('No direct script access allowed!');

if (!class_exists('Directorist_Paypal_Gateway')) {
    final class Directorist_Paypal_Gateway
    {
        /**
         * @var Directorist_Paypal_Gateway The one true Directorist_Paypal_Gateway
         * @since 1.0.0
         */
        private static $instance;

        /**
         * If true, the paypal sandbox URI www.sandbox.paypal.com is used for the
         * post back. If false, the live URI www.paypal.com is used. Default false.
         *
         * @since    1.0.0
         * @access   private
         * @var      bool
         */
        private $use_sandbox = false;

        /**
         * Main Directorist_Paypal_Gateway Instance.
         *
         * Insures that only one instance of Directorist_Paypal_Gateway exists in memory at any one
         * time. Also prevents needing to define globals all over the place.
         * @return Directorist_Paypal_Gateway
         * @since 1.0.0
         */
        public static function instance()
        {
            // if no object is created, then create it and return it. Else return the old object of our class
            if (!isset(self::$instance) && !(self::$instance instanceof self)) {
                self::$instance = new self; // create an instance of Directorist_Paypal_Gateway
                self::$instance->setup_constants();
                self::$instance->includes();
                self::$instance->use_sandbox = get_directorist_option('gateway_test_mode', true); //@todo; is it good to make the sandbox var private???
                // enable translation
                add_action('plugins_loaded', array(self::$instance, 'load_textdomain'));
                // load admin scripts
                add_action('admin_enqueue_scripts', array(self::$instance, 'admin_enqueue_scripts'));
                // push license settings
                add_filter('atbdp_license_settings_controls', array(self::$instance, 'paypal_license_settings_controls'), 10, 1);
                // Add paypal gateway to the active gateway & default gateways selections
                add_filter('directorist_active_gateways', array(self::$instance, 'default_active_gateways'));
                add_filter('atbdp_default_gateways', array(self::$instance, 'default_active_gateways'));
                // Process payment
                add_action('atbdp_process_paypal_gateway_payment', array(self::$instance, 'process_payment'));
                //Process IPN
                add_action('parse_request', array(self::$instance, 'parse_request'));
                // licence activation
                add_action('wp_ajax_atbdp_paypal_license_activation', array(self::$instance, 'atbdp_paypal_license_activation'));
                // license deactivation
                add_action('wp_ajax_atbdp_paypal_license_deactivation', array(self::$instance, 'atbdp_paypal_license_deactivation'));
                // settings
                add_filter( 'atbdp_listing_type_settings_field_list', array( self::$instance, 'atbdp_listing_type_settings_field_list' ) );
                add_filter( 'atbdp_monetization_settings_submenu', array( self::$instance, 'atbdp_monetization_settings_submenu' ) );

            }
            return self::$instance;
        }

        public function atbdp_listing_type_settings_field_list( $stripe_fields ) {
            $gsp = sprintf("<a target='_blank' href='%s'>%s</a>", esc_url(admin_url('edit.php?post_type=at_biz_dir&page=aazztech_settings#_gateway_general')), __('Gateway Settings Page', 'directorist-paypal'));

            $stripe_fields['paypal_gateway_note'] = [
                'type'               => 'note',
                'title'              => __('Note About Paypal Gateway:', 'directorist-paypal'),
                'description'        => sprintf(__('If you want to use PayPal for a testing purpose, you should set Test MODE to Yes on The %s.', 'directorist-paypal'), $gsp),
            ];
            $stripe_fields['paypal_gateway_email'] = [
                'type'              => 'text',
                'label'             => __('Your Business Email', 'directorist-stripe'),
                'description'       => __('Enter your PayPal business email', 'directorist-stripe'),
                'value'             => '',
            ];
            $stripe_fields['paypal_gateway_title'] = [
                'type'              => 'text',
                'label'             => __('Gateway Title', 'directorist-stripe'),
                'description'       => __('Enter the title of this gateway that should be displayed to the user on the front end.', 'directorist-stripe'),
                'value'             => esc_html__('PayPal', 'directorist-paypal'),
            ];
            $stripe_fields['paypal_gateway_description'] = [
                'type'              => 'text',
                'label'             => __('Gateway Description', 'directorist-stripe'),
                'description'       => __('Enter some description for your user to make payment using paypal.', 'directorist-paypal'),
                'value'             => __('You can make payment using paypal if you choose this payment gateway.', 'directorist-paypal'),
            ];


            return $stripe_fields;
        }

        public function atbdp_monetization_settings_submenu( $submenu ) {
            $submenu['paypal'] = [
                'label'      => __('Paypal Gateway', 'directorist-paypal'),
                'icon'       => '<i class="fab fa-paypal"></i>',
                'sections'   => apply_filters( 'atbdp_paypal_settings_controls', [
                    'gateways' => [
                        'title'         => __('Paypal Gateway Settings', 'directorist-paypal'),
                        'description'   => __('You can customize all the settings related to your paypal gateway. After switching any option, Do not forget to save the changes.', 'directorist-paypal'),
                        'fields'        =>  [ 'paypal_gateway_note', 'paypal_gateway_email', 'paypal_gateway_title', 'paypal_gateway_description' ],
                    ],
                ] ),
            ];

            return $submenu;
        }

        public function atbdp_paypal_license_deactivation()
        {
            $license = !empty($_POST['paypal_license']) ? trim($_POST['paypal_license']) : '';
            $options = get_option('atbdp_option');
            $options['paypal_license'] = $license;
            update_option('atbdp_option', $options);
            update_option('directorist_paypal_license', $license);
            $data = array();
            if (!empty($license)) {
                // data to send in our API request
                $api_params = array(
                    'edd_action' => 'deactivate_license',
                    'license' => $license,
                    'item_id' => ATBDP_PAYPAL_POST_ID, // The ID of the item in EDD
                    'url' => home_url()
                );
                // Call the custom API.
                $response = wp_remote_post(ATBDP_AUTHOR_URL, array('timeout' => 15, 'sslverify' => false, 'body' => $api_params));
                // make sure the response came back okay
                if (is_wp_error($response) || 200 !== wp_remote_retrieve_response_code($response)) {

                    $data['msg'] = (is_wp_error($response) && !empty($response->get_error_message())) ? $response->get_error_message() : __('An error occurred, please try again.', 'directorist-paypal');
                    $data['status'] = false;

                } else {
                    $license_data = json_decode(wp_remote_retrieve_body($response));
                    if (!$license_data) {
                        $data['status'] = false;
                        $data['msg'] = __('Response not found!', 'directorist-paypal');
                        wp_send_json($data);
                        die();
                    }
                    update_option('directorist_paypal_license_status', $license_data->license);
                    if (false === $license_data->success) {
                        switch ($license_data->error) {
                            case 'expired' :
                                $data['msg'] = sprintf(
                                    __('Your license key expired on %s.', 'directorist-paypal'),
                                    date_i18n(get_option('date_format'), strtotime($license_data->expires, current_time('timestamp')))
                                );
                                $data['status'] = false;
                                break;

                            case 'revoked' :
                                $data['status'] = false;
                                $data['msg'] = __('Your license key has been disabled.', 'directorist-paypal');
                                break;

                            case 'missing' :

                                $data['msg'] = __('Invalid license.', 'directorist-paypal');
                                $data['status'] = false;
                                break;

                            case 'invalid' :
                            case 'site_inactive' :

                                $data['msg'] = __('Your license is not active for this URL.', 'directorist-paypal');
                                $data['status'] = false;
                                break;

                            case 'item_name_mismatch' :

                                $data['msg'] = sprintf(__('This appears to be an invalid license key for %s.', 'directorist-paypal'), 'Directorist - PayPal');
                                $data['status'] = false;
                                break;

                            case 'no_activations_left':

                                $data['msg'] = __('Your license key has reached its activation limit.', 'directorist-paypal');
                                $data['status'] = false;
                                break;

                            default :
                                $data['msg'] = __('An error occurred, please try again.', 'directorist-paypal');
                                $data['status'] = false;
                                break;
                        }

                    } else {
                        $data['status'] = true;
                        $data['msg'] = __('License deactivated successfully!', 'directorist-paypal');
                    }

                }
            } else {
                $data['status'] = false;
                $data['msg'] = __('License not found!', 'directorist-paypal');
            }
            wp_send_json($data);
            die();
        }


        public function atbdp_paypal_license_activation()
        {
            $license = !empty($_POST['paypal_license']) ? trim($_POST['paypal_license']) : '';
            $options = get_option('atbdp_option');
            $options['paypal_license'] = $license;
            update_option('atbdp_option', $options);
            update_option('directorist_paypal_license', $license);
            $data = array();
            if (!empty($license)) {
                // data to send in our API request
                $api_params = array(
                    'edd_action' => 'activate_license',
                    'license' => $license,
                    'item_id' => ATBDP_PAYPAL_POST_ID, // The ID of the item in EDD
                    'url' => home_url()
                );
                // Call the custom API.
                $response = wp_remote_post(ATBDP_AUTHOR_URL, array('timeout' => 15, 'sslverify' => false, 'body' => $api_params));
                // make sure the response came back okay
                if (is_wp_error($response) || 200 !== wp_remote_retrieve_response_code($response)) {

                    $data['msg'] = (is_wp_error($response) && !empty($response->get_error_message())) ? $response->get_error_message() : __('An error occurred, please try again.', 'directorist-paypal');
                    $data['status'] = false;

                } else {

                    $license_data = json_decode(wp_remote_retrieve_body($response));
                    if (!$license_data) {
                        $data['status'] = false;
                        $data['msg'] = __('Response not found!', 'directorist-paypal');
                        wp_send_json($data);
                        die();
                    }
                    update_option('directorist_paypal_license_status', $license_data->license);
                    if (false === $license_data->success) {
                        switch ($license_data->error) {
                            case 'expired' :
                                $data['msg'] = sprintf(
                                    __('Your license key expired on %s.', 'directorist-paypal'),
                                    date_i18n(get_option('date_format'), strtotime($license_data->expires, current_time('timestamp')))
                                );
                                $data['status'] = false;
                                break;

                            case 'revoked' :
                                $data['status'] = false;
                                $data['msg'] = __('Your license key has been disabled.', 'directorist-paypal');
                                break;

                            case 'missing' :

                                $data['msg'] = __('Invalid license.', 'directorist-paypal');
                                $data['status'] = false;
                                break;

                            case 'invalid' :
                            case 'site_inactive' :

                                $data['msg'] = __('Your license is not active for this URL.', 'directorist-paypal');
                                $data['status'] = false;
                                break;

                            case 'item_name_mismatch' :

                                $data['msg'] = sprintf(__('This appears to be an invalid license key for %s.', 'directorist-paypal'), 'Directorist - PayPal');
                                $data['status'] = false;
                                break;

                            case 'no_activations_left':

                                $data['msg'] = __('Your license key has reached its activation limit.', 'directorist-paypal');
                                $data['status'] = false;
                                break;

                            default :
                                $data['msg'] = __('An error occurred, please try again.', 'directorist-paypal');
                                $data['status'] = false;
                                break;
                        }

                    } else {
                        $data['status'] = true;
                        $data['msg'] = __('License activated successfully!', 'directorist-paypal');
                    }

                }
            } else {
                $data['status'] = false;
                $data['msg'] = __('License not found!', 'directorist-paypal');
            }
            wp_send_json($data);
            die();
        }

        public static function get_version_from_file_content( $file_path = '' ) {
            $version = '';

            if ( ! file_exists( $file_path ) ) {
                return $version;
            }

            $content = file_get_contents( $file_path );
            $version = self::get_version_from_content( $content );

            return $version;
        }

        public static function get_version_from_content( $content = '' ) {
            $version = '';

            if ( preg_match('/\*[\s\t]+?version:[\s\t]+?([0-9.]+)/i', $content, $v) ) {
                $version = $v[1];
            }

            return $version;
        }

        /**
         * Setup Directorist Paypal's plugin constants.
         *
         * @access private
         * @return void
         * @since 1.0.0
         */
        private function setup_constants()
        {
            if ( ! defined('DT_PAYPAL_FILE') ) {
                define('DT_PAYPAL_FILE', __FILE__);
            }

            $version = self::get_version_from_file_content( DT_PAYPAL_FILE );

            require_once plugin_dir_path(__FILE__) . 'constants.php'; // loads constant from a file so that it can be available on all files.
        }

        /**
         *It includes required files and library needed by our class
         * @since 1.0.0
         */
        private function includes()
        {
            if (!class_exists('PaypalIPN')) {
                require_once plugin_dir_path(__FILE__) . 'library/PaypalIPN.php';
            }

            if (!class_exists('EDD_SL_Plugin_Updater')) {
                // load our custom updater if it doesn't already exist
                include(dirname(__FILE__) . '/library/EDD_SL_Plugin_Updater.php');
            }
            // setup the updater
            $license_key = trim(get_option('directorist_paypal_license'));
            new EDD_SL_Plugin_Updater(ATBDP_AUTHOR_URL, __FILE__, array(
                'version' => DT_PAYPAL_VERSION,        // current version number
                'license' => $license_key,    // license key (used get_option above to retrieve from DB)
                'item_id' => ATBDP_PAYPAL_POST_ID,    // id of this plugin
                'author' => 'AazzTech',    // author of this plugin
                'url' => home_url(),
                'beta' => false // set to true if you wish customers to receive update notifications of beta releases
            ));
            require_once plugin_dir_path(__FILE__) . 'helper.php';
        }

        public function admin_enqueue_scripts()
        {
            $data = array(
                'ajaxurl' => admin_url('admin-ajax.php'),
            );
            wp_register_script('atbdp-paypal-main-script', plugin_dir_url(__FILE__) . 'assets/js/main.js', array('jquery'), ATBDP_VERSION, true);
            wp_register_style('atbdp-paypal-main-style', plugin_dir_url(__FILE__) . 'assets/css/style.css');
            wp_enqueue_script('atbdp-paypal-main-script');
            wp_enqueue_style('atbdp-paypal-main-style');
            wp_localize_script('atbdp-paypal-main-script', 'atbdp_paypal', $data);
        }

        /**
         * It loads plugin text domain
         * @since 1.0.0
         */
        public function load_textdomain()
        {
            load_plugin_textdomain('directorist-paypal', false, DT_PAYPAL_LANG_DIR);
        }

        /**
         * It adds our gateways to the active and default gateways list
         * @param array $gateways Arrays of all old gateways
         * @return array It returns the new gateways list after adding paypal gateways
         * @since 1.0.0
         */
        public function default_active_gateways($gateways)
        {
            /**
             * @todo latter PayPal option hide if shop currency doesn't support by PayPal
             */
            $gateways[] = array(
                'value' => 'paypal_gateway',
                'label' => __('Paypal', 'directorist-paypal'),
            );
            return $gateways;
        }


        public function paypal_license_settings_controls($default)
        {
            $status = get_option('directorist_paypal_license_status');
            if (!empty($status) && ($status !== false && $status == 'valid')) {
                $action = array(
                    'type' => 'toggle',
                    'name' => 'paypal-deactivated',
                    'label' => __('Action', 'directorist-paypal'),
                    'validation' => 'numeric',
                );
            } else {
                $action = array(
                    'type' => 'toggle',
                    'name' => 'paypal-activated',
                    'label' => __('Action', 'directorist-paypal'),
                    'validation' => 'numeric',
                );
            }
            $new = apply_filters('atbdp_paypal_extension_controls', array(
                'type' => 'section',
                'title' => __('PayPal', 'directorist-paypal'),
                'description' => __('You can active your PayPal extension here.', 'directorist-paypal'),
                'fields' => apply_filters('atbdp_paypal_license_settings_field', array(
                    array(
                        'type' => 'textbox',
                        'name' => 'paypal_license',
                        'label' => __('License', 'directorist-paypal'),
                        'description' => __('Enter your PayPal extension license', 'directorist-paypal'),
                        'default' => '',
                    ),
                    $action
                )),

            ));
            $settings = apply_filters('atbdp_licence_menu_for_paypal', true);
            if($settings){
                array_push($default, $new);
            }
            return $default;
        }

        /**
         * It process the payment of the given order
         * @see for sending more than one custom var https://stackoverflow.com/questions/11631926/paypal-ipn-process-more-than-one-custom-variable
         * @param int $order_id
         * @since 1.0.0
         */
        public function process_payment($order_id)
        {
            $redirect_url = apply_filters('atbdp_payment_receipt_page_link', ATBDP_Permalink::get_payment_receipt_page_link($order_id), $order_id);
            $currency = get_directorist_option('payment_currency', get_directorist_option('g_currency', 'USD'));
            $business = get_directorist_option('paypal_gateway_email');
            $listing_id = get_post_meta($order_id, '_listing_id', true);
            $amount = get_post_meta($order_id, '_amount', true);
            $host = $this->use_sandbox ? 'www.sandbox.paypal.com' : 'www.paypal.com';
            $cmd = '_xclick';
            $plan = '';
            if (class_exists('ATBDP_Pricing_Plans')) {
                $plan = get_post_meta($listing_id, '_fm_plans', true);
                $is_recurring = get_post_meta($plan, '_atpp_recurring', true);
                if (!empty($is_recurring)) {
                    $cmd = '_xclick-subscriptions';
                }
            }
            ?>
            <p><?php esc_html_e('Please DO NOT close this window. Now you will be redirected to paypal.com for completing your purchase.', 'directorist-paypal'); ?></p>

            <form id="directorist-paypal-form" name="directorist-paypal-form"
                  action="<?php echo esc_url("https://{$host}/cgi-bin/webscr"); ?>" method="post">
                <input type="hidden" name="cmd" value="<?php echo $cmd; ?>">
                <input type="hidden" name="custom" value="<?php echo $listing_id; ?>">
                <!--if we need to send more than one custom var, -->
                <!--Business email is the email of the seller who will received the money from the paypal -->
                <input type="hidden" name="business" value="<?php echo esc_attr($business) ?>">
                <input type="hidden" name="currency_code" value="<?php echo esc_attr($currency); ?>">
                <input type="hidden" name="item_name"
                       value="<?php echo esc_attr(get_the_title(!empty($plan) ? $plan : $listing_id)); ?>">
                <input type="hidden" name="item_number" value="<?php echo esc_attr($order_id); ?>">
                <input type="hidden" name="amount" value="<?php echo esc_attr($amount); ?>">
                <input type="hidden" name="cancel_return"
                       value="<?php echo ATBDP_Permalink::get_transaction_failure_page_link(); ?>">
                <input type="hidden" name="notify_url"
                       value="<?php echo ATBDP_Permalink::get_ipn_notify_page_link($order_id); ?>">
                <input type="hidden" name="return"
                       value="<?php echo $redirect_url; ?>">
                <input type="hidden" name="no_shipping" value="0">
                <?php
                if (class_exists('ATBDP_Pricing_Plans')) {
                    $plan = get_post_meta($listing_id, '_fm_plans', true);
                    $is_recurring = get_post_meta($plan, '_atpp_recurring', true);
                    $recurrence_period_term = get_post_meta($plan, '_recurrence_period_term', true);
                    $recurrence_time = get_post_meta($plan, 'fm_length', true);
                    $time_period = '';
                    if ('day' === $recurrence_period_term) {
                        $time_period = 'D';
                    }
                    if ('week' === $recurrence_period_term) {
                        $time_period = 'W';
                    }
                    if ('month' === $recurrence_period_term) {
                        $time_period = 'M';
                    }
                    if ('year' === $recurrence_period_term) {
                        $time_period = 'Y';
                    }
                    if (!empty($is_recurring)) {
                        ?>
                        <input type="hidden" name="a3" value="<?php echo esc_attr($amount); ?>">
                        <input type="hidden" name="p3" value="<?php echo (int)$recurrence_time; ?>">
                        <input type="hidden" name="t3" value="<?php echo($time_period) ?>">
                        <input type="hidden" name="src" value="1">
                        <input type="hidden" name="sra" value="1">
                        <?php
                    }
                }
                ?>

            </form>

            <script type="text/javascript">
                document.getElementById('directorist-paypal-form').submit();
            </script>
            <?php

        }

        /**
         *It process Paypal Instant Payment Notification
         * @see https://github.com/paypal/ipn-code-samples/blob/master/php/example_usage.php
         * @param int $order_id
         * @since 1.0.0
         */
        private function process_paypal_ipn($order_id)
        {
            $ipn = new PaypalIPN();
            // Use the sandbox endpoint during testing.
            if ($this->use_sandbox) {
                $ipn->useSandbox();
            }
            try {
                $verified = $ipn->verifyIPN();
            } catch (Exception $e) {
                $this->log_custom_error($e->getMessage());
                //$this->write_log_to_file($e->getMessage());

                $payment_status = ( isset( $_POST['payment_status'] ) ) ? strtolower(  $_POST['payment_status'] ) : '';

                if ( in_array( $payment_status, [ 'completed' ] ) || ( $this->use_sandbox && 'pending' == $payment_status ) ) {
                    $this->process_transection( $order_id );

                    // Reply with an empty 200 response to indicate to paypal the IPN was received correctly.
                    header("HTTP/1.1 200 OK");
                    exit;
                }
                exit;
            }

            if ($verified) {
                $this->process_transection( $order_id );

                // Reply with an empty 200 response to indicate to paypal the IPN was received correctly.
                header("HTTP/1.1 200 OK");

            } else {
                $this->log_custom_error('IPN Verification Failed.');
                //$this->write_log_to_file('verification failed');
            }


        }

        /**
         * Process Transection From Paypal IPN
         *
         * @param $order_id
         * @return void
         */
        public function process_transection( $order_id ) {
            $error          = 0;
            $currency       = get_directorist_option('payment_currency', get_directorist_option('g_currency', 'USD'));
            $transaction_id = get_post_meta($order_id, '_transaction_id', true);
            $amount         = get_post_meta($order_id, '_amount', true);
            $business       = get_directorist_option('paypal_gateway_email');

            if ($_POST['receiver_email'] != $business) {
                $this->log_custom_error('Receiver Business Email mismatch : ' . $_POST['receiver_email']);
                //$this->write_log_to_file('Receiver Business Email mismatch : ' . $_POST['receiver_email']);

                $error++;
            }

            if ($_POST['mc_gross'] != $amount) {
                $this->log_custom_error('Amount mismatch : ' . $_POST['mc_gross']);
                //$this->write_log_to_file('Amount mismatch : ' . $_POST['mc_gross']);
                $error++;
            }

            if ($_POST['mc_currency'] != $currency) {
                $this->log_custom_error('Payment Currency mismatch : ' . $_POST['mc_currency']);
                //$this->write_log_to_file('Payment Currency mismatch : ' . $_POST['mc_currency']);
                $error++;
            }

            if ($_POST['txn_id'] == $transaction_id) {
                $this->log_custom_error('Duplicate Transaction ID : ' . $_POST['txn_id']);
                //$this->write_log_to_file('Duplicate Transaction : '.$_POST['txn_id']);
                $error++;
            }

            if (!$error) {

                $status = strtolower($_POST['payment_status']); // payment_status sent by paypal IPN
                if ('completed' == $status || ($this->use_sandbox && 'pending' == $status)) {

                    $this->complete_order(
                        array(
                            'ID' => $order_id,
                            'transaction_id' => $_POST['txn_id'],
                        )
                    );
                }

            }
        }


        /**
         * It completes order
         * @param $order_data
         * @since 1.0.0
         * @todo; think if it is better to move this to Order Class later
         */
        private function complete_order($order_data)
        {
            // add payment status, tnx_id etc.
            update_post_meta($order_data['ID'], '_payment_status', 'completed');
            update_post_meta($order_data['ID'], '_transaction_id', $order_data['transaction_id']);
            // If the order has featured, make the related listing featured.
            $featured = get_post_meta($order_data['ID'], '_featured', true);
            // use given listing id or fetch the ID
            $listing_id = !empty($order_data['listing_id']) ? $order_data['listing_id'] : get_post_meta($order_data['ID'], '_listing_id', true);

            if (!empty($featured)) {
                update_post_meta($listing_id, '_featured', 1);
            }
            if (get_post_status($listing_id) != 'publish') {
                if (is_fee_manager_active()):
                    $user_id = get_current_user_id();
                    $plan_id = get_post_meta($listing_id, '_fm_plans', true);
                    $package_length = get_post_meta($plan_id, 'fm_length', true);
                    $fm_length_unl = get_post_meta($plan_id, 'fm_length_unl', true);
                    $package_length = $package_length ? $package_length : '1';
                    atpp_need_listing_to_refresh($user_id, $order_data['ID'], $plan_id);
                    //if plan has
                    // Current time
                    $current_d = current_time('mysql');
                    // Calculate new date
                    $date = new DateTime($current_d);
                    $date->add(new DateInterval("P{$package_length}D")); // set the interval in days
                    $expired_date = $date->format('Y-m-d H:i:s');
                    // is it renewal order? yes, lets update the listing according to plan
                    $is_renewal = get_post_meta($listing_id, '_renew_with_plan', true);
                    $new_l_status = get_directorist_option('new_listing_status', 'pending');
                    //order comes from renewal so update the listing if payment is completed
                    if (!empty($is_renewal)) {
                        $time = current_time('mysql');
                        $post_array = array(
                            'ID' => $listing_id,
                            'post_status' => 'publish',
                            'post_date' => $time,
                            'post_date_gmt' => get_gmt_from_date($time)
                        );
                        //Updating listing
                        wp_update_post($post_array);

                        // Update the post_meta into the database && update related post metas
                        if (!empty($fm_length_unl)) {
                            update_post_meta($listing_id, '_never_expire', 1);
                        } else {

                            update_post_meta($listing_id, '_expiry_date', $expired_date);
                        }
                        update_post_meta($listing_id, '_listing_status', 'post_status');
                    } else {
                        $my_post = array();
                        $my_post['ID'] = $listing_id;
                        $my_post['post_status'] = $new_l_status;
                        wp_update_post($my_post);
                    }
                endif;

            }

            // Order has been completed. Let's fire a hook for a developer to extend if they wish
            do_action('atbdp_order_completed', $order_data['ID'], $listing_id);
        }

        /**
         * Parse request to process Paypal IPN.
         *
         * @param WP_Query $query WordPress Query object.
         * @since    1.0.0
         * @access   public
         *
         */
        public function parse_request($query)
        {

            if (array_key_exists('atbdp_action', $query->query_vars) && 'paypal-ipn' == $query->query_vars['atbdp_action'] && array_key_exists('atbdp_order_id', $query->query_vars)) {
                $this->process_paypal_ipn($query->query_vars['atbdp_order_id']);
                exit();

            }
        }

        /**
         * It logs error message in the sandbox mode
         * @param $message
         * @since 1.0.0
         */
        private function log_custom_error($message)
        {
            if ($this->use_sandbox) error_log($message);
        }

        /**
         * It logs error message in a local file
         * @param $message
         * @since 1.0.0
         */
        private function write_log_to_file($message)
        {
            file_put_contents(dirname(__FILE__) . '/error_log.txt', $message, FILE_APPEND);
        }


    }

    if ( ! function_exists( 'directorist_is_plugin_active' ) ) {
        function directorist_is_plugin_active( $plugin ) {
            return in_array( $plugin, (array) get_option( 'active_plugins', array() ), true ) || directorist_is_plugin_active_for_network( $plugin );
        }
    }

    if ( ! function_exists( 'directorist_is_plugin_active_for_network' ) ) {
        function directorist_is_plugin_active_for_network( $plugin ) {
            if ( ! is_multisite() ) {
                return false;
            }

            $plugins = get_site_option( 'active_sitewide_plugins' );
            if ( isset( $plugins[ $plugin ] ) ) {
                    return true;
            }

            return false;
        }
    }

    /**
     * The main function for that returns Directorist_Paypal_Gateway
     * @return Directorist_Paypal_Gateway
     */
    function Directorist_Paypal()
    {
        return Directorist_Paypal_Gateway::instance();
    }

    // Instantiate Directorist Paypal gateway only if our directorist plugin is active
    if ( directorist_is_plugin_active( 'directorist/directorist-base.php' ) ) {
        Directorist_Paypal();
    }
}