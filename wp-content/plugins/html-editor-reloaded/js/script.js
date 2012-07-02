jQuery(document).ready(function ($) {
	$("#content").tabOverride();
	$("#wp_mce_fullscreen").tabOverride();
	
	$("#qt_content_hed_tabs").live("click", function () {
		if ($(this).attr("value") == "disable tabs") {
			$(this).attr("value", "enable tabs");
			$("#content").tabOverride(false)
			$("#wp_mce_fullscreen").tabOverride(false);
		} else {
			$(this).attr("value", "disable tabs");
			$("#content").tabOverride()
			$("#wp_mce_fullscreen").tabOverride();
		}
	});
		
	$("#hed-table tbody").sortable({
		axis: "y",
		revert: true,
		opacity: 0.6
	}).css("cursor", "move");

	$(".hed-add").live("click", function () {
		$(this).closest("tr").after('<tr valign="top"><td scope="row" class="submit"><input type="submit" class="hed-add" value="+" /></td><td scope="row"><input type="text" name="html_editor_reloaded[label][]" /></td><td scope="row"><input type="text" name="html_editor_reloaded[before][]" /></td><td scope="row"><input type="text" name="html_editor_reloaded[after][]" /></td><td scope="row"><input type="text" name="html_editor_reloaded[shortcut][]" /></td><td scope="row" class="submit"><input type="submit" class="hed-delete" value="Delete" /></td></tr>');
		return false;
	})

	$(".hed-add-tp").click(function () {
		$("#hed-table tbody").prepend('<tr valign="top"><td scope="row" class="submit"><input type="submit" class="hed-add" value="+" /></td><td scope="row"><input type="text" name="html_editor_reloaded[label][]" /></td><td scope="row"><input type="text" name="html_editor_reloaded[before][]" /></td><td scope="row"><input type="text" name="html_editor_reloaded[after][]" /></td><td scope="row"><input type="text" name="html_editor_reloaded[shortcut][]" /></td><td scope="row" class="submit"><input type="submit" class="hed-delete" value="Delete" /></td></tr>');
		return false
	});

	$(".hed-delete").live("click", function () {
		$(this).closest("tr").remove();
		return false;
	})

});
