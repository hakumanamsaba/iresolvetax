<?php
/**
 * @category   Jccbweb
 * @package    Jccbweb_Dbainfo
 * @author     jcc@jccbweb.com
 * @copyright  This file was generated by using Module Creator(http://code.vky.co.in/magento-2-module-creator/) provided by VKY <viky.031290@gmail.com>
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Jccbweb\Dbainfo\Model;

use Magento\Framework\Model\AbstractModel;

class Dbainfo extends AbstractModel
{
    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init('Jccbweb\Dbainfo\Model\ResourceModel\Dbainfo');
    }
}