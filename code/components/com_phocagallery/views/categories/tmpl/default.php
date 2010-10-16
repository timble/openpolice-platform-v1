<?php
defined('_JEXEC') or die('Restricted access');
?>
<!-- <div><a>www.phoca.cz - Begin Categories -->
<?php
// Pagetitle
if ( $this->params->def( 'show_page_title', 1 ) ) {
	echo '<div class="componentheading'.$this->params->get( 'pageclass_sfx' ).'">'. $this->params->get('page_title').'</div>';
}
// Image, description
echo '<div class="contentpane'.$this->params->get( 'pageclass_sfx' ).'">';
if ( ($this->params->def('image', -1) != -1) || $this->params->def('show_comp_description', 1) ) {
	echo '<div class="contentdescription'.$this->params->get( 'pageclass_sfx' ).'">';
	if ( isset($this->tmpl['image']) ) {
		echo $this->tmpl['image'];
	}
	echo $this->params->get('comp_description'). '</div>'."\n";
}
echo '</div>';

// Phoca Gallery Width
if ($this->tmpl['phocagallerywidth'] != '') {
	$centerPage = '';
	if ($this->tmpl['phocagallerycenter'] == 2 || $this->tmpl['phocagallerycenter'] == 3) {
		$centerPage = 'margin: auto;';
	}
	echo '<div id="phocagallery" style="width:'. $this->tmpl['phocagallerywidth'].'px;'.$centerPage.'">';
} else {
	echo '<div id="phocagallery">';
}

echo '<form action="'.$this->tmpl['action'].'" method="post" name="adminForm">';

$columns 			= (int)$this->tmpl['categoriescolumns'];
$countCategories 	= count($this->categories);
$begin				= array();
$end				= array();
$begin[0]			= 0;// first
$begin[1]			= ceil ($countCategories / $columns);
$end[0]				= $begin[1] -1;

for ( $j = 2; $j < $columns; $j++ ) {
	$begin[$j]	= ceil(($countCategories / $columns) * $j);
	$end[$j-1]	= $begin[$j] - 1;
}
$end[$j-1]		= $countCategories - 1;// last
$endFloat		= $countCategories - 1;


if($this->tmpl['equalpercentagewidth'] == 1) {
	$fixedWidth			= 100 / (int)$columns;
	$fixedWidhtStyle1	= 'width:'.$fixedWidth.'%;';
	$fixedWidhtStyle2	= 'width:'.$fixedWidth.'%;';
} else {
	$fixedWidhtStyle1	= 'margin: 10px;';
	$fixedWidhtStyle2	= 'margin: 0px;';
}


// -------------------
// TABLE LAYOUT
// -------------------
if ($this->tmpl['displayimagecategories'] == 1) {	
	for ($i = 0; $i < $countCategories; $i++) {
		if ( $columns == 1 ) {
			echo '<table>';
		} else {
			$float = 0;
			foreach ($begin as $k => $v) {
				if ($i == $v) {
					$float = 1;
				}
			}
			if ($float == 1) {		
				echo '<div style="position:relative;float:left;'.$fixedWidhtStyle1.'"><table>';
			}
		}

		echo '<tr>';		
		echo '<td align="center" valign="middle" style="'.$this->tmpl['imagebg'].';text-align:center;"><a href="'.$this->categories[$i]->link.'">';

		if (isset($this->categories[$i]->extpic) && $this->categories[$i]->extpic) {
		
			$correctImageRes = PhocaGalleryPicasa::correctSizeWithRate($this->categories[$i]->extw, $this->categories[$i]->exth, $this->tmpl['picasa_correct_width'], $this->tmpl['picasa_correct_height']);
			echo JHTML::_( 'image', $this->categories[$i]->linkthumbnailpath, str_replace('&raquo;', '-',$this->categories[$i]->title), array('width' => $correctImageRes['width'], 'height' => $correctImageRes['height']), '', '', 'style="border:0"');
			
		} else {
		
			echo JHTML::_( 'image.site', $this->categories[$i]->linkthumbnailpath, '', '', '', str_replace('&raquo;', '-',$this->categories[$i]->title), 'style="border:0"' );
		}
		echo '</a></td>';
		echo '<td><a href="'.$this->categories[$i]->link.'" class="category'.$this->params->get( 'pageclass_sfx' ).'">'.$this->categories[$i]->title.'</a>&nbsp;';
		
		if ($this->categories[$i]->numlinks > 0) {echo '<span class="small">('.$this->categories[$i]->numlinks.')</span>';}
		
		echo '</td>';
		echo '</tr>';
		
		if ( $columns == 1 ) {
			echo '</table>';
		} else {
			if ($i == $endFloat) {
				echo '</table></div><div style="clear:both"></div>';
			} else {
				$float = 0;
				foreach ($end as $k => $v)
				{
					if ($i == $v) {
						$float = 1;
					}
				}
				if ($float == 1) {		
					echo '</table></div>';
				}
			}
		}
	} 
}

// -------------------
// DETAIL LAYOUT 2 (with columns)
// -------------------

else if ($this->tmpl['displayimagecategories'] == 2){
	
	echo '<div id="phocagallery-categories-detail">';
	
	for ($i = 0; $i < $countCategories; $i++) {
		
		// - - - - -
		if ( $columns == 1 ) {
			echo '<div>';
		} else {
			$float = 0;
			foreach ($begin as $k => $v) {
				if ($i == $v) {
					$float = 1;
				}
			}
			if ($float == 1) {		
				echo '<div style="position:relative;float:left;'.$fixedWidhtStyle2.'">';
			}
		}
		// - - - - -
	
		echo '<fieldset>'
			.' <legend>'
			.'  <a href="'.$this->categories[$i]->link.'" class="category'.$this->params->get( 'pageclass_sfx' ).'">'.$this->categories[$i]->title_self.'</a> ';
			
		if ($this->categories[$i]->numlinks > 0) {
			echo '<span class="small">('.$this->categories[$i]->numlinks.')</span>';
		}	
			
		echo ' </legend>';
		
		echo '<div style="padding:0;margin:0;margin-top:10px;margin-bottom:5px">'
		    .'<div style="position:relative;float:left;margin:0;padding:0">'
		    .' <table border="0" cellpadding="0" cellspacing="0">'
			.'  <tr>'
			.'   <td style="'.$this->tmpl['imagebg'].';text-align:center;"><a href="'.$this->categories[$i]->link.'">';
		
		if (isset($this->categories[$i]->extpic) && $this->categories[$i]->extpic) {
		
			$correctImageRes = PhocaGalleryPicasa::correctSizeWithRate($this->categories[$i]->extw, $this->categories[$i]->exth, $this->tmpl['picasa_correct_width'], $this->tmpl['picasa_correct_height']);
			echo JHTML::_( 'image', $this->categories[$i]->linkthumbnailpath, '', array('width' => $correctImageRes['width'], 'height' => $correctImageRes['height']), '', str_replace('&raquo;', '-',$this->categories[$i]->title), 'style="border:0"');
			
		} else {
		
			echo JHTML::_( 'image.site', $this->categories[$i]->linkthumbnailpath, '', '', '', str_replace('&raquo;', '-',$this->categories[$i]->title), 'style="border:0"' );
		}

		echo '</a></td>'
			.'  </tr>'
			.' </table>'
			.'</div>';
		
		
		echo '<div style="margin-right:5px;margin-left:'.$this->tmpl['imagewidth'].'px;">';
		if ($this->categories[$i]->description != '') {
		   echo '<div>'.$this->categories[$i]->description.'</div><p>&nbsp;</p>';
		}
		echo '<table border="0" cellpadding="0" cellspacing="0" >';
		if ( $this->categories[$i]->username != '') {
			echo '<tr><td>'.JText::_('Author') .': </td>'
			    .'<td>'.$this->categories[$i]->username.'</td></tr>';
		}
		
		echo '<tr><td>'.JText::_('Number of images in category') .': </td>'
		.'<td>'.$this->categories[$i]->numlinks.'</td></tr>'
		.'<tr><td>'.JText::_('Category viewed') .': </td>'
		.'<td>'.$this->categories[$i]->hits.' x</td></tr>';

		// Rating
		if ($this->tmpl['displayrating'] == 1) {
			$votesCount = $votesAverage = $votesWidth = 0;
			if (!empty($this->categories[$i]->ratingcount)) {
				$votesCount = $this->categories[$i]->ratingcount;
			}
			if (!empty($this->categories[$i]->ratingaverage)) {
				$votesAverage = $this->categories[$i]->ratingaverage;
				if ($votesAverage > 0) {
					$votesAverage 	= round(((float)$votesAverage / 0.5)) * 0.5;
					$votesWidth		= 22 * $votesAverage;
				}
				
			}
			if ((int)$votesCount > 1) {
				$votesText = 'votes';
			} else {
				$votesText = 'vote';
			}
			
			echo '<tr><td>' . JText::_('Rating'). ': </td>'
				.'<td>' . $votesAverage .' / '.$votesCount . ' ' . JText::_($votesText). '</td></tr>'
				.'<tr><td>&nbsp;</td>'
				.'<td>'
				.' <ul class="star-rating">'
				.'  <li class="current-rating" style="width:'.$votesWidth.'px"></li>'
				.'   <li><span class="star1"></span></li>';
			for ($r = 2;$r < 6;$r++) {
				echo '<li><span class="stars'.$r.'"></span></li>';
			}
			echo '</ul>'
				 .'</td>'
				 .'</tr>';
		}
		
		echo '</table>'
			 .'</div>'
		     //.'<div style="clear:both;"></div>'
			 .'</div>'
		     .'</fieldset>';
	
		// - - - - - 
		if ( $columns == 1 ) {
			echo '</div>';
		} else {
			if ($i == $endFloat) {
				echo '</div><div style="clear:both"></div>';
			} else {
				$float = 0;
				foreach ($end as $k => $v) {
					if ($i == $v) {
						$float = 1;
					}
				}
				if ($float == 1) {		
					echo '</div>';
				}
			}
		}
		// - - - - -
	}
	echo '</div>';

}


// -------------------
// DETAIL LAYOUT 3 - FLOAT - Every categoy will float Categories, images and detail information (Float)
// -------------------

else if ($this->tmpl['displayimagecategories'] == 3){
	
	echo '<div id="phocagallery-categories-detail">';
	
	for ($i = 0; $i < $countCategories; $i++) {
		
		echo '<div style="position:relative;float:left;width:'.$this->tmpl['categoriesboxwidth'].';">';
	
		echo '<fieldset>'
			.' <legend>'
			.'  <a href="'.$this->categories[$i]->link.'" class="category'.$this->params->get( 'pageclass_sfx' ).'">'.$this->categories[$i]->title_self.'</a> ';
			
		if ($this->categories[$i]->numlinks > 0) {
			echo '<span class="small">('.$this->categories[$i]->numlinks.')</span>';
		}	
			
		echo ' </legend>';
		
		echo '<div style="padding:0;margin:0;margin-top:10px;margin-bottom:5px">'
		    .'<div style="position:relative;float:left;margin:0;padding:0">'
		    .' <table border="0" cellpadding="0" cellspacing="0">'
			.'  <tr>'
			.'   <td style="'.$this->tmpl['imagebg'].';text-align:center;"><a href="'.$this->categories[$i]->link.'">';
		
		if (isset($this->categories[$i]->extpic) && $this->categories[$i]->extpic) {
		
			$correctImageRes = PhocaGalleryPicasa::correctSizeWithRate($this->categories[$i]->extw, $this->categories[$i]->exth, $this->tmpl['picasa_correct_width'], $this->tmpl['picasa_correct_height']);
			echo JHTML::_( 'image', $this->categories[$i]->linkthumbnailpath, str_replace('&raquo;', '-',$this->categories[$i]->title), array('width' => $correctImageRes['width'], 'height' => $correctImageRes['height']), '', '', 'style="border:0"');
			
		} else {
		
			echo JHTML::_( 'image.site', $this->categories[$i]->linkthumbnailpath, '', '', '', str_replace('&raquo;', '-',$this->categories[$i]->title), 'style="border:0"' );
		}

		echo '</a></td>'
			.'  </tr>'
			.' </table>'
			.'</div>';
		
		
		echo '<div style="margin-right:5px;margin-left:'.$this->tmpl['imagewidth'].'px;">';
		if ($this->categories[$i]->description != '') {
		   echo '<div>'.$this->categories[$i]->description.'</div><p>&nbsp;</p>';
		}
		echo '<table border="0" cellpadding="0" cellspacing="0" >';
		if ( $this->categories[$i]->username != '') {
			echo '<tr><td>'.JText::_('Author') .': </td>'
			    .'<td>'.$this->categories[$i]->username.'</td></tr>';
		}
		
		echo '<tr><td>'.JText::_('Number of images in category') .': </td>'
		.'<td>'.$this->categories[$i]->numlinks.'</td></tr>'
		.'<tr><td>'.JText::_('Category viewed') .': </td>'
		.'<td>'.$this->categories[$i]->hits.' x</td></tr>';

		// Rating
		if ($this->tmpl['displayrating'] == 1) {
			$votesCount = $votesAverage = $votesWidth = 0;
			if (!empty($this->categories[$i]->ratingcount)) {
				$votesCount = $this->categories[$i]->ratingcount;
			}
			if (!empty($this->categories[$i]->ratingaverage)) {
				$votesAverage = $this->categories[$i]->ratingaverage;
				if ($votesAverage > 0) {
					$votesAverage 	= round(((float)$votesAverage / 0.5)) * 0.5;
					$votesWidth		= 22 * $votesAverage;
				}
				
			}
			if ((int)$votesCount > 1) {
				$votesText = 'votes';
			} else {
				$votesText = 'vote';
			}
			
			echo '<tr><td>' . JText::_('Rating'). ': </td>'
				.'<td>' . $votesAverage .' / '.$votesCount . ' ' . JText::_($votesText). '</td></tr>'
				.'<tr><td>&nbsp;</td>'
				.'<td>'
				.' <ul class="star-rating">'
				.'  <li class="current-rating" style="width:'.$votesWidth.'px"></li>'
				.'   <li><span class="star1"></span></li>';
			for ($r = 2;$r < 6;$r++) {
				echo '<li><span class="stars'.$r.'"></span></li>';
			}
			echo '</ul>'
				 .'</td>'
				 .'</tr>';
		}
		
		echo '</table>'
			 .'</div>'
		     //.'<div style="clear:both;"></div>'
			 .'</div>'
		     .'</fieldset>';
	
		
		echo '</div>';
		
	}
	echo '<div style="clear:both"></div>';
	echo '</div>';

}

// -------------------
// LAYOUT 4 (with columns) (easy categories, images and description)
// -------------------

else if ($this->tmpl['displayimagecategories'] == 4){
	
	echo '<div id="phocagallery-categories-detail">';
	
	for ($i = 0; $i < $countCategories; $i++) {
		
		echo '<div style="position:relative;float:left;width:'.$this->tmpl['categoriesboxwidth'].';">';
	
		/*echo '<fieldset>'
			.' <legend>'
			.'  <a href="'.$this->categories[$i]->link.'" class="category'.$this->params->get( 'pageclass_sfx' ).'">'.$this->categories[$i]->title_self.'</a> ';
			
		if ($this->categories[$i]->numlinks > 0) {
			echo '<span class="small">('.$this->categories[$i]->numlinks.')</span>';
		}	
			
		echo ' </legend>';*/
		
		echo '<div style="padding:0;margin:0;margin-top:10px;margin-bottom:5px">'
		    .'<div style="position:relative;float:left;margin:0;padding:0">'
		    .' <table border="0" cellpadding="0" cellspacing="0">'
			.'  <tr>'
			.'   <td style="'.$this->tmpl['imagebg'].';text-align:center;"><a href="'.$this->categories[$i]->link.'">';
		
		if (isset($this->categories[$i]->extpic) && $this->categories[$i]->extpic) {
		
			$correctImageRes = PhocaGalleryPicasa::correctSizeWithRate($this->categories[$i]->extw, $this->categories[$i]->exth, $this->tmpl['picasa_correct_width'], $this->tmpl['picasa_correct_height']);
			echo JHTML::_( 'image', $this->categories[$i]->linkthumbnailpath, str_replace('&raquo;', '-',$this->categories[$i]->title), array('width' => $correctImageRes['width'], 'height' => $correctImageRes['height']), '', '', 'style="border:0"');
			
		} else {
		
			echo JHTML::_( 'image.site', $this->categories[$i]->linkthumbnailpath, '', '', '', str_replace('&raquo;', '-',$this->categories[$i]->title), 'style="border:0"' );
		}

		echo '</a></td>'
			.'  </tr>'
			.' </table>'
			.'</div>';
		
		
		echo '<div style="margin-right:5px;margin-left:'.$this->tmpl['imagewidth'].'px;">';
		
		echo '<div style="padding-top:5px"><a href="'.$this->categories[$i]->link.'" class="category'.$this->params->get( 'pageclass_sfx' ).'">'.$this->categories[$i]->title_self.'</a> ';
			
		if ($this->categories[$i]->numlinks > 0) {
			echo '<span class="small">('.$this->categories[$i]->numlinks.')</span>';
		}
		echo '</div>';
		
		if ($this->categories[$i]->description != '') {
		   echo '<div style="margin-top:5px">'.$this->categories[$i]->description.'</div>';
		}
		
		echo '</div>'
		     //.'<div style="clear:both;"></div>'
			 .'</div>';
	
		
		echo '</div>';
		
	}
	echo '<div style="clear:both"></div>';
	echo '</div>';

}

// -------------------
// UL LAYOUT
// -------------------
else {
	for ($i = 0; $i < $countCategories; $i++) {
		if ( $columns == 1 ) {
			echo '<ul>';
		} else {
			$float = 0;
			foreach ($begin as $k => $v) {
				if ($i == $v) {
					$float = 1;
				}
			}
			if ($float == 1) {		
				echo '<div style="position:relative;float:left;'.$fixedWidhtStyle1.'"><ul>';
			}
		}
		
		echo '<li><a href="'.$this->categories[$i]->link.'" class="category'.$this->params->get( 'pageclass_sfx' ).'">'.$this->categories[$i]->title.'</a>&nbsp;';
		
		if ($this->categories[$i]->numlinks > 0) {echo '<span class="small">('.$this->categories[$i]->numlinks.')</span>';}
		
		echo '</li>';
		
		if ( $columns == 1 ) {
			echo '</ul>';
		} else {
			if ($i == $endFloat) {
				echo '</ul></div><div style="clear:both"></div>';
			} else {
				$float = 0;
				foreach ($end as $k => $v)
				{
					if ($i == $v) {
						$float = 1;
					}
				}
				if ($float == 1) {		
					echo '</ul></div>';
				}
			}
		}
	}
}


if (count($this->categories)) {
	echo '<div class="pgcenter">';
	if ($this->params->get('show_pagination_limit_categories')) {
		
		echo '<div class="pginline">'
			.JText::_('Display Num') .'&nbsp;'
			.$this->tmpl['pagination']->getLimitBox()
			.'</div>';
	}
	
	if ($this->params->get('show_pagination_categories')) {
	
		echo '<div style="margin:0 10px 0 10px;display:inline;" class="sectiontablefooter'.$this->params->get( 'pageclass_sfx' ).'" >'
			.$this->tmpl['pagination']->getPagesLinks()
			.'</div>'
		
			.'<div style="margin:0 10px 0 10px;display:inline;" class="pagecounter">'
			.$this->tmpl['pagination']->getPagesCounter()
			.'</div>';
	}
	echo '</div>';
}
echo '</form><div>&nbsp;</div>' . $this->tmpl['phoac'].'</div>';
?>
<!-- End Categories </a></div> -->