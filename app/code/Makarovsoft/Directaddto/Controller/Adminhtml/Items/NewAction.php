<?php
/**
 * Copyright © 2015 Makarovsoft. All rights reserved.
 */

namespace Makarovsoft\Directaddto\Controller\Adminhtml\Items;

class NewAction extends \Makarovsoft\Directaddto\Controller\Adminhtml\Items
{

    public function execute()
    {
        $this->_forward('edit');
    }
}
