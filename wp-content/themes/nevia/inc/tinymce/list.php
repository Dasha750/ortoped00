<?php
// Call WP Load
$wp_include = "../wp-load.php";
$i = 0;
while (!file_exists($wp_include) && $i++ < 10) {
    $wp_include = "../$wp_include";
} require
($wp_include);
if ( !is_user_logged_in() || !current_user_can('edit_posts') )
    wp_die(__("You are not allowed to be here","purepress"));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Lists generator</title>
       <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/inc/css/tinymce.css" type="text/css" media="screen" />
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo site_url() ?>/wp-includes/js/tinymce/tiny_mce_popup.js?v=3211"></script>
    <script type="text/javascript" >
    tinyMCEPopup.requireLangPack();


    var ListsDialog = {
        local_ed : 'ed',
        init : function(ed) {
            ListsDialog.local_ed = ed;
            var f = document.forms[0];
            output = '';
                    // Get the selected contents as text and place it in the input
                    //f.someval.value = tinyMCEPopup.editor.selection.getContent({format : 'text'});
                    jQuery('#selector').change(function(){
                        jQuery("#selector option:selected").each(function () {
                         var style = $(this).val();
                         jQuery("ul.list").attr('class', 'purelist').addClass(style);
                     });
                    }).change();

                },

                insert : function() {

                    var choosedStyle = jQuery('#selector option:selected').val();

                    output = ' [list type="'+choosedStyle+'"]'+ ListsDialog.local_ed.selection.getContent() + ' [/list] ';

                    // Insert the contents from the input into the document
                    tinyMCEPopup.editor.execCommand('mceInsertContent', false, output);
                    tinyMCEPopup.close();
                }
            };

            tinyMCEPopup.onInit.add(ListsDialog.init, ListsDialog);

            </script>
        </head>
        <body>

            <form onsubmit="ListsDialog.insert();return false;" action="#">
               <div class="dialogbox"  id="lists">

                    <h3>Choose list style</h3>
                    <p>
                        <label>List style:</label>
                        <select id="selector">check, star, plus, sign
                            <option value="check">Check</option>
                            <option value="plus">Plus</option>
                            <option value="sign">Sign</option>
                            <option value="star">Star</option>
                        </select>

                    </p>
                    <div class="desc">
                        <ul style="list-style:none; margin:0px; padding:0px;">
                            <li> <img src="<?php echo get_template_directory_uri(); ?>/inc/tinymce/images/icon-list-check.png"> Check </li>
                            <li> <img src="<?php echo get_template_directory_uri(); ?>/inc/tinymce/images/icon-list-plus.png"> Plus </li>
                            <li> <img src="<?php echo get_template_directory_uri(); ?>/inc/tinymce/images/icon-list-sign.png"> Sign </li>
                            <li> <img src="<?php echo get_template_directory_uri(); ?>/inc/tinymce/images/icon-list-star.png"> Star </li>
                        </ul>
                    </div>
                </div>

                <div class="mceActionPanel">
                    <input type="button" id="insert" name="insert" value="{#insert}" onclick="ListsDialog.insert();" />
                    <input type="button" id="cancel" name="cancel" value="{#cancel}" onclick="tinyMCEPopup.close();" />
                </div>
            </form>

        </body>
        </html>
