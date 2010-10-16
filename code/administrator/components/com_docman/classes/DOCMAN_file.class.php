<?php
/**
 * @version		$Id: DOCMAN_file.class.php 1368 2010-05-04 13:39:40Z mathias $
 * @category	DOCman
 * @package		DOCman15
 * @copyright	Copyright (C) 2003 - 2009 Johan Janssens and Mathias Verraes. All rights reserved.
 * @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link     	http://www.joomladocman.org
 */
defined('_JEXEC') or die('Restricted access');

require_once($_DOCMAN->getPath('classes', 'mime'));
require_once($_DOCMAN->getPath('includes', 'defines'));	// define _DM_VALIDATE_xxxx
jimport('joomla.filesystem.path');

class DOCMAN_File
{
	/**
	* @access public
	* @var string
	*/
    var $path 			= null;
	/**
	* @access public
	* @var string
	*/
    var $name 			= null;
	/**
	* @access public
	* @var string
	*/
    var $mime 			= null;
    /**
	* @access public
	* @var string
	*/
    var $ext 			= null;

    /**
	* @access public
	* @var string
	*/
    var $size			= null;

    /**
	* @access public
	* @var string
	*/
    var $date			= null;

    /**
	* @access private
	* @var string
	*/
    var $_err    		= null;

	/**
	 * @access private
	 * @var boolean
	 */
	var $_isLink;

	function DOCMAN_File($name, $path)
	{
		$path = DOCMAN_Compat::mosPathName( $path );
		if (!is_dir( $path )) {
			$path = dirname( $path );
			// Make sure there's a trailing slash in the path
            $path = DOCMAN_Compat::mosPathName($path);
		}

		$this->name = trim($name);
		$this->path = $path;

		if( strcasecmp( substr( $this->name , 0, _DM_DOCUMENT_LINK_LNG ) , _DM_DOCUMENT_LINK )==0){
			$this->_isLink = true;
			$this->size    = 0;
			$this->mime    = 'link';
		}else{
			$this->_isLink = false;
			$this->size = @filesize($this->path.$this->name);
			$this->mime	= DOCMAN_MIME_Magic::filenameToMIME($this->name, false);
			$this->name = basename($name);
		}

		$this->ext  = $this->getExtension();
	}

	/**
	*    Downloads a file from the server
	*
	*    @desc This is the function handling files downloading using HTTP protocol
	*    @param void
	*    @return void
	*/

    function download($inline = false)
    {
		// Fix [3164]
		while (@ob_end_clean());

		if( $this->_isLink ){
			header( "Location: " . substr( $this->name , 6 ) );
			return;
		}

		$fsize = @filesize($this->path.$this->name);
		$mod_date = date('r', filemtime( $this->path.$this->name ) );
		$cont_dis = $inline ? 'inline' : 'attachment';

		// required for IE, otherwise Content-disposition is ignored
		if(ini_get('zlib.output_compression'))  {
			ini_set('zlib.output_compression', 'Off');
		}

		// fix for IE7/8, ticket #183
		if(function_exists('apache_setenv')) {
			apache_setenv('no-gzip', '1');
		}

        header("Pragma: public");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Expires: 0");
        header("Content-Transfer-Encoding: binary");
		header('Content-Disposition:' . $cont_dis .';'
			. ' filename="' . str_replace('"', '\"', $this->name) . '";'
			. ' modification-date="' . $mod_date . '";'
			. ' size=' . $fsize .';'
			); //RFC2183
        header("Content-Type: "    . $this->mime );			// MIME type
        header("Content-Length: "  . $fsize);

        if( ! ini_get('safe_mode') ) { // set_time_limit doesn't work in safe mode
		    @set_time_limit(0);
        }

 		// No encoding - we aren't using compression... (RFC1945)
		//header("Content-Encoding: none");
		//header("Vary: none");


        $this->readfile_chunked($this->path.$this->name);
        // The caller MUST 'die();'
    }

    function readfile_chunked($filename,$retbytes=true)
    {
   		$chunksize = 1*(1024*1024); // how many bytes per chunk
   		$buffer = '';
   		$cnt =0;
   		$handle = fopen($filename, 'rb');
   		if ($handle === false) {
       		return false;
   		}
   		while (!feof($handle)) {
       		$buffer = fread($handle, $chunksize);
       		echo $buffer;
			@ob_flush();
			flush();
       		if ($retbytes) {
           		$cnt += strlen($buffer);
       		}
   		}
       $status = fclose($handle);
   	   if ($retbytes && $status) {
       		return $cnt; // return num. bytes delivered like readfile() does.
   		}
   		return $status;
	}

	 function exists() {
		if( $this->_isLink ){
			return true;
		}
	    return file_exists($this->path.DS.$this->name);
    }

	function isLink(){
		return $this->_isLink ;
	}

    /**
	*    Get file size
	*
	*    @desc Gets the file size and convert it to friendly format
	*    @param void
	*    @return string Returns filesize in a friendly format.
	*/

	function getSize()
    {
		if( $this->_isLink ){
			return 'Link';
		}
        $kb = 1024;
        $mb = 1024 * $kb;
        $gb = 1024 * $mb;
        $tb = 1024 * $gb;

        $size = $this->size;

        if ($size) {
            if ($size < $kb) {
                $file_size = $size .' '. _DML_BYTES;
            }
            elseif ($size < $mb) {
                $final = round($size/$kb,2);
                $file_size = $final .' '. _DML_KB;
            }
            elseif ($size < $gb) {
                $final = round($size/$mb,2);
                $file_size = $final .' '. _DML_MB;
            }
            elseif($size < $tb) {
                $final = round($size/$gb,2);
                $file_size = $final .' '. _DML_GB;
            } else {
                $final = round($size/$tb,2);
                $file_size = $final .' '. _DML_TB;
            }
        } else {
	       if( $size == 0 ) {
	           $file_size = _DML_EMPTY;
           } else {
                $file_size = _DML_ERROR;
           }
        }
        return $file_size;
    }

    /**
	*    @desc Gets the extension of a file
	*    @return string The file extension
	*/

    function getExtension()
    {
		/*
         * Fix for http://www.joomlatools.eu/index.php?option=com_simpleboard&Itemid=0&func=view&id=13805&catid=506
		 */
         //if( $this->_isLink )
		 //	return "lnk";

        $dotpos = strrpos($this->name, ".");
        if ($dotpos < 1)
            return "unk";

        return substr($this->name, $dotpos + 1);
    }

    function getDate($type = 'm')
    {
        $mainframe = JFactory::getApplication();
    	$offset = $mainframe->getCfg('offset');

		if( $this->_isLink ){
			return "";
		}

    	$date = '';

    	switch($type) {
    		case 'm' :
    			$date = filemtime($this->path.$this->name);
    			break;
    		case 'a' :
    			$date = fileatime($this->path.$this->name);
    			break;
    		case 'c' :
    			$date = filectime($this->path.$this->name);
    			break;
    	}

        return strftime( _DM_DATEFORMAT_LONG, $date + ($offset*60*60) );

    }

    function remove(){
    	@unlink( $this->path.$this->name );
        return !$this->exists;
    }
}

class DOCMAN_FileUpload
{
	/**
	* @access public
	* @var string
	*/
    var $max_file_size	= null;
	/**
	* @access public
	* @var string
	*/
    var $ext_array		= null;
	/**
	* @access private
	* @var string
	*/
    var $_err           = null;
	/**
	* @access private
	* @var string
	*/
    var $fname_blank;
	/**
	* @access private
	* @var string
	*/
    var $fname_reject;
	/**
	* @access private
	* @var string
	*/
    var $fname_lc;
	/**
	* @access private
	* @var array
	*/
    var $proto_accept = null;
	/**
	* @access private
	* @var array
	*/
    var $proto_reject;


	function DOCMAN_FileUpload()
	{
		global $_DOCMAN;
		$this->max_file_size = 0+ trim( $_DOCMAN->getCfg('maxAllowed'));
		$this->ext_array     = explode('|', strtolower( $_DOCMAN->getCfg('extensions')));
		$this->_err          = '';

		$this->fname_blank   = $_DOCMAN->getCfg('fname_blank');
		$this->fname_reject  = $_DOCMAN->getCfg('fname_reject');
		$this->fname_lc      = $_DOCMAN->getCfg('fname_lc'   );
		$this->proto_reject  = array( 'file','php','zlib', 'asp', 'pl',
				'compress.zlib','compress.bzip2','ogg' );
		$this->proto_accept  = array( 'http','https','ftp');
	}

	/**
	*    Uploads a file using the HTTP protocol
	*
	*    @desc Uploads a file using HTTP.
	*    @param void
	*    @return boolean Returns true if succeed and false if not. Sets $this->_err with false.
	*/

    function uploadHTTP(&$file, $path, $validate = _DM_VALIDATE_ALL )
    {
		$name 	   = DOCMAN_Utils::stripslashes($file['name']);

		$errorcode = $file['error'] ? $file['error'] : 0;
    	$temp_name = trim($file['tmp_name']);

        if(($validate & _DM_VALIDATE_PATH   && ! $this->validatePath( $path) )
	 		|| ($validate & _DM_VALIDATE_NAME   && ! $this->validateName( $name ) )
	 		|| ($validate & _DM_VALIDATE_EXISTS && ! $this->validateExists( $name, $path ) )
	 		|| ($validate & _DM_VALIDATE_SIZE   && ! $this->validateSize($temp_name))
	 		|| ($validate & _DM_VALIDATE_EXT    && ! $this->validateExt($name)) ){

            	return false;
        }


		if( $errorcode == 0 ){
    	     return $this->_upload($name, $temp_name, $path);
        }

		// Finish by handling errors
		switch ($errorcode )
		{
	     case UPLOAD_ERR_INI_SIZE:
	     case UPLOAD_ERR_FORM_SIZE:
        	$this->_err = _DML_SIZEEXCEEDS;
			break;

	     case UPLOAD_ERR_PARTIAL:
			$this->_err = _DML_ONLYPARTIAL;
			break;

	     case UPLOAD_ERR_NO_FILE:
			$this->_err = _DML_NOUPLOADED;
			break;

	     default:
	  		$this->_err = _DML_TRANSFERERROR." $errorcode";
			break;
		}
		return false;
    }


    function _upload($name, $temp_name, $path)
    {
		if (is_uploaded_file($temp_name)) {
	   		if (move_uploaded_file($temp_name, $path.DS.$name)) {
               	$file = new DOCMAN_File($name, $path);
               	return $file;
	   		} else {
        		$this->_err = _DML_DIRPROBLEM." ";
	   		}
       	} else {
        	$this->_err = _DML_DIRPROBLEM2." ";
		}
        return false;
    }

    /**
	*    transfer a file using HTTP protocol between servers
	*
	*    @desc Member function handling file transfer using HTTP protocol from a foreign server to local server
	*    @param void
	*    @return boolean Returns false if file could not be transfered
	*                    and true if it does. Sets _error if false.
	*/

    function uploadURL($url, $path, $validate=_DM_VALIDATE_ALL, $name=null )
    {
		$errid  = null;
        $errmsg = null;

        if( !$parsedurl = parse_url($url))
        {
            $this->_err = 'Malformed url: '.$url;
            return false;
        }

		if( ! $name ) {
			$name = basename($parsedurl["path"]) ;
		}

        if(($validate & _DM_VALIDATE_PATH   && ! $this->validatePath( $path) )
	 		|| ($validate & _DM_VALIDATE_NAME   && ! $this->validateName( $name ) )
	 		|| ($validate & _DM_VALIDATE_EXISTS && ! $this->validateExists( $name, $path ) )
	 		|| ($validate & _DM_VALIDATE_EXT    && ! $this->validateExt( $name))
	 		|| ($validate & _DM_VALIDATE_PROTO  && ! $this->validateProtocol( $parsedurl['scheme']))
		){
            return false;
        }

		// Open the URL source using PHP fopen schema.
		$bufferhandle = @fopen( $url , 'rb' );	//Binary read-mode
		if( ! $bufferhandle ){
       		$this->_err = _DML_COULDNOTCONNECT." " . @$parsedurl['host'];
			return false;
		}

		// Open the local file and copy contents
		$file_to_open = $path . $name ;
		if ($fh = fopen($file_to_open,"w") ) {
			$filesize = 0;
			while (!feof($bufferhandle)) {
              	$buffer = fread($bufferhandle,40960);
		   		$bsize = strlen( $buffer );
		   		if( $validate & _DM_VALIDATE_SIZE ){
					if( $filesize+$bsize > $this->max_file_size){
						fclose( $fh );
						fclose( $bufferhandle );
						unlink( $file_to_open );
        				$this->_err .= _DML_SIZEEXCEEDS;
						return( false );
					}
		   		}
              	fwrite($fh, $buffer);
               	$filesize += $bsize;
          	}
          	fclose($fh);
          	fclose($bufferhandle);

         	$file = new DOCMAN_File($name , $path);
           	return $file;
		} else {
			$this->_err = _DML_COULDNOTOPEN." $file_to_open , $path , $name";
            return false;
        }
    }


    /**
	*    Check a file for linking
	*
	*    @desc Member function handling link testing using internet protocol from a foreign server to local server
	*    @param void
	*    @return boolean Returns false if file could not be transfered
	*                    and true if it does. Sets _error if false.
	*/
    function uploadLINK($url,  $validate=_DM_VALIDATE_ALL )
    {
		if( !$parsedurl = parse_url($url))
        {
        	$this->_err = 'Malformed url: '.$url;
            return false;
        }


        if( $validate &
			_DM_VALIDATE_PROTO  && ! $this->validateProtocol( $parsedurl['scheme'])){
            	return false;
        }

		if( $parsedurl['host'] == '' ){
			$this->_err = _DML_ENTRY_DOCLINK_HOST ;
			return false;
		}

        /* Removed test, user is responsible for submitting existing urls
         *
		// Open the URL source using PHP fopen schema. this is a test ONLY!
		$bufferhandle = fopen( $url , 'rb' );	//Binary read-mode
		if( ! $bufferhandle ){
			$this->_err = _DML_COULDNOTCONNECT." " . @$parsedurl['host'];
			return false;
		}
		fclose( $bufferhandle );
        */

		return true;
	}

	/**
	*    Validate file extension
	*
	*    @desc This is the function handling the file extension validation when uploading.
	*    @param void
	*    @return boolean Returns true if extension is valid and false if not. Sets $this->err with error message if false.
	*/

    function validateExt($name)
    {
		if(!$name ) {
            return false;
		}
		if(!$this->ext_array ) {
           	return true;
		}

		$valid_ext = preg_replace( "/^[.](.*)$/", "$1" , $this->ext_array );

		// Simple lookup first ...
        $extension = @strtolower( @substr( $name , strrpos($name,".")+1 ));
		if( $extension && in_array( $extension, $valid_ext ) ) {
			return true;
		}

		// Translate to mimetype for wider test...
		$extension=DOCMAN_MIME_Magic::MIMEToExt(DOCMAN_MIME_Magic::filenameToMIME($name));

		if( in_array( $extension , $valid_ext ) ) {

           	return true;
		}

		$this->_err .= _DML_FILETYPE." &quot;".$extension."&quot; "._DML_NOTPERMITED;


    	return false;
    }

	/**
	*    Validate file size
	*
	*    @desc This is the function handling the file size validation when uploading.
	*    @param void
	*    @return boolean Returns true if size is valid and false if not. Sets $this->err with error message if false.
	*/

    function validateSize($temp_name)
    {
        if ($temp_name) {
            $size = filesize($temp_name);
           	if ($size <= $this->max_file_size && $size > 0 ) {
              	return true;
            }
		}

        $this->_err .= _DML_SIZEEXCEEDS;
        return false;
    }

    function validatePath($path)
    {
        if ($path) {
        	$path = JPath::clean($path);
	    	if (!is_dir( $path )) {
				$path = dirname( $path );
	    	}

	    	$finalchar = @substr($path,-1);
            if ( $finalchar != '/' || $finalchar != '\\' ){
				$path = $path.DS;
            }

            $handle = @opendir($path);

            if ($handle) {
              	closedir($handle);
           	} else {
            	$path = false;
         	}
        } else {
            $path = false;
        }

		if(!$path ) {
            $this->_err=_DML_DIRPROBLEM2.": $path";
		}


        return $path;
    }

    /**
	*    Check file existence
	*
	*    @desc This is the function handling the file existence validation when uploading.
	*    @param file name
	*    @return boolean Returns true if file exists and false if not. Sets $this->err file exists.
	*/

    function validateExists($name,$path)
    {
		global $_DOCMAN;
		if( ! $_DOCMAN->getCfg( 'overwrite' ) &&
          	file_exists($path.DS.$name) ){
         	$this->_err .= _DML_FILE." &quot;" . $name . "&quot; "._DML_ALREADYEXISTS;
            return false;
      	} else {
           	return true;
    	}
    }

    /**
	*    Validate protocol passed.
	*	We never want 'file' to be used as this could expose server
	*	readable files to the outside world.
	*
	*    @desc This function confirms the protocol is supported
	*    @param pointer to filename
	*    @return boolean Returns true if filename is supported, else false.
	*/
    function validateProtocol( $proto )
    {
		$proto = strtolower( $proto );
		if(! $proto)
			return true;

		if(($this->proto_reject &&  in_array( $proto, $this->proto_reject )) ||
	       ($this->proto_accept && !in_array( $proto, $this->proto_accept ) ) ){
				$this->_err = _DML_PROTOCOL." &quot;" . $proto . "&quot; "._DML_NOTSUPPORTED;
				return false;
		}
		return true;
    }
    /**
	*    Validate filename passed.
	*
	*    @desc This is the function handling the file name
	*    @param pointer to filename
	*    @return boolean Returns true if filename is good, else false.
	*/

    function validateName(&$name)
    {
		$name = trim( $name );
		if( ! $name ) {
			$this->_err = _DML_NOFILENAME;
			return false;
		}

		if($this->fname_lc ) {
			$name = strtolower( $name );
		}

		if(strchr($name , " "))
		{
			switch($this->fname_blank)
			{
				case 0: // Accept
				default:
				break;

				case 1: // REJECT
			   		$this->_err .= _DML_FILENAME." &quot;" . $name . "&quot; "._DML_CONTAINBLANKS;
			   		return false;

				case 2: // convert to underscore
			   		$name=preg_replace( "/\s/" , '_' , $name );
			   		break;

				case 3: // convert to dash
			   		$name=preg_replace( "/\s/" , '-' , $name );
			   		break;

				case 4: // REMOVE
			   		$name=preg_replace( "/\s/" , '' , $name );
			   		break;
	 		}
		}

		if( ($this->fname_reject && preg_match( "/^(" . $this->fname_reject . ")$/i" , $name ) )
            OR preg_match( "/^(" . _DM_FNAME_REJECT . ")$/i" , $name )){
			$this->_err .= "&quot;" . $name . "&quot; "._DML_ISNOTVALID;
			return false;
		}


		return true;
    }
}

class DOCMAN_Folder
{
	var $path 	= null;

	function DOCMAN_Folder($path)
	{
		$this->path = $path;
	}

	/**
	* Utility function to read the files in a directory
	* @param string The file system path
	* @param string A filter for the names
	*/
	function getFiles($match_filter=null, $ignore_filter=null, $filter=null)
	{
		global $_DOCMAN;

		// Don't show the 'ignore files'. They are...er, magic.
		if ( empty($ignore_filter) ) {
            $ignore_filter = $_DOCMAN->getCfg('fname_reject');
        }

		$arr = array();
		if ( !@is_dir($this->path) ) {
			return $arr;
		}
		$handle = @opendir($this->path);

		$match_filter = preg_quote($match_filter);
		while ( $file = @readdir($handle) )
		{
            if ( substr($file,0,1) == '.' ) continue;
            if ( @is_dir($this->path.DS.$file) ) continue;
            if ( !empty($ignore_filter) && preg_match("/^".$ignore_filter.'/',$file) ) continue;
            if ( preg_match("/^"._DM_FNAME_REJECT."^/",$file) ) continue;

            if ( !empty($match_filter) && !preg_match("/".$match_filter.'/i',$file) ) continue;

			//check for xml files with two periods . in the title
			//for example: template.xml.bak, which we want to avoid
			if ($filter == ".xml") {
				$file_count = explode(".",$file);
				if (count($file_count) == "2"){
					$arr[] = new DOCMAN_File(trim( $file ), $this->path);
				}
			} else {
				$arr[] = new DOCMAN_File(trim( $file ), $this->path);
			}
		}
		@closedir($handle);
		asort($arr);
		return $arr;
	}
}
