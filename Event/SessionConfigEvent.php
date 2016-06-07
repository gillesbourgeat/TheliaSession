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

namespace TheliaSession\Event;

use Symfony\Component\EventDispatcher\Event;
use TheliaSession\Entity\SessionConfigEntity;

/**
 * Class SessionConfigEvent
 * @package TheliaSession\Event
 * @author gilles bourgeat <gilles.bourgeat@gmail.com>
 */
class SessionConfigEvent extends Event
{
    /** @var SessionConfigEntity */
    protected $sessionConfigEntity;

    /**
     * SessionConfigEvent constructor.
     * @param SessionConfigEntity $sessionConfigEntity
     */
    public function __construct(SessionConfigEntity $sessionConfigEntity)
    {
        $this->sessionConfigEntity = $sessionConfigEntity;
    }

    /**
     * @return SessionConfigEntity
     */
    public function getSessionConfigEntity()
    {
        return $this->sessionConfigEntity;
    }

    /**
     * @param SessionConfigEntity $sessionConfigEntity
     * @return SessionConfigEvent
     */
    public function setSessionConfigEntity(SessionConfigEntity $sessionConfigEntity)
    {
        $this->sessionConfigEntity = $sessionConfigEntity;
        return $this;
    }
}
