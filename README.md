# Restinga
Easily Create REST API Clients for your PHP Applications

[![Latest Stable Version](https://poser.pugx.org/codecasts/iugu/v/stable.svg)](https://packagist.org/packages/codecasts/restinga) [![Total Downloads](https://poser.pugx.org/codecasts/restinga/downloads.svg)](https://packagist.org/packages/codecasts/restinga) [![Latest Unstable Version](https://poser.pugx.org/codecasts/restinga/v/unstable.svg)](https://packagist.org/packages/codecasts/restinga) [![License](https://poser.pugx.org/codecasts/restinga/license.svg)](https://packagist.org/packages/codecasts/restinga) [![Monthly Downloads](https://poser.pugx.org/codecasts/restinga/d/monthly.png)](https://packagist.org/packages/codecasts/restinga)

###What it is?
Restinga is tool to help you building REST Clients for your chosen API's.

###Why?
Well, sometimes the PHP Clients that companies provides sucks, you know it. Sometimes they are even more hard to use than CURLing the API itself.
We've built this package to help you when that happens.

###Quick Start

Before starting, you need to install Restinga as a project dependency. you can do that by running:

> composer require codecasts/restinga ~1.0

So now we can move defining your services.

#### 1 - Creating a Descritor for the Desired Service

Let's take for example [Digital Ocean](https://www.digitalocean.com/?refcode=3fa7794b0116) API, Restinga is not designed to handle Authorization it self so you should already have a person token or user token.

Start by Creating a file that will describe where to find and how to authorize the requests, you can easily do that by extending the `Codecasts\Restinga\Service\Descriptor` class.

```php
<?php namespace Codecasts\DigitalOcean;

use Codecasts\Restinga\Authorization\Bearer;
use Codecasts\Restinga\Service\Descriptor;

class DigitalOceanDescriptor extends Descriptor
{
    // the identifier of the service that
    // we're gonna use later when creating
    // our resource classes
    protected $service = 'digital-ocean';

    // the prefix to be used when calling the api
    protected $prefix = 'https://api.digitalocean.com/v2';

    // this method returns an Authorization class instance
    // There are a few available, just check
    // the Codecasts\Restinga\Authorization namespace
    public function authorization()
    {
        return new Bearer('your-token-here');
    }
}
```

After creating this file, you need to Register it on the Restinga Container, so it can be used by your resource classes later.

You can do that by using:

```php
$digital_ocean = new Codecasts\DigitalOcean\DigitalOceanDescriptor();
Codecasts\Restinga\Container::register($digital_ocean);
```

####2 - Defining your resources

Ok, now that we have everything in place, let's create our first resource.
Let's say we want to handle the digital ocean droplets, right? so, we'll define a Resource (by extending `Codecasts\Restinga\Data\Resource`) to handle it.

```php
<?php namespace Codecasts\DigitalOcean\Resource;

use Codecasts\Restinga\Data\Resource;
use Codecasts\Restinga\Http\Format\Receive\ReceiveJson;
use Codecasts\Restinga\Http\Format\Receive\ReceiveJsonErrors;
use Codecasts\Restinga\Http\Format\Send\SendJson;

class Droplet extends Resource
{
    // Each resource will need to use 2 traits to
    // define in which format it should send & receive data.
    // In your example, Digital Ocean uses Json to exchange data.
    use ReceiveJson;
    use SendJson;
    
    // Also, a format for errors are needed
    use ReceiveJsonErrors;

    // the identifier of which service restinga should use when
    // handling this resource
    // the name should match with the one you defined on the Service Descriptor
    protected $service = 'digital-ocean';

    // In this attribute, we dine the resource name, that will be used
    // as the sufix for the already defined api prefix
    protected $name = 'droplets';

    // The identifier is the main attribute that should be used when calling the api for
    // the current resource
    protected $identifier = 'id';

    // When receiving Data, the result may be nested inside 
    // a response object, like {"items": {"first_item"}}
    // this attribute is where you set the root element for the response
    // when searching for a collection (multiple items)
    protected $collection_root = 'droplets';

    // works like $collection_root, but now this attribute
    // sets the root when a single result is expected
    // (like getting a droplet by using an id)
    protected $item_root = 'droplet';
}
```

####3 - Using the Defined Resource

Ok, now that we defined your resource, we can start using it.

*Creating a Droplet*

```php
use Codecasts\DigitalOcean\Resource\Droplet;

$droplet = new Droplet();
$droplet->name = 'server.restinga.dev';
$droplet->region = 'nyc3';
$droplet->size = '512mb';
$droplet->image = 'ubuntu-14-04-x64';

$saved = $droplet->save();

if ($saved) {
    echo $droplet->id; // 4242424
}
```
**Error when creating a Droplet**

```php
use Codecasts\DigitalOcean\Resource\Droplet;

$droplet = new Droplet();
$droplet->name = 'server.restinga.dev';
$droplet->region = 'nyc3';
$droplet->size = '512mb';
// Image is required, let's send the request without it to see an error happening
//$droplet->image = 'ubuntu-14-04-x64';

$saved = $droplet->save();

if ($saved) {
    echo $droplet->id;
} else {
    // will print:
    // "unprocessable_entity, You specified an invalid image for Droplet creation."
    echo implode(', ', $droplet->getErrors()->all()); 
}
```

**Finding a resource by it's identifier**

```php
use Codecasts\DigitalOcean\Resource\Droplet;

$droplet = new Droplet();

$found = $droplet->find('4242424'); // the id of the droplet we just created

if ($found) {
    echo $droplet->name; // server.restinga.dev
} else {
    foreach ($droplet->errors->all() as $code => $error) {
        echo $code . ": " . $error . "\n"; 
    }
    // id: not_found
    // message: The resource you were accessing could not be found.
}

```

**Updating an Resource**

The General idea is the same:

```php
use YourApp\Resources\YourResource();

$resource = new YourResource();
$resource->find('123');

$resource->price = '43.99';

$resource->update();
```

**Deleting an Resource**

Works the same way:

```php
use YourApp\Resources\YourResource();

$resource = new YourResource();
$resource->find('123');

$resource->destroy();
```

**Nested Resources**
All good for an example so far, but real world api has nested objects. That's ok, let's see how to handle it.

Digital Ocean has Domain and Domain Records, let's create those two resources and link them.

Domains:

```php
<?php namespace Codecasts\DigitalOcean\Resource;

use Codecasts\Restinga\Data\Resource;
use Codecasts\Restinga\Http\Format\Receive\ReceiveJson;
use Codecasts\Restinga\Http\Format\Receive\ReceiveJsonErrors;
use Codecasts\Restinga\Http\Format\Send\SendJson;

class Domain extends Resource
{
    use ReceiveJson;
    use SendJson;
    use ReceiveJsonErrors;

    protected $service = 'digital-ocean';

    protected $name = 'domains';

    protected $identifier = 'name';

    protected $collection_root = 'domains';

    protected $item_root = 'domain';
}
```

DomainRecord:
```php
<?php namespace Codecasts\DigitalOcean\Resource;

use Codecasts\Restinga\Data\Resource;
use Codecasts\Restinga\Http\Format\Receive\ReceiveJson;
use Codecasts\Restinga\Http\Format\Receive\ReceiveJsonErrors;
use Codecasts\Restinga\Http\Format\Send\SendJson;

class DomainRecord extends Resource
{
    use ReceiveJson;
    use SendJson;
    use ReceiveJsonErrors;

    protected $service = 'digital-ocean';

    protected $name = 'records';

    protected $identifier = 'id';

    protected $collection_root = 'records';

    protected $item_root = 'record';
}
```

Those two are created but not linked yet, let's do that by creating a `record()` method inside the Domain resource class:

```php
    public function record()
    {
        return $this->childResource(new DomainRecord());
    }
```

Now, we can use it this way:

```php

use Codecasts\DigitalOcean\Resource\Domain;

$domain = new Domain();

$domain->find('restinga.dev');

$records = $domain->record()->all();

foreach ($records as $record) {
    echo $record->id . ' - ' . $record->type. ' - ' . $record->data . "\n";
}
//6124929 - NS - ns1.digitalocean.com
//6124930 - NS - ns2.digitalocean.com
//6124931 - NS - ns3.digitalocean.com
//6124932 - A - 123.123.123.123
```


Other method also works the same way, for example, to find and update a record

```php
use Codecasts\DigitalOcean\Resource\Domain;

$domain = new Domain();

$domain->find('restinga.dev');

$record = $domain->record()->find('6124932');

$record->data = '222.222.222.222';

$record->update();
```

# NOTICE: Full documentation is about to be writen. Thanks for understanding
