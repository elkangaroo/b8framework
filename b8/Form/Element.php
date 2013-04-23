<?php

namespace b8\Form;
use b8\View,
	b8\Registry;

abstract class Element
{
	protected $_name;
	protected $_id;
	protected $_label;
	protected $_css;
	protected $_ccss;
	protected $_parent;

	public function __construct($name = null)
	{
		if(!is_null($name))
		{
			$this->setName($name);
		}
	}

	public function getName()
	{
		return $this->_name;
	}

	public function setName($name)
	{
		$this->_name = $name;
	}

	public function getId()
	{
		return !$this->_id ? 'element-'.$this->_name : $this->_id;
	}

	public function setId($id)
	{
		$this->_id = $id;
	}

	public function getLabel()
	{
		return $this->_label;
	}

	public function setLabel($label)
	{
		$this->_label = $label;
	}

	public function getClass()
	{
		return $this->_css;
	}

	public function setClass($class)
	{
		$this->_css = $class;
	}

	public function getContainerClass()
	{
		return $this->_ccss;
	}

	public function setContainerClass($class)
	{
		$this->_ccss = $class;
	}

	public function setParent(Element $parent)
	{
		$this->_parent = $parent;
	}

	public function render($viewFile = null)
	{
		$viewPath = Registry::getInstance()->get('ViewPath');

		if(is_null($viewFile))
		{
			$class = explode('\\', get_called_class());
			$viewFile = end($class);
		}

		if(file_exists($viewPath . 'Form/' . $viewFile))
		{
			$view = new View('Form/' . $viewFile);
		}
		else
		{
			$view = new View($viewFile, B8_PATH . 'Form/View/');
		}

		$view->name     = $this->getName();
		$view->id       = $this->getId();
		$view->label    = $this->getLabel();
		$view->css      = $this->getClass();
		$view->ccss     = $this->getContainerClass();
		$view->parent   = $this->_parent;

		$this->_onPreRender($view);

		return $view->render();
	}

	abstract protected function _onPreRender(View &$view);
}