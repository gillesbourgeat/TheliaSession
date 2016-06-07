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

namespace TheliaSession\Entity;

use TheliaSession\TheliaSession;

/**
 * Class SessionConfigEntity
 * @package TheliaSession\Entity
 * @author gilles bourgeat <gilles.bourgeat@gmail.com>
 */
class SessionConfigEntity
{
    const HANDLER_MEMCACHED = 'memcached';
    //const HANDLER_MEMCACHE = 'memcache';
    //const HANDLER_MONGO_DB = 'mongo_db';
    //const HANDLER_PDO = 'pdo';

    /** @var bool */
    protected $active = false;

    /** @var string */
    protected $handlerName;

    /** @var string */
    protected $host = "127.0.0.1";

    /** @var int */
    protected $port;

    /** @var null|string */
    protected $user;

    /** @var null|string */
    protected $password;

    /** @var int */
    protected $expire = TheliaSession::DEFAULT_VALUE_EXPIRE;

    /** @var string */
    protected $pool = TheliaSession::DEFAULT_VALUE_POOL;

    /**
     * @return string
     */
    public function getPool()
    {
        return $this->pool;
    }

    /**
     * @param string $pool
     * @return SessionConfigEntity
     */
    public function setPool($pool)
    {
        $this->pool = $pool;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param boolean $active
     * @return SessionConfigEntity
     */
    public function setActive($active)
    {
        $this->active = (bool) $active;
        return $this;
    }

    /**
     * @return string
     */
    public function getHandlerName()
    {
        return $this->handlerName;
    }

    /**
     * @param string $handlerName
     * @return SessionConfigEntity
     */
    public function setHandlerName($handlerName)
    {
        $this->handlerName = $handlerName;
        return $this;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param string $host
     * @return SessionConfigEntity
     */
    public function setHost($host)
    {
        $this->host = $host;
        return $this;
    }

    /**
     * @return int
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @param int $port
     * @return SessionConfigEntity
     */
    public function setPort($port)
    {
        $this->port = (int) $port;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param null|string $user
     * @return SessionConfigEntity
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param null|string $password
     * @return SessionConfigEntity
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return int
     */
    public function getExpire()
    {
        return $this->expire;
    }

    /**
     * @param int $expire
     * @return SessionConfigEntity
     */
    public function setExpire($expire)
    {
        $this->expire = (int) $expire;
        return $this;
    }
}
