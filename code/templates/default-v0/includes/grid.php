<?php
defined('_JEXEC') or die('Restricted access');

$main = '12';
$main_right = '4';

$main_component = $main - ($this->countModules('right') ? $main_right : '');