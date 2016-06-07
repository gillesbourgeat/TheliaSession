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

namespace TheliaSession\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use TheliaSession\Event\SessionConfigEvent;
use TheliaSession\Event\TheliaSessionEvents;
use TheliaSession\Factory\HandlerFactory;
use TheliaSession\TheliaSession;

/**
 * Class TheliaSessionListener
 * @package TheliaSession\EventListener
 * @author gilles bourgeat <gilles.bourgeat@gmail.com>
 */
class TheliaSessionListener implements EventSubscriberInterface
{
    /**
     * @param SessionConfigEvent $event
     */
    public function sessionConfig(SessionConfigEvent $event)
    {
        $sessionConfigEntity = $event->getSessionConfigEntity();

        // connection test
        HandlerFactory::get($sessionConfigEntity);

        $sessionConfigEntity->setActive(true);

        TheliaSession::setConfig($sessionConfigEntity);
    }

    public function sessionClear()
    {
        $sessionConfigEntity = TheliaSession::getConfig();

        HandlerFactory::flush($sessionConfigEntity);
    }

    /**
     * @inheritdoc
     * @api
     */
    public static function getSubscribedEvents()
    {
        return array(
            TheliaSessionEvents::SESSION_CONFIG => ['sessionConfig', 128],
            TheliaSessionEvents::SESSION_CLEAR => ['sessionClear', 128]
        );
    }
}
