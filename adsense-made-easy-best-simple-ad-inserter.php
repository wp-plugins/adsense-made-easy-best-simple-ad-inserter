<?php
/*
Plugin Name: Adsense Made Easy - Best Simple Ad Inserter
Plugin URI:
Version: 1.00
Author: <a href="http://www.seo101.net">Seo101</a>
Description: Easily add Google Adsense to your posts, pages and sidebar
License: GPLv2 a

*/
if (!class_exists("AdsenseMadeEasy")) {
	class AdsenseMadeEasy {
		function AdsenseMadeEasy() { //constructor remains empty

		}
		function addHeaderCode() {
			?>
			<?php

		}
		function addContent($content = '') {
 	 	  global $wp_query;
	 	  global $post;

		  if (((is_single() && get_option('adsense_made_easy_displayposts')=='yes') || (is_singular() && is_page() && get_option('adsense_made_easy_displaypages')=='yes') || is_category() || is_archive()) && $wp_query->posts[0]->ID == $post->ID) {
			$original = $content;
			if (get_option('adsense_made_easy_topadtype')=='square') {
				$content = "<div style=\"padding-left:5px; padding-right:5px; padding-bottom:5px; padding-top:5px; float: left;\">\n";
			} else {
				$content = "<div style=\"padding-left:5px; padding-right:5px; padding-bottom:5px; padding-top:5px; margin-left:auto; margin-right:auto; \">\n";
			}
			if (get_option('adsense_made_easy_topadtype')!='none') {
				$content .= "<script type=\"text/javascript\"><!--\n";
				$content .= "google_ad_client = \"";
				$content .= get_option('adsense_made_easy_publisherid');
				$content .= "\";\n";
				if (get_option('adsense_made_easy_topadtype')=='square') {
				  $content .= "google_ad_width = 250;\n";
				  $content .= "google_ad_height = 250;\n";
				} elseif (get_option('adsense_made_easy_topadtype')=='rectangle') {
				  $content .= "google_ad_width = 336;\n";
				  $content .= "google_ad_height = 280;\n";
				} else {
				  $content .= "google_ad_width = 468;\n";
				  $content .= "google_ad_height = 60;\n";
				}

				$content .= "google_color_border = \"";
				$content .= get_option('adsense_made_easy_bordercolor');
				$content .= "\";\n";
				$content .= "google_color_link = \"";
				$content .= get_option('adsense_made_easy_titlecolor');
				$content .= "\";\n";
				$content .= "google_color_text = \"";
				$content .= get_option('adsense_made_easy_textcolor');
				$content .= "\";\n";
				$content .= "google_color_bg = \"";
				$content .= get_option('adsense_made_easy_backgroundcolor');
				$content .= "\";\n";
				$content .= "google_color_url = \"";
				$content .= get_option('adsense_made_easy_urlcolor');
				$content .= "\";\n";
				$content .= "//-->\n";
				$content .= "</script>\n";
				$content .= "<script type=\"text/javascript\"\n";
				$content .= "src=\"http://pagead2.googlesyndication.com/pagead/show_ads.js\">\n";
				$content .= "</script>\n";
			}
			$content .= "</div>\n";
			$content .= $original;

			if (get_option('adsense_made_easy_bottomadtype')!='none') {
				$content .= "<center> <script type=\"text/javascript\"><!--\n";
				$content .= "google_ad_client = \"";
				$content .= get_option('adsense_made_easy_publisherid');
				$content .= "\";\n";
				if (get_option('adsense_made_easy_bottomadtype')=='rectangle') {
				  $content .= "google_ad_width = 336;\n";
				  $content .= "google_ad_height = 280;\n";
				} elseif (get_option('adsense_made_easy_bottomadtype')=='square') {
				  $content .= "google_ad_width = 250;\n";
				  $content .= "google_ad_height = 250;\n";
				} else {
				  $content .= "google_ad_width = 468;\n";
				  $content .= "google_ad_height = 60;\n";
				}
				$content .= "google_color_border = \"";
				$content .= get_option('adsense_made_easy_bordercolor');
				$content .= "\";\n";
				$content .= "google_color_link = \"";
				$content .= get_option('adsense_made_easy_titlecolor');
				$content .= "\";\n";
				$content .= "google_color_text = \"";
				$content .= get_option('adsense_made_easy_textcolor');
				$content .= "\";\n";
				$content .= "google_color_bg = \"";
				$content .= get_option('adsense_made_easy_backgroundcolor');
				$content .= "\";\n";
				$content .= "google_color_url = \"";
				$content .= get_option('adsense_made_easy_urlcolor');
				$content .= "\";\n";
				$content .= "//-->\n";
				$content .= "</script>\n";
				$content .= "<script type=\"text/javascript\"\n";
				$content .= "src=\"http://pagead2.googlesyndication.com/pagead/show_ads.js\">\n";
				$content .= "</script> </center>\n";
			}
			return $content;
		  }
		  return $content;
		}
		function authorUpperCase($author = '') {
			return strtoupper($author);
		}

	}

} //End Class AdsenseMadeEasy


class AdsenseMadeEasyWidget extends WP_Widget
{
  function AdsenseMadeEasyWidget()
  {
    $widget_ops = array('classname' => 'AdsenseMadeEasyWidget', 'description' => 'Adsense Made Easy - Sidebar add' );
    $this->WP_Widget('AdsenseMadeEasyWidget', 'Adsense Made Easy - Sidebar add', $widget_ops);
  }

  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
    $title = $instance['title'];
?>
  <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
<?php
  }

  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    return $instance;
  }

  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);

    echo $before_widget;
    $title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);

    if (!empty($title))
      echo $before_title . $title . $after_title;;

    // WIDGET CODE GOES IN HERE
    echo "<script type=\"text/javascript\"> <!--\n";
    echo "google_ad_client = \"";
	echo get_option('adsense_made_easy_publisherid');
    echo "\";\n";
    echo "/* GrootVierkantWit */\n";
    echo "google_ad_width = 160;\n";
    echo "google_ad_height = 600;\n";
    echo "google_color_border = \"";
    echo get_option('adsense_made_easy_bordercolor');
    echo "\";\n";
    echo "google_color_link = \"";
    echo get_option('adsense_made_easy_titlecolor');
    echo "\";\n";
    echo "google_color_text = \"";
    echo get_option('adsense_made_easy_textcolor');
    echo "\";\n";
    echo "google_color_bg = \"";
    echo get_option('adsense_made_easy_backgroundcolor');
    echo "\";\n";
    echo "google_color_url = \"";
    echo get_option('adsense_made_easy_urlcolor');
    echo "\";\n";
    echo "//-->\n";
    echo "</script>\n";
    echo "<script type=\"text/javascript\"\n";
    echo "src=\"http://pagead2.googlesyndication.com/pagead/show_ads.js\">\n";
    echo "</script> \n";

    echo $after_widget;
  }

}
add_action( 'widgets_init', create_function('', 'return register_widget("AdsenseMadeEasyWidget");') );





if (class_exists("AdsenseMadeEasy")) {
	$dl_pluginSeries = new AdsenseMadeEasy();
}
//Actions and Filters
if (isset($dl_pluginSeries)) {
	//Actions
	//Filters
	add_filter('the_content', array(&$dl_pluginSeries, 'addContent'));
}

/* Runs when plugin is activated */
register_activation_hook(__FILE__,'adsense_made_easy_install');

/* Runs on plugin deactivation*/
register_deactivation_hook( __FILE__, 'adsense_made_easy_remove' );

function adsense_made_easy_install() {
/* Creates new database field */
add_option("adsense_made_easy_publisherid", '', '', 'yes');
add_option("adsense_made_easy_bordercolor", 'FFFFFF', '', 'yes');
add_option("adsense_made_easy_titlecolor", '0000FF', '', 'yes');
add_option("adsense_made_easy_backgroundcolor", 'FFFFFF', '', 'yes');
add_option("adsense_made_easy_textcolor", '000000', '', 'yes');
add_option("adsense_made_easy_urlcolor", '008000', '', 'yes');
add_option("adsense_made_easy_topadtype", 'banner', '', 'yes');
add_option("adsense_made_easy_bottomadtype", 'banner', '', 'yes');
add_option("adsense_made_easy_displayposts", 'yes', '', 'yes');
add_option("adsense_made_easy_displaypages", 'yes', '', 'yes');
}

function adsense_made_easy_remove() {
/* Deletes the database field */

}


if ( is_admin() ){

/* Call the html code */
add_action('admin_menu', 'adsense_made_easy_admin_menu');

function adsense_made_easy_admin_menu() {
add_options_page('Adsense Made Easy', 'Adsense Made Easy', 'administrator',
'adsense-made-easy-best-simple-ad-inserter', 'adsense_made_easy_page');
}
}

?>
<?php
function adsense_made_easy_page() {
?>
<div>
<h2>Adsense Made Easy - Settings</h2>

<form method="post" action="options.php">
<?php wp_nonce_field('update-options'); ?>

<table width="850">
<tr valign="top">
<th width="250" scope="row">Enter your Google Adsense Publisher ID</th>
<td width="600">
<input name="adsense_made_easy_publisherid" type="text" id="adsense_made_easy_publisherid" value="<?php echo get_option('adsense_made_easy_publisherid'); ?>" /> (For example: pub-1234567891234567 )</td>
</tr>
</table>

<table width="850">
<tr valign="top">
<th width="250" scope="row">Top add type </th>
<td width="600">
<select name="adsense_made_easy_topadtype" id="adsense_made_easy_topadtype">
<option value="square" <?php if (get_option('adsense_made_easy_topadtype')=='square') echo ' selected ' ?> >Square</option>
<option value="banner" <?php if (get_option('adsense_made_easy_topadtype')=='banner') echo ' selected ' ?> >Banner (horizontal)</option>
<option value="rectangle" <?php if (get_option('adsense_made_easy_topadtype')=='rectangle') echo ' selected ' ?> >Big Rectangle</option>
<option value="none" <?php if (get_option('adsense_made_easy_topadtype')=='none') echo ' selected ' ?> >None (No add will be shown)</option>
</select> Do you want the top add to be a left alligned square or a centered horizontal banner or a big rectangle?
</td>
</tr>
</table>

<table width="850">
<tr valign="top">
<th width="250" scope="row">Bottom add type </th>
<td width="600">
<select name="adsense_made_easy_bottomadtype" id="adsense_made_easy_bottomadtype">
<option value="banner" <?php if (get_option('adsense_made_easy_bottomadtype')=='banner') echo ' selected ' ?> >Banner (horizontal)</option>
<option value="square" <?php if (get_option('adsense_made_easy_bottomadtype')=='square') echo ' selected ' ?> >Square (little less big then Rectangle)</option>
<option value="rectangle" <?php if (get_option('adsense_made_easy_bottomadtype')=='rectangle') echo ' selected ' ?> >Big Rectangle</option>
<option value="none" <?php if (get_option('adsense_made_easy_bottomadtype')=='none') echo ' selected ' ?> >None (No add will be shown)</option>
</select> Do you want the bottom add to be a centered horizontal banner or a square or a big rectangle?
</td>
</tr>
</table>

<table width="850">
<tr valign="top">
<th width="250" scope="row">Display adds on posts? </th>
<td width="600">
<select name="adsense_made_easy_displayposts" id="adsense_made_easy_displayposts">
<option value="yes" <?php if (get_option('adsense_made_easy_displayposts')=='yes') echo ' selected ' ?> >yes</option>
<option value="no" <?php if (get_option('adsense_made_easy_displayposts')=='no') echo ' selected ' ?> >no</option>
</select>
</td>
</tr>
</table>
<table width="850">
<tr valign="top">
<th width="250" scope="row">Display adds on pages? </th>
<td width="600">
<select name="adsense_made_easy_displaypages" id="adsense_made_easy_displaypages">
<option value="yes" <?php if (get_option('adsense_made_easy_displaypages')=='yes') echo ' selected ' ?> >yes</option>
<option value="no" <?php if (get_option('adsense_made_easy_displaypages')=='no') echo ' selected ' ?> >no</option>
</select>
</td>
</tr>
</table>
<script type="text/javascript" src="<?php bloginfo( 'wpurl' ); ?>
/wp-content/plugins/adsense-made-easy-best-simple-ad-inserter/jscolor.js"></script>
<BR><BR>
<table width="850">
<tr valign="top">
<th width="250" scope="row">Bordercolor of the adds</th>
<td width="600">
<input class="color" name="adsense_made_easy_bordercolor" type="text" id="adsense_made_easy_bordercolor" value="<?php echo get_option('adsense_made_easy_bordercolor'); ?>" /></td>
</tr>
</table>
<table width="850">
<tr valign="top">
<th width="250" scope="row">Titlecolor (Link) of the adds</th>
<td width="600">
<input class="color" name="adsense_made_easy_titlecolor" type="text" id="adsense_made_easy_titlecolor" value="<?php echo get_option('adsense_made_easy_titlecolor'); ?>" /></td>
</tr>
</table>
<table width="850">
<tr valign="top">
<th width="250" scope="row">Backgroundcolor of the adds</th>
<td width="600">
<input class="color" name="adsense_made_easy_backgroundcolor" type="text" id="adsense_made_easy_backgroundcolor" value="<?php echo get_option('adsense_made_easy_backgroundcolor'); ?>" /></td>
</tr>
</table>
<table width="850">
<tr valign="top">
<th width="250" scope="row">Textcolor of the adds</th>
<td width="600">
<input class="color" name="adsense_made_easy_textcolor" type="text" id="adsense_made_easy_textcolor" value="<?php echo get_option('adsense_made_easy_textcolor'); ?>" /></td>
</tr>
</table>
<table width="850">
<tr valign="top">
<th width="250" scope="row">URLcolor of the adds </th>
<td width="600">
<input class="color" name="adsense_made_easy_urlcolor" type="text" id="adsense_made_easy_urlcolor" value="<?php echo get_option('adsense_made_easy_urlcolor'); ?>" /></td>
</tr>
</table>


<input type="hidden" name="action" value="update" />
<input type="hidden" name="page_options" value="adsense_made_easy_publisherid, adsense_made_easy_bordercolor, adsense_made_easy_titlecolor, adsense_made_easy_backgroundcolor, adsense_made_easy_textcolor, adsense_made_easy_urlcolor, adsense_made_easy_topadtype, adsense_made_easy_bottomadtype, adsense_made_easy_displayposts, adsense_made_easy_displaypages" />

<p>
<input type="submit" value="<?php _e('Save Changes') ?>" />
</p>

</form>
</div>
<BR><BR>
<?php
}
?>