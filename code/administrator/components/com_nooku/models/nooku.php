<?php
/**
 * @version     $Id: nooku.php 1143 2010-07-25 18:23:35Z johan $
 * @category   	Nooku
 * @package     Nooku_Administrator
 * @subpackage  Models
 * @copyright   Copyright (C) 2007 - 2010 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license     GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link        http://www.nooku.org
 */

/**
 * Nooku Nooku Model
 *
 * @author      Johan Janssens <johan@joomlatools.org>
 * @author      Mathias Verraes <mathias@joomlatools.org>
 * @category   	Nooku
 * @package     Nooku_Administrator
 * @subpackage  Models
 */
class NookuModelNooku extends KModelAbstract
{
	/**
	 * Nooku configuration
	 * 
	 * @var	JParameters
	 */
	protected $_config;
	
    /**
     * Available languages
     *
     * @var array
     */
	protected $_languages = null;

	/**
	 * Available tables
	 *
	 * @var array
	 */
	protected $_tables    = null;

    /**
     * Available translators
     *
     * @var array
     */
    protected $_translators = null;

    /**
	 * Get the configuration
	 *
	 * @access	public
	 * @return	object JParameter
	 */
	public function getConfig()
	{
		if(!isset($this->_config)) {
			$this->_config =  JComponentHelper::getParams('com_nooku');
		}
		return $this->_config;
	}

	/**
	 * Get the installed nooku languages
	 *
	 * @access	public
	 * @return	array	An object list
	 */
	public function getLanguages()
	{
		if(!isset($this->_languages))
		{
			//If we are not in the administrator application take the enable state for languages 
			//into account
			$app = KFactory::get('lib.joomla.application');
			$db  = KFactory::get('lib.joomla.database');
		
			$query = $db->getQuery()
				->select(array('*', 'nooku_language_id AS id'))
				->from('nooku_languages');
				
			if($app->getName() != 'admin') {
				$query->where('enabled', '=', '1');
			}
	
			$db->select($query);
			$this->_languages = $db->loadObjectList('iso_code');
		}
		
		return $this->_languages;
	}

	/**
 	 * Tries to retrieve the client language
 	 *
 	 * @access	public
 	 * @return	array locale
 	 */
	public function getClientLanguages()
	{
		$primary 	= $this->getPrimaryLanguage()->iso_code;
		$accept		= KInput::get('HTTP_ACCEPT_LANGUAGE', 'server', 'raw', null, $primary);

		$languages  = substr( $accept, 0, strcspn($accept, ';' ) );
		$languages	= explode( ',', $languages );
		$languages = array_map('strtolower', $languages);
		
		return $languages;
	}

	/**
	 * Get the tables
	 *
	 * @access	public
	 * @return	array	An object list
	 */
	public function getTables()
	{
		if(!isset($this->_tables))
		{
			$db  = KFactory::get('lib.joomla.database');
			$query = $db->getQuery()
				->select(array('*', 'nooku_table_id AS id'))
				->from('nooku_tables')
				->where('enabled', '=', '1')
				->order('table_name');
			
			$db->select($query);
			$this->_tables = $db->loadObjectList('table_name');
		}

		return $this->_tables;
	}

    /**
     * Get all enabled translators that are associated to an existing language
     *
     * @access  public
     * @return  array   An object list by userid
     */
    public function getTranslators()
    {
        if(!isset($this->_translators))
        {
			$db  = KFactory::get('lib.joomla.database');
        	$a = $db->getQuery()
				->select(array('t.*', 'u.*'))
        		->from('nooku_translators AS t')
        		->join('LEFT', 'users AS u', 'u.id = t.user_id');
        	
        	$b = $db->getQuery()
        		->select(array('0 AS nooku_translator_id', 'u.id AS t.user_id', '1 AS enabled', 'u.*'))
        		->from('users AS u')
        		->where('u.gid', '=', '25')
        		->order('name');
        		
	        $db->select($a.' UNION '.$b);
            $this->_translators = $db->loadObjectList();
        }

        return $this->_translators;
    }

	/**
	 * Set the language
	 *
	 * @access	public
	 * @return	string The language code
	 */
	public function setLanguage($language = '')
	{
		$app    = KFactory::get('lib.joomla.application');
		$lang 	= KFactory::get('lib.joomla.language');
		$db  	= KFactory::get('lib.joomla.database');
		$router = $app->getRouter();

		// Fall back to the language set in the session or cookie
		if(empty($language) || !isset($this->_languages[$language])) {
			$language = $this->getLanguage();
		}

		// Set the language for the site only
		if($app->getName() == 'site') 
		{
			//Set the language in the language object and reload it
			$lang->setLanguage($language);
			$lang->load('joomla', JPATH_BASE, null, true);
			
			//Set the language in the config object
			$config = KFactory::get('lib.joomla.config');
			$config->setValue('config.language', $language);
			
			if(array_key_exists('mosConfig_lang', $GLOBALS)) {
				$GLOBALS['mosConfig_lang'] = $lang->getBackwardLang();
			}
		}

		// Set the language in the session
		$app->setUserState('application.language.content', $language);

		// Set the language in the database object
        $db->setActiveLanguage($language);
        
        // Set a language cookie
        setcookie( 'nooku_lang_'.$app->getName(), $language, time()+ 3600*24*31*12, '/' );

        // Set the language in the legacy database object
        if(defined('_JLEGACY') && (_JLEGACY == '1.0'))
        {
            global $database;
            $database->setActiveLanguage($language);
        }
        
		return $language;
	}

	/**
	 * Get the language
	 *
	 * @access	public
	 * @return	string	The language code
	 */
	public function getLanguage()
	{
		$app = KFactory::get('lib.joomla.application');

		/*
		 * 1. Session
		 * 
		 * Get the language out of the session
		 */
		$language = $app->getUserState('application.language.content');
		
		/*
		 * 2. Cookie
		 * 
		 * Get the language from the cookie and handle corrupted cookies gracefully
		 */
		if(empty($language)) 
		{
			try {
				$language = KInput::get('nooku_lang_'.$app->getName(), 'cookie', 'lang', 'lang', '');
			} catch (KInputException $e) { /* do nothing */ }
		}
		
		/*
		 * 3. User 
		 * 
		 * Get the language from the user 
		 */
		if(empty($language) && $app->isSite()) 
		{
			$user = KFactory::get('lib.joomla.user');
			if(!$user->guest) {
				$language = $user->getParam('language');
			}
		}
		
		/*
		 * 4.Client
		 * 
		 * Try to detect the language based on the client languages
		 */
		if(empty($language))
		{
			$clientLangs = $this->getClientLanguages();
			$systemLangs = array_keys($this->getLanguages());

			foreach($clientLangs as $clientLang)
			{
				foreach($systemLangs as $systemLang)
				{
					if(strtolower($clientLang) === strtolower($systemLang)) 
					{
						$language = $systemLang;
						break(2);
					}
				}
			}
		}
		
		// Try again using only the first part of the client language (eg 'en' instead of 'en-gb')
		if(empty($language))
		{
			foreach($clientLangs as $clientLang)
			{
				$clientLangPart = substr( $clientLang, 0, strcspn($clientLang, '-' ) );
				foreach($systemLangs as $systemLang)
				{
					$systemLangPart = substr( $systemLang, 0, strcspn($systemLang, '-' ) );
					if(strtolower($clientLangPart) === strtolower($systemLangPart)) 
					{
						$language = $systemLang;
						break(2);
					}
				}
			}
			
		}
	
		/*
		 * 5. Primary language
		 * 
		 * If no matching client language was found fall back to the primary language
		 */
		if(empty($language)) {
			$language = $this->getPrimaryLanguage()->iso_code;
		}

		return $language;
	}

    /**
     * Get the primary language
     *
     * @return object
     */
    public function getPrimaryLanguage()
    {
        $config     = $this->getConfig();
        $iso_code   = $config->getValue('primary_language', 'en-GB');
        $languages  = $this->getLanguages();
        return $languages[$iso_code];
    }

    /**
     * Get all languages except the primary
     *
     * @return array	List of languages
     */
    public function getAddedLanguages()
    {
    	$config     = $this->getConfig();
        $iso_code   = $config->getValue('primary_language', 'en-GB');
        $languages  = $this->getLanguages();
        unset($languages[$iso_code]);
        return $languages;
    }    
}

