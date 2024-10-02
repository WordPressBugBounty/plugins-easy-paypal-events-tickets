<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_action('init', 'wpeevent_button_media_buttons_init');

function wpeevent_button_media_buttons_init() {
	global $pagenow, $typenow;

	// add media button for editor page
	if ( in_array( $pagenow, array( 'post.php', 'page.php', 'post-new.php', 'post-edit.php' ) ) && $typenow != 'download' ) {
		
		add_action('admin_footer', 'wpeevent_button_add_inline_popup_content');
		add_action('media_buttons', 'wpeevent_button_add_my_media_button', 20);
		
		// button
		function wpeevent_button_add_my_media_button() {
			echo '<a href="#TB_inline?width=600&height=500&inlineId=wpeevent_popup_container" title="Insert a PayPal Event Button" id="insert-my-media" class="button thickbox">PayPal Events</a>';
		}
		
		// popup
		function wpeevent_button_add_inline_popup_content() {
		?>
		
			
		<script type="text/javascript">
			function wpeevent_button_InsertShortcode() {
			
				var id = document.getElementById("wpeevent_button_id").value;
				
				if(id == "No buttons found.") { alert("Error: Please select an existing button from the dropdown or make a new one."); return false; }
				if(id == "") { alert("Error: Please select an existing button from the dropdown or make a new one."); return false; }
				
				window.send_to_editor('[wpeevent id="' + id + '"]');
				
				document.getElementById("wpeevent_button_id").value = "";
				wpeevent_alignmentc.selectedIndex = null;
			}
		</script>

		
		<div id="wpeevent_popup_container" style="display:none;">
		
		
			<h2>Insert a PayPal Event Button</h2>

			<table><tr><td>
			
			Choose an existing Event: </td></tr><tr><td>
			<select id="wpeevent_button_id" name="wpeevent_button_id">
				<?php
				$args = array('post_type' => 'wpplugin_evt_button','posts_per_page' => -1);

				$posts = get_posts($args);

				$count = "0";
				
				if (isset($posts)) {
					
					foreach ($posts as $post) {

						$id = $posts[$count]->ID;
						$post_title = $posts[$count]->post_title;

                        printf('<option value="%d">Name: %s</option>',
                            esc_attr($id),
                            esc_html($post_title)
                        );

						$count++;
					}
				}
				else {
					echo "<option>No buttons found.</option>";
				}
				
				?>
			</select>
			</td></tr><tr><td>
			Make a new Event: <a target="_blank" href="admin.php?page=wpeevent_buttons&action=new">here</a><br />
			Manage existing Event: <a target="_blank" href="admin.php?page=wpeevent_buttons">here</a>
			
			</td></tr><tr><td>
			<br />
			</td></tr><tr><td>
			
			<input type="button" id="wpeevent-paypal-insert" class="button-primary" onclick="wpeevent_button_InsertShortcode();" value="Insert Button">		
			
			</td></tr></table>
		</div>
		<?php
		}
	}
}