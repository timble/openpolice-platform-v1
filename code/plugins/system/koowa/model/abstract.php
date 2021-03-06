<?php
/**
 * @version		$Id: abstract.php 2106 2010-05-26 19:30:56Z johanjanssens $
 * @category	Koowa
 * @package		Koowa_Model
 * @copyright	Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.koowa.org
 */

/**
 * Abstract Model Class
 *
 * @author		Johan Janssens <johan@joomlatools.org>
 * @category	Koowa
 * @package     Koowa_Model
 * @uses		KMixinClass
 * @uses		KInflector
 * @uses		KObject
 * @uses		KFactory
 */
abstract class KModelAbstract extends KObject
{
	/**
	 * A state object
	 *
	 * @var KRegistry object
	 */
	protected $_state;

    /**
     * List total
     *
     * @var integer
     */
    protected $_total;

    /**
     * Pagination object
     *
     * @var object
     */
    protected $_pagination;

	/**
	 * Model list data
	 *
	 * @var array
	 */
	protected $_list;

    /**
     * Model item data
     *
     * @var mixed
     */
    protected $_item;
      
	/**
	 * Constructor
     *
     * @param	array An optional associative array of configuration settings.
	 */
	public function __construct(array $options = array())
	{
        // Initialize the options
        $options  = $this->_initialize($options);

        // Mixin the KClass
        $this->mixin(new KMixinClass($this, 'Model'));

        // Assign the classname with values from the config
        $this->setClassName($options['name']);

        //Use KObject to store the model state
        $this->_state = new KObject();
        $this->_state->setProperties($options['state']);
		$this->_state->setProperties($this->getDefaultState());
	}

    /**
     * Initializes the options for the object
     * 
     * Called from {@link __construct()} as a first step of object instantiation.
     *
     * @param   array   Options
     * @return  array   Options
     */
    protected function _initialize(array $options)
    {
        $defaults = array(
            'base_path'     => null,
            'name'          => array(
                        'prefix'    => 'k',
                        'base'      => 'model',
                        'suffix'    => 'default'
                        ),
            'state'         => array()
        );

        return array_merge($defaults, $options);
    }

	/**
	 * Method to set model state variables
	 *
	 * @param	string	The name of the property
	 * @param	mixed	The value of the property to set
	 * @return	this
	 */
	public function setState( $property, $value = null )
	{
		$this->_state->set($property, $value);
		return $this;
	}

	/**
	 * Method to get model state variables
	 *
	 * @param	string	Optional parameter name
	 * @param   mixed	Optional default value
	 * @return	object	The property where specified, the state object where omitted
	 */
	public function getState($property = null, $default = null)
	{
		return $property === null ? $this->_state : $this->_state->get($property, $default);
	}

    /**
     * Method to get a item object which represents a table row
     *
     * @return  object KDatabaseRow
     */
    public function getItem()
    {
        return $this->_item;
    }

    /**
     * Get a list of items which represnts a  table rowset
     *
     * @return  object KDatabaseRowset
     */
    public function getList()
    {
        return $this->_list;
    }

    /**
     * Get the total amount of items
     *
     * @return  int
     */
    public function getTotal()
    {
        return $this->_total;
    }

    /**
     * Get a Pagination object
     *
     * @return  JPagination
     */
    public function getPagination()
    {
        // Get the data if it doesn't already exist
        if (!isset($this->_pagination))
        {
            Koowa::import('lib.joomla.html.pagination');
            $this->_pagination = new JPagination($this->getTotal(), $this->getState('offset'), $this->getState('limit'));
        }

        return $this->_pagination;
    }

    /**
     * Get a list of filters
     *
     * @return  array
     */
    public function getFilters()
    {
       $filters = array();
       $filters['limit']       = $this->getState('limit');
       $filters['limitstart']  = $this->getState('offset');
       
    	return $filters;
    }
     
    /**
     * Get the default states
     * 
     * @return array The array with the default state information
     */
    public function getDefaultState()
    {
       	$app 	= KFactory::get('lib.joomla.application');
    	
    	//Get the namespace
    	$ns  	= $app->getName().'::'.'com.'.$this->getClassName('prefix').'.model.'.$this->getClassName('suffix');

        $state = array(); 
        $state['limit']  = $app->getUserStateFromRequest('global.list.limit', 'limit', '20', 'int');
        $state['offset'] = $app->getUserStateFromRequest($ns.'limitstart', 'limitstart', 0, 'int');
        return $state;
    }
}