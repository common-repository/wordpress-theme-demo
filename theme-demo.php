<?php

/*

Plugin Name: WordPress Theme Demo

Plugin URI: http://www.spotonseoservices.com/wordpress-theme-demo-plugin/

Description: This plugin will make it easy to demo any theme installed on a blog.

Version: 1.0

Author: SpotOn SEO Services

Author URI: http://www.spotonseoservices.com

Special Thanks to Brad Williams. I have taken great help from his plugin.

Example:

http://yourblog.com/index.php?preview_theme=WordPress%20Default



*/



//  Set this to the user level required to preview themes.

$preview_theme_user_level = 0;

// Set this to the name of the GET variable you want to use.

$preview_theme_query_arg = 'preview_theme';



$preview_theme = empty($_GET[$preview_theme_query_arg]) ? $_COOKIE['preview_theme'] : urldecode($_GET[$preview_theme_query_arg]);



if(!empty($preview_theme)){

	setcookie('preview_theme',$preview_theme,time()+900);

}





function preview_theme_stylesheet($stylesheet) {

    global $user_level, $preview_theme_user_level, $preview_theme_query_arg, $preview_theme;



    get_currentuserinfo();



    if ($user_level  < $preview_theme_user_level) {

        return $stylesheet;

    }



    $theme = $preview_theme;



    if (empty($theme)) {

        return $stylesheet;

    }



    $theme = get_theme($theme);



    if (empty($theme)) {

        return $stylesheet;

    }



    return $theme['Stylesheet'];

}



function preview_theme_template($template) {

    global $user_level, $preview_theme_user_level, $preview_theme_query_arg, $preview_theme;



    get_currentuserinfo();



    if ($user_level  < $preview_theme_user_level) {

        return $template;

    }



    $theme = $preview_theme;



    if (empty($theme)) {

        return $template;

    }



    $theme = get_theme($theme);



    if (empty($theme)) {

        return $template;

    }



    return $theme['Template'];

}



function wp_theme_preview($content) {



if ( !defined('WP_CONTENT_URL') )

	$pos = strpos(get_bloginfo('url'), 'wp-content');



	If ($pos === false) {

	    define( 'WP_CONTENT_URL', get_bloginfo('url') . '/');

	}Else{

		define( 'WP_CONTENT_URL', get_bloginfo('url') . 'wp-content/');

	}



	$themes = get_themes();



	if ( 1 < count($themes) ) {



		$style = '';



		$theme_names = array_keys($themes);

		natcasesort($theme_names);

		$x = 1;



		foreach ($theme_names as $theme_name) {

			if ( $theme_name == $ct->name )

				continue;

			$template = $themes[$theme_name]['Template'];

			$stylesheet = $themes[$theme_name]['Stylesheet'];

			$title = $themes[$theme_name]['Title'];

			$version = $themes[$theme_name]['Version'];

			$description = $themes[$theme_name]['Description'];

			$author = $themes[$theme_name]['Author'];

			$screenshot = $themes[$theme_name]['Screenshot'];

			$stylesheet_dir = $themes[$theme_name]['Stylesheet Dir'];

			$tags = $themes[$theme_name]['Tags'];



			if ( $screenshot ) :

				$form = $form . '<h3><a href="' . get_bloginfo('url') . '/?preview_theme=' . $theme_name . '" target="_blank">' .  $title . '</a></h3>';

				$form = $form . '<a href="' . get_bloginfo('url') . '/?preview_theme=' . $theme_name . '" target="_blank"><img src= "' . WP_CONTENT_URL . $stylesheet_dir . '/' . $screenshot . '" alt="" /></a>';

				$form = $form . '<p><a href="' . get_bloginfo('url') . '/?preview_theme=' . $theme_name . '" target="_blank">Preview Theme</a></p>';

				$form = $form . '<p>Description: '. $description . '</p>';

				$form = $form . '<p></p>';



			endif;



		}



	}



	return str_replace('[theme_list]', $form, $content);



}



function preview_footer(){

	echo '<p align="right"><a href="http://www.spotonseoservices.com/wordpress-theme-demo-plugin/">WordPress theme demo plugin</a> by <a href="http://www.spotonseoservices.com">SpotOn Search Engine Optimization</a>.</p>';

	

}

add_filter('stylesheet', 'preview_theme_stylesheet');

add_filter('template', 'preview_theme_template');

add_filter('the_content', 'wp_theme_preview');

add_action('wp_footer','preview_footer');



?>