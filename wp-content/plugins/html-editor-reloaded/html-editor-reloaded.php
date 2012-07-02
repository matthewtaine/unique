<?php

/*
Plugin Name: HTML Editor Reloaded
Plugin URI: http://uniquemethod.com/projects/html-editor-reloaded
Description: Add custom buttons to the HTML editor toolbar and full tabbing functionality.
Version: 1.1
Author: Unique Method
Author URI: http://uniquemethod.com
*/



new html_editor();



class html_editor {
	
	
	
	function html_editor() {
		
		if (is_admin()) {
		
			// load js files and dependencies
			wp_enqueue_script('script', WP_PLUGIN_URL.'/'.plugin_basename(dirname(__FILE__)).'/js/script.min.js', array('jquery','jquery-ui-sortable'), false, false);
			wp_enqueue_script('taboverride', WP_PLUGIN_URL.'/'.plugin_basename(dirname(__FILE__)).'/js/jquery.taboverride-1.0.min.js', array('jquery'), false, false);
			
			// on activation
			register_activation_hook(__FILE__, array($this, 'activate_plugin'));
			
			// on deactivation
			register_deactivation_hook(__FILE__, array($this, 'deactivate_plugin'));
			
			// add settings link to plugin page
			add_filter('plugin_action_links_'.plugin_basename(__FILE__), array($this, 'plugin_actions'));
			
			// add plugin menu options
			add_action('admin_menu',  array($this, 'plugin_menu'));
									
			// add code to the footer section of admin pages
			add_action('admin_print_footer_scripts', array($this, 'admin_footer'));			
			
		}
		
	}
	
	
	
	// on activation
	function activate_plugin() {
		$defaults = array(
				'label'		=> array('h1','h2','h3'),
				'before'	=> array('<h1>','<h2>','<h3>'),
				'after'		=> array('</h1>\n','</h2>\n','</h3>\n'),
				'shortcut'	=> array('1','2','3')
			);
		
		add_option('html_editor_reloaded', $defaults );
	}
	
	
	
	// on deactivation
	function deactivate_plugin() {
		delete_option('html_editor_reloaded');
	}
	
	
	
	// add settings link to plugin page
	function plugin_actions($links) {
		// before deativate link
		//$links[] = '<a href="options-general.php?page=html-editor-reloaded">' . __('Settings') . '</a>';
		//return $links;
		
		// after deactive link
		array_unshift($links, '<a href="options-general.php?page=html-editor-reloaded">' . __('Settings') . '</a>');
		return $links;
	}
	
	
	
	// add plugin menu options
	function plugin_menu() {
		add_options_page('HTML Editor', 'HTML Editor', 'manage_options', 'html-editor-reloaded', array($this, 'manage_html_editor'));
	}
	
	
	
	// add code to the footer section of admin pages
	function admin_footer() {
		?>
		<script>
		<?php
		
		// update HTML Editor with custom buttons
		$options = get_option('html_editor_reloaded');
				
		for ( $i = 0; $i < count($options['label']); $i++ ) {
		
			?>
			QTags.addButton('hed_<?php echo $i; ?>',
				'<?php echo str_replace('"','&quot;',$options['label'][$i]); ?>',
				'<?php echo str_replace('"','\"',$options['before'][$i]); ?>',
				'<?php echo str_replace('"','\"',$options['after'][$i]); ?>',
				'<?php echo str_replace('"','&quot;',$options['shortcut'][$i]); ?>');
			<?php
			
		}
		
		?>
		
		QTags.addButton('hed_tabs', 'disable tabs', '', '');
		
		</script>
		<?php
	}
	
	
	
	// manage html editor options
	function manage_html_editor() {
	
		// import backup
		if ( isset($_POST['hed-import-buttons']) ) {
		
			$options = get_option('html_editor_reloaded');
			$data = maybe_unserialize( stripslashes_deep( $_POST['hed_import'] ) );
			$backup = array();
			
			// merge imported buttons with existing buttons
			if ( !empty($data) &&  $_POST['hed_overwrite'] != 1 ) {
				update_option('html_editor_reloaded', $backup);
				$backup['label'] = array_merge( (array)$options['label'], (array)$data['label'] );
				$backup['before'] = array_merge( (array)$options['before'], (array)$data['before'] );
				$backup['after'] = array_merge( (array)$options['after'], (array)$data['after'] );
				$backup['shortcut'] = array_merge( (array)$options['shortcut'], (array)$data['shortcut'] );
			}
			else if ( !empty($data) && $_POST['hed_overwrite'] == 1 ) {
				update_option('html_editor_reloaded', $backup);
				$backup['label'] = $data['label'];
				$backup['before'] = $data['before'];
				$backup['after'] = $data['after'];
				$backup['shortcut'] = $data['shortcut'];
			}
			
			// display success or error message
			if ( !empty($data) && update_option('html_editor_reloaded', $backup) ) {
				echo '<div class="updated"><p><strong>Buttons imported.</strong></p></div>';
			}
			else {
				echo '<div class="error"><p><strong>Import error.</strong></p></div>';
			}
			
		}
		
		// get buttons
		$options = get_option('html_editor_reloaded');
		
        ?>
        
		<div class="wrap" style="max-width:850px;">
		
			<?php screen_icon(); ?>
			<h2><?php _e('HTML Editor Settings'); ?> <a href="" class="hed-add-tp button add-new-h2"><?php _e('New Button') ?></a></h2>
			
			<p><?php _e('Add custom buttons to the HTML editor toolbar and easily reorder them by dragging and dropping the rows below. Full tabbing functionality is also enabled by default which can be disabled or re-enabled directly on the toolbar.'); ?></p>
			
			<form method="post" action="options.php">
			<?php wp_nonce_field('update-options'); ?>
						
				<table id="hed-table" class="form-table">
				
					<thead>
						<tr valign="top">
							<th scope="row"></th>
							<th scope="row"><?php _e('Button Label') ?></th>
							<th scope="row"><?php _e('Insert Before') ?></th>
							<th scope="row"><?php _e('Insert After') ?></th>
							<th scope="row"><?php _e('Shortcut Key') ?></th>
							<th scope="row"></th>
						</tr>
					</thead>
					
					<tbody>
					
						<?php for ( $i = 0; $i < count($options['label']); $i++ ) { ?>
						<tr valign="top">
							<td class="submit"><input type="submit" class="hed-add" value="<?php _e('+') ?>" /></td>
							<td><input type="text" name="html_editor_reloaded[label][]" value="<?php echo htmlentities($options['label'][$i], ENT_QUOTES); ?>" /></td>
							<td><input type="text" name="html_editor_reloaded[before][]" value="<?php echo htmlentities($options['before'][$i], ENT_QUOTES); ?>" /></td>
							<td><input type="text" name="html_editor_reloaded[after][]" value="<?php echo htmlentities($options['after'][$i], ENT_QUOTES); ?>" /></td>
							<td><input type="text" name="html_editor_reloaded[shortcut][]" value="<?php echo htmlentities($options['shortcut'][$i], ENT_QUOTES); ?>" /></td>
							<td class="submit"><input type="submit" class="hed-delete" value="<?php _e('Delete') ?>" /></td>
						</tr>
						<?php } ?>
						
					</tbody>
					
				</table>
				
				<p class="description"><br /><?php _e('You can use \t for tabs and \n for new lines. Keyboard shortcuts already in use include '); ?><em><?php _e('strong (b), em (i), href (a), blockquote (q), ins (s), img (m), ul (u), ol (o), li (l), code (c), more (t), fullscreen (f), and publish (p).'); ?></em></p>
				
				<input type="hidden" name="action" value="update" />
				<input type="hidden" name="page_options" value="html_editor_reloaded" />
				
				<?php submit_button( 'Save Changes', 'primary', 'hed-save-changes' ); ?>
				
			</form>
			
			<div class="form-wrap">
			
				<div class="form-field">
					<label for="hed_export"><?php _e('Export Buttons'); ?></label>
					<textarea id="hed_export" name="hed_export" rows="3" onclick="this.focus(); this.select();"><?php echo esc_textarea( serialize( $options ) ); ?></textarea>
					<p><?php _e('Backup your HTML editor buttons by copying and pasting this data into a saved text file.'); ?></p>
				</div>
				
			</div>
	
			<div class="form-wrap">
			
				<form method="post" action="">
				
				<div class="form-field">
					<label for="hed_import"><?php _e('Import Buttons'); ?></label>
					<textarea id="hed_import" name="hed_import" rows="3"></textarea>
					<p><?php _e('Restore your HTML editor buttons by copying and pasting the data from your backup text file.'); ?></p>
				</div>
				
				<input type="checkbox" name="hed_overwrite" value="1" /> <?php _e('Overwrite the custom buttons above during the import.'); ?>
				
				<?php submit_button( 'Import Buttons', 'secondary', 'hed-import-buttons' ); ?>
										
				</form>
				
			</div>
			
		</div>
		
		<?php
		
	}
	
}

?>