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
            //var choosedStyle = jQuery('#selector option:selected').val();
            var columns = jQuery('#columns option:selected').val();
            var icon = jQuery('#icon option:selected').val();
            var title = jQuery('input.title').val();
            var url = jQuery('input.url').val();

            output = '[iconbox column="'+columns+'" icon="'+icon+'" title="'+title+'" link="'+url+'"]'+ puremceDialog.local_ed.selection.getContent() + ' [/iconbox] ';

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
                        <h3>Feature box</h3>
                        <p>
                            <label>Column</label>
                            <select id="columns">
                                <option value="one-third">One third</option>
                                <option value="two-third">Two third</option>
                                <option value="one">One</option>
                                <option value="two">Two</option>
                                <option value="three">Three</option>
                                <option value="four">Four</option>
                                <option value="five">Five</option>
                                <option value="six">Six</option>
                                <option value="seven">Seven</option>
                                <option value="eight">Eight</option>
                                <option value="nine">Nine</option>
                                <option value="ten">Ten</option>
                                <option value="eleven">Eleven</option>
                                <option value="twelve">Twelve</option>
                                <option value="thirteen">Thirteen</option>
                                <option value="fourteen">Fourteen</option>
                                <option value="fifteen">Fifteen</option>
                                <option value="sixteen">Sixteen</option>
                            </select>
                            <small>width of box</small>
                        </p>
                        <p>
                            <label>Title</label>
                            <input class="title" name="url" type="text"/>
                        </p>
                        <p>
                            <label>Link (optional)</label>
                            <input class="url" name="url" type="text"/>
                        </p>
                        <p>
                            <label>Icon</label>
                            <select id="icon">
                                <option value="icon-glass">Glass</option>
                                <option value="icon-music">Music</option>
                                <option value="icon-search">Search</option>
                                <option value="icon-envelope">Envelope</option>
                                <option value="icon-heart">Heart</option>
                                <option value="icon-star">Star</option>
                                <option value="icon-star-empty">Stare empty</option>
                                <option value="icon-user">User</option>
                                <option value="icon-film">Film</option>
                                <option value="icon-th-large">Th large</option>
                                <option value="icon-th">Th</option>
                                <option value="icon-th-list">Th list</option>
                                <option value="icon-ok">Ok</option>
                                <option value="icon-remove">Remove</option>
                                <option value="icon-zoom-in">Zoom in</option>
                                <option value="icon-zoom-out">Zoom out</option>
                                <option value="icon-off">Off</option>
                                <option value="icon-signal">Signal</option>
                                <option value="icon-cog">Cog</option>
                                <option value="icon-trash">Trash</option>
                                <option value="icon-home">Home</option>
                                <option value="icon-file">File</option>
                                <option value="icon-time">Time</option>
                                <option value="icon-road">Road</option>
                                <option value="icon-download-alt">Download alt</option>
                                <option value="icon-download">Download</option>
                                <option value="icon-upload">Upload</option>
                                <option value="icon-inbox">Inbox</option>
                                <option value="icon-play-circle">Play circle</option>
                                <option value="icon-repeat">Repeat</option>
                                <option value="icon-refresh">Refresh</option>
                                <option value="icon-list-alt">List alt</option>
                                <option value="icon-lock">Lock</option>
                                <option value="icon-flag">Flag</option>
                                <option value="icon-headphones">Headphones</option>
                                <option value="icon-volume-off">Volume off</option>
                                <option value="icon-volume-down">Volume down</option>
                                <option value="icon-volume-up">Volume up</option>
                                <option value="icon-qrcode">Qrcode</option>
                                <option value="icon-barcode">Barcode</option>
                                <option value="icon-tag">Tag</option>
                                <option value="icon-tags">tags</option>
                                <option value="icon-book">Book</option>
                                <option value="icon-bookmark">Bookmark</option>
                                <option value="icon-print">Print</option>
                                <option value="icon-camera">Camera</option>
                                <option value="icon-font">Font</option>
                                <option value="icon-bold">Bold</option>
                                <option value="icon-italic">Italic</option>
                                <option value="icon-text-height">Text height</option>
                                <option value="icon-text-width">Text width</option>
                                <option value="icon-align-left">Align Left</option>
                                <option value="icon-align-center">Align center</option>
                                <option value="icon-align-right">Align right</option>
                                <option value="icon-align-justify">Align justify</option>
                                <option value="icon-list">List</option>
                                <option value="icon-indent-left">Indent left</option>
                                <option value="icon-indent-right">Indent right</option>
                                <option value="icon-facetime-video">Facetime video</option>
                                <option value="icon-picture">Picture</option>
                                <option value="icon-pencil">Pencil</option>
                                <option value="icon-map-marker">Map marker</option>
                                <option value="icon-adjust">Adjust</option>
                                <option value="icon-tint">Tint</option>
                                <option value="icon-edit">Edit</option>
                                <option value="icon-share">Share</option>
                                <option value="icon-check">Check</option>
                                <option value="icon-move">Move</option>
                                <option value="icon-step-backward">Step backward</option>
                                <option value="icon-fast-backward">Fast backward</option>
                                <option value="icon-backward">Backward</option>
                                <option value="icon-play">Play</option>
                                <option value="icon-pause">Pause</option>
                                <option value="icon-stop">Stop</option>
                                <option value="icon-forward">Forward</option>
                                <option value="icon-fast-forward">Fast forward</option>
                                <option value="icon-step-forward">Step forward</option>
                                <option value="icon-eject">Eject</option>
                                <option value="icon-chevron-left">Chevron left</option>
                                <option value="icon-chevron-right">Chevron right</option>
                                <option value="icon-plus-sign">Plus sign</option>
                                <option value="icon-minus-sign">Minus sign</option>
                                <option value="icon-remove-sign">Remove sign</option>
                                <option value="icon-ok-sign">OK sign</option>
                                <option value="icon-question-sign">Question sign</option>
                                <option value="icon-info-sign">Info sign</option>
                                <option value="icon-screenshot">Screenshot</option>
                                <option value="icon-remove-circle">Remove circle</option>
                                <option value="icon-ok-circle">OK circle</option>
                                <option value="icon-ban-circle">Ban circle</option>
                                <option value="icon-arrow-left">Arrow left</option>
                                <option value="icon-arrow-right">Arrow right</option>
                                <option value="icon-arrow-up">Arrow up</option>
                                <option value="icon-arrow-down">Arrow down</option>
                                <option value="icon-share-alt">Share alt</option>
                                <option value="icon-resize-full">Resize full</option>
                                <option value="icon-resize-small">Resize small</option>
                                <option value="icon-plus">Plus</option>
                                <option value="icon-minus">Minus</option>
                                <option value="icon-asterisk">Asterisk</option>
                                <option value="icon-exclamation-sign">Exclamation sign</option>
                                <option value="icon-gift">Gift</option>
                                <option value="icon-leaf">Leaf</option>
                                <option value="icon-fire">Fire</option>
                                <option value="icon-eye-open">Eye open</option>
                                <option value="icon-eye-close">Eye close</option>
                                <option value="icon-warning-sign">Warnign Sign</option>
                                <option value="icon-plane">Plane</option>
                                <option value="icon-calendar">Calendar</option>
                                <option value="icon-random">Random</option>
                                <option value="icon-comment">Comment</option>
                                <option value="icon-magnet">Magnet</option>
                                <option value="icon-chevron-up">Chevron up</option>
                                <option value="icon-chevron-down">Chevron down</option>
                                <option value="icon-retweet">Retweet</option>
                                <option value="icon-shopping-cart">Shopping-cart</option>
                                <option value="icon-folder-close">Folder close</option>
                                <option value="icon-folder-open">Foldet open</option>
                                <option value="icon-resize-vertical">Resize vertical</option>
                                <option value="icon-resize-horizontal">Resize horizontal</option>
                                <option value="icon-bar-chart">Bar chart</option>
                                <option value="icon-twitter-sign">Twitter sign</option>
                                <option value="icon-facebook-sign">Facebook sign</option>
                                <option value="icon-camera-retro">Camera retro</option>
                                <option value="icon-key">Key</option>
                                <option value="icon-cogs">Cogs</option>
                                <option value="icon-comments">Comments</option>
                                <option value="icon-thumbs-up">Thumbs up</option>
                                <option value="icon-thumbs-down">Thumbs down</option>
                                <option value="icon-star-half">Star half</option>
                                <option value="icon-heart-empty">Heart empty</option>
                                <option value="icon-signout">Signout</option>
                                <option value="icon-linkedin-sign">LinkedIn sign</option>
                                <option value="icon-pushpin">Pushpin</option>
                                <option value="icon-external-link">External link</option>
                                <option value="icon-signin">Signin</option>
                                <option value="icon-trophy">Trophy</option>
                                <option value="icon-github-sign">Github sign</option>
                                <option value="icon-upload-alt">Upload alt</option>
                                <option value="icon-lemon">Lemon</option>
                                <option value="icon-phone">Phone</option>
                                <option value="icon-check-empty">Check empty</option>
                                <option value="icon-bookmark-empty">Bookmark empty</option>
                                <option value="icon-phone-sign">Phone sign</option>
                                <option value="icon-twitter">Twitter</option>
                                <option value="icon-facebook">Facebook</option>
                                <option value="icon-github">Github</option>
                                <option value="icon-unlock">Unlock</option>
                                <option value="icon-credit-card">Credit card</option>
                                <option value="icon-rss">RSS</option>
                                <option value="icon-hdd">HDD</option>
                                <option value="icon-bullhorn">bullhorn </option>
                                <option value="icon-bell">Bell</option>
                                <option value="icon-certificate">Certificate</option>
                                <option value="icon-hand-right">Hand right</option>
                                <option value="icon-hand-left">Hand left</option>
                                <option value="icon-hand-up">Hand up</option>
                                <option value="icon-hand-down">Hand down</option>
                                <option value="icon-circle-arrow-left">Circle arrow left</option>
                                <option value="icon-circle-arrow-right">Circle arrow right</option>
                                <option value="icon-circle-arrow-up">Circle arrow up</option>
                                <option value="icon-circle-arrow-down">Circle arrow down</option>
                                <option value="icon-globe">Globe</option>
                                <option value="icon-wrench">Wrench</option>
                                <option value="icon-tasks">Tasks</option>
                                <option value="icon-filter">Filter</option>
                                <option value="icon-briefcase">Briefcase</option>
                                <option value="icon-fullscreen">Fullscreen</option>
                                <option value="icon-group">Group</option>
                                <option value="icon-link">Link</option>
                                <option value="icon-cloud">Cloud</option>
                                <option value="icon-beaker">Beaker</option>
                                <option value="icon-cut">Cut</option>
                                <option value="icon-copy">Copy</option>
                                <option value="icon-paper-clip">Paper clip</option>
                                <option value="icon-save">Save</option>
                                <option value="icon-sign-blank">Sign blank</option>
                                <option value="icon-reorder">Reorder</option>
                                <option value="icon-list-ul">List ul</option>
                                <option value="icon-list-ol">List ol</option>
                                <option value="icon-strikethrough">Strike through </option>
                                <option value="icon-underline">Underline</option>
                                <option value="icon-table">Table</option>
                                <option value="icon-magic">Magic</option>
                                <option value="icon-truck">Truck</option>
                                <option value="icon-pinterest">Pinterest</option>
                                <option value="icon-pinterest-sign">Pinterest sign</option>
                                <option value="icon-google-plus-sign">Google plus sign</option>
                                <option value="icon-google-plus">Google plus</option>
                                <option value="icon-money">Money</option>
                                <option value="icon-caret-down">Caret down</option>
                                <option value="icon-caret-up">Caret up</option>
                                <option value="icon-caret-left">Caret left</option>
                                <option value="icon-caret-right">Caret right</option>
                                <option value="icon-columns">Columns</option>
                                <option value="icon-sort">Sort</option>
                                <option value="icon-sort-down">Sort down</option>
                                <option value="icon-sort-up">Sort up</option>
                                <option value="icon-envelope-alt">Envelope alt</option>
                                <option value="icon-linkedin">Linkedin</option>
                                <option value="icon-undo">Undo</option>
                                <option value="icon-legal">Legal</option>
                                <option value="icon-dashboard">Dashboard</option>
                                <option value="icon-comment-alt">Comment alt</option>
                                <option value="icon-comments-alt">Comments alt</option>
                                <option value="icon-bolt">Bolt</option>
                                <option value="icon-sitemap">Sitemap</option>
                                <option value="icon-umbrella">Umbrella</option>
                                <option value="icon-paste">Paste</option>
                                <option value="icon-user-md">User md</option>
                            </select>
                        </p>

                        <div class="desc">
                            You'll find how all the icons look <a href="http://nevia.purethemes.wpengine.com/icons/">here</a>
                        </div>
                        <div class="warning">
                            Remember that whole section of <strong>[iconbox]</strong> shortcodes you'll create needs to be wrapped in <strong>[iconwrapper]</strong> tag. Example: <br/>
                            <pre>[iconwrapper] (rest of iconbox shortcodes) [/iconwrapper]</pre>
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
