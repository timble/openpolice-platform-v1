<?php

/**
 * @package   	JCE
 * @copyright 	Copyright (c) 2009-2013 Ryan Demmer. All rights reserved.
 * @license   	GNU/GPL 2 or later - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * JCE is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */
class WFMediamanagerPluginConfig {

    public static function getConfig(&$settings) {
        $wf     = WFEditor::getInstance();
        $model  = new WFModelEditor();

        if ($wf->getParam('mediamanager.aggregator.youtube.enable', 1) || $wf->getParam('mediamanager.aggregator.vimeo.enable', 1)) {
            $model->removeKeys($settings['invalid_elements'], array('iframe'));
        }
    }

}

?>