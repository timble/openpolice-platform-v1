<?php defined('_JEXEC') or die('Restricted access'); 

?><div id="phocagallery-comments"><?php
	echo '<div style="font-size:1px;height:1px;margin:0px;padding:0px;">&nbsp;</div>';//because of IE bug 
	
	$option = JRequest::getVar('option', 'com_phocagallery');
	$view 	= JRequest::getVar('view', 'category');
	$xid 	= md5(JURI::base() . $option . $view) . 'pgcat'.(int)$this->category->id;
	
	if ($this->tmpl['fb_comment_app_id'] == '') {
		echo JText::_('COM_PHOCAGALLERY_ERROR_FB_APP_ID_EMPTY');
	} else {

?><fb:comments xid="<?php echo $xid ?>" simple="1" width="<?php echo (int)$this->tmpl['fb_comment_width'] ?>"></fb:comments>
<div id="fb-root"></div>
<script>
  window.fbAsyncInit = function() {
   FB.init({
     appId: '<?php echo $this->tmpl['fb_comment_app_id'] ?>',
     status: true,
	 cookie: true,
     xfbml: true
   });
 }; 
  (function() {
    var e = document.createElement('script');
    e.type = 'text/javascript';
    e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
    e.async = true;
    document.getElementById('fb-root').appendChild(e);
   }());
</script>
<?php } ?>
</div>
