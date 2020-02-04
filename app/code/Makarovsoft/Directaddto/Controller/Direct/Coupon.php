<?php

namespace Makarovsoft\Directaddto\Controller\Direct;

class Coupon extends \Magento\Checkout\Controller\Cart\CouponPost
{
    /**
     * @var \Magento\Framework\Data\Form\FormKey
     */
    protected $formKey;

    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $checkoutSession;


    /**
     * Coupon factory
     *
     * @var \Magento\SalesRule\Model\CouponFactory
     */
    protected $couponFactory;
    protected $quoteRepository;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,
        \Magento\Checkout\Model\Cart $cart,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Framework\Data\Form\FormKey $key,
        \Magento\Quote\Api\CartRepositoryInterface $quoteRepository,
        \Magento\SalesRule\Model\CouponFactory $couponFactory
    ) {

        parent::__construct(
            $context,
            $scopeConfig,
            $checkoutSession,
            $storeManager,
            $formKeyValidator,
            $cart,
            $couponFactory,
            $quoteRepository
        );
        $this->formKey = $key;
        $this->couponFactory = $couponFactory;
        $this->checkoutSession = $checkoutSession;
        $this->quoteRepository = $quoteRepository;

        $this->execute();
    }

    public function execute()
    {
        parent::execute();

        if ($this->getRequest()->getParam('bypass')) {
            return $this->goBack2($this->_url->getUrl($this->_scopeConfig->getValue('makarovsoft_directaddto/general/checkout_url')));
        } else {
            if ($this->_scopeConfig->getValue('makarovsoft_directaddto/general/cart_redirect')) {
                return $this->goBack2($this->_url->getUrl('checkout/cart'));
            }
            return $this->goBack2($this->_redirect->getRefererUrl());
        }
    }
    public function goBack2($backUrl = null)
    {
        $exclude = [
            'form_key',
            'product',
            'qty',
            'id',
        ];

        $qs = $this->getRequest()->getParams();
        foreach ($exclude as $key) {
            if (isset($qs[$key])) {
                unset($qs[$key]);
            }
        }

        $qs = http_build_query($qs);

        header('Location: ' . $backUrl . '?' . $qs);
        exit;
    }
}