<?php
/**
 * Description of PHP file wsp\class\display\advanced_object\autocomplete\AutoComplete.class.php
 * Class AutoComplete
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2011 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 17/01/2011
 *
 * @version     1.0.30
 * @access      public
 * @since       1.0.17
 */

class AutoComplete extends WebSitePhpObject {
	/**#@+
	* @access private
	*/
	private $autocomplete_url = null;
	private $autocomplete_min_length = 4;
	private $autocomplete_event = null;
	/**#@-*/
	
	function __construct($url_object, $min_lenght=4, $autocomplete_event=null) {
		parent::__construct();
		
		if (gettype($url_object) != "object" && get_class($url_object) != "Url") {
			throw new NewException("AutoComplete: \$url_object must be a Url object", 0, 8, __FILE__, __LINE__);
		}
		if ($autocomplete_event != null) {
			if (gettype($autocomplete_event) != "object" && get_class($autocomplete_event) != "AutoCompleteEvent") {
				throw new NewException("AutoComplete: \$autocomplete_event must be a AutoCompleteEvent object", 0, 8, __FILE__, __LINE__);
			}
		}
		$this->autocomplete_url = $url_object;
		$this->autocomplete_min_length = $min_lenght;
		$this->autocomplete_event = $autocomplete_event;
	}
	
	/* Intern management of AutoComplete */
	public function setLinkObjectId($id) {
		$this->link_object_id = $id;
	}
	
	public function render($ajax_render=false) {
		$html = "";
		$html .= $this->getJavascriptTagOpen();
		$html .= "\$('#".$this->link_object_id."').autocomplete({ source: '".$this->autocomplete_url->render()."', minLength: ".$this->autocomplete_min_length.", select: function( event, ui ) { ";
		if ($this->autocomplete_event != null) {
			$html .= $this->autocomplete_event->render();
		}
		$html .= " } });\n";
		$html .= $this->getJavascriptTagClose();
		$this->object_change = false;
		return $html;
	}
}
?>