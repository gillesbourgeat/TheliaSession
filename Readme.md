# Thelia Session

This module allows to change the session storage of Thelia.
- [x] Memcached

## Installation

### Manually

* Copy the module into ```<thelia_root>/local/modules/``` directory and be sure that the name of the module is TheliaSession.
* Activate it in your thelia administration panel

### Composer

Add it in your main thelia composer.json file

```
composer require thelia/thelia-session-module:~0.1
```

## Usage

### Command : session config

* Example for Memcached

```bach
php Thelia session:config --handler=memcached --host=127.0.0.1 --port=11211
```

### Command : session clear

```bach
php Thelia session:clear
```

### Todo

- [ ] MongoSessionHandler
- [ ] PdoSessionHandler
- [ ] MemcacheSessionHandler
- [ ] RedisSessionHandler
