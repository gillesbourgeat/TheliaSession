<?php
/*************************************************************************************/
/*      This file is part of the TheliaSession module                                */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace TheliaSession\Handler;

use Symfony\Component\HttpFoundation\Session\Storage\Handler\MemcachedSessionHandler as MemcachedSessionHandlerCore;

/**
 * Class MemcachedSessionHandler
 * @package TheliaSession\Handler
 * @author gilles bourgeat <gilles.bourgeat@gmail.com>
 */
class MemcachedSessionHandler extends MemcachedSessionHandlerCore
{
    public function getMemcached()
    {
        return parent::getMemcached();
    }
}
