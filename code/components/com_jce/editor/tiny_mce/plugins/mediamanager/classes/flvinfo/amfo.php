<?php  
/**
 * AMF0 Parser
 * 
 * Based (pretty far) on the AMFPHP serializer. I actually started using the AMFPHP serializer and
 * mostly rewrote it.
 *
 * @author        Tommy Lacroix <tlacroix@quantiksolutions.com>
 * @copyright   Copyright (c) 2006-2008 Tommy Lacroix
 * @license        LGPL
 */

class AMF0Parser {   
    /**
     * Endianess, 0x00 for big, 0x01 for little
     *
     * @var int
     */
    var $endian;
    
    /**
     * AMF0 Data
     *
     * @var string (binary)
     */
    var $data;
    
    /**
     * Index in data
     *
     * @var int
     */
    var $index;
    
    /**
     * Data length
     *
     * @var int
     */
    var $dataLength;
    
    /**
     * Constructor
     *
     * @return AMF0Parser
     */
    function AMF0Parser() {    
        /**
         * Proceed to endianess detection. This will be needed by
         * double decoding because unpack doesn't allow the selection
         * of endianess when decoding doubles.
         */
        
        // Pack 1 in machine order
        $tmp = @pack("L", 1);
        
        // Unpack it in big endian order
        $tmp2 = @unpack("None",$tmp);
        
        // Check if it's still one
        if ($tmp2['one'] == 1) $this->endian = 0x00; // Yes, big endian
            else $this->endian = 0x01;    // No, little endian
    }
    
    /**
     * Initialize data
     *
     * @param string    AMF0 Data
     */
    function initialize($str) {
        $this->data = $str;
        $this->dataLength = strlen($str);
        $this->index = 0;
    }
    
    
    /**
     * Read all packets
     * 
     * @param string    AMF0 data (optional, uses the initialized one if not given)
     * @return array
     */
    function readAllPackets($str = false) {
        // Initialize if needed
        if ($str !== false) $this->initialize($str);
        
        // Parse each packet
        $ret = array();
        while ($this->index < $this->dataLength)
            $ret[] = $this->readPacket();
            
        // Return it
        return $ret;
    }
    
    /**
     * Read a packet at current index
     *
     * @return mixed
     */
    function readPacket() {    
        // Get data code
        $dataType = ord($this->data[$this->index++]);
        // Interpret
        switch($dataType) {    
            case 0x00:        // Number 0x00
                return $this->readNumber();
            case 0x01:     // Boolean 0x01
                return $this->readBoolean();
            case 0x02:        // String 0x02
                return $this->readString();
                break;
            case 0x03:        // Object 0x03
                return $this->readObject();
                break;
            case 0x08 :     // Mixed array 0x08
                return $this->readMixedArray();
                break;
            case 0x0a:    // Array 0x0a
                return $this->readArray();
                break;
            case 0x0c:     // 0x0c
                return $this->readLongString();
                break;
            case 0x0f:     // 0x0f
                return $this->readLongString();
                break;
            case 0x10:     // 0x10 Typed Object
                return $this->readTypedObject();
                break;
			default:
               break;
        }
    }    
    
    /**
     * Read a string at current index
     *
     * @return string
     */
    function readString() {
        // Get length
		
		$data = substr($this->data,$this->index,2);
		
		if( strlen( $data ) == 2 ){
		
			$len = @unpack('nlen', $data);
			$this->index+=2;
			
			// Get string
			$val = substr($this->data, $this->index, $len['len']);
			$this->index += $len['len'];
			
		}
        
        // Return it
        return $val;
    }    
    
    /**
     * Read a long string at current index
     *
     * @return string
     */
    function readLongString() {
        // Get length
		$data = substr($this->data,$this->index,2);
		
		if( strlen( $data ) == 4 ){
		
			$len = @unpack('Nlen', $data);
			$this->index+=4;
			
			// Get string
			$val = substr($this->data, $this->index, $len['len']);
			$this->index += $len['len'];
			
		}
        
        // Return it
        return $val;
    }
    
    /**
     * Read a number (double) at current index
     *
     * @return double
     */
    function readNumber() {    
        // Get the packet, big endian (8 bytes long)
        $packed = substr($this->data, $this->index, 8);
		
		if( strlen( $packed ) == 8 ){

			$this->index += 8;
			
			// Reverse it if we're little endian
			if ($this->endian == 0x01) $packed = strrev($packed);
	
			// Unpack it
			$tmp = @unpack("dnumber", $packed);
			
			// Return it
			return $tmp['number'];
		}
    }
    
    /**
     * Read a boolean at current index
     *
     * @return boolean
     */
    function readBoolean() {
        return ord($this->data[$this->index++]) == 1;
    }
    
    /**
     * Read an object at current index
     *
     * @return stdClass
     */
    function readObject() {    
        // Create return object we will add data to
        $ret = new stdClass();
		
		while( in_array( $key = $this->readString(), array( 'width', 'height', 'duration' ) ) ) {		
			$dataType = ord( $this->data[$this->index] );
			
			if( !$key || $dataType == 0x09 ){		
				// Consume byte
				$this->index += 1;
				break;
			}
			// Get data
			$val = $this->readPacket();	
			// Store it
			$ret->$key = $val;
		}
		return $ret;
    }
    
    /**
     * Read a typed object at current index
     *
     * @return stdClass
     */
    function readTypedObject() {
        $className = $this->readString();
        $object = $this->readObject();
        
        $object->__className = $className;
        return $object;
    }

    /**
     * Read a mixed array at current position
     * 
     * Note: A mixed array is basically an object, but with a long integer describing its highest index at first.
     *
     * @return array
     */
    function readMixedArray() {    
        // Skip the index
        $this->index += 4;
        
        // Parse the object, but return it as an array
        return get_object_vars($this->readObject());
    }
    
    /**
     * Get an indexed array ([0,1,2,3,4,...])
     *
     * @return array
     */
    function readArray() {    
        // Get item count
		$data = substr($this->data,$this->index,4);
		
		if( strlen( $data ) == 4 ){
		
			$len = @unpack('Nlen', $data);
			$this->index+=4;
			
			// Get each packet
			$ret = array();
			for($i=0;$i<$len['len'];$i++) $ret[] = $this->readPacket();
		
		}        
        // Return the array
        return $ret;
    }
}

?>