<?php 

/*
// Override any of the default settings below:

$config['site_title'] = 'Pico';			// Site title
$config['base_url'] = ''; 				// Override base URL (e.g. http://example.com)
$config['theme'] = 'default'; 			// Set the theme (defaults to "default")
$config['date_format'] = 'jS M Y';		// Set the PHP date format
$config['twig_config'] = array(			// Twig settings
	'cache' => false,					// To enable Twig caching change this to CACHE_DIR
	'autoescape' => false,				// Autoescape Twig vars
	'debug' => false					// Enable Twig debug
);
$config['pages_order_by'] = 'alpha';	// Order pages by "alpha" or "date"
$config['pages_order'] = 'asc';			// Order pages "asc" or "desc"
$config['excerpt_length'] = 50;			// The pages excerpt length (in words)

// To add a custom config setting:

$config['custom_setting'] = 'Hello'; 	// Can be accessed by {{ config.custom_setting }} in a theme

*/

$config['site_title'] = 'Sergi Rodriguez';
$config['theme'] = 'sergi';

// Social links
$config['social'] = array(
	'email' => 'info@sergirodriguez.net',
	'linkedin' => 'http://es.linkedin.com/in/sergirodriguez86',
	'stackoverflow' => 'http://careers.stackoverflow.com/sergirodriguez',
	'github' => 'https://github.com/rod86'
);

// Portfolio setup
$config['portfolio']['tag_slug'] = 'category';
$config['portfolio']['tag_labels'] = array(
	'frontend' => 'Frontend',
	'typo3' => 'TYPO3',
	'magento' => 'Magento',
	'android' => 'Android',
	'zend' => 'Zend Framework',
	'wordpress' => 'Wordpress'
);

