<?php

namespace Makarovsoft\Directaddto\Controller\Direct;

class Bulk extends \Makarovsoft\Directaddto\Controller\Direct\Add
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

        $products = $this->getRequest()->getParam('product', []);
        foreach ($products as $id => $productInfo) {
            $this->cart->addProduct($id, $productInfo);
        }

        $this->cart->save();

        $msg = $this->getRequest()->getParam('msg');
        $this->messageManager->getMessages()->clear();

        if ($msg != '') {
            $this->messageManager->addSuccessMessage($msg);
        }

        $couponCode = $this->getRequest()->getParam('coupon');

        if ($couponCode) {
            $this->getRequest()->setParams(array('coupon_code' => $couponCode));
            return $this->_redirect($this->_url->getUrl('mascartdirect/direct/coupon', $this->getRequest()->getParams()));
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
}