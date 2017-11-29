<?php
/*
* Plugin Name: Remove Footer Credit
* Version: 1.0
* Description: A simple plugin to remove footer credits
* Author: Macho Themes
* Author URI: https://www.machothemes.com/
* License: GPLv3 or later
* Text Domain: remove-footer-credit
*/

/*
Copyright 2017 Macho Themes

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

//Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
* Add a submenu under Tools
*/
function jabrfc_admin_menu() {
	$page = add_submenu_page( 'tools.php', 'Remove Footer Credit', 'Remove Footer Credit', 'activate_plugins', 'remove-footer-credit', 'jabrfc_options_page' );
}

function jabrfc_admin_enqueue_scripts( $hook ) {

	if ( 'tools_page_remove-footer-credit' != $hook ) {
		return;
	}

	wp_enqueue_style( 'jabrfc-styles', plugin_dir_url( __FILE__ ) . 'assets/css/admin.css' );

}

function jabrfc_options_page() {
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$_POST = stripslashes_deep( $_POST );

		$data = array(
			'find'  => explode("\n", str_replace("\r", "", $_POST['find'])),
			'replace'  => explode("\n", str_replace("\r", "", $_POST['replace'])),
			'willLinkback' => $_POST['willLinkback'],
			'linkbackPostId' => $_POST['linkbackPostId']
		);

		update_option( 'jabrfc_text', $data );

		echo '<div id="message" class="updated fade">';
			echo '<p><strong>Settings Saved</strong></p>';
		echo '</div>';
	}


?>

<div class="wrap" style="padding-bottom:5em;">
	<h2>Remove Footer Credit</h2>


	<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>" class="settings-form">
		<p><strong>Need help removing your footer credit? Or need WordPress help? Send me a message <a href="https://upwerd.com/#help">here</a> and I will get back to you within 24 hours. <span style="font-size: 30px;line-height: 1;color:#ffcc4d;text-shadow: 1px 0 0 #000, 0 -1px 0 #000, 0 1px 0 #000, -1px 0 0 #000;">&#9787;</span></strong></p>

		<?php $data = get_option( 'jabrfc_text' ); ?>
		<?php $replace = ""; if ($data['replace'])  $replace = implode("\n",$data['replace']); ?>
		<?php $willLinkback = "no"; if ($data['willLinkback'])  $willLinkback = $data['willLinkback']; ?>
		<?php $linkbackPostId = ""; if ($data['linkbackPostId'])  $linkbackPostId = $data['linkbackPostId']; ?>

		<h3>Step 1: Enter text/HTML to remove (one per line)</h3>
		<p><textarea name="find" id="find" class="small-text code" rows="6" style="width: 100%;"><?php if ($data['find']) echo htmlentities(implode("\n",$data['find'])); ?></textarea></p>
		<h3>Step 2: Enter your own footer credit (one per line)</h3>
		<?php wp_editor( $replace, 'replace', $settings = array('quicktags' => true, 'wpautop' => false,'editor_height' => '100', 'teeny' => false) ); ?>
		<h3>Step 3: Please support my work and spread the word (optional)</h3>
		<p>Help keep this plugin free by providing one link back at the bottom of one of your posts/pages.</p>
		<label><input type="radio" name="willLinkback" value="no" class="js-linkback" <?php if ($willLinkback == 'no') echo 'checked="checked"' ?>> No, thanks.</label><br>
		<label><input type="radio" name="willLinkback" value="yes" class="js-linkback" <?php if ($willLinkback == 'yes') echo 'checked="checked"' ?>> Yes, I will support you!</label>

		<div class="js-linkback-panel" style="<?php if ($willLinkback == 'no') echo 'display: none;' ?> margin-top: 15px;">
			<?php $post_args = array(
				'posts_per_page'   => -1,
				'orderby'          => 'title',
				'order'            => 'asc',
				'post_type'        => 'post',
				'post_status'      => 'publish',
				'suppress_filters' => true
			);
			$page_args = array(
				'posts_per_page'   => -1,
				'orderby'          => 'title',
				'order'            => 'asc',
				'post_type'        => 'page',
				'post_status'      => 'publish',
				'suppress_filters' => true
			);
			$posts_array = get_posts( $post_args );
			$pages_array = get_posts( $page_args );
			?>
			<strong>Select a post/page:</strong><br>
			<select name="linkbackPostId" style="margin-bottom: 15px;">
				<?php if (sizeof($posts_array) > 0) { ?>
					<option disabled>-- Posts --</option>
					<?php foreach ($posts_array as $item) { ?>
					<option value="<?php echo $item->ID ?>" <?php if ($linkbackPostId == $item->ID) echo 'selected=selected'?>><?php echo $item->post_title ?></option>
					<?php } ?>
				<?php } ?>
				<?php if (sizeof($pages_array) > 0) { ?>
					<option disabled>-- Pages --</option>
					<?php foreach ($pages_array as $item) { ?>
						<option value="<?php echo $item->ID ?>" <?php if ($linkbackPostId == $item->ID) echo 'selected=selected'?>><?php echo $item->post_title ?></option>
					<?php } ?>
				<?php } ?>
			</select>

			<div>
				<strong>The text below will appear at the bottom of the selected post/page.</strong><br>
				Get WordPress help, plugins and tips at <a href="https://upwerd.com">upwerd.com</a>.
			</div>
		</div>
		<div style="margin-top: 20px;">
			<input type="submit" class="button" value="Save" />
		</div>
	</form>
	<div class="col-fulwidth feedback-box">
  <h3>
    <?php esc_html_e( 'Lend a hand & share your thoughts', 'saboxplugin' ); ?>
	    <img src="<?php echo plugin_dir_url( __FILE__ ) . 'assets/images/handshake.png' ?>"> 
	  </h3>
	  <p>
	    <?php
	    echo vsprintf(
	      // Translators: 1 is Theme Name, 2 is opening Anchor, 3 is closing.
	      __( 'We\'ve been working hard on making %1$s the best one out there. We\'re interested in hearing your thoughts about %1$s and what we could do to <u>make it even better</u>.<br/> <br/> %2$sHave your say%3$s', 'sb-pack' ),
	      array(
	        'Remove Footer Credit',
	        '<a class="button button-hero" target="_blank" href="http://bit.ly/feedback-remove-footer-credit">',
	        '</a>',
	      )
	    );
	    ?>
	  </p>
	</div>
	<div class="get-help">
		<h3>Get Help</h3>
		<p>Need help using this plugin or want to report a bug? Contact me <a href="https://upwerd.com/#help">here</a>.</p>
		<hr>
		<h3>Learn</h3>
		<p><a href="https://upwerd.com/remove-footer-credit/">Click here</a> to view instructions on how to use this plugin.</p>

	</div>
	<br>

</div>
	<script>
		jQuery('.js-linkback').change(function() {
			jQuery('.js-linkback-panel').toggle();
		});

	</script>

<?php }

/*
* Apply find and replace rules
*/
function jabrfc_ob_call( $buffer ) { // $buffer contains entire page

	$data = get_option( 'jabrfc_text' );
	if ( is_array( $data['find']) ) {
		$i = 0;
		foreach ( $data['find'] as &$value ) {
			$buffer = str_replace( $value, (array_key_exists($i, $data['replace']) ? $data['replace'][$i] : ''), $buffer );
			$i++;
		}
	}
	return $buffer;
}

function jabrfc_template_redirect() {
	ob_start();
	ob_start( 'jabrfc_ob_call' );
}

function jabrfc_the_content($content) {
	global $post;
	$data = get_option( 'jabrfc_text' );
	if ( $data['willLinkback'] == 'yes' && is_singular() && $data['linkbackPostId'] == $post->ID ) {
		$content = $content . '<p>Get WordPress help, plugins and tips at <a href="https://upwerd.com?s=rfc">upwerd.com</a>.</p>';
	}
	return $content;
}

add_filter( 'the_content', 'jabrfc_the_content' );

// Add style
add_action( 'admin_enqueue_scripts', 'jabrfc_admin_enqueue_scripts' );

//Add left menu item in admin
add_action( 'admin_menu', 'jabrfc_admin_menu' );

//Handles find and replace for public pages
add_action( 'template_redirect', 'jabrfc_template_redirect' );