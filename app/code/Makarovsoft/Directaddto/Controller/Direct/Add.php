<?php

namespace Makarovsoft\Directaddto\Controller\Direct;

class Add extends \Magento\Checkout\Controller\Cart\Add
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
            $productRepository
        );
        $this->formKey = $key;
        $this->couponFactory = $couponFactory;
        $this->checkoutSession = $checkoutSession;
        $this->quoteRepository = $quoteRepository;

        $this->execute();
    }

    public function execute()
    {
        $form = new \Magento\Framework\Math\Random;
        $newFormKey = $form->getRandomString(16);

        $formKey = $this->getRequest()->getParam('form_key', null);

        if (!$formKey ||
            $formKey != $this->formKey->getFormKey()
        ) {
            $this->formKey->set($newFormKey);
            $this->getRequest()->setParams(array('form_key' => $newFormKey));
        }

        $this->getRequest()->setParams(array('product' => $this->getRequest()->getParam('id')));

        $this->getRequest()->setParams(array('qty' => $this->getRequest()->getParam('qty', 1)));
        $this->getRequest()->setParams(array('product' => $this->getRequest()->getParam('id')));

        parent::execute();

        $couponCode = $this->getRequest()->getParam('coupon');

        if ($couponCode) {
            $this->getRequest()->setParams(array('coupon_code' => $couponCode));
            return $this->goBack2($this->_url->getUrl('mascartdirect/direct/coupon', $this->getRequest()->getParams()));
        }

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
            'id'
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