<?php
defined('_JEXEC') or die('Restricted access'); 

if(!empty($this->itemscv)) {
	$columns 			= (int)$this->tmpl['categoriescolumnscv'];
	$countCategories 	= count($this->itemscv);
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
} else {
	$countCategories 	= 0;
}
// -------------------
// TABLE LAYOUT
// -------------------
if ($this->tmpl['displayimagecategoriescv'] == 1) {	
	for ($i = 0; $i < $countCategories; $i++) {
		
		// Change the thumbnail for Category View
		// We are in Category View but need Categories View Settings
		if (isset($this->itemscv[$i]->extpic) && $this->itemscv[$i]->extpic) {
			
			$categoryCVSize = PhocaGalleryImageFront::getSizeString($this->tmpl['imagetypecv']);
			if ($categoryCVSize == 'm') {
				$picCorW = $this->tmpl['picasa_correct_width_m'];
				$picCorH = $this->tmpl['picasa_correct_height_m'];
			} else {
				$picCorW = $this->tmpl['picasa_correct_width_s'];
				$picCorH = $this->tmpl['picasa_correct_height_s'];
			}
			$imageThumbnail = PhocaGalleryImageFront::displayCategoriesCVExtImgOrFolder($this->itemscv[$i]->extm, $this->itemscv[$i]->exts, $this->itemscv[$i]->linkthumbnailpath, (int)$this->tmpl['imagetypecv']);
		} else {
			$imageThumbnail = PhocaGalleryImageFront::displayCategoriesCVImageOrFolder($this->itemscv[$i]->linkthumbnailpath, (int)$this->tmpl['imagetypecv']);
		}
		// - - - - - - - - - - - - - - -
	
		if ( $columns == 1 ) {
			echo '<table>';
		} else {
			$float = 0;
			foreach ($begin as $k => $v)
			{
				if ($i == $v) {
					$float = 1;
				}
			}
			if ($float == 1) {		
				echo '<div style="position:relative;float:left;margin:10px;"><table>';
			}
		}

		echo '<tr>';		
		echo '<td align="center" valign="middle" style="'.$this->tmpl['imagebgcv'].';text-align:center;"><a href="'.$this->itemscv[$i]->link.'">';
		if (isset($this->itemscv[$i]->extpic) && $this->itemscv[$i]->extpic) {
			
			$correctImageRes = PhocaGalleryPicasa::correctSizeWithRate($this->itemscv[$i]->extw, $this->itemscv[$i]->exth,$picCorW, $picCorH );
			
			echo JHTML::_( 'image', $imageThumbnail, $this->itemscv[$i]->title, array('width' => $correctImageRes['width'], 'height' => $correctImageRes['height']), '',  '', 'style="border:0"' );
		} else {
			echo JHTML::_( 'image.site',$imageThumbnail, '', '', '', $this->itemscv[$i]->title, 'style="border:0"' );
		}
		echo '</a></td>';
		echo '<td><a href="'.$this->itemscv[$i]->link.'" class="category'.$this->params->get( 'pageclass_sfx' ).'">'.$this->itemscv[$i]->title.'</a>&nbsp;';
		
		if ($this->itemscv[$i]->numlinks > 0) {echo '<span class="small">('.$this->itemscv[$i]->numlinks.')</span>';}
		
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
// UL LAYOUT
// -------------------
else {
	for ($i = 0; $i < $countCategories; $i++) {
		
		if ( $columns == 1 ) {
			echo '<ul>';
		} else {
			$float = 0;
			foreach ($begin as $k => $v)
			{
				if ($i == $v) {
					$float = 1;
				}
			}
			if ($float == 1) {		
				echo '<div style="position:relative;float:left;margin:10px"><ul>';
			}
		}
		
		echo '<li><a href="'.$this->itemscv[$i]->link.'" class="category'.$this->params->get( 'pageclass_sfx' ).'">'.$this->itemscv[$i]->title.'</a>&nbsp;';
		
		if ($this->itemscv[$i]->numlinks > 0) {echo '<span class="small">('.$this->itemscv[$i]->numlinks.')</span>';}
		
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
?>
<div class="phoca-hr"></div>