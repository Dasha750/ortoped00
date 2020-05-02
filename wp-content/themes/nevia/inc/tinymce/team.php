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
            var name = jQuery('input.name').val();
            var job = jQuery('input.job').val();
            var photo = jQuery('input.photo').val();
            var link = jQuery('input.link').val();
            var content = $('.content').val();

            output += ' [team name="'+name+'"  link="'+link+'" job="'+job+'" photo="'+photo+'"] '+ content + ' [/team] ';


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
                <h3>Team member shortcode</h3>
                <p>
                    <label>Name:</label>
                    <input class="name" name="tab" type="text" class="text" />
                </p>
                <p>
                    <label>Job:</label>
                    <input class="job" name="tab" type="text" class="text" />
                </p>
                <p>
                    <label>Photo:</label>
                    <input class="photo" name="tab" type="text" class="text" />
                </p>
                <p>
                    <label>Link:</label>
                    <input class="link" name="tab" type="text" class="text" />
                </p>
                <p>
                    <label>Content:</label>
                    <textarea class="content" name="tab-content" class="text" ></textarea>
                </p>
                 <div class="desc">
                    <p>For the best effect you should put each team shortcode in columns layour. URL is optional, you can just link photo to separate page for member.</p>
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
