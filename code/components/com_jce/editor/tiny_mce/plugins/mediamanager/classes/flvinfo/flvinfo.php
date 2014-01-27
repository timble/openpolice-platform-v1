<?php 
/**
 * FlvInfo class
 * 
 * Reads FLV meta data from a Flash Video File.
 *
 * @author        Tommy Lacroix <tlacroix@quantiksolutions.com>
 * @license        LGPL
 * Modified for JCE Media Manager Ryan Demmer <info@joomlacontenteditor.net>
 */

require_once 'amfo.php';

class FlvInfo {
    
    /**
     * Constructor
     */
    function FlvInfo() {
    }
    
    /**
     * Get a files meta data and cuepoints
     * 
     * @param      string       $filename
     * @return     array		$meta
     */
    function getMeta( $file ) {
        // Open file
        $f = fopen( $file,'rb' );
        
        // Read header
        $buffer = fread( $f, 9 );
        $header = @unpack( 'C3signature/Cversion/Cflags/Noffset', $buffer );
        
        // If signature is valid, go on
        if( $header['signature1'] == 70 && $header['signature2'] == 76 && $header['signature3'] == 86 ){
            // Read tags
            fseek( $f, $header['offset'] );
            while( feof( $f ) == false ){
                // Read tag header and check length
                $buffer = fread( $f, 15 );
                if( strlen( $buffer ) < 15) break;
                
                // Interpret header
                $tag 			= @unpack( 'Nprevsize/C1type/C3size/C4timestamp/C3stream', $buffer );
                $tag['size'] 	= ( $tag['size1'] << 16 ) + ( $tag['size2'] << 8 ) + ( $tag['size3'] );
				
				if( !$tag['size'] ) break;
                
				// Read tag body (max 16k)
				$next = ftell( $f ) + $tag['size'];
				$body = fread( $f, min( $tag['size'], 16384 ) );
				
				// Seek
				fseek( $f, $next );
			
				switch( $tag['type'] ){
					case 0x09:						
						// Unpack flags
						$info = @unpack( 'Cflags', $body );
						
						// Get frame type and store it
						$ft = ( $info['flags'] >> 4 ) & 15;
						
						if( !isset( $fw ) && !isset( $fh ) && $ft == 0x01 ){
							switch( $info['flags'] & 15 ){
								case 0x04:
								case 0x05:
								
								//codec_on2_vp6:
								//codec_on2_vp6alpha:
									$fw = ord( $body[5] )*16;
									$fh = ord( $body[6] )*16;
									break;
								//codec_sorenson_h263:
								case 0x02:
									$bin = '';
									for( $i=0; $i<16; $i++ ){
										$sbin = decbin( ord( $body[$i+1] ) );
										$bin .= str_pad( $sbin, 8, '0', STR_PAD_LEFT );
									}
									
									// Size type
									$size = bindec( substr( $bin, 30, 3 ) );
									
									// Get width/height
									switch ($size) {
										case 0:        // Custom, 8 bit
											$fw = bindec( substr( $bin, 33, 8 ) );
											$fh = bindec( substr( $bin, 41, 8 ) );
											break;
										case 1:        // Custom, 16 bit
											$fw = bindec( substr( $bin, 33, 16 ) );
											$fh = bindec( substr( $bin, 49, 16 ) );
											break;
										case 2:
											$fw = 352;
											$fh = 288;
											break;
										case 3:
											$fw = 176;
											$fh = 144;
											break;                                        
										case 4:
											$fw = 128;
											$fh = 96;
											break;
										case 5:
											$fw = 320;
											$fh = 240;
											break;
										case 6:
											$fw = 160;
											$fh = 120;
											break;
									}
									break;
							}
						}
						break;
					case 0x12:
						$parser = new AMF0Parser();
						// Parse data
						$data = $parser->readAllPackets( $body );
						$meta = $data[0] == 'onMetaData' ? $data[1] : array('width'=>'', 'height'=>'', 'duration'=>'');
						break;
				}
            }// while
        } 
        
        // Close file
        fclose( $f );
        
		// Width
		if ( isset( $fw ) && !isset( $meta['width'] ) ) {
			$meta['width'] = $fw;
		}
		
		// Height
		if ( isset( $fh ) && !isset( $meta['height'] ) ) {
			$meta['height'] = $fh;
		}  
		
		if( isset( $meta['duration'] ) ){
			$time = abs( $meta['duration'] );
			
			$minutes = floor( $time / 60);
			$seconds = round( ( ( $time / 60 ) - floor( $time / 60 ) ) * 60 );
	
			if( $seconds >= 60 ){
				$seconds -= 60;
				$minutes++;
			}
			
			$meta['duration'] = $minutes . ':' . str_pad( $seconds, 2, 0, STR_PAD_LEFT );
		}else{
			$meta['duration'] = 0;
		}
	   	return $meta;
    }
   
}

?>