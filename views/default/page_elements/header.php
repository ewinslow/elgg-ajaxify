<?php
//	global $CONFIG;

	/**
	 * Elgg pageshell
	 * The standard HTML header that displays across the site
	 *
	 * @package Elgg
	 * @subpackage Core
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd
	 * @copyright Curverider Ltd 2009
	 * @link http://elgg.org/
	 *
	 * @uses $vars['config'] The site configuration settings, imported
	 * @uses $vars['title'] The page title
	 * @uses $vars['body'] The main content of the page
	 * @uses $vars['messages'] A 2d array of various message registers, passed from system_messages()
	 */
	 
	 // Set title
		if (empty($vars['title'])) {
			$title = $vars['config']->sitename;
		} else if (empty($vars['config']->sitename)) {
			$title = $vars['title'];
		} else {
			$title = $vars['config']->sitename . ": " . $vars['title'];
		}
		
		global $autofeed;
		if (isset($autofeed) && $autofeed == true) {
			$url = $url2 = full_url();
			if (substr_count($url,'?')) {
				$url .= "&view=rss";
			} else {
				$url .= "?view=rss";
			}
			if (substr_count($url2,'?')) {
				$url2 .= "&view=odd";
			} else {
				$url2 .= "?view=opendd";
			}
			$feedref = <<<END
			
	<link rel="alternate" type="application/rss+xml" title="RSS" href="{$url}" />
	<link rel="alternate" type="application/odd+xml" title="OpenDD" href="{$url2}" />
			
END;
		} else {
			$feedref = "";
		}
		
		$version = get_version();
		$release = get_version(true);
		
		$csscache = get_plugin_setting('csscache', 'minify') ? "&".$vars['config']->lastcache : '';
		$jscache = get_plugin_setting('jscache', 'minify') ? "&".$vars['config']->lastcache : '';
		
		// http currently does not work, forward to https
		if ((isset($CONFIG->https_login)) && ($CONFIG->https_login)) {
			if(getservbyname("http", 'tcp') == $_SERVER['SERVER_PORT']) {
				$https_url = str_replace("http:", "https:", $vars['url']);
				//forward($https_url);
			}
		}
		
		$lastcache = $vars['config']->lastcache;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="ElggRelease" content="<?php echo $release; ?>" />
	<meta name="ElggVersion" content="<?php echo $version; ?>" />
	<title><?php echo $title; ?></title>

	<!-- CSS -->
	<link href="<?php echo $vars['url']; ?>_css/css.css?lastcache=<?php echo $vars['config']->lastcache; ?>&amp;viewtype=<?php echo $vars['view']; ?>" rel="stylesheet" type="text/css" />

	<!-- JS -->
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
	<script type="text/javascript" src="<?php echo $vars['url']; ?>_css/js.php?lastcache=<?php echo $vars['config']->lastcache; ?>&amp;js=initialise_elgg&amp;viewtype=<?php echo $vars['view']; ?>"></script>
	
	<?php
		global $pickerinuse;
		if (isset($pickerinuse) && $pickerinuse == true) {
	?>
		<!-- only needed on pages where we have friends collections and/or the friends picker -->
		<script type="text/javascript" src="<?php echo $vars['url']; ?>vendors/jquery/jquery.easing.1.3.packed.js?lastcache=<?php echo $lastcache; ?>"></script>
		<script type="text/javascript" src="<?php echo $vars['url']; ?>_css/js.php?lastcache=<?php echo $vars['config']->lastcache; ?>&js=friendsPickerv1&viewtype=<?php echo $vars['view']; ?>"></script>
	<?php
		}
	?>
	
	<!-- Feeds -->
	<?php echo $feedref; ?>
	
	<!-- Metatags -->
	<?php echo elgg_view('metatags',$vars); ?>
	
	<!-- More -->
</head>

<body>
