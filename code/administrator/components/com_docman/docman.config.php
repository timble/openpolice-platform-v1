<?php
if(defined('_dmConfig')) {
return true;
} else { 
define('_dmConfig',1); 

class dmConfig
{
var $author_can = '2';
var $days_for_new = '5';
var $default_editor = '-6';
var $default_order = 'name';
var $default_order2 = 'DESC';
var $default_reader = '0';
var $default_viewer = '-1';
var $display_license = '1';
var $dmpath = JPATH_DOCUMENTS;
var $docman_version = '1.5.8';
var $editor_assign = '2';
var $emailgroups = '0';
var $extensions = 'zip|rar|pdf|txt';
var $fname_blank = '0';
var $fname_lc = '0';
var $fname_reject = 'index.htm|index.html|index.php';
var $hide_remote = '1';
var $hot = '100';
var $icon_size = '1';
var $icon_theme = 'default';
var $individual_perm = '1';
var $isDown = '0';
var $log = '0';
var $maintainer = '1';
var $maxAllowed = '10485760';
var $methods = array (
  0 => 'http',
  1 => 'link',
  2 => 'transfer',
);
var $overwrite = '0';
var $perpage = '5';
var $process_bots = '0';
var $reader_assign = '3';
var $registered = '2';
var $security_allowed_hosts = 'localhost';
var $security_anti_leech = '0';
var $specialcompat = '0';
var $trimwhitespace = '1';
var $user_all = '0';
var $user_approve = '-3';
var $user_publish = '-3';
var $user_upload = '0';
var $viewtypes = 'html|htm|txt|jpg|jpeg|gif|png';
}
}