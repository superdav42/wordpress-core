<?php
/**
 * Administration Menu Functions.
 *
 * Extracted from menu.php to allow menu.php to be re-included in long-running
 * PHP applications (e.g. Swoole, ReactPHP) without fatal redeclaration errors.
 *
 * @package WordPress
 * @subpackage Administration
 */

/**
 * Adds a CSS class to a string.
 *
 * @since 2.7.0
 *
 * @param string $class_to_add The CSS class to add.
 * @param string $classes      The string to add the CSS class to.
 * @return string The string with the CSS class added.
 */
if ( ! function_exists( 'add_cssclass' ) ) :
function add_cssclass( $class_to_add, $classes ) {
	if ( empty( $classes ) ) {
		return $class_to_add;
	}

	return $classes . ' ' . $class_to_add;
}
endif;

/**
 * Adds CSS classes for top-level administration menu items.
 *
 * The list of added classes includes `.menu-top-first` and `.menu-top-last`.
 *
 * @since 2.7.0
 *
 * @param array $menu The array of administration menu items.
 * @return array The array of administration menu items with the CSS classes added.
 */
if ( ! function_exists( 'add_menu_classes' ) ) :
function add_menu_classes( $menu ) {
	$first_item  = false;
	$last_order  = false;
	$items_count = count( $menu );

	$i = 0;

	foreach ( $menu as $order => $top ) {
		++$i;

		if ( 0 === $order ) { // Dashboard is always shown/single.
			$menu[0][4] = add_cssclass( 'menu-top-first', $top[4] );
			$last_order = 0;
			continue;
		}

		if ( str_starts_with( $top[2], 'separator' ) && false !== $last_order ) { // If separator.
			$first_item = true;
			$classes    = $menu[ $last_order ][4];

			$menu[ $last_order ][4] = add_cssclass( 'menu-top-last', $classes );
			continue;
		}

		if ( $first_item ) {
			$first_item = false;
			$classes    = $menu[ $order ][4];

			$menu[ $order ][4] = add_cssclass( 'menu-top-first', $classes );
		}

		if ( $i === $items_count ) { // Last item.
			$classes = $menu[ $order ][4];

			$menu[ $order ][4] = add_cssclass( 'menu-top-last', $classes );
		}

		$last_order = $order;
	}

	/**
	 * Filters administration menu array with classes added for top-level items.
	 *
	 * @since 2.7.0
	 *
	 * @param array $menu Associative array of administration menu items.
	 */
	return apply_filters( 'add_menu_classes', $menu );
}
endif;
