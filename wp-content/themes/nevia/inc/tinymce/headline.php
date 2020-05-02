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

            var margin = jQuery('#margin option:selected').val();
            var type = jQuery('#type option:selected').val();

            output = ' [headline margin="'+margin+'" type="'+type+'"]'+ puremceDialog.local_ed.selection.getContent() + ' [/headline] ';

                    // Insert the contents from the input into the document
                    tinyMCEPopup.editor.execCommand('mceInsertContent', false, output);
                    tinyMCEPopup.close();
                }
            };

            tinyMCEPopup.onInit.add(puremceDialog.init, puremceDialog);
            </script>
        </head>
        <body>

            <form onsubmit="HeadlineDialog.insert();return false;" action="#">
                <div class="dialogbox">
                    <div class="tabcont">
                        <h3>Headline</h3>
                        <p>
                            <label>Margin:</label>
                            <select id="margin">
                                <option value="margin-reset">margin-reset</option>
                                <option value="margin-down">margin-down</option>
                                <option value="margin-both">margin-both</option>
                            </select>
                        </p>
                        <p>
                            <label>Type:</label>
                            <select id="type">
                                <option value="h2">H2</option>
                                <option value="h3">H3</option>
                                <option value="h4">H4</option>
                                <option value="h5">H5</option>
                            </select>
                        </p>
                        <div class="desc">
                            This shorcode helps you to set/remove some distance from header.
                            <ul>
                                <li><strong>margin-reset</strong> moves header up 10px </li>
                                <li><strong>margin-down</strong> set 15px space below header</li>
                                <li><strong>margin-both</strong> set 15px space below header and 10px above</li>
                            </ul>
                        </div>
                    </div>

                </div>
                <div class="mceActionPanel">
                    <input type="button" id="insert" name="insert" value="{#insert}" onclick="puremceDialog.insert();" />
                    <input type="button" id="cancel" name="cancel" value="{#cancel}" onclick="tinyMCEPopup.close();" />
                </div>
            </form>

        </body>
        </html>
