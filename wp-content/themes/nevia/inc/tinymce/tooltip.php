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
	<title>Nevia</title>
    <link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/inc/css/tinymce.css" type="text/css" media="screen" />
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo site_url(); ?>/wp-includes/js/tinymce/tiny_mce_popup.js?v=3211"></script>
    <script type="text/javascript" >
    tinyMCEPopup.requireLangPack();

    var puremceDialog = {
        local_ed : 'ed',
        init : function(ed) {
            puremceDialog.local_ed = ed;
            var f = document.forms[0];
            output = '';
        },

        insert : function() {

            var title = jQuery('input.text').val();
            var url = jQuery('input.url').val();

            output = '[tooltip title="'+title+'" url="'+url+'"]'+ puremceDialog.local_ed.selection.getContent() + ' [/tooltip] ';

                    // Insert the contents from the input into the document
                    tinyMCEPopup.editor.execCommand('mceInsertContent', false, output);
                    tinyMCEPopup.close();
                }
            };

            tinyMCEPopup.onInit.add(puremceDialog.init, puremceDialog);
            </script>
        </head>
        <body>

            <form onsubmit="puremceDialog.insert();return false;" action="#">
                <div class="dialogbox">
                    <div class="tabcont">
                        <h3>Tooltip</h3>
                        <p>
                            <label>Tooltip text</label>
                            <input class="text" name="text" type="text" />
                        </p>
                        <p>
                            <label>URL:</label>
                            <input class="url" name="url" type="text"/>
                        </p>

                    </div>

                </div>
                <div class="mceActionPanel">
                    <input type="button" id="insert" name="insert" value="{#insert}" onclick="puremceDialog.insert();" />
                    <input type="button" id="cancel" name="cancel" value="{#cancel}" onclick="tinyMCEPopup.close();" />
                </div>
            </form>

        </body>
        </html>
