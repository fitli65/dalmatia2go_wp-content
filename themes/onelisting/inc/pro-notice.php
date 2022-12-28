<?php
/**
 * @author  wpWax
 * @since   1.0
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class wpWax_Theme_Pro_Notice {

	protected static $instance = null;

	public $notice_dissmiss_id = 'onelisting-dismiss-pro-notice';

	private function __construct() {
		if ( ! is_admin() ) {
			return;
		}

		add_action( 'admin_notices', array( $this, 'admin_notice' ) );
		add_action( 'admin_head', array( $this, 'notice_style' ) );
		add_action( 'switch_theme', array( $this, 'delete_dismiss_info' ) );
	}

	public static function instance() {
		if ( null == self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function delete_dismiss_info() {
		delete_user_meta( get_current_user_id(), $this->notice_dissmiss_id );
	}

	public function notice_style() {
		if (  ( get_user_meta( get_current_user_id(), $this->notice_dissmiss_id, true ) ) ) {
			return;
		}
		?>
		<style>
			p {
				text-align: inherit;
			}
			.directorist-theme-updater-notice.directorist-theme-updater-notice-pro{
				background: #3221a1;
				background: -moz-linear-gradient(45deg,  #3221a1 0%, #9c37ce 100%);
				background: -webkit-linear-gradient(45deg,  #3221a1 0%,#9c37ce 100%);
				background: linear-gradient(45deg,  #3221a1 0%,#9c37ce 100%);
				filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#3221a1', endColorstr='#9c37ce',GradientType=1 );
				border-left: 0 none;
				padding: 40px;
				color: #fff;

			}
			.directorist-theme-updater-notice.directorist-theme-updater-notice-pro h2{
				font-size: 26px;
				margin: 0 8px 15px 0;
				color: rgba(255,255,255,.90);
			}
			.directorist-theme-updater-notice.directorist-theme-updater-notice-pro p{
				font-size: 16px;
				margin-bottom: 15px;
				color: rgba(255,255,255,.90);
			}
			.directorist-updater-list{
				display: flex;
			}
			.directorist-updater-list ul{
				display: flex;
				flex-wrap: wrap;
				align-items: center;
				margin: 0;
			}
			.directorist-updater-list .directorist-updater-list-label{
				margin-right: 16px;
				font-weight: 500;
				min-width: 110px;
				position: relative;
				top: 7px;
				color: rgba(255,255,255,.70);
			}
			.directorist-updater-list ul li{
				display: flex;
				align-items: center;
				min-height: 28px;
				border-radius: 16px;
				padding: 0 16px 0 12px;
				margin: 3px;
				background-color: rgba(255,255,255,.10);
			}
			.directorist-updater-list ul li .dashicon-check{
				line-height: .75;
				position: relative;
				top: 1px;
				margin-right: 4px;
			}
			.directorist-updater-list ul li .directorist-updater-text{
				font-weight: 600;
				color: rgba(255,255,255,.80);
			}
			.directorist-updater-list ul li .dashicon-check:before{
				font-size: 16px;
				content: '\f147';
				color: #fff;
				font-family: dashicons;
			}
			.directorist-theme-updater-notice-pro .directorist-updater-action{
				margin-top: 22px;
				margin: 16px -5px -5px -5px;
			}
			.directorist-theme-updater-notice-pro .directorist-updater-action a:focus{
				outline: 0 none;
				box-shadow: 0 0;
			}
			.directorist-theme-updater-notice-pro .directorist-updater-action .directorist-btn{
				min-height: 40px;
				color: #fff;
				padding: 8.5px 26px;
				margin: 5px;
			}
			.directorist-theme-updater-notice-pro .directorist-updater-action .directorist-btn:hover{
				color: #fff;
			}
			.directorist-theme-updater-notice-pro .directorist-updater-action .directorist-btn.directorist-btn-updgrade{
				background: #d62b54;
				background-image: -moz-linear-gradient(45deg,  #d62b54 0%, #dcba0f 100%);
				background-image: -webkit-linear-gradient(45deg,  #d62b54 0%,#dcba0f 100%);
				background-image: linear-gradient(45deg,  #d62b54 0%,#dcba0f 100%);
				filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#d62b54', endColorstr='#dcba0f',GradientType=1 );
				background-size: 100% 100%;
				transition: all .4s ease-in-out;
			}
			.directorist-theme-updater-notice-pro .directorist-updater-action .directorist-btn.directorist-btn-updgrade:hover{
				background-size: 140% 100%;
				transition: all .4s ease-in-out;
			}
			.directorist-theme-updater-notice-pro .directorist-updater-action .directorist-btn.directorist-btn-bordered{
				font-size: 14px;
				background-color: transparent;
				padding: 0;
				min-height: auto;
				text-decoration: underline;
				opacity: .75;
				transition: .3s;
			}
			.directorist-theme-updater-notice-pro .directorist-updater-action .directorist-btn.directorist-btn-bordered:hover{
				opacity: 1;
			}
			.directorist-theme-updater-notice-pro .directorist-updater-action .directorist-btn.directorist-btn-bordered:focus{
				text-decoration: underline !important;
			}
			.directorist-theme-updater-notice-pro .notice-dismiss:before{
				border-radius: 50%;
				color: rgba(255,255,255,.80);
				font-size: 18px;
			}
			.directorist-theme-updater-notice-pro .notice-dismiss{
				box-shadow: 0 0;
			}
		</style>

	<?php }

	public function admin_notice() {
		if ( isset( $_GET[$this->notice_dissmiss_id] ) ) {
			update_user_meta( get_current_user_id(), $this->notice_dissmiss_id, 1 );
		}

		if (  ( get_user_meta( get_current_user_id(), $this->notice_dissmiss_id, true ) ) ) {
			return;
		}
		?>
		<div class="notice notice-success is-dismissible directorist-theme-updater-notice directorist-theme-updater-notice-pro">
			<h2>Thank you for using OneListing Theme. Upgrade to the pro version to unleash all the features!</h2>
			<p>Pro version comes with a dedicated Theme Option Panel, 8 Premium Directorist Extensions($250+ value), 10+ Custom Elementor Widgets and a premium Homepage.</p>
			<div class="directorist-updater-list">
				<span class="directorist-updater-list-label">Theme Options:</span>
				<ul>
					<li>
						<span class="dashicon-check"></span>
						<span class="directorist-updater-text">Color</span>
					</li>
					<li>
						<span class="dashicon-check"></span>
						<span class="directorist-updater-text">Typography</span>
					</li>
					<li>
						<span class="dashicon-check"></span>
						<span class="directorist-updater-text">Preloader</span>
					</li>
					<li>
						<span class="dashicon-check"></span>
						<span class="directorist-updater-text">Header/Footer Control</span>
					</li>
					<li>
						<span class="dashicon-check"></span>
						<span class="directorist-updater-text">Layout Settings</span>
					</li>
					<li>
						<span class="dashicon-check"></span>
						<span class="directorist-updater-text">Blog Settings</span>
					</li>
					<li>
						<span class="dashicon-check"></span>
						<span class="directorist-updater-text">Post Settings</span>
					</li>
					<li>
						<span class="dashicon-check"></span>
						<span class="directorist-updater-text">Copyright Section</span>
					</li>
					<li>
						<span class="dashicon-check"></span>
						<span class="directorist-updater-text">10+ Elementor Widgets</span>
					</li>
				</ul>
			</div>
			<div class="directorist-updater-list">
				<span class="directorist-updater-list-label">8 Premium Extensions:</span>
				<ul>
					<li>
						<span class="dashicon-check"></span>
						<span class="directorist-updater-text">Pricing Plans</span>
					</li>
					<li>
						<span class="dashicon-check"></span>
						<span class="directorist-updater-text">Booking & Appointment</span>
					</li>
					<li>
						<span class="dashicon-check"></span>
						<span class="directorist-updater-text">Business Hours</span>
					</li>
					<li>
						<span class="dashicon-check"></span>
						<span class="directorist-updater-text">Stripe Payment Gateway</span>
					</li>
					<li>
						<span class="dashicon-check"></span>
						<span class="directorist-updater-text">PayPal Payment Gateway</span>
					</li>
					<li>
						<span class="dashicon-check"></span>
						<span class="directorist-updater-text">Claim Listing</span>
					</li>
					<li>
						<span class="dashicon-check"></span>
						<span class="directorist-updater-text">Listings with Map</span>
					</li>
					<li>
						<span class="dashicon-check"></span>
						<span class="directorist-updater-text">Social Login</span>
					</li>
				</ul>
			</div>
			<div class="directorist-updater-action">
				<a class="directorist-btn directorist-btn-updgrade" href="https://directorist.com/product/onelisting-pro/" target="_blank"><?php esc_html_e( 'Upgrade To Pro', 'onelisting' );?></a>

				<a class="directorist-btn directorist-btn-bordered" href="<?php echo esc_url(add_query_arg( $this->notice_dissmiss_id, 1 ));?>" class="directorist-btn directorist-btn-updgrade"><?php esc_html_e( 'Dismiss This Notice Permanently', 'onelisting' );?></a>
			</div>
		</div>
		<?php
	}
}

wpWax_Theme_Pro_Notice::instance();