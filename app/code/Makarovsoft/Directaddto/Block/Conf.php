<?php 

namespace Makarovsoft\Directaddto\Block;


class Conf extends \Magento\Framework\View\Element\Template
{
	/**
	 * Core registry
	 *
	 * @var Registry
	 */
	protected $coreRegistry = null;

	public function __construct(
			\Magento\Framework\View\Element\Template\Context $context,
			\Magento\Framework\Registry $registry,
			array $data = [])
	{
		$this->coreRegistry = $registry;
		parent::__construct($context, $data);
	}


	public function _toHtml()
	{
		if (!$this->getRequest()->getParam('mascartdirect')) {
			return '';
		}
		return parent::_toHtml();
	}
	
	public function getProductId()
	{
		return $this->coreRegistry->registry('current_product')->getId();
	}
	
	public function getCartLink()
	{
		return $this->getUrl('mascartdirect/direct/add', array('product' => $this->getProductId()));
	}
	
	public function getCheckoutLink()
	{
		return $this->getUrl('mascartdirect/direct/add', array('product' => $this->getProductId(), 'bypass' => true));
	}
}