<?php defined('_JEXEC') or die('Restricted access');
if ($this->tmpl['backbutton'] != '') {
	echo $this->tmpl['backbutton'];
} 
echo '<div id="phocagallery-comments">';
if ($this->tmpl['detailwindow'] == 7 || $this->tmpl['display_comment_nopup'] == 1) {
	echo '<div id="image-box" style="text-align:center">'.$this->item->linkimage.'</div>';
}

if (JComponentHelper::isEnabled('com_jcomments', true) && $this->tmpl['externalcommentsystem'] == 1) {
	include_once(JPATH_BASE.DS.'components'.DS.'com_jcomments'.DS.'jcomments.php');
	echo JComments::showComments(  $this->tmpl['id'], 'com_phocagallery_images', JText::_('PHOCAGALLERY_IMAGE') .' '. $this->tmpl['imgtitle']);
} else if($this->tmpl['externalcommentsystem'] == 2) {
	
	$option = JRequest::getVar('option', 'com_phocagallery');
	$view 	= JRequest::getVar('view', 'detail');
	$xid 	= md5(JURI::base() . $option . $view) . 'pgimg'.(int)$this->tmpl['id'];
	
	echo '<div style="margin:10px">';
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
<?php 
	echo '</div>';
	} 

} else {

	if (!empty($this->commentitem)){
		$userImage	= JHTML::_( 'image.site', 'components/com_phocagallery/assets/images/icon-user.'.$this->tmpl['formaticon'],'', '', '', '', '');
		$smileys = PhocaGalleryComment::getSmileys();
			
		foreach ($this->commentitem as $itemValue) {
			$date		= JHTML::_('date',  $itemValue->date, JText::_('DATE_FORMAT_LC2') );
			$comment	= $itemValue->comment;
			$comment 	= PhocaGalleryComment::bbCodeReplace($comment);
			foreach ($smileys as $smileyKey => $smileyValue) {
				$comment = str_replace($smileyKey, JHTML::_( 'image.site', 'components/com_phocagallery/assets/images/'.$smileyValue .'.'.$this->tmpl['formaticon'],'', '', '', '', ''), $comment);
			}
			
			echo '<fieldset>'
				.'<legend>'.$userImage.'&nbsp;'.$itemValue->name.'</legend>'
				.'<p><strong>'.PhocaGalleryText::wordDelete($itemValue->title, 50, '...').'</strong></p>'
				.'<p style="overflow:auto;width:'.$this->tmpl['commentwidth'].'px;">'.$comment.'</p>'
				.'<p style="text-align:right"><small>'.$date.'</small></p>'
				.'</fieldset>';
		}
	}
	
	echo '<fieldset>'.'<legend>'.JText::_('Add comment').'</legend>';

	if ($this->tmpl['alreadycommented']) {
		echo '<p>'.JText::_('You have already submitted comment').'</p>';
	} else if ($this->tmpl['notregistered']) {
		echo '<p>'.JText::_('Only registered and logged in user can submit a comment').'</p>';
	} else {
		echo '<form action="'.$this->tmpl['action'].'" name="phocagallerycommentsform" id="phocagallery-comments-form" method="post" >'	
			.'<table>'
			.'<tr>'
			.'<td>'.JText::_('Name').':</td>'
			.'<td>'.$this->tmpl['name'].'</td>'
			.'</tr>';
			
		echo '<tr>'
			.'<td>'.JText::_('Title').':</td>'
			.'<td><input type="text" name="phocagallerycommentstitle" id="phocagallery-comments-title" value="" maxlength="255" class="comment-input" /></td>'
			.'</tr>';
			
		echo '<tr>'
			.'<td>&nbsp;</td>'
			.'<td>'
			.'<a href="#" onclick="pasteTag(\'b\', true); return false;">'
			. JHTML::_('image', 'components/com_phocagallery/assets/images/icon-b.'.$this->tmpl['formaticon'], JText::_('Bold'))
			.'</a>&nbsp;'
			
			.'<a href="#" onclick="pasteTag(\'i\', true); return false;">'
			. JHTML::_('image', 'components/com_phocagallery/assets/images/icon-i.'.$this->tmpl['formaticon'], JText::_('Italic'))
			.'</a>&nbsp;'
			
			.'<a href="#" onclick="pasteTag(\'u\', true); return false;">'
			. JHTML::_('image', 'components/com_phocagallery/assets/images/icon-u.'.$this->tmpl['formaticon'], JText::_('Underline'))
			.'</a>&nbsp;&nbsp;'
				
			.'<a href="#" onclick="pasteSmiley(\':)\'); return false;">'
			. JHTML::_('image', 'components/com_phocagallery/assets/images/icon-s-smile.'.$this->tmpl['formaticon'], JText::_('Smile'))
			.'</a>&nbsp;'
			
			.'<a href="#" onclick="pasteSmiley(\':lol:\'); return false;">'
			. JHTML::_('image', 'components/com_phocagallery/assets/images/icon-s-lol.'.$this->tmpl['formaticon'], JText::_('Lol'))
			.'</a>&nbsp;'
			
			.'<a href="#" onclick="pasteSmiley(\':(\'); return false;">'
			. JHTML::_('image', 'components/com_phocagallery/assets/images/icon-s-sad.'.$this->tmpl['formaticon'], JText::_('Sad'))
			.'</a>&nbsp;'
			
			.'<a href="#" onclick="pasteSmiley(\':?\'); return false;">'
			. JHTML::_('image', 'components/com_phocagallery/assets/images/icon-s-confused.'.$this->tmpl['formaticon'], JText::_('Confused'))
			.'</a>&nbsp;'
			
			.'<a href="#" onclick="pasteSmiley(\':wink:\'); return false;">'
			. JHTML::_('image', 'components/com_phocagallery/assets/images/icon-s-wink.'.$this->tmpl['formaticon'], JText::_('Wink'))
			.'</a>&nbsp;'
			.'</td>'
			.'</tr>';
			
			echo '<tr>'
				.'<td>&nbsp;</td>'
				.'<td>'
				.'<textarea name="phocagallerycommentseditor" id="phocagallery-comments-editor" cols="30" rows="10"  class= "comment-input" onkeyup="countChars();" ></textarea>'
				.'</td>'
				.'</tr>';
			
			echo '<tr>'
				.'<td>&nbsp;</td>'
				.'<td>'
				. JText::_('Characters written').' <input name="phocagallerycommentscountin" value="0" readonly="readonly" class="comment-input2" /> '
				. JText::_('and left for comment').' <input name="phocagallerycommentscountleft" value="'. $this->tmpl['maxcommentchar'].'" readonly="readonly" class="comment-input2" />'
				.'</td>'
				.'</tr>';
				
			echo '<tr>'
				.'<td>&nbsp;</td>'
				.'<td align="right">'
				.'<input type="submit" id="phocagallerycommentssubmit" onclick="return(checkCommentsForm());" value="'. JText::_('Submit Comment').'"/>'
				.'</td>'
				.'</tr>';
			
			echo '</table>';

			echo '<input type="hidden" name="task" value="comment" />';
			echo '<input type="hidden" name="view" value="comment" />';
			echo '<input type="hidden" name="controller" value="comment" />';
			echo '<input type="hidden" name="id" value="'. $this->tmpl['id'].'" />';
			echo '<input type="hidden" name="catid" value="'. $this->tmpl['catid'].'" />';
			echo '<input type="hidden" name="Itemid" value="'. JRequest::getVar('Itemid', 0, '', 'int') .'" />';
			echo JHTML::_( 'form.token' );
			echo '</form>';
		}
	echo '</fieldset>';
}
echo '</div>';
if ($this->tmpl['detailwindow'] == 7 || $this->tmpl['display_comment_nopup']) {
	echo $this->tmpl['df'];
}
?>