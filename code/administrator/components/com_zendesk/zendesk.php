<?php
require_once (JPATH_COMPONENT.DS.'controller.php');

$controller = new ZendeskController();
$controller->execute('authenticate');
$controller->redirect();