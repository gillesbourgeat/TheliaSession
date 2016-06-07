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

namespace TheliaSession\Factory;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Thelia\Model\ConfigQuery;
use TheliaSession\Handler\MemcachedSessionHandler;
use TheliaSession\Entity\SessionConfigEntity;
use TheliaSession\Exception\TheliaSessionException;

/**
 * Class HandlerFactory
 * @package TheliaSession\Factory
 * @author gilles bourgeat <gilles.bourgeat@gmail.com>
 */
class HandlerFactory
{
    /**
     * @param SessionConfigEntity $sessionConfig
     * @return null|MemcachedSessionHandler
     * @throws TheliaSessionException
     */
    public static function get(SessionConfigEntity $sessionConfig)
    {
        if ($sessionConfig->isActive()) {
            return static::getHandler($sessionConfig);
        }

        return null;
    }

    public static function flush(SessionConfigEntity $sessionConfig)
    {
        if ($sessionConfig->isActive()) {
            switch ($sessionConfig->getHandlerName()) {
                case SessionConfigEntity::HANDLER_MEMCACHED:
                    $handler = static::getMemcachedHandler($sessionConfig);
                    $handler->getMemcached()->flush();
                    return $handler;
            }
        }

        $path = ConfigQuery::read("session_config.save_path", THELIA_ROOT . '/local/session/');
        $finder = new Finder();
        $fs = new Filesystem();

        /** @var SplFileInfo $file */
        foreach ($finder->files()->in($path) as $file) {
            $fs->remove($file->getPath());
        }
    }

    /**
     * @param SessionConfigEntity $sessionConfig
     * @return MemcachedSessionHandler
     * @throws TheliaSessionException
     */
    protected static function getHandler(SessionConfigEntity $sessionConfig)
    {
        switch ($sessionConfig->getHandlerName()) {
            case SessionConfigEntity::HANDLER_MEMCACHED:
                return static::getMemcachedHandler($sessionConfig);
        }

        throw new TheliaSessionException("Invalid handler name : " . $sessionConfig->getHandlerName());
    }

    /**
     * @param SessionConfigEntity $sessionConfig
     * @return MemcachedSessionHandler
     * @throws TheliaSessionException
     */
    protected static function getMemcachedHandler(SessionConfigEntity $sessionConfig)
    {
        if (!class_exists('\Memcached')) {
            throw new TheliaSessionException(
                'Please add Memcached php module on your server. "php5-memcached" '
                . 'http://php.net/manual/fr/book.memcached.php'
            );
        }

        $memcached = new \Memcached();

        // set default port
        if (!$sessionConfig->getPort()) {
            $sessionConfig->setPort(11211);
        }

        $memcached->addServer($sessionConfig->getHost(), $sessionConfig->getPort());

        $status = $memcached->getStats();

        $key = $sessionConfig->getHost() . ':' . $sessionConfig->getPort();

        if (isset($status[$key])
            && (int) $status[$key]['pid'] < 0) {
            throw new TheliaSessionException(
                'Invalid configuration for memcached server.'
                . ' Host : ' . $sessionConfig->getHost()
                . ' Port : ' . $sessionConfig->getPort()
            );
        }

        return new MemcachedSessionHandler($memcached);
    }
}
