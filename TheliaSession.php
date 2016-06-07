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

namespace TheliaSession;

use Thelia\Module\BaseModule;
use TheliaSession\Entity\SessionConfigEntity;

/**
 * Class TheliaSession
 * @package TheliaSession
 * @author gilles bourgeat <gilles.bourgeat@gmail.com>
 */
class TheliaSession extends BaseModule
{
    /** @var string */
    const DOMAIN_NAME = 'theliasession';

    const CONFIG_KEY_ACTIVE = 'active';
    const CONFIG_KEY_HANDLER = 'handler';
    const CONFIG_KEY_HOST = 'host';
    const CONFIG_KEY_PORT = 'port';
    const CONFIG_KEY_USER = 'user';
    const CONFIG_KEY_PASSWORD = 'password';
    const CONFIG_KEY_POOL = 'pool';
    const CONFIG_KEY_EXPIRE = 'expire';

    const DEFAULT_VALUE_EXPIRE = 86400;
    const DEFAULT_VALUE_POOL = 'thelia';
    const DEFAULT_VALUE_HANDLER = SessionConfigEntity::HANDLER_MEMCACHED;

    /**
     * @return SessionConfigEntity
     */
    public static function getConfig()
    {
        return $sessionConfig = (new SessionConfigEntity())
            ->setActive((bool) static::getConfigValue(self::CONFIG_KEY_ACTIVE, false))
            ->setHandlerName(static::getConfigValue(self::CONFIG_KEY_HANDLER, self::DEFAULT_VALUE_HANDLER))
            ->setHost(static::getConfigValue(self::CONFIG_KEY_HOST, '127.0.0.1'))
            ->setPort((int) static::getConfigValue(self::CONFIG_KEY_PORT, null))
            ->setUser(static::getConfigValue(self::CONFIG_KEY_USER, null))
            ->setPassword(static::getConfigValue(self::CONFIG_KEY_PASSWORD, null))
            ->setPool(static::getConfigValue(self::CONFIG_KEY_POOL, self::DEFAULT_VALUE_POOL))
            ->setExpire((int) static::getConfigValue(self::CONFIG_KEY_EXPIRE, self::DEFAULT_VALUE_EXPIRE))
        ;
    }

    /**
     * @param SessionConfigEntity $sessionConfigEntity
     */
    public static function setConfig(SessionConfigEntity $sessionConfigEntity)
    {
        static::setConfigValue(static::CONFIG_KEY_ACTIVE, (int) $sessionConfigEntity->isActive());
        static::setConfigValue(static::CONFIG_KEY_HANDLER, $sessionConfigEntity->getHandlerName());
        static::setConfigValue(static::CONFIG_KEY_HOST, $sessionConfigEntity->getHost());
        static::setConfigValue(static::CONFIG_KEY_PORT, (int) $sessionConfigEntity->getPort());
        static::setConfigValue(static::CONFIG_KEY_USER, $sessionConfigEntity->getUser());
        static::setConfigValue(static::CONFIG_KEY_PASSWORD, $sessionConfigEntity->getPassword());
        static::setConfigValue(static::CONFIG_KEY_POOL, $sessionConfigEntity->getPool());
        static::setConfigValue(static::CONFIG_KEY_EXPIRE, (int) $sessionConfigEntity->getExpire());
    }
}
