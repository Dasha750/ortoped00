<?php
// Call WP Load
$wp_include = "../wp-load.php";$i = 0;
while (!file_exists($wp_include) && $i++ < 10) {$wp_include = "../$wp_include";} require($wp_include);
if ( !is_user_logged_in() || !current_user_can('edit_posts') )
	wp_die(__("You are not allowed to be here","purepress"));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Notice box creator</title>
    <link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/inc/css/tinymce.css" type="text/css" media="screen" />
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo site_url(); ?>/wp-includes/js/tinymce/tiny_mce_popup.js?v=3211"></script>
    <script type="text/javascript" >
    tinyMCEPopup.requireLangPack();


    var AccordionDialog = {
        init : function() {
          var f = document.forms[0];
          output = '';
		// Get the selected contents as text and place it in the input
		//f.someval.value = tinyMCEPopup.editor.selection.getContent({format : 'text'});
    },
    insert : function() {
            var title = jQuery('input.title').val();
            var subtitle = jQuery('input.subtitle').val();
            var limit = jQuery('.limit option:selected').val();

            output += ' [testimonials title="'+title+'"  subtitle="'+subtitle+'" limit="'+limit+'"] ';

		// Insert the contents from the input into the document
		tinyMCEPopup.editor.execCommand('mceInsertContent', false, output);
		tinyMCEPopup.close();
    }
};

tinyMCEPopup.onInit.add(AccordionDialog.init, AccordionDialog);

</script>
</head>
<body>

    <form onsubmit="AccordionDialog.insert();return false;" action="#">
        <div class="dialogbox"  id="tabs">
            <div class="tabcont">
                <h3>Testimonials</h3>
                <p>
                    <label>Title:</label>
                    <input class="title" name="title" type="text" class="text" value="Testimonials" />
                </p>
                <p>
                    <label>Subtitle</label>
                    <input class="subtitle" name="subtitle" type="text" class="text" value=" / What Our Clients Say" />
                </p> <p>
                    <label>Limit</label>
                    <select class="limit">
                                <?php for ($i=2; $i <= 12 ; $i++) {  ?>
                                <option value="<?php echo $i ?>"><?php echo $i ?></option>
                                <?php } ?>
                    </select>
                </p>
                <div class="desc">
                        <p>The testimonials should be added in wp-admin -> Testimonials (it's custom post type)</p>
                    </div>
            </div>

        </div>
        <div class="mceActionPanel">
            <input type="button" id="insert" name="insert" value="{#insert}" onclick="AccordionDialog.insert();" />
            <input type="button" id="cancel" name="cancel" value="{#cancel}" onclick="tinyMCEPopup.close();" />
        </div>
    </form>

</body>
</html>
