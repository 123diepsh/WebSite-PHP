<?php
class NewException extends Exception
{
    public function __construct($message, $code=NULL) {
        parent::__construct($message, $code);
    }
   
    public function __toString() {
    	try {
			return NewException::generateErrorMessage($this->getCode(), $this->getMessage(), $this->getFile(), $this->getLine(), (isset($this->_class)?$this->_class:""), (isset($this->_method)?$this->_method:""), $this->getTraceAsString());
		} catch (Exception $e) {
			echo $e->getMessage();
			exit;
		}
    }
    
    public static function generateErrorMessage($code, $message, $file, $line, $class_name='', $method='', $trace='') {
    	if ($message == "Class 'WebSitePhpSoapClient' not found") {
    		$message = "You must activate PHP extension php_soap in php.ini";
    	}
    	
    	$str = "";
        $str .= "<b>Error</b><br/>";
		$str .= "<br/><b>Message:</b> ".htmlentities(html_entity_decode($message))."<br/>";
        $str .= "<b>File:</b> ".$file."<br/>";
        $str .= "<b>Line:</b> ".$line."<br/>";
        $str .= "<b>Class :</b> ".$class_name."<br/>\n";
		$str .= "<b>Method :</b> ".$method."<br/><br/>\n";
		if ($trace != "") {
        	$str .= "<b>Trace:</b><br/>".str_replace("\n", "<br/>", htmlentities($trace))."<br/>";
        }
        
        return $str;
    }
   
    public function getException() {
        return $this; // This will print the return from the above method __toString()
    }
   
	public static function getStaticException($exception) {
		if (method_exists($exception, "getException")) {
         	print $exception->getException(); // $exception is an instance of this class
        } else {
        	print $exception;
        }
    }
    
	public static function printStaticException($exception) {
		if (method_exists($exception, "getException")) {
			NewException::printStaticDebugMessage($exception->getException());
		} else {
			NewException::printStaticDebugMessage($exception);
		}
    }
    
    public static function redirectOnError($buffer) {  
		$lastError = error_get_last();  
		if(!is_null($lastError) && ($lastError['type'] === E_ERROR || $lastError['type'] === E_PARSE)) {
			$debug_msg = NewException::generateErrorMessage($lastError['type'], $lastError['message'], $lastError['file'], $lastError['line']);
			NewException::printStaticDebugMessage($debug_msg);
		}  
		return $buffer;  
	}
	
	public static function printStaticDebugMessage($debug_msg) {
		// print the debug
		if ($GLOBALS['__DEBUG_PAGE_IS_PRINTING__'] == false) {
			$GLOBALS['__DEBUG_PAGE_IS_PRINTING__'] = true;
			if (gettype($debug_msg) == "object") {
				if (get_class($debug_msg) == "NewException") {
					$debug_msg = NewException::generateErrorMessage($debug_msg->code, $debug_msg->message, $debug_msg->file, $debug_msg->line);
				} else {
					$debug_msg = echo_r($debug_msg);
				}
			}
			
			if ($GLOBALS['__AJAX_PAGE__'] == false || $GLOBALS['__AJAX_LOAD_PAGE__'] == true) {
				$_GET['debug'] = $debug_msg;
				$_GET['p'] = "error-debug";
				
				try {
					if (!defined('FORCE_SERVER_NAME') || FORCE_SERVER_NAME == "") {
						$from_url = "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
					} else {
						$from_url = "http://".FORCE_SERVER_NAME.$_SERVER['REQUEST_URI'];
					}
					$_GET['from_url'] = $from_url;
					
					require_once(dirname(__FILE__)."/../../pages/error/error-debug.php");
					$debug_page = new ErrorDebug();
					$debug_page->Load();
					
					$split_request_uri = explode("\?", $_SERVER['REQUEST_URI']);
					if (!defined('FORCE_SERVER_NAME') || FORCE_SERVER_NAME == "") {
						$my_site_base_url = "http://".str_replace("//", "/", $_SERVER['SERVER_NAME'].substr($split_request_uri[0], 0, strrpos($split_request_uri[0], "/"))."/");
					} else {
						$my_site_base_url = "http://".str_replace("//", "/", FORCE_SERVER_NAME.substr($split_request_uri[0], 0, strrpos($split_request_uri[0], "/"))."/");
					}
					if (isset($_GET['folder_level']) && $_GET['folder_level'] > 0) { // when URL rewriting with folders
						if ($my_site_base_url[strlen($my_site_base_url) - 1] == "/") {
							$my_site_base_url = substr($my_site_base_url, 0, strlen($my_site_base_url) - 1);
						}
						for ($i=0; $i < $_GET['folder_level']; $i++) {
							$pos = strrpos($my_site_base_url, "/");
							if ($pos != false && $my_site_base_url[$pos-1] != "/") {
								$my_site_base_url = substr($my_site_base_url, 0, $pos);
							} else {
								break;
							}
						}
						$my_site_base_url .= "/";
					}
					if ($my_site_base_url[strlen($my_site_base_url) - 4] == "/") {
						$my_site_base_url = substr($my_site_base_url, 0, strlen($my_site_base_url) - 3);
					}
					
					header("Content-Type: text/html");
					
					echo "<html><head><title>Debug Error - ".SITE_NAME."</title>\n";
					echo "<link type=\"text/css\" rel=\"StyleSheet\" href=\"".$my_site_base_url."wsp/css/styles.css.php\" media=\"screen\" />\n";
					echo "<link type=\"text/css\" rel=\"StyleSheet\" href=\"".$my_site_base_url."wsp/css/angle.css.php\" media=\"screen\" />\n";
					echo "</head><body>\n";
					echo $debug_page->render();
					echo "</body></html>\n";
				} catch (Exception $e) {
					echo $e->getMessage();
				}
			} else {
				header('HTTP/1.1 500 Internal Server Error');
				echo $debug_msg;
				exit;
			}
		}
    }
} 
?>