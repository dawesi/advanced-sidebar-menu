<?php
/**
 * The Ouput of the Advanced Sidebar Page Widget
 *
 * @author Mat Lipe
 *
 * @since  4.5.0
 *
 * @since  9.24.13
 *
 *
 * @uses   to edit, create a file named page_list.php and put in a folder in the your theme called 'advanced-sidebar-menu
 * @uses   copy the contents of the file into that file and edit at will
 * @uses   Do not edit this file in its original location or it will break on upgrade
 */

$asm->title();

#-- list the parent page if chosen
if( $asm->include_parent() ){
	$content .= '<ul class="parent-sidebar-menu" >';
	$content .= $asm->openListItem( wp_list_pages( "post_type=" . $post_type . "&sort_column=$order_by&title_li=&echo=0&depth=1&include=" . $top_parent ) );
}


//If there are children start the Child Sidebar Menu
if( $child_pages ){
	$content .= '<ul class="child-sidebar-menu">';

	#-- If they want all the pages displayed always
	if( $asm->display_all() ){
		$content .= wp_list_pages( "post_type=" . $post_type . "&sort_column=$order_by&title_li=&echo=0&child_of=" . $top_parent . "&depth=" . $instance[ 'levels' ] . "&exclude=" . implode( ',', $asm->exclude ) );

	} else {

		//TODO // BENCHMARK new vs old

		$args = array(
			'post_type'   => $post_type,
			'sort_column' => $order_by,
			'exclude'     => $asm->exclude
		);

		$menu = new Advanced_Sidebar_Menu_List_Pages( $top_parent, $args );
		$menu->list_pages();


		//TODO // REMOVE the old structure

		#-- Display children of current page's parent only
		foreach( $child_pages as $pID ){

			#-- If the page is not in the excluded ones
			if( $asm->exclude( $pID->ID ) ){
				#--echo the current page from the $result
				$content .= $asm->openListItem( wp_list_pages( "post_type=" . $post_type . "&sort_column=$order_by&title_li=&echo=0&depth=1&include=" . $pID->ID ) );
			} else {
				continue;
			}

			$content .= $asm->displayGrandChildMenu( $pID );


			$content .= '</li>';
		}
	}

	#-- Close the First Level menu
	$content .= '</ul><!-- End child-sidebar-menu -->';

}
if( $asm->include_parent() ){
	$content .= '</li></ul><!-- .parent-sidebar-menu -->';
}
		


	
