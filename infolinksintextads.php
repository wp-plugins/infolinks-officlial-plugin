<?php
/*
Plugin Name: Infolinks Official Plugin
Plugin URI: http://www.infolinks.com
Description: This plugin will automatically add your Infolinks script to your website pages.
Author: Infolinks
Version: 3.1
Author URI: http://www.infolinks.com
*/

//install/uninstall function calls
register_activation_hook( __FILE__, 'infolinks_install' );
register_uninstall_hook( __FILE__, 'infolinks_uninstall' );

add_action( 'admin_menu', 'infolinks_pages' );
add_action( 'wp_footer', 'infolinksAdsscript' );

function infolinks_install() {
	add_option( 'infolinks_status', '1' );
	add_option( 'infolinks_comments', '1' );
	add_option( 'infolinks_post', '1' );
}

function infolinks_uninstall() {
	delete_option( 'infolinks_status' );
	delete_option( 'infolinks_publisherid' );
	delete_option( 'infolinks_websiteid' );
	delete_option( 'infolinks_excludepage' );
	delete_option( 'infolinks_comments' );
	delete_option( 'infolinks_post' );
	delete_option( 'infolinks_keytag' );
	delete_option( 'infolinks_jquery' );
}

$pluginpath = plugins_url( '/', __FILE__ );

define( 'JS_PATH', $pluginpath .'js/jquery.js' );

// action function for above hook
function infolinks_pages() {
    add_options_page( 'Info Links Text Ads', 'Infolinks Settings', 'manage_options', 'infolink-admin', 'infosettingoptions_page' );
}

//plugin settings page
function infosettingoptions_page() {

	//save plugin settings
	if( isset( $_POST['btnSave'] ) ) {

		//check nonce for security
		check_admin_referer( 'infolinks_plugin_save' );

		$infolinks_status = ( isset( $_POST['infolinks_status'] ) ) ? $_POST['infolinks_status'] : 0;
		$infolinks_keytag = ( isset( $_POST['infolinks_keytag'] ) ) ? $_POST['infolinks_keytag'] : 0;
		$infolinks_jquery = ( isset( $_POST['infolinks_jquery'] ) ) ? $_POST['infolinks_jquery'] : 0;
		$infolinks_comments = ( isset( $_POST['infolinks_comments'] ) ) ? $_POST['infolinks_comments'] : 0;
		$infolinks_post = ( isset( $_POST['infolinks_post'] ) ) ? $_POST['infolinks_post'] : 0;

		update_option( 'infolinks_status', absint( $infolinks_status ) );
		update_option( 'infolinks_publisherid', absint( $_POST['infolinks_publisherid'] ) );
		update_option( 'infolinks_websiteid', absint( $_POST['infolinks_websiteid'] ) );
		update_option( 'infolinks_excludepage', strip_tags( $_POST['infolinks_excludepage'] ) );
		update_option( 'infolinks_comments', absint( $infolinks_comments ) );
		update_option( 'infolinks_post', absint( $infolinks_post ) );
		update_option( 'infolinks_keytag', absint( $infolinks_keytag ) );
		update_option( 'infolinks_jquery', absint( $infolinks_jquery ) );

		echo '<div id="message" class="updated">Settings saved successfully</div>';

	}

	//reset plugin settings
	if( isset( $_POST['btnReset'] ) ) {

		//check nonce for security
		check_admin_referer( 'infolinks_plugin_save' );

		//set options back to specified defaults
		update_option( 'infolinks_status', 1 );
		update_option( 'infolinks_comments', 1 );
		update_option( 'infolinks_post', 1 );
		update_option( 'infolinks_keytag', 1 );
		update_option( 'infolinks_jquery', 0 );
		delete_option( 'infolinks_excludepage' );

		echo '<div id="message" class="updated">Settings reset successfully</div>';
	}

	//load setting values
	$infolinks_status = get_option( 'infolinks_status' );
	$infolinks_keytag = get_option( 'infolinks_keytag' );
	$infolinks_jquery = get_option( 'infolinks_jquery' );
	$infolinks_publisherid = get_option( 'infolinks_publisherid' );
	$infolinks_websiteid = ( get_option( 'infolinks_websiteid' ) ) ? get_option( 'infolinks_websiteid' ) : 0;
	$infolinks_excludepage = get_option( 'infolinks_excludepage' );
	$infolinks_post = get_option( 'infolinks_post' );
	$infolinks_comments = get_option( 'infolinks_comments' );
?>
<style type="text/css">
.small_txt {
	font-size:0.85em;
	color:#898989;
	font-family:Verdana,sans-serif;
}
h2 {
	font-family:Georgia,"Times New Roman","Bitstream Charter",Times,serif;
	font-size:24px;
	font-size-adjust:none;
	font-stretch:normal;
	font-style:italic;
	font-variant:normal;
	font-weight:normal;
	line-height:35px;
	margin:0;
	padding:14px 15px 3px 0;
	text-shadow:0 1px 0 #FFFFFF;
}
</style>
<form method="post" name="frm_infolinks" id="frm_infolinks">
	<?php wp_nonce_field( 'infolinks_plugin_save' ); ?>
  <input type="hidden" id="infoid" name="infoid" value="" />
  <div style="float:left; width:40%;"><table border="1" width="100%">
    <tr>
      <td><table width="95%">
          <tr>
            <td colspan="2"><h2>Infolinks Official Plugin</h2></td>
          </tr>
          <tr>
            <td colspan="2">This plugin will automatically add your Infolinks script to your website pages</td>
          </tr>
          <tr>
            <td colspan="2" height="30">&nbsp;</td>
          </tr>
          <tr>
            <td valign="top" width="200">Infolinks In Text Ads:</td>
			<td>
				<input type="radio" name="infolinks_status" value="1" <?php checked( $infolinks_status, 1 ); ?> /> On <br />
				<input type="radio" name="infolinks_status" value="0" <?php checked( $infolinks_status, 0 ); ?> /> Off
			</td>
          </tr>
          <tr>
            <td colspan="2" height="20">&nbsp;</td>
          </tr>
          <tr>
            <td valign="top"><label for="publisherid">Publisher ID :</label></td>
            <td>
				<input type="text" name="infolinks_publisherid" id="infolinks_publisherid"  value="<?php echo esc_attr( $infolinks_publisherid ); ?>"/><br />
				<span class="small_txt">Please enter your infolinks pid</span>
			</td>
          </tr>
          <tr>
            <td valign="top"><label for="websiteid">Website ID :</label></td>
            <td>
				<input type="text" name="infolinks_websiteid" id="infolinks_websiteid" value="<?php echo esc_attr( $infolinks_websiteid ); ?>"/><br />
				<span class="small_txt">Please enter your website wsid</span>
			</td>
          </tr>
          <tr>
			<td colspan="2" height="40">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2"><label for="excludepage">Exclude from the following pages</label>
				<input type="text" name="infolinks_excludepage" id="infolinks_excludepage" value="<?php echo esc_attr( $infolinks_excludepage ); ?>" /><br />
				<span class="small_txt"> (please enter page numbers comma- separated. Infolinks will not be added to these pages)</span>
			</td>
          </tr>
          <tr>
            <td colspan="2" height="20">&nbsp;</td>
          </tr>
          <tr>
            <td valign="top">jQuery :</td>
            <td><input type="radio" name="infolinks_jquery" value="1" <?php checked( $infolinks_jquery, 1 ); ?> /> Use plugin jQuery <br />
              <input type="radio" name="infolinks_jquery" value="0"  <?php checked( $infolinks_jquery, 0 ); ?> /> Use site jQuery
			</td>
          </tr>
		  <tr>
            <td colspan="2" height="20">&nbsp;</td>
          </tr>
		  <tr>
            <td valign="top">Show in header / titles: <br />
			<span class="small_txt">(jQuery is mandatory for this feature)</span></td>
            <td>
				<input type="radio" name="infolinks_keytag" value="1" <?php checked( $infolinks_keytag, 1 ); ?> />On <br />
				<input type="radio" name="infolinks_keytag" value="0"  <?php checked( $infolinks_keytag, 0 ); ?> />Off </td>
          </tr>
          <tr>
            <td colspan="2" height="20">&nbsp;</td>
          </tr>
          <tr>
			<td colspan="2">
				<div style="padding-top:3px;float:left;">
				<input type="checkbox" name="infolinks_post" value="1"  <?php checked( $infolinks_post, 1 ); ?> />
                &nbsp;</div>
              <div style="padding-top:3px;float:left;">Enable Infolinks on posts</div>
			</td>
          </tr>
          <tr>
            <td colspan="2">
				<div style="padding-top:3px;float:left;">
				<input type="checkbox" name="infolinks_comments" value="1" <?php checked( $infolinks_comments, 1 ); ?> />
                &nbsp;</div>
				<div style="padding-top:3px;float:left;">Enable Infolinks on comments</div>
			</td>
          </tr>
          <tr>
		     <td colspan="2" height="40">&nbsp;</td>
          </tr>
		  <tr>
			  <td colspan="2">
					<strong>Want to earn even more?</strong>
					<p><a href="http://publishers.infolinks.com/members/tag-cloud" target="_blank">Click here to activate Tag Cloud on your pages</a></p>
					<p>By adding Tag Cloud to your pages, you can increase your earnings with our attractive, fully-customizable cloud of keywords that display in a Tag Cloud unit at the bottom of your text.</p>
					<p>Tag Cloud operates just like our In-Text ads, a mouse hover reveals our ad bubble, and each click equals more money for you! Our smart algorithm delivers the best keywords for each page and helps to further turn your content into money by matching each keyword with a relevant ad.</p>
			  </td>
          <tr>
		     <td colspan="2" height="40">&nbsp;</td>
          </tr>
        </table></td>
      <td></td>
    </tr>
    <tr>
      <td colspan="2">To view or edit your Infolinks account settings, please visit the <a href="http://publishers.infolinks.com/members/1-minute-integration" target="_blank">Integration guide</a> <br />
        and <a href="http://www.infolinks.com/faq.html" target="_blank">our FAQs</a>, or contact us at <a href="mailto:support@infolinks.com">support@infolinks.com</a> </td>
    </tr>
    <tr>
      <td colspan="2" height="20">&nbsp;</td>
    </tr>
    <tr>
		<td colspan="2" height="40">
			<input type="submit" class="button-primary" name="btnSave" value="Save Settings" />
			<input type="submit" class="button-secondary" name="btnReset" value="Reset to Default" />
		</td>
    </tr>
  </table>
  </div>
  <div style="float: left; margin-left:auto; padding-top:100px; width:60%;">
	<img src="<?php echo plugins_url( 'images/bubble.png', __FILE__ ); ?>" width="350" style="padding-left:150px;" /><br />
	<img src="<?php echo plugins_url( 'images/tag-cloud.png', __FILE__ ); ?>" width="550" style="padding-top:80px;" />
  </div>

</form>
<?php	
}

//add the script in footer
function infolinksAdsscript() {
	$display = 0;
	//to check the ads enable or disable
	 $options = get_option( 'infolinks_status' );
	 $tagKeys = get_option( 'infolinks_keytag' );
	 $JQuery = get_option( 'infolinks_jquery' );
	 $cJoin = '';
	 $idJoin = '';
	 $keyJoin = '';
	 $strOnOff = '';

	 if( $options == 1 ){
			 $display =1;
			 $postings = get_option( 'infolinks_post' );
			 $commentspage = get_option( 'infolinks_comments' );
			 $pages = get_option( 'infolinks_excludepage' );
			 
			   //to check the following pages
			   if( !empty( $pages ) ) {
			   		$disablepageArray = explode( ",", $pages );
					global $post;
					$current_page = $post->ID;	
					foreach ( $disablepageArray as $page ) {
						if ( $current_page == intval( $page ) ) {
							$display = 0;
						}
					}
			   }
			  if (is_single() || is_front_page()) {  // to check the post
			  		$display = 0;
			    	 if( $postings == 1 ){
						$display = 1;
					 } 
			   }

			   if( $tagKeys == 0 ) {

					$classArray = array( ".description" );
					$IdArray = array( "#headerimg" );
					$KeyArray = array( "h1", "h2", "h3" );
					
					for( $c=0; $c < count( $classArray ); $c++ ){
						$cJoin .= "jQuery('".$classArray[$c]."').before('<span><!--INFOLINKS_OFF--></span>');";
						$cJoin .= "jQuery('".$classArray[$c]."').after('<span><!--INFOLINKS_ON--></span>');";
					}
					
					for( $i=0; $i < count( $IdArray ); $i++ ){
						$idJoin .= "jQuery('".$IdArray[$i]."').before('<span><!--INFOLINKS_OFF--></span>');";
						$idJoin .= "jQuery('".$IdArray[$i]."').after('<span><!--INFOLINKS_ON--></span>');";
					}
					
					for( $k=0; $i < count( $KeyArray ); $i++ ){
						$keyJoin .= "jQuery('".$KeyArray[$k]."').before('<span><!--INFOLINKS_OFF--></span>');";
						$keyJoin .= "jQuery('".$KeyArray[$k]."').after('<span><!--INFOLINKS_ON--></span>');";
					}
			   
			   if( $JQuery == 1 ) {
					$strOnOff = '<script type="text/javascript" src="'.esc_url( JS_PATH ).'"></script>';
				}
				
				$strOnOff .= '<script type="text/javascript">
							jQuery(document).ready(function(){ 
							'.$cJoin.$idJoin.$keyJoin.'	
								});
						</script>';			   
			   }
	 }
	
	 if( $display == 1 ){
	  $infoscript = '
		<!-- Infolinks START -->
		<script type="text/javascript">
		   var infolink_pid ='.absint( get_option( 'infolinks_publisherid' ) ).'; var infolink_wsid = '.absint( get_option('infolinks_websiteid') ).';
		</script>
		<script type="text/javascript" src="http://resources.infolinks.com/js/infolinks_main.js"></script>
		'.$strOnOff.'
		<!-- Infolinks END -->';
	 }
	 echo $infoscript;
	
}
?>