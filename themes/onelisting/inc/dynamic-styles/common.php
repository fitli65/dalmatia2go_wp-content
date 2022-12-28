<?php
/**
 * @author  wpWax
 * @since   1.0
 * @version 1.0
 */

namespace wpWax\OneListing;

/*--------------
#-Typography
---------------*/
$typo_body = Theme::$options['typo_body'];
$typo_h1   = Theme::$options['typo_h1'];
$typo_h2   = Theme::$options['typo_h2'];
$typo_h3   = Theme::$options['typo_h3'];
$typo_h4   = Theme::$options['typo_h4'];
$typo_h5   = Theme::$options['typo_h5'];
$typo_h6   = Theme::$options['typo_h6'];

$menu_typo    = Theme::$options['menu_typo'];
$submenu_typo = Theme::$options['submenu_typo'];
$resmenu_typo = Theme::$options['resmenu_typo']; // Mobile Menu
?>

<?php
/*--------------
#-Typography
---------------*/
?>

body,
gtnbg_root,
input,
gtnbg_root p {
	font-family: '<?php echo esc_html( $typo_body['font-family'] ); ?>', sans-serif;
	font-size: <?php echo esc_html( $typo_body['font-size'] . 'px' ); ?>;
	font-weight : <?php echo esc_html( $typo_body['font-weight'] ); ?>;
}
h1,
h1.gtnbg_suffix {
	font-family: '<?php echo esc_html( $typo_h1['font-family'] ); ?>', sans-serif;
	font-size: <?php echo esc_html( $typo_h1['font-size'] . 'px' ); ?>;
	font-weight : <?php echo esc_html( $typo_h1['font-weight'] ); ?>;
}
h2,
h2.gtnbg_suffix {
	font-family: '<?php echo esc_html( $typo_h2['font-family'] ); ?>', sans-serif;
	font-size: <?php echo esc_html( $typo_h2['font-size'] . 'px' ); ?>;
	font-weight : <?php echo esc_html( $typo_h2['font-weight'] ); ?>;
}
h3,
h3.gtnbg_suffix {
	font-family: '<?php echo esc_html( $typo_h3['font-family'] ); ?>', sans-serif;
	font-size: <?php echo esc_html( $typo_h3['font-size'] . 'px' ); ?>;
	font-weight : <?php echo esc_html( $typo_h3['font-weight'] ); ?>;
}
h4,
h4.gtnbg_suffix {
	font-family: '<?php echo esc_html( $typo_h4['font-family'] ); ?>', sans-serif;
	font-size: <?php echo esc_html( $typo_h4['font-size'] . 'px' ); ?>;
	font-weight : <?php echo esc_html( $typo_h4['font-weight'] ); ?>;
}
h5,
h5.gtnbg_suffix {
	font-family: '<?php echo esc_html( $typo_h5['font-family'] ); ?>', sans-serif;
	font-size: <?php echo esc_html( $typo_h5['font-size'] . 'px' ); ?>;
	font-weight : <?php echo esc_html( $typo_h5['font-weight'] ); ?>;
}
h6,
h6.gtnbg_suffix {
	font-family: '<?php echo esc_html( $typo_h6['font-family'] ); ?>', sans-serif;
	font-size: <?php echo esc_html( $typo_h6['font-size'] . 'px' ); ?>;
	font-weight : <?php echo esc_html( $typo_h6['font-weight'] ); ?>;
}