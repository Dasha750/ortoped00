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
	<title>Tabs creator</title>
    <link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/inc/css/tinymce.css" type="text/css" media="screen" />
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo site_url() ?>/wp-includes/js/tinymce/tiny_mce_popup.js?v=3211"></script>
    <script type="text/javascript" >
    tinyMCEPopup.requireLangPack();


    var TabsDialog = {
        init : function() {
          var f = document.forms[0];
          output = '';
		// Get the selected contents as text and place it in the input
		//f.someval.value = tinyMCEPopup.editor.selection.getContent({format : 'text'});
		jQuery('#newtab').click(function(){
            jQuery('.tabcont:first').clone().addClass('newtab').appendTo('#tabs');
            return false;
        });

        jQuery('.removeTab').live('click', function() {
            if(jQuery('#tabs .tabcont').size() == 1) {
                alert('Sorry, you need at least one element');
            }
            else {
                jQuery(this).parent().slideUp(300, function() {
                    jQuery(this).remove();
                })
            }
            return false;
        });
    },

    insert : function() {

        output = ' [skillbars] ';

        jQuery('.tabcont').each(function(index) {
            var title = $(this).find('.skill-title').val();
            var value = $(this).find('.skill-level option:selected').val();
            output += ' [skillbar title="'+title+'" value="'+value+'"]';
        });
        output += ' [/skillbars] ';
		// Insert the contents from the input into the document
		tinyMCEPopup.editor.execCommand('mceInsertContent', false, output);
		tinyMCEPopup.close();
    }
};

tinyMCEPopup.onInit.add(TabsDialog.init, TabsDialog);

</script>
</head>
<body>

    <form onsubmit="TabsDialog.insert();return false;" action="#">

        <div id="tabs" class="dialogbox">
            <div class="tabcont">
                <h3>Skillbars</h3>
                <p>
                    <label>Skill name</label>
                    <input class="skill-title" name="tab" type="text" class="text" />
                </p>
                <p>
                    <label>Skill level:</label>

                    <select class="skill-level">
                        <?php for ($i=0; $i <= 100 ; $i=$i+5) {  ?>
                            <option value="<?php echo $i ?>"><?php echo $i ?></option>
                        <?php } ?>


                    </select>
                </p>
                <button class="updateButton removeTab">Remove</button>
            </div>

        </div>
        <br/>
        <a href="#" class="button small yellow" id="newtab">Add new skill</a>
        <div class="mceActionPanel">
            <input type="button" id="insert" name="insert" value="{#insert}" onclick="TabsDialog.insert();" />
            <input type="button" id="cancel" name="cancel" value="{#cancel}" onclick="tinyMCEPopup.close();" />
        </div>
    </form>

</body>
</html>
