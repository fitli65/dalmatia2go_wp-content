<?php
/**
 * @author  wpWax
 * @since   1.0
 * @version 1.0
 */

use \wpWax\OneListing\Helper;
use \wpWax\OneListing\Theme;

$nav_menu_args 	   = Helper::get_nav_menu_args('button');
$menu_align		   = ( Theme::$options['add_listing_button'] || Theme::$options['header_account'] ) ? '' : ' menu-right';
$container_type    = ( Theme::$options['container_type'] ) ? Theme::$options['container_type'] : 'theme-container' ;
?>
<div class="theme-header-menu-area">

	<div class="<?php echo esc_attr( $container_type ); ?>">

		<div class="theme-header-menu-full">
			
			<div class="theme-header-logo-wrap">

				<div class="theme-header-logo-inner site-branding">
						
					<?php if ( function_exists( 'the_custom_logo' ) && get_theme_mod( 'custom_logo' ) ) : ?>

						<div class="navbar-brand theme-header-logo-brand order-sm-1 order-1">

							<?php the_custom_logo() ;?>

						</div>
					
					<?php else : ?>

						<a class="navbar-brand theme-header-logo-brand order-sm-1 order-1" href="<?php echo esc_url( home_url( '/' ) ); ?>">

							<h1 class="site-title"><?php echo esc_html( get_bloginfo( 'name' ) )?></h1>

						</a>

					<?php endif;?>

				</div>

			</div>

			<div class="theme-menu-container">

				<div class="theme-main-navigation<?php echo esc_attr( $menu_align ); ?>">

					<div class="theme-main-navigation-inner">

						<a href="#" class="theme-mobile-menu-close"><i class="themeicon themeicon-times-solid"></i></a>

						<?php wp_nav_menu( $nav_menu_args ); ?>

					</div>

					<?php if ( has_nav_menu('primary') ) : ?>

						<span class="theme-mobile-menu-trigger d-none">
							<span></span>
							<span></span>
							<span></span>
						</span>

					<?php endif; ?>
					
				</div>

			</div>

			<?php if ( class_exists( 'Directorist_Base' ) ) : ?>

			<div class="theme-menu-action-box">

				<div class="theme-menu-action-box__search">

					<?php if ( ! atbdp_is_page( 'add_listing' ) && Theme::$options['header_search'] ) : ?>

						<a href="" class="theme-menu-action-box__search--trigger">

							<i class="search-icon themeicon-search-solid themeicon"></i>

						</a>

					<?php endif; ?>

				</div>

				<?php if ( Theme::$options['header_account'] && ! atbdp_is_page( 'login' ) && ! atbdp_is_page( 'registration' ) ) : ?>

					<div class="theme-menu-action-box__author">

						<div class="theme-menu-action-box__author--access-area">

							<?php if ( ! is_user_logged_in() ) : ?>

								<div class="theme-menu-action-box__login">

									<div class="theme-menu-action-box__login--modal">

										<a href="#" class="btn theme-btn btn-sm btn-outline-light" data-bs-toggle="modal" data-bs-target="#theme-login-modal">
											<span class="d-none d-lg-block"><?php esc_html_e( 'Sign In', 'onelisting' ); ?></span>
											<?php directorist_icon( 'las la-user', true, '' ); ?>
										</a>

									</div>

								</div>

							<?php else : ?>

								<?php Helper::get_template_part( 'directorist/custom/header-avatar' ); ?>

							<?php endif; ?>

						</div>

					</div>
				
				<?php endif; ?>

				<?php if ( Theme::$options['add_listing_button'] && isset( Theme::$options['add_listing_button_text'] ) && class_exists( 'ATBDP_Permalink') ) : ?>
					
					<div class="theme-menu-action-box__add-listing">

						<a href="<?php echo esc_url( \ATBDP_Permalink::get_add_listing_page_link() ); ?>" class="btn theme-btn btn-sm btn-primary btn-add-listing"><?php directorist_icon( 'las la-plus' ); ?> <span class="d-none d-lg-block"><?php echo Theme::$options['add_listing_button_text']; ?></span></a>

					</div>

				<?php endif; ?>

			</div>

			<?php endif;?>

		</div>

	</div>
	
</div>