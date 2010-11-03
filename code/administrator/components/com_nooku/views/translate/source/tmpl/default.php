<? /** $Id: default.php 699 2008-09-15 16:29:46Z mathias $ */ ?>
<? defined('_JEXEC') or die; ?>

<? @helper('stylesheet', 'editor_content.css', JURI::root().'plugins/editors/tinymce/jscripts/tiny_mce/themes/simple/css/');?>
<? @helper('stylesheet', 'editor.css', JURI::root().'templates/system/css/');?>

<?= @$text?>