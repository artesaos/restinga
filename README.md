# Restinga
Restinga a is a ActiveResource Framework. What it means? It allows you to consume Rest APIs in a easy and intuitive way. Heavy inspired by Laravel's Eloquent (ActiveRecord Library).

[![Latest Stable Version](https://poser.pugx.org/artesaos/restinga/v/stable.svg)](https://packagist.org/packages/artesaos/restinga) [![Total Downloads](https://poser.pugx.org/artesaos/restinga/downloads.svg)](https://packagist.org/packages/artesaos/restinga) [![Latest Unstable Version](https://poser.pugx.org/artesaos/restinga/v/unstable.svg)](https://packagist.org/packages/artesaos/restinga) [![License](https://poser.pugx.org/artesaos/restinga/license.svg)](https://packagist.org/packages/artesaos/restinga) [![Monthly Downloads](https://poser.pugx.org/artesaos/restinga/d/monthly.png)](https://packagist.org/packages/artesaos/restinga)

## Documentation
[Dig into the Documentation](https://github.com/artesaos/restinga/wiki)

###Why it was built?
Well, sometimes the PHP Clients that companies provides sucks, you know it. Sometimes they are even more hard to use than CURLing the API itself.
We've built this package to help you when that happens.

###Quick Start Guide

**For our quick usage tutorial, let's use Digital Ocean as a example Rest API we want to consume.**

##### 1 - Define the API Service.

```php
<?php namespace Artesaos\DigitalOcean;

use Artesaos\Restinga\Authorization\Bearer;
use Artesaos\Restinga\Service\Descriptor;

class DigitalOceanDescriptor extends Descriptor
{
    // service alias
    protected $service = 'digital-ocean';

    // api prefix
    protected $prefix = 'https://api.digitalocean.com/v2';

    // how to authenticate on the api
    public function authorization()
    {
        return new Bearer('your-token-here');
    }
}
```

##### 2 - Register the API against the Restinga Container

```php

use Artesaos\DigitalOcean\DigitalOceanDescriptor;
use Artesaos\Restinga\Container;

Container::register(new DigitalOceanDescriptor());
```

##### 3 - Define a API Resource

```php
<?php namespace Artesaos\DigitalOcean\Resource;

use Artesaos\Restinga\Data\Resource;
use Artesaos\Restinga\Http\Format\Receive\ReceiveJson;
use Artesaos\Restinga\Http\Format\Receive\ReceiveJsonErrors;
use Artesaos\Restinga\Http\Format\Send\SendJson;

class Droplet extends Resource
{
    // send & receive formats
    use ReceiveJson;
    use SendJson;

    // errors format
    use ReceiveJsonErrors;

    // the service to use (defined on the descriptor)
    protected $service = 'digital-ocean';

    // api resource to consume
    protected $name = 'droplets';

    // resource identifier
    protected $identifier = 'id';

    // resource collection root
    protected $collection_root = 'droplets';

    // resource single item root
    protected $item_root = 'droplet';
}
```

##### 4 - Use it!

```php
<?php

use Artesaos\DigitalOcean\Resource\Droplet;

$droplet = new Droplet();
$droplet->name = 'server.restinga.dev';
$droplet->region = 'nyc3';
$droplet->size = '512mb';
$droplet->image = 'ubuntu-14-04-x64';

$saved = $droplet->save();

if ($saved) {
    echo $droplet->id; // 4242424
} else {
    foreach ($droplet->errors->all() as $code => $error) {
        echo $code . ": " . $error . "\n";
    }
}

```

