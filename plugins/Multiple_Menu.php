<?php

/**
 * Example hooks for a Pico plugin
 *
 * @author Gilbert Pellegrom
 * @link http://picocms.org
 * @license http://opensource.org/licenses/MIT
 */
class Multiple_Menu {

	//var $menus = array();

	public function before_read_file_meta(&$headers) {
       $headers['mm_menu'] = 'MM_Menu';
       $headers['mm_order'] = 'MM_Order';

       $headers['layout'] = 'Layout';
    }
		
	public function get_pages(&$pages, &$current_page, &$prev_page, &$next_page)
	{
		$menus = array();

		foreach($pages as $page){

			// Skip pages without menu
			if ( empty($page['mm_menu'])) continue;

			if ( $page['url'] == $current_page['url'] ) $page['is_active'] = true;
	
			// Order pages by mm_menu param. If it is empty, add at the end
			if (!empty($page['mm_order'])) {
				$menus[$page['mm_menu']][$page['mm_order']] = $page;
			} else {
				$menus[$page['mm_menu']][] = $page;
			}		
			
		}

		// Order arrays by numeric key
		foreach ($menus as $key => $menu) ksort($menus[$key], SORT_NUMERIC);	

		//$this->menus = $menus;
		$pages = $menus;
	}

	public function get_page_data(&$data, $page_meta) {
		$data['mm_menu'] = $page_meta['mm_menu'];
		$data['mm_order'] = $page_meta['mm_order'];
	}
	
	public function before_render(&$twig_vars, &$twig, &$template)
	{	
		//$twig_vars['multiple_menu'] = $this->menus;
	}
	
}

?>
