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
    <title>Add Button</title>
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/inc/css/tinymce.css?v=2" type="text/css" media="screen" />
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
                },

                insert : function() {

                    var url = jQuery('#url').val();
                    var text = jQuery('#text').val();
                    var customcolor = jQuery('#customcolor').val();
                    var choosedStyle = jQuery('#selector option:selected').val();
                    var target = jQuery('#target option:selected').val();
                    var choosedSize = jQuery('#size option:selected').val();
                    var choosedicon = jQuery('#icon option:selected').val();
                    var choosediconcolor = jQuery('#iconcolor option:selected').val();

                    if(choosedicon != "none") {
                        var icon = 'icon="'+choosedicon+'" iconcolor="'+choosediconcolor+'" ';
                    } else {
                        var icon = ' ';
                    }
                    if(customcolor) {
                        var pop = 'customcolor="'+ customcolor +'" ';
                    } else {
                        var pop = ' ';
                    }
                    if(target) {
                        var tarcod = 'target="'+ target +'" ';
                    } else {
                        var tarcod = ' ';
                    }
                    if (text) {
                        output = '[button color="'+choosedStyle+'" size="'+choosedSize+'" url="'+url+'" '+icon+' '+pop+' '+tarcod+'] '+ text + ' [/button] ';
                    } else {
                        output = '[button color="'+choosedStyle+'" size="'+choosedSize+'" url="'+url+'" '+icon+' '+pop+' '+tarcod+'] '+ ListsDialog.local_ed.selection.getContent() + ' [/button] ';
                    }
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
                <div id="lists" class="dialogbox">

                    <h3>Button properties</h3>
                    <p>
                        <label>URL</label>
                        <input type="text" class="tab-title" name="url" id="url"/>
                    </p>
                    <p>
                        <label>Text</label>
                        <input type="text" class="tab-title" name="text" id="text"/>
                    </p>

                    <p>
                        <label>Style</label>
                        <select id="selector">
                            <option value="color">Current main color</option>
                            <option value="light">Light</option>
                            <option value="gray">Gray</option>
                        </select>
                    </p>
                    <p>
                        <label>Size</label>
                        <select id="size">
                            <option value="medium">Medium</option>
                            <option value="small">Small</option>

                        </select>
                    </p>
                    <p>
                        <label>Link target</label>
                        <select id="target">
                            <option value="">none</option>
                            <option value="_blank">_blank</option>
                            <option value="_self">_self</option>
                            <option value="_parent">_parent</option>
                            <option value="_top">_top</option>
                        </select>
                    </p>
                    <p>
                        <label>Icon</label>
                        <select id="icon">
                            <option value="none">NONE</option>
                            <option value="glass">glass</option>
                            <option value="music">music</option>
                            <option value="search">search</option>
                            <option value="envelope">envelope</option>
                            <option value="heart">heart</option>
                            <option value="star">star</option>
                            <option value="star-empty">star-empty</option>
                            <option value="user">user</option>
                            <option value="film">film</option>
                            <option value="th-large">th-large</option>
                            <option value="th">th</option>
                            <option value="th-list">th-list</option>
                            <option value="ok">ok</option>
                            <option value="remove">remove</option>
                            <option value="zoom-in">zoom-in</option>
                            <option value="zoom-out">zoom-out</option>
                            <option value="off">off</option>
                            <option value="signal">signal</option>
                            <option value="cog">cog</option>
                            <option value="trash">trash</option>
                            <option value="home">home</option>
                            <option value="file">file</option>
                            <option value="time">time</option>
                            <option value="road">road</option>
                            <option value="download-alt">download-alt</option>
                            <option value="download">download</option>
                            <option value="upload">upload</option>
                            <option value="inbox">inbox</option>
                            <option value="play-circle">play-circle</option>
                            <option value="repeat">repeat</option>
                            <option value="refresh">refresh</option>
                            <option value="list-alt">list-alt</option>
                            <option value="lock">lock</option>
                            <option value="flag">flag</option>
                            <option value="headphones">headphones</option>
                            <option value="volume-off">volume-off</option>
                            <option value="volume-down">volume-down</option>
                            <option value="volume-up">volume-up</option>
                            <option value="qrcode">qrcode</option>
                            <option value="barcode">barcode</option>
                            <option value="tag">tag</option>
                            <option value="tags">tags</option>
                            <option value="book">book</option>
                            <option value="bookmark">bookmark</option>
                            <option value="print">print</option>
                            <option value="camera">camera</option>
                            <option value="font">font</option>
                            <option value="bold">bold</option>
                            <option value="italic">italic</option>
                            <option value="text-height">text-height</option>
                            <option value="text-width">text-width</option>
                            <option value="align-left">align-left</option>
                            <option value="align-center">align-center</option>
                            <option value="align-right">align-right</option>
                            <option value="align-justify">align-justify</option>
                            <option value="list">list</option>
                            <option value="indent-left">indent-left</option>
                            <option value="indent-right">indent-right</option>
                            <option value="facetime-video">facetime-video</option>
                            <option value="picture">picture</option>
                            <option value="pencil">pencil</option>
                            <option value="map-marker">map-marker</option>
                            <option value="adjust">adjust</option>
                            <option value="tint">tint</option>
                            <option value="edit">edit</option>
                            <option value="share">share</option>
                            <option value="check">check</option>
                            <option value="move">move</option>
                            <option value="step-backward">step-backward</option>
                            <option value="fast-backward">fast-backward</option>
                            <option value="backward">backward</option>
                            <option value="play">play</option>
                            <option value="pause">pause</option>
                            <option value="stop">stop</option>
                            <option value="forward">forward</option>
                            <option value="fast-forward">fast-forward</option>
                            <option value="step-forward">step-forward</option>
                            <option value="eject">eject</option>
                            <option value="chevron-left">chevron-left</option>
                            <option value="chevron-right">chevron-right</option>
                            <option value="plus-sign">plus-sign</option>
                            <option value="minus-sign">minus-sign</option>
                            <option value="remove-sign">remove-sign</option>
                            <option value="ok-sign">ok-sign</option>
                            <option value="question-sign">question-sign</option>
                            <option value="info-sign">info-sign</option>
                            <option value="screenshot">screenshot</option>
                            <option value="remove-circle">remove-circle</option>
                            <option value="ok-circle">ok-circle</option>
                            <option value="ban-circle">ban-circle</option>
                            <option value="arrow-left">arrow-left</option>
                            <option value="arrow-right">arrow-right</option>
                            <option value="arrow-up">arrow-up</option>
                            <option value="arrow-down">arrow-down</option>
                            <option value="share-alt">share-alt</option>
                            <option value="resize-full">resize-full</option>
                            <option value="resize-small">resize-small</option>
                            <option value="plus">plus</option>
                            <option value="minus">minus</option>
                            <option value="asterisk">asterisk</option>
                            <option value="exclamation-sign">exclamation-sign</option>
                            <option value="gift">gift</option>
                            <option value="leaf">leaf</option>
                            <option value="fire">fire</option>
                            <option value="eye-open">eye-open</option>

                            <option value="eye-close">eye-close</option>
                            <option value="warning-sign">warning-sign</option>
                            <option value="plane">plane</option>
                            <option value="calendar">calendar</option>
                            <option value="random">random</option>
                            <option value="comment">comment</option>
                            <option value="magnet">magnet</option>
                            <option value="chevron-up">chevron-up</option>
                            <option value="chevron-down">chevron-down</option>
                            <option value="retweet">retweet</option>
                            <option value="shopping-cart">shopping-cart</option>
                            <option value="folder-close">folder-close</option>
                            <option value="folder-open">folder-open</option>
                            <option value="resize-vertical">resize-vertical</option>
                            <option value="resize-horizontal">resize-horizontal</option>
                            <option value="hdd">hdd</option>
                            <option value="bullhorn">bullhorn</option>
                            <option value="bell">bell</option>
                            <option value="certificate">certificate</option>
                            <option value="thumbs-up">thumbs-up</option>
                            <option value="thumbs-down">thumbs-down</option>
                            <option value="hand-right">hand-right</option>
                            <option value="hand-left">hand-left</option>
                            <option value="hand-up">hand-up</option>
                            <option value="hand-down">hand-down</option>
                            <option value="circle-arrow-right">circle-arrow-right</option>
                            <option value="circle-arrow-left">circle-arrow-left</option>
                            <option value="circle-arrow-up">circle-arrow-up</option>
                            <option value="circle-arrow-down">circle-arrow-down</option>
                            <option value="globe">globe</option>
                            <option value="wrench">wrench</option>
                            <option value="tasks">tasks</option>
                            <option value="filter">filter</option>
                            <option value="briefcase">briefcase</option>
                            <option value="fullscreen">fullscreen</option>
                            <option value="dashboard">dashboard</option>
                            <option value="paperclip">paperclip</option>
                            <option value="heart-empty">heart-empty</option>
                            <option value="link">link</option>
                            <option value="phone">phone</option>
                            <option value="pushpin">pushpin</option>
                            <option value="euro">euro</option>
                            <option value="usd">usd</option>
                            <option value="gbp">gbp</option>
                            <option value="sort">sort</option>
                            <option value="sort-by-alphabet">sort-by-alphabet</option>
                            <option value="sort-by-alphabet-alt">sort-by-alphabet-alt</option>
                            <option value="sort-by-order">sort-by-order</option>
                            <option value="sort-by-order-alt">sort-by-order-alt</option>
                            <option value="sort-by-attributes">sort-by-attributes</option>
                            <option value="sort-by-attributes-alt">sort-by-attributes-alt</option>
                            <option value="unchecked">unchecked</option>
                            <option value="expand">expand</option>
                            <option value="collapse">collapse</option>
                            <option value="collapse-top">collapse-top</option>
                        </select>
                    </p>
                    <p>
                        <label>Icon color</label>
                        <select id="iconcolor">
                            <option value="black">Black</option>
                            <option value="white">White</option>
                        </select>
                    </p>
                    <p>
                       <label>Custom color hash</label>
                        <input type="text" class="popuptitle" name="customcolor" id="customcolor"/>
                    </p>

                </div>

                <div class="mceActionPanel">
                    <input type="button" id="insert" name="insert" value="{#insert}" onclick="ListsDialog.insert();" />
                    <input type="button" id="cancel" name="cancel" value="{#cancel}" onclick="tinyMCEPopup.close();" />
                </div>
            </form>

        </body>
        </html>
