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
            jQuery('p.portfolio').hide();

            jQuery('#type').change(function(){
                jQuery("#type option:selected").each(function () {

                 var type = $(this).val();
                 jQuery('p.portfolio,ul.portfolio').hide();
                 jQuery('p.blog').hide();
                 jQuery("p."+type+", ul."+type).show()

             });
            }).change();
        },

        insert : function() {

            var type = jQuery('#type option:selected').val();
            var limit = jQuery('.limit option:selected').val();
            var title = jQuery('.title').val();
            var subtitle = jQuery('.subtitle').val();
            var words = jQuery('.words').val();
            var orderby = jQuery('#orderby option:selected').val();
            var order = jQuery('#order option:selected').val();

            var allVals = [];
            $('.taxonomy:checked').each(function() {
             allVals.push($(this).val());
         });

            var filters = allVals;
            console.log(filters);
            if(filters === ["all"] ) filters ="";
            var carousel = jQuery('#carousel option:selected').val();


            if(type==='blog') {
                output = '[recent_blog limit="'+limit+'" title="'+title+'" subtitle="'+subtitle+'" words="'+words+'" ]';
            } else {
                 output = '[recent_work limit="'+limit+'" title="'+title+'" orderby="'+orderby+'" order="'+order+'" carousel="'+carousel+'" filters="'+filters+'"] ';
             }

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
                        <h3>Recent blog/portfolio</h3>
                        <p>
                            <label>Type:</label>
                            <select id="type">
                                <option value="blog">Blog</option>
                                <option value="portfolio">Portfolio</option>
                            </select>
                        </p>
                        <p>
                            <label>Limit items:</label>
                            <select class="limit">
                                <?php for ($i=2; $i <= 12 ; $i++) {  ?>
                                <option value="<?php echo $i ?>"><?php echo $i ?></option>
                                <?php } ?>

                            </select>
                        </p>
                        <p class="blog portfolio">
                            <label>Title</label>
                            <input class="title" name="tab" type="text" class="text" />
                        </p>
                        <p  class="blog">
                            <label>Subtitle</label>
                            <input class="subtitle" name="tab" type="text" class="text" />
                        </p>


                        <p class="blog">
                            <label>Words limit</label>
                            <input class="words" value="15" name="tab" type="text" class="text" />
                            <br/><small>Put number of words after content will be cut off</small>
                        </p>
                        <p class="portfolio">
                            <label>Orderby:</label>
                            <select id="orderby">
                                <option value="date"> Order by date.</option>
                                <option value="ID">Order by post id</option>
                                <option value="author">Order by author.</option>
                                <option value="title"> Order by title.</option>
                                <option value="name">Order by post name (post slug).</option>
                                <option value="modified"> Order by last modified date.</option>
                                <option value="parent"> Order by post/page parent id.</option>
                                <option value="rand">Random order.</option>
                            </select>
                        </p>
                        <p class="portfolio">
                            <label>Order:</label>
                            <select id="order">
                                <option value="DESC">Descending order.</option>
                                <option value="ASC">Ascending order.</option>

                            </select>
                        </p>
                        <p class="portfolio">
                            <label>Filters:</label>

                            <?php  $taxonomies = get_categories( array( 'hide_empty' => false, 'taxonomy' => 'filters' ) );
                            if ( $taxonomies ) {
                              $count = 1;
                              echo "<ul class='taxcheck portfolio'>";
                              echo '<li><input type="checkbox" class="taxonomy" name="taxonomy" id="taxonomy-0" value="all"><label for="taxonomy-0">All</label></li>';
                              foreach( $taxonomies as $taxonomy ) {
                                echo "<li>";
                                echo '<input type="checkbox" class="taxonomy" name="taxonomy" id="taxonomy-' . esc_attr( $count ) . '" value="' . esc_attr( $taxonomy->slug ) . '" />';
                                echo '<label for="taxonomy-' . esc_attr( $count ) . '">' . esc_attr( $taxonomy->name ) . '</label>';
                                echo "</li>";
                                $count++;
                            }
                            echo "</ul>";
                        } else {
                          echo '<p>' . __( 'No Taxonomies Found', 'option-tree' ) . '</p>';
                      } ?>

                  </p>
                  <p class="portfolio">
                    <label>Carousel:</label>
                    <select id="carousel">
                        <option value="yes">Display as carousel.</option>
                        <option value="no">Just as columns.</option>

                    </select>
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
