<?php

namespace Makarovsoft\Directaddto\Block\Adminhtml;

use Magento\Framework\Escaper;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Store\Model\System\Store as SystemStore;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class Store
 */
class Ren extends Column
{
    /**
     * Escaper
     *
     * @var \Magento\Framework\Escaper
     */
    protected $escaper;

    /**
     * System store
     *
     * @var SystemStore
     */
    protected $systemStore;

    protected $context;

    /*
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * Constructor
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param SystemStore $systemStore
     * @param Escaper $escaper
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        SystemStore $systemStore,
        Escaper $escaper,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $components = [],
        array $data = []
    ) {
        $this->systemStore = $systemStore;
        $this->escaper = $escaper;
        $this->context = $context;
        $this->storeManager = $storeManager;

        parent::__construct($context, $uiComponentFactory, $components, $data);
    }


    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $item[$this->getData('name')] = $this->prepareItem($item);
            }
        }

        return $dataSource;
    }

    /**
     * Get data
     *
     * @param array $item
     * @return string
     */
    protected function prepareItem(array $item)
    {

        $row = new \Magento\Framework\DataObject($item);

        $productId = $row->getEntityId();
        $wrap = '';

        $type = $row->getTypeId();

        $help = __('Copy link address to clipboard');
        $help2 = __('Copy link address to clipboard');
        if (!$this->isPlainProduct($type)) {
            $help = __('Open link in new tab to get configuration of product to be added to cart');
            $help2 = __('Open link in new tab to get configuration of product to be added directly to checkout');
        }

        $url = $this->storeManager->getStore()->getBaseUrl();
        if ($this->isPlainProduct($type)) {
            $url .= 'mascartdirect/direct/add?id=' . $productId;
        } else {
            $url .= 'catalog/product/view?id=' . $productId . '&mascartdirect=1';
        }


        $wrap .= sprintf('<a target="_blank" href="%s" class="directaddto" data-url="%s" title="%s">%s</a><br />',
            $url,
            $url,
            $help,
            __('To Cart'));

        $url = $this->storeManager->getStore()->getBaseUrl();
        if ($this->isPlainProduct($type)) {
            $url .= 'mascartdirect/direct/add?id=' . $productId . '&bypass=1';
        } else {
            $url .= 'catalog/product/view?id=' . $productId . '&mascartdirect=1';
        }

        $wrap .= sprintf('<a target="_blank" href="%s" class="directaddto" data-url="%s" title="%s">%s</a>',
            $url,
            $url,
            $help2,
            __('To Checkout')
        );

        return $wrap;
    }

    public function isPlainProduct($type) {
        return !in_array($type, array('grouped', 'configurable', 'bundle'));
    }
}
