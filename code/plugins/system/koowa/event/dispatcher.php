<?php
/**
 * @version     $Id: dispatcher.php 2106 2010-05-26 19:30:56Z johanjanssens $
 * @category	Koowa
 * @package     Koowa_Event
 * @copyright   Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license     GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link        http://www.koowa.org
 */

/**
 * Class to handle dispatching of events.
 *
 * @author 		Johan Janssens <johan@joomlatools.org>
 * @category	Koowa
 * @package 	Koowa_Event
 */
class KEventDispatcher extends KPatternObservable
{
	/**
	 * Registers an event handler to the event dispatcher
	 *
	 * @param	string|object	$handler	Name of the event handler or an instance
	 */
	public function register($handler)
	{
		if(!$handler instanceof KEventHandler) 
		{
			if (class_exists($handler)) {
				$this->attach(new $handler());
			}
		} else $this->attach($handler);
	}

	/**
	 * Triggers an event by dispatching arguments to all observers that handle
	 * the event and returning their return values.
	 *
	 * @param	string	$event			The event name
	 * @param	object	$args			An associative array of arguments
	 * @return	array	An array of results from each function call
	 */
	public function dispatch($event, ArrayObject $args)
	{
		$args['event'] = $event;
		return $this->notify($args);
	}
}
