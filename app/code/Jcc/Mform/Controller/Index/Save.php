<?php
/**
 * @category   Jcc
 * @package    Jcc_Mform
 * @author     jcc@jccbweb.com
 * @copyright  This file was generated by using Module Creator(http://code.vky.co.in/magento-2-module-creator/) provided by VKY <viky.031290@gmail.com>
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Jcc\Mform\Controller\Index;

use Magento\Framework\App\Action\Context;
use Jcc\Mform\Model\MformFactory;

class Save extends \Magento\Framework\App\Action\Action
{
	/**
     * @var Mform
     */
    protected $_mform;

    public function __construct(
		Context $context,
        MformFactory $mform
    ) {
        $this->_mform = $mform;
        parent::__construct($context);
    }
	public function execute()
    {
        $data = $this->getRequest()->getParams();
    	$mform = $this->_mform->create();
        $mform->setData($data);
        if($mform->save()){
            $this->messageManager->addSuccessMessage(__('You saved the data.'));
        }else{
            $this->messageManager->addErrorMessage(__('Data was not saved. Contact Customer Service'));
        }
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('mascartdirect/direct/add?id=2');
        return $resultRedirect;
    }



    public function savercorporation()
    {

        $data = $this->getRequest()->getParams();
        $mform = $this->_mform->create();
        $mform->setData($data);
        if($mform->save()){
            $this->messageManager->addSuccessMessage(__('You saved the data.'));
        }else{
            $this->messageManager->addErrorMessage(__('Data was not saved. Contact Customer Service'));
        }
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('mascartdirect/direct/add?id=3');
        return $resultRedirect;
    }




}
