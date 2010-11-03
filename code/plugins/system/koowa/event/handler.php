<?php
/**
 * @version     $Id: handler.php 2106 2010-05-26 19:30:56Z johanjanssens $
 * @category	Koowa
 * @package     Koowa_Event
 * @copyright   Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license     GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link        http://www.koowa.org
 */

/**
 * Class to handle events.
 *
 * @author 		Johan Janssens <johan@joomlatools.org>
 * @category	Koowa
 * @package 	Koowa_Event
 */
class KEventHandler extends KObject implements KPatternObserver
{
	/**
	 * Constructor
	 */
	public function __construct()
	{
        // Mixin the KClass
        $this->mixin(new KMixinClass($this, 'Event'));
	}

	/**
	 * Method to trigger events
	 *
	 * @param  object	$args	 The event arguments
	 * @return mixed Routine return value
	 */
	public function onNotify(ArrayObject $args)
	{		
		if (method_exists($this, $args['event'])) {
			return $this->{$args['event']}($args);
		} 
		
		return null;
	}
}
