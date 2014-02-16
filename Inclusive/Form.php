<?php

class Inclusive_Form extends Zend_Form 
{
	
	protected $_attribs = array(
		'class'=>'inclusive'
		);
	
	protected $_removeCSRF = false;
	
	protected $_removeConfirm = false;
	
	protected $_services = array();
	
	protected $_serviceClasses = array();
	
	protected $_unsetIfEmpty = array();
	
	protected $_ifEmptySetNull = array();
	
	public function __construct($options=null)
	{
	
		parent::__construct($options);
		
	}
	
	public function addCSRFElement()
	{
	
		$this->addElement(new Inclusive_Form_Element_CSRF());
		
		$this->_removeCSRF = true;
		
		return $this;
	
	}
	
	public function addConfirmElement($options=null)
	{
	
		$this->addElement(new Inclusive_Form_Element_Confirm('confirm',$options));
		
		$this->_removeConfirm = true;
		
		return $this;
	
	}
	
	public function getValues($suppressArrayNotation=false)
	{
	
		$values = parent::getValues($suppressArrayNotation);
		
		if ($this->_removeConfirm)
		{
		
			unset($values['confirm']);
		
		}
		
		if ($this->_removeCSRF)
		{
		
			unset($values['inclusive_csrf']);
		
		}
		
		foreach ($this->_unsetIfEmpty as $key)
		{
			
			if (array_key_exists($key,$values))
			{
				
				if ($this->isValueEmpty($values[$key]))
				{
				
					unset($values[$key]);
					
				}
			
			}
		
		}
		
		foreach ($this->_ifEmptySetNull as $key)
		{
		
			if (array_key_exists($key,$values) && $this->isValueEmpty($values[$key]))
			{
			
				$values[$key] = null;
			
			}
		
		}
		
		return $values;
		
	}
	
	public function getService($key) 
	{
	
		if (isset($this->_serviceClasses[$key]))
		{
		
			$class = $this->_serviceClasses[$key];
		
		}
		else 
		{
		
			$class = $key;
		
		}
	
		if (!isset($this->_services[$key])
			or !($this->_services[$key] instanceof $class))
		{
		
			$this->setService(new $class(),$key);
		
		}
		
		return $this->_services[$key];
		
	}
	
	public function isValueEmpty($value)
	{
	
		if ('' === $value 
			|| null === $value 
			|| (is_array($value) && empty($value))) 
		{
		
			return true;	
		
		}
		
		return false;
	
	}
	
	public function setService(Inclusive_Service_Abstract $service,$key) 
	{
	
		$this->_services[$key] = $service;
			
		return $this;
		
	}
	
}