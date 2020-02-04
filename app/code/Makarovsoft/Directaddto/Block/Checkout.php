<?php 

namespace Makarovsoft\Directaddto\Block;


class Checkout extends \Magento\Framework\View\Element\Template
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

	public function isEnabled()
	{
		return $this->_scopeConfig->getValue(
				'makarovsoft_directaddto/general/show_to_checkout',
				\Magento\Store\Model\ScopeInterface::SCOPE_STORE
		);
	}

	public function _toHtml()
	{
		return parent::_toHtml();
	}
	
	public function getProductId()
	{
		return $this->coreRegistry->registry('current_product')->getId();
	}	
	
	public function getCheckoutLink()
	{
		return $this->getUrl('mascartdirect/direct/add', array('product' => $this->getProductId(), 'bypass' => true));
	}
}