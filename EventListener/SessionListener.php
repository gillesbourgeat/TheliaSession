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
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
use Thelia\Core\Event\SessionEvent;
use Thelia\Core\HttpFoundation\Session\Session;
use Thelia\Core\TheliaKernelEvents;
use Thelia\Model\ConfigQuery;
use TheliaSession\Factory\HandlerFactory;
use TheliaSession\TheliaSession as TheliaSessionCore;

/**
 * Class SessionListener
 * @package TheliaSession\EventListener
 * @author gilles bourgeat <gilles.bourgeat@gmail.com>
 */
class SessionListener implements EventSubscriberInterface
{
    /**
     * @param SessionEvent $event
     */
    public function addSession(SessionEvent $event)
    {
        $sessionConfig = TheliaSessionCore::getConfig();

        if ($sessionConfig->isActive()) {
            $storage = new NativeSessionStorage(
                ['cookie_lifetime' => ConfigQuery::read('session_config.lifetime', 0)],
                HandlerFactory::get($sessionConfig)
            );

            $session = new Session($storage);

            $event->setSession($session);

            $event->stopPropagation();
        }
    }

    /**
     * @inheritdoc
     * @api
     */
    public static function getSubscribedEvents()
    {
        return array(
            TheliaKernelEvents::SESSION => ['addSession', 64]
        );
    }
}
