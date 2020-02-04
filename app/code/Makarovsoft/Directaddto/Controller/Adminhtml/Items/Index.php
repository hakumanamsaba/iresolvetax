<?php
/**
 * Copyright © 2015 Makarovsoft. All rights reserved.
 */

namespace Makarovsoft\Directaddto\Controller\Adminhtml\Items;

class Index extends \Makarovsoft\Directaddto\Controller\Adminhtml\Items
{
    /**
     * Items list.
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Makarovsoft_Directaddto::directaddto');
        $resultPage->getConfig()->getTitle()->prepend(__('Makarovsoft Items'));
        $resultPage->addBreadcrumb(__('Makarovsoft'), __('Makarovsoft'));
        $resultPage->addBreadcrumb(__('Items'), __('Items'));
        return $resultPage;
    }
}
