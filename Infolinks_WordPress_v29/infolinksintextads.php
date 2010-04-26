<?php
/*
Plugin Name: Infolinks In Text Ads
Plugin URI: http://www.infolinks.com/signin/implementation.html
Description: This plugin will automatically add your Infolinks script to your website pages..
Version: Wordpress, 2.9
Author: Infolinks
Author URI: http://www.infolinks.com
*/





// Hook for adding admin menus
register_activation_hook( __FILE__, 'infolinks_install' );
register_deactivation_hook( __FILE__, 'infolinks_deactivate' );


add_action('admin_menu', 'infolinks_pages');
add_action('wp_footer', 'infolinksAdsscript');



 function infolinks_install() {
	 add_option('infolinks_status', '1', $deprecated, $autoload);
	 add_option('infolinks_comments', '1', $deprecated, $autoload);
	 add_option('infolinks_post', '1', $deprecated, $autoload);
 }
  function infolinks_deactivate() {
	  delete_option('infolinks_status');
	  delete_option('infolinks_comments');
	  delete_option('infolinks_post'); 
 }
 


define('IMG_PATH','/wp-content/plugins/info-links-in-text-ads/Bubble.gif');
define('JS_PATH','/wp-content/plugins/info-links-in-text-ads/jquery.js');


// action function for above hook
function infolinks_pages() {
    add_options_page('Info Links Text Ads', 'Infolinks In Text Ads', 'administrator', 'infolink-admin', 'infosettingoptions_page');
}



//admin settings
function infosettingoptions_page() {
extract($_REQUEST);
		if($_REQUEST['btnSave']=="save configurations"){	
				$options = get_option('infolinks_status');
				if($options!="") {				
					 update_option('infolinks_status', $infolinks_status);
					 update_option('infolinks_publisherid', $infolinks_publisherid);
					 update_option('infolinks_websiteid', $infolinks_websiteid);
					 update_option('infolinks_excludepage', $infolinks_excludepage); 
					 update_option('infolinks_comments', $infolinks_comments); 
					 update_option('infolinks_post', $infolinks_post);  
					 update_option('infolinks_keytag',$infolinks_keytag);
				 }
				 else {				 
				 	$deprecated=' ';
    				$autoload='no';
    				add_option('infolinks_status', $infolinks_status, $deprecated, $autoload);
					add_option('infolinks_publisherid', $infolinks_publisherid, $deprecated, $autoload);
					add_option('infolinks_websiteid', $infolinks_websiteid, $deprecated, $autoload);
					add_option('infolinks_excludepage', $infolinks_excludepage, $deprecated, $autoload);
					add_option('infolinks_comments', $infolinks_comments, $deprecated, $autoload);
					add_option('infolinks_post', $infolinks_post, $deprecated, $autoload);		
					add_option('infolinks_keytag',$infolinks_keytag,$deprecated, $autoload);
				 }	 				 
		}
		if($_REQUEST['btnReset']=="Reset to default"){	
				delete_option('infolinks_status');
				delete_option('infolinks_publisherid');
				delete_option('infolinks_websiteid');
				delete_option('infolinks_excludepage');
				delete_option('infolinks_comments');
				delete_option('infolinks_post');
				delete_option('infolinks_keytag');				
		}
    ?>
<?php
		//radio 
		 $infopage = get_option('infolinks_status');		
			if($infopage==1){	$adsenable = "Checked='checked'"; }
			if($infopage==0){	$adsdisble = "Checked='checked'"; }
			
		//tags enables	
		 $infokeys = get_option('infolinks_keytag');		
			if($infokeys==1){	$adskeyenable = "Checked='checked'"; }
			if($infokeys==0){	$adskeydisble = "Checked='checked'"; }
			
		
		//checkbox	
		 $enablecmds = get_option('infolinks_comments');
		 $enablepost = get_option('infolinks_post');
			if($enablecmds==1){	$infocomments = "Checked='checked'"; }else{	$page = ''; }
			if($enablepost==1){	$infopost = "Checked='checked'"; }else{	$post = '';	}	
			
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
text-shadow:0 1px 0 #FFFFFF;}
		</style>
<form action="" method="post" name="frm_infolinks" id="frm_infolinks">
  <input type="hidden" id="infoid" name="infoid" value="" />
  <div style="float:left; width:50%;"><table border="1" width="100%">
    <tr>
      <td><table width="100%">
          <tr>
            <td colspan="2"><h2>Infolinks In Text Ads</h2></td>
          </tr>
          <tr>
            <td colspan="2">This plugin will automatically add your Infolinks script to your website pages</td>
          </tr>
          <tr>
            <td colspan="2" height="30">&nbsp;</td>
          </tr>
          <tr>
            <td valign="top" width="200">Infolinks in Text Ads:</td>
			
            <td><input type="radio" name="infolinks_status" value="1" <?=$adsenable?> />
              On <br />
              <input type="radio" name="infolinks_status" value="0"  <?=$adsdisble?> />
              Off </td>
          </tr>
          <tr>
            <td colspan="2" height="20">&nbsp;</td>
          </tr>
          <tr>
            <td valign="top"><label for="publisherid">Publisher ID :</label></td>
            <td><input type="text" name="infolinks_publisherid" id="infolinks_publisherid"  value="<?=get_option('infolinks_publisherid')?>"/>
              <br />
              <span class="small_txt">Please enter your infolinks pid</span> </td>
          </tr>
          <tr>
            <td valign="top"><label for="websiteid">Website ID :</label></td>
            <?php $wid = get_option('infolinks_websiteid')?get_option('infolinks_websiteid'):0; ?>
            <td><input type="text" name="infolinks_websiteid" id="infolinks_websiteid" value="<?=$wid?>"/>
              <br />
              <span class="small_txt">Please enter your website wsid</span> </td>
          </tr>
          <tr>
            <td colspan="2" height="40">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2"><label for="excludepage">Exclude from the following pages</label>
              <input type="text" name="infolinks_excludepage" id="infolinks_excludepage" value="<?=get_option('infolinks_excludepage')?>" />
              <br />
              <span class="small_txt"> (please enter page numbers comma- separated. Infolinks will not be added to these pages)</span></td>
          </tr>
          <tr>
            <td colspan="2" height="20">&nbsp;</td>
          </tr>
          <tr>
            <td valign="top">Show in header / titles:</td>
            <td><input type="radio" name="infolinks_keytag" value="1" <?=$adskeyenable?> />
              On <br />
              <input type="radio" name="infolinks_keytag" value="0"  <?=$adskeydisble?> />
              Off </td>
          </tr>
          <tr>
            <td colspan="2" height="20">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2"><div style="padding-top:3px;float:left;">
                <input type="checkbox" name="infolinks_post"  value="1" <?=$infopost?> />
                &nbsp;</div>
              <div style="padding-top:3px;float:left;">Enable Infolinks on posts</div></td>
          </tr>
          <tr>
            <td colspan="2"><div style="padding-top:3px;float:left;">
                <input type="checkbox" name="infolinks_comments" value="1" <?=$infocomments?>/>
                &nbsp;</div>
              <div style="padding-top:3px;float:left;">Enable Infolinks on comments</div></td>
          </tr>
          <tr>
            <td colspan="2" height="40">&nbsp;</td>
          </tr>
        </table></td>
      <td></td>
    </tr>
    <tr>
      <td colspan="2"> To view or edit your Infolinks account settings, please visit the <a href="http://www.infolinks.com/signin/implementation.html" target="_blank">Integration guide</a> <br />
        and <a href="http://www.infolinks.com/faq.html" target="_blank">our FAQs</a>, or contact us at <a href="mailto:support@infolinks.com">support@infolinks.com</a> </td>
    </tr>
    <tr>
      <td colspan="2" height="20">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" height="40"><input type="submit" name="btnSave" value="save configurations"/>
        <input type="submit" name="btnReset" value="Reset to default"/></td>
    </tr>
  </table>
  </div>
  <div style="float: left; margin-left:auto; padding-top:100px; width:50%;">
  <img src="<?php echo get_option('siteurl').IMG_PATH; ?>"  /></div>
</form>
<?php	
}







//to write the script in footer 
function infolinksAdsscript() {
	$display = 0;
	//to check the ads enable or disable
	 $options = get_option('infolinks_status');
	 $tagKeys = get_option('infolinks_keytag');
	 if($options==1){	  		
			 $display =1;
			 $postings = get_option('infolinks_post');
			 $commentspage = get_option('infolinks_comments');			
			 $pages = get_option('infolinks_excludepage');	
			 
			   //to check the following pages
			   if(!empty($pages)) {
			   		$disablepageArray = explode(",",$pages);
					global $post;
					$current_page = $post->ID;	
					foreach ($disablepageArray as $page) {
						if ($current_page == intval($page)) {
							$display = 0;
						}
					}
			   }
			  if (is_single() || is_front_page()) {  // to check the post
			  		$display = 0;
			    	 if($postings==1){
						$display = 1;
					 } 
			   }
			   if($tagKeys==0) {
			   		
					$classArray = array(".description");
					$IdArray = array("#headerimg");					
			   		$KeyArray = array("h1","h2","h3");
					
					for($c=0;$c<count($classArray);$c++){
					  $cJoin .= "$('".$classArray[$c]."').before('<span><!--INFOLINKS_OFF--></span>');";
					  $cJoin .= "$('".$classArray[$c]."').after('<span><!--INFOLINKS_ON--></span>');";
					}
					
					for($i=0;$i<count($IdArray);$i++){
					  $idJoin .= "$('".$IdArray[$i]."').before('<span><!--INFOLINKS_OFF--></span>');";
					  $idJoin .= "$('".$IdArray[$i]."').after('<span><!--INFOLINKS_ON--></span>');";
					}
					
					for($k=0;$i<count($KeyArray);$i++){
					  $keyJoin .= "$('".$KeyArray[$k]."').before('<span><!--INFOLINKS_OFF--></span>');";
					  $keyJoin .= "$('".$KeyArray[$k]."').after('<span><!--INFOLINKS_ON--></span>');";
					}
			   	$strOnOff = '
				<script type="text/javascript" src="'.get_option('siteurl').JS_PATH.'"></script>
				<script type="text/javascript">
							$(document).ready(function(){ 
							'.$cJoin.$idJoin.$keyJoin.'	
								});
						</script>';			   
			   }
			   
			
			
	 }
	
	 if($display==1){ 
	  $infoscript = '<script type="text/javascript">
		   var infolink_pid ='.get_option('infolinks_publisherid').'; var infolink_wsid = '.get_option('infolinks_websiteid').';
		</script>
		<script type="text/javascript" src="http://resources.infolinks.com/js/infolinks_main.js"></script>
		'.$strOnOff.'
		';
	 }
	 echo $infoscript;
	
}


?>
