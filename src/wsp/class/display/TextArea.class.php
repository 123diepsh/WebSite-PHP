<?php
/**
 * PHP file wsp\class\display\TextArea.class.php
 * @package display
 */
/**
 * Class TextArea
 *
 * WebSite-PHP : PHP Framework 100% object (http://www.website-php.com)
 * Copyright (c) 2009-2013 WebSite-PHP.com
 * PHP versions >= 5.2
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @package display
 * @author      Emilien MOREL <admin@website-php.com>
 * @link        http://www.website-php.com
 * @copyright   WebSite-PHP.com 10/01/2013
 * @version     1.2.1
 * @access      public
 * @since       1.2.0
 */

class TextArea extends WebSitePhpEventObject {
	
	/**#@+
	* @access private
	*/
	private $value = "";
	private $default_value = "";
	private $width = "";
	private $height = "";
	private $style = "";
	private $class = "";
	private $disable = false;
	private $has_focus = false;
	private $force_empty = false;
	private $strip_tags = false;
	private $strip_tags_allowable = "";
	
	private $live_validation = null;
	private $is_clearable = false;
	
	private $is_changed = false;
	private $onchange = "";
	private $callback_onchange = "";
	
	private $is_clicked = false;
	private $onclick = "";
	private $callback_onclick = "";
	
	private $callback_onblur = "";
	private $onblur = "";
	
	private $callback_onkeypress = "";
	private $onkeypress = "";
	
	private $callback_onkeyup = "";
	private $onkeyup = "";
	
	private $onmouseover = "";
	private $onmouseout = "";
	
	private $encrypt_object = null;
	/**#@-*/
	
	/**
	 * Constructor TextArea
	 * @param mixed $page_or_form_object 
	 * @param string $name 
	 * @param string $id 
	 * @param string $value 
	 * @param string $width 
	 */
	function __construct($page_or_form_object, $name='', $id='', $value='', $width='') {
		parent::__construct();
		
		if (!isset($page_or_form_object) || gettype($page_or_form_object) != "object" || (!is_subclass_of($page_or_form_object, "Page") && get_class($page_or_form_object) != "Form")) {
			throw new NewException("Argument page_or_form_object for ".get_class($this)."::__construct() error", 0, getDebugBacktrace(1));
		}
		
		if (is_subclass_of($page_or_form_object, "Page")) {
			$this->class_name = get_class($page_or_form_object);
			$this->page_object = $page_or_form_object;
			$this->form_object = null;
		} else {
			$this->page_object = $page_or_form_object->getPageObject();
			$this->class_name = get_class($this->page_object)."_".$page_or_form_object->getName();
			$this->form_object = $page_or_form_object;
		}
		
		if ($name == "") {
			$name = $this->page_object->createObjectName($this);
			$this->name = $name;
		} else {
			$exist_object = $this->page_object->existsObjectName($name);
			$this->name = $name;
			if ($exist_object != false) {
				throw new NewException("Tag name \"".$name."\" for object ".get_class($this)." already use for other object ".get_class($exist_object), 0, getDebugBacktrace(1));
			}
			$this->page_object->addEventObject($this, $this->form_object);
		}
		
		if ($id == "") {
			$this->id = $name;
		} else {
			$this->id = $id;
		}
		$this->value = $value;
		$this->default_value = $value;
		$this->width = $width;
	}
	
	/**
	 * Method setValue
	 * @access public
	 * @param mixed $value 
	 * @return TextArea
	 * @since 1.2.0
	 */
	public function setValue($value) {
		if ($this->strip_tags) {
			$this->value = strip_tags($value, $this->strip_tags_allowable);
		} else {
			$this->value = $value;
		}
		if (!$GLOBALS['__LOAD_VARIABLES__']) { 
			if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		} else {
			$this->is_changed = true;
			$this->is_clicked = true;
		}
		return $this;
	}

	/**
	 * Method setDefaultValue
	 * @access public
	 * @param mixed $value 
	 * @return TextArea
	 * @since 1.2.0
	 */
	public function setDefaultValue($value) {
		$this->default_value = $value;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setWidth
	 * @access public
	 * @param integer $width 
	 * @return TextArea
	 * @since 1.2.0
	 */
	public function setWidth($width) {
		$this->width = $width;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setHeight
	 * @access public
	 * @param integer $height 
	 * @return TextArea
	 * @since 1.2.0
	 */
	public function setHeight($height) {
		$this->height = $height;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setStyle
	 * @access public
	 * @param mixed $style 
	 * @return TextArea
	 * @since 1.2.0
	 */
	public function setStyle($style) {
		$this->style = $style;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setClass
	 * @access public
	 * @param mixed $class 
	 * @return TextArea
	 * @since 1.2.0
	 */
	public function setClass($class) {
		$this->class = $class;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setName
	 * @access public
	 * @param mixed $name 
	 * @return TextArea
	 * @since 1.2.0
	 */
	public function setName($name) {
		$this->name = $name;
		if ($id == "") {
			$this->id = $name;
		}
		return $this;
	}
	
	/**
	 * Method setFocus
	 * @access public
	 * @return TextArea
	 * @since 1.2.0
	 */
	public function setFocus() {
		$this->has_focus = true;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setLiveValidation
	 * @access public
	 * @param mixed $live_validation_object 
	 * @return TextArea
	 * @since 1.2.0
	 */
	public function setLiveValidation($live_validation_object) {
		if (get_class($live_validation_object) != "LiveValidation") {
			throw new NewException("setLiveValidation(): \$live_validation_object must be a valid LiveValidation object", 0, getDebugBacktrace(1));
		}
		$live_validation_object->setObject($this);
		$this->live_validation = $live_validation_object;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method setEncryptObject
	 * @access public
	 * @param mixed $encrypt_object 
	 * @return TextArea
	 * @since 1.2.0
	 */
	public function setEncryptObject($encrypt_object) {
		if ($encrypt_object == null) {
			$encrypt_object = new EncryptDataWspObject();
		}
		if (gettype($encrypt_object) != "object" || get_class($encrypt_object) != "EncryptDataWspObject") {
			throw new NewException(get_class($this)."->setEncryption(): \$encrypt_object must be a EncryptDataWspObject object.", 0, getDebugBacktrace(1));
		}
		
		$this->addJavaScript(BASE_URL."wsp/js/jsbn.js", "", true);
		$this->addJavaScript(BASE_URL."wsp/js/lowpro.jquery.js", "", true);
		$this->addJavaScript(BASE_URL."wsp/js/rsa.js", "", true);
		
		$this->encrypt_object = $encrypt_object;
		$this->encrypt_object->setObject($this);
		
		return $this;
	}
	
	/**
	 * Method setStripTags
	 * @access public
	 * @param string $allowable_tags 
	 * @return TextArea
	 * @since 1.2.0
	 */
	public function setStripTags($allowable_tags='') {
		$this->strip_tags = true;
		$this->strip_tags_allowable = $allowable_tags;
		return $this;
	}
	
	/**
	 * Method getEncryptObject
	 * @access public
	 * @return mixed
	 * @since 1.2.0
	 */
	public function getEncryptObject() {
		return $this->encrypt_object;
	}
	
	/**
	 * Method isEncrypted
	 * @access public
	 * @return mixed
	 * @since 1.2.0
	 */
	public function isEncrypted() {
		return ($this->encrypt_object==null?false:true);
	}
	
	/**
	 * Method enable
	 * @access public
	 * @return TextArea
	 * @since 1.2.0
	 */
	public function enable() {
		$this->disable = false;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method disable
	 * @access public
	 * @return TextArea
	 * @since 1.2.0
	 */
	public function disable() {
		$this->disable = true;
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method clearable
	 * @access public
	 * @return TextArea
	 * @since 1.2.0
	 */
	public function clearable() {
		$this->is_clearable = true;
		
		$this->addCss(BASE_URL."wsp/css/jquery.clearable.css", "", true);
		$this->addJavaScript(BASE_URL."wsp/js/jquery.clearable.js", "", true);
		
		return $this;
	}

	/**
	 * Method getValue
	 * @access public
	 * @return mixed
	 * @since 1.2.0
	 */
	public function getValue() {
		$this->initSubmitValue(); // init value with submit value if not already do
		return $this->value;
	}

	/**
	 * Method getDefaultValue
	 * @access public
	 * @return mixed
	 * @since 1.2.0
	 */
	public function getDefaultValue() {
		return $this->default_value;
	}
		
	/**
	 * Method getClass
	 * @access public
	 * @return mixed
	 * @since 1.2.0
	 */
	public function getClass() {
		return $this->class;
	}
	
	/**
	 * Method onChange
	 * @access public
	 * @param mixed $str_function 
	 * @param mixed $arg1 [default value: null]
	 * @param mixed $arg2 [default value: null]
	 * @param mixed $arg3 [default value: null]
	 * @param mixed $arg4 [default value: null]
	 * @param mixed $arg5 [default value: null]
	 * @return TextArea
	 * @since 1.2.0
	 */
	public function onChange($str_function, $arg1=null, $arg2=null, $arg3=null, $arg4=null, $arg5=null) {
		$args = func_get_args();
		$str_function = array_shift($args);
		$this->callback_onchange = $this->loadCallbackMethod($str_function, $args);
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method onChangeJs
	 * @access public
	 * @param mixed $js_function 
	 * @return TextArea
	 * @since 1.2.0
	 */
	public function onChangeJs($js_function) {
		if (gettype($js_function) != "string" && get_class($js_function) != "JavaScript") {
			throw new NewException(get_class($this)."->onChangeJs(): \$js_function must be a string or JavaScript object.", 0, getDebugBacktrace(1));
		}
		if (get_class($js_function) == "JavaScript") {
			$js_function = $js_function->render();
		}
		$this->onchange = trim($js_function);
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method isChanged
	 * @access public
	 * @return mixed
	 * @since 1.2.0
	 */
	public function isChanged() {
		if ($this->callback_onchange == "") {
			if ($this->getValue() != $this->getDefaultValue()) {
				return true;
			} else {
				return false;
			}
		} else {
			return $this->is_changed;
		}
	}

	/**
	 * Method onClick
	 * @access public
	 * @param mixed $str_function 
	 * @param mixed $arg1 [default value: null]
	 * @param mixed $arg2 [default value: null]
	 * @param mixed $arg3 [default value: null]
	 * @param mixed $arg4 [default value: null]
	 * @param mixed $arg5 [default value: null]
	 * @return TextArea
	 * @since 1.2.0
	 */
	public function onClick($str_function, $arg1=null, $arg2=null, $arg3=null, $arg4=null, $arg5=null) {
		$args = func_get_args();
		$str_function = array_shift($args);
		$this->callback_onclick = $this->loadCallbackMethod($str_function, $args);
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method onClickJs
	 * @access public
	 * @param mixed $js_function 
	 * @return TextArea
	 * @since 1.2.0
	 */
	public function onClickJs($js_function) {
		if (gettype($js_function) != "string" && get_class($js_function) != "JavaScript") {
			throw new NewException(get_class($this)."->onClickJs(): \$js_function must be a string or JavaScript object.", 0, getDebugBacktrace(1));
		}
		if (get_class($js_function) == "JavaScript") {
			$js_function = $js_function->render();
		}
		$this->onclick = trim($js_function);
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method isClicked
	 * @access public
	 * @return mixed
	 * @since 1.2.0
	 */
	public function isClicked() {
		if ($this->callback_onclick == "") {
			throw new NewException(get_class($this)."->isClicked(): this method can be used only if an onClick event is defined on this ".get_class($this).".", 0, getDebugBacktrace(1));
		}
		return $this->is_clicked;
	}
	
	/**
	 * Method onMouseOverJs
	 * @access public
	 * @param mixed $js_function 
	 * @return TextArea
	 * @since 1.2.0
	 */
	public function onMouseOverJs($js_function) {
		if (gettype($js_function) != "string" && get_class($js_function) != "JavaScript") {
			throw new NewException(get_class($this)."->onChangeJs(): \$js_function must be a string or JavaScript object.", 0, getDebugBacktrace(1));
		}
		if (get_class($js_function) == "JavaScript") {
			$js_function = $js_function->render();
		}
		$this->onmouseover = trim($js_function);
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method onMouseOutJs
	 * @access public
	 * @param mixed $js_function 
	 * @return TextArea
	 * @since 1.2.0
	 */
	public function onMouseOutJs($js_function) {
		if (gettype($js_function) != "string" && get_class($js_function) != "JavaScript") {
			throw new NewException(get_class($this)."->onChangeJs(): \$js_function must be a string or JavaScript object.", 0, getDebugBacktrace(1));
		}
		if (get_class($js_function) == "JavaScript") {
			$js_function = $js_function->render();
		}
		$this->onmouseout = trim($js_function);
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method onBlur
	 * @access public
	 * @param mixed $str_function 
	 * @param mixed $arg1 [default value: null]
	 * @param mixed $arg2 [default value: null]
	 * @param mixed $arg3 [default value: null]
	 * @param mixed $arg4 [default value: null]
	 * @param mixed $arg5 [default value: null]
	 * @return TextArea
	 * @since 1.2.0
	 */
	public function onBlur($str_function, $arg1=null, $arg2=null, $arg3=null, $arg4=null, $arg5=null) {
		$args = func_get_args();
		$str_function = array_shift($args);
		$this->callback_onblur = $this->loadCallbackMethod($str_function, $args);
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method onBlurJs
	 * @access public
	 * @param mixed $js_function 
	 * @return TextArea
	 * @since 1.2.0
	 */
	public function onBlurJs($js_function) {
		if (gettype($js_function) != "string" && get_class($js_function) != "JavaScript") {
			throw new NewException(get_class($this)."->onChangeJs(): \$js_function must be a string or JavaScript object.", 0, getDebugBacktrace(1));
		}
		if (get_class($js_function) == "JavaScript") {
			$js_function = $js_function->render();
		}
		$this->onblur = trim($js_function);
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method onKeyPress
	 * @access public
	 * @param mixed $str_function 
	 * @param mixed $arg1 [default value: null]
	 * @param mixed $arg2 [default value: null]
	 * @param mixed $arg3 [default value: null]
	 * @param mixed $arg4 [default value: null]
	 * @param mixed $arg5 [default value: null]
	 * @return TextArea
	 * @since 1.2.0
	 */
	public function onKeyPress($str_function, $arg1=null, $arg2=null, $arg3=null, $arg4=null, $arg5=null) {
		$args = func_get_args();
		$str_function = array_shift($args);
		$this->callback_onkeypress = $this->loadCallbackMethod($str_function, $args);
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method onKeyPressJs
	 * @access public
	 * @param mixed $js_function 
	 * @return TextArea
	 * @since 1.2.0
	 */
	public function onKeyPressJs($js_function) {
		if (gettype($js_function) != "string" && get_class($js_function) != "JavaScript") {
			throw new NewException(get_class($this)."->onChangeJs(): \$js_function must be a string or JavaScript object.", 0, getDebugBacktrace(1));
		}
		if (get_class($js_function) == "JavaScript") {
			$js_function = $js_function->render();
		}
		$this->onkeypress = trim($js_function);
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method onKeyUp
	 * @access public
	 * @param mixed $str_function 
	 * @param mixed $arg1 [default value: null]
	 * @param mixed $arg2 [default value: null]
	 * @param mixed $arg3 [default value: null]
	 * @param mixed $arg4 [default value: null]
	 * @param mixed $arg5 [default value: null]
	 * @return TextArea
	 * @since 1.2.0
	 */
	public function onKeyUp($str_function, $arg1=null, $arg2=null, $arg3=null, $arg4=null, $arg5=null) {
		$args = func_get_args();
		$str_function = array_shift($args);
		$this->callback_onkeyup = $this->loadCallbackMethod($str_function, $args);
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method onKeyUpJs
	 * @access public
	 * @param mixed $js_function 
	 * @return TextArea
	 * @since 1.2.0
	 */
	public function onKeyUpJs($js_function) {
		if (gettype($js_function) != "string" && get_class($js_function) != "JavaScript") {
			throw new NewException(get_class($this)."->onChangeJs(): \$js_function must be a string or JavaScript object.", 0, getDebugBacktrace(1));
		}
		if (get_class($js_function) == "JavaScript") {
			$js_function = $js_function->render();
		}
		$this->onkeyup = trim($js_function);
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method forceEmpty
	 * @access public
	 * @return TextArea
	 * @since 1.2.0
	 */
	public function forceEmpty() {
		$this->getValue(); // ack to be sure of the value of force empty
		$this->force_empty = true;
		$this->setValue("");
		if ($GLOBALS['__PAGE_IS_INIT__']) { $this->object_change =true; }
		return $this;
	}
	
	/**
	 * Method render
	 * @access public
	 * @param boolean $ajax_render [default value: false]
	 * @return string html code of object TextArea
	 * @since 1.2.0
	 */
	public function render($ajax_render=false) {
		$this->automaticAjaxEvent();
		
		$html = "";
		if ($this->class_name != "") {
			if ($this->callback_onchange != "" || $this->callback_onclick != "" || $this->callback_onblur != "" || $this->callback_onkeypress != "" || $this->callback_onkeyup != "") {
				$html .= "<input type='hidden' id='Callback_".$this->getEventObjectName()."' name='Callback_".$this->getEventObjectName()."' value=''/>\n";
			}
			if ($this->is_ajax_event) {
				if ($this->form_object == null) {
					throw new NewException("Unable to activate action to this ".get_class($this)." : Attribut page_or_form_object must be a Form object", 0, getDebugBacktrace(1));
				}
				$html .= $this->getJavascriptTagOpen();
				$html .= $this->getAjaxEventFunctionRender();
				$html .= $this->getJavascriptTagClose();
			}
			
			$html .= "<textarea ";
			$html .= "name='".$this->getEventObjectName()."' id='".$this->id."'";
			if ($this->width != "" || $this->height != "" || $this->style != "") {
				$html .= " style='";
				if ($this->width != "") {
					$html .= "width:";
					if (is_integer($this->width)) {
						$html .= $this->width."px";
					} else {
						$html .= $this->width;
					}
					$html .= ";";
				}
				if ($this->height != "") {
					$html .= "height:";
					if (is_integer($this->height)) {
						$html .= $this->height."px";
					} else {
						$html .= $this->height;
					}
					$html .= ";";
				}
				if ($this->style != "") {
					$html .= $this->style.";";
				}
				$html .= "'";
			}
			if ($this->class != "") {
				$html .= " class='".$this->class."'";
			}
			if ($this->disable) {
				$html .= " disabled";
			}
			if ($this->onchange != "" || $this->callback_onchange != "") {
				$html .= " onChange=\"";
				if ($this->live_validation != null && $this->form_object != null && $this->callback_onchange != "") {
					$html .= "if (LiveValidationForm_".$this->form_object->getName()."_".$this->getId()."() == false) { return false; }";
				}
				$html .= str_replace("\n", "", $this->getObjectEventValidationRender($this->onchange, $this->callback_onchange))."\"";
			}
			if ($this->onclick != "" || $this->callback_onclick != "") {
				$html .= " onClick=\"".str_replace("\n", "", $this->getObjectEventValidationRender($this->onclick, $this->callback_onclick))."\"";
			}
			if ($this->onmouseover != "") {
				$html .= " onMouseOver=\"".str_replace("\n", "", str_replace("\"", "\\\"", $this->onmouseover))."\"";
			}
			if ($this->onmouseout != "") {
				$html .= " onMouseOut=\"".str_replace("\n", "", str_replace("\"", "\\\"", $this->onmouseout))."\"";
			}
			if ($this->onblur != "" || $this->callback_onblur != "") {
				$html .= " onBlur=\"";
				if ($this->live_validation != null && $this->form_object != null && $this->callback_onblur != "") {
					$html .= "if (LiveValidationForm_".$this->form_object->getName()."_".$this->getId()."() == false) { return false; }";
				}
				$html .= str_replace("\n", "", $this->getObjectEventValidationRender($this->onblur, $this->callback_onblur))."\"";
			}
			if ($this->onkeypress != "" || $this->callback_onkeypress != "") {
				$html .= " onKeyPress=\"".str_replace("\n", "", $this->getObjectEventValidationRender($this->onkeypress, $this->callback_onkeypress, "", true))."\"";
			}
			if ($this->onkeyup != "" || $this->callback_onkeyup != "") {
				$html .= " onKeyUp=\"".str_replace("\n", "", $this->getObjectEventValidationRender($this->onkeyup, $this->callback_onkeyup, "", true))."\"";
			}
			$html .= ">";
			
			$html.=str_replace('"', '\\"', $this->getValue())."</textarea>";
			
			if ($this->live_validation != null) {
				$html .= $this->live_validation->render();
			}
			if ($this->has_focus || $this->is_clearable) {
				$html .= $this->getJavascriptTagOpen();
				$html .= "\$(document).ready(function() { ";
				if ($this->is_clearable) {
					$html .= "\$('#".$this->getId()."').clearable(); ";
				}
				if ($this->has_focus) {
					$html .= "\$('#".$this->getId()."').focus(); ";
				} 
				$html .= "});\n";
				$html .= $this->getJavascriptTagClose();
			}
		}
		$this->object_change = false;
		return $html;
	}
	
	/**
	 * Method getAjaxRender
	 * @access public
	 * @return string javascript code to update initial html of object TextArea (call with AJAX)
	 * @since 1.2.0
	 */
	public function getAjaxRender() {
		$this->automaticAjaxEvent();
		
		$html = "";
		if ($this->object_change && !$this->is_new_object_after_init) {
			if ($this->isChanged() || $this->getValue() != $this->default_value || ($this->force_empty && $this->getValue() == "")) {
				$html .= "$('#".$this->id."').text(\"";
				$html .= str_replace("\n", "\\n", str_replace("\r", "\\r", str_replace('"', '\\"', str_replace("\\", "\\\\", $this->getValue()))));
				$html .= "\");\n";
			}
			$html .= "$('#".$this->id."').css('width', \"";
			if (is_integer($this->width)) {
				$html .= $this->width."px";
			} else {
				$html .= $this->width;
			}
			$html .= "\");\n";
			$html .= "$('#".$this->id."').attr('class', \"".$this->class."\");";
			$html .= "$('#".$this->id."').attr('disabled', ".(($this->disable)?"true":"false").");\n";
			
			if ($this->onchange != "" || $this->callback_onchange != "") {
				$html .= "$('#".$this->id."').attr('onChange', '";
				if ($this->live_validation != null && $this->form_object != null && $this->callback_onchange != "") {
					$html .= "if (LiveValidationForm_".$this->form_object->getName()."_".$this->getId()."() == false) { return false; }";
				}
				$html .= addslashes(str_replace("\n", "", $this->getObjectEventValidationRender($this->onchange, $this->callback_onchange)))."');\n";
			}
			
			if ($this->onclick != "" || $this->callback_onclick != "") {
				$html .= "$('#".$this->id."').attr('onClick', '".addslashes(str_replace("\n", "", $this->getObjectEventValidationRender($this->onclick, $this->callback_onclick)))."');\n";
			}
			
			if ($this->onmouseover != "") {
				$html .= "$('#".$this->id."').attr('onMouseOver', '".addslashes(str_replace("\n", "", $this->onmouseover))."');\n";
			}
			if ($this->onmouseout != "") {
				$html .= "$('#".$this->id."').attr('onMouseOut', '".addslashes(str_replace("\n", "", $this->onmouseout))."');\n";
			}
			if ($this->onblur != "" || $this->callback_onblur != "") {
				$html .= "$('#".$this->id."').attr('onBlur', '";
				if ($this->live_validation != null && $this->form_object != null && $this->callback_onblur != "") {
					$html .= "if (LiveValidationForm_".$this->form_object->getName()."_".$this->getId()."() == false) { return false; }";
				}
				$html .= addslashes(str_replace("\n", "", $this->getObjectEventValidationRender($this->onblur, $this->callback_onblur)))."');\n";
			}
			if ($this->onkeypress != "" || $this->callback_onkeypress != "") {
				$html .= "$('#".$this->id."').attr('onKeyPress', '".addslashes(str_replace("\n", "", $this->getObjectEventValidationRender($this->onkeypress, $this->callback_onkeypress, "", true)))."');\n";
			}
			if ($this->onkeyup != "" || $this->callback_onkeyup != "") {
				$html .= "$('#".$this->id."').attr('onKeyUp', '".addslashes(str_replace("\n", "", $this->getObjectEventValidationRender($this->onkeyup, $this->callback_onkeyup, "", true)))."');\n";
			}
			
			if ($this->has_focus) {
				$html .= "\$('#".$this->getId()."').focus();\n";
			}
		}
		return $html;
	}
	
}
?>
