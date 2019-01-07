# shorturl
Simply launch a url-shortener on your server.
As the main purpose of this package is to shorten urls locally, so for now the `local` driver
is available and `bitly and google` drivers will be added soon.

**Requirements:**

1- php-7.1

2- Laravel-5.5


**Installation:**

Install via composer:

`
composer require ako/shorturl
`

Or add ` "ako/shorturl":"^0.0.3"` to the `composer.json` file of your project.

Run `php artisan vendor:publish` to add the `shorturl.php` config file to the `config` folder.

Run `php artisan migrate` to create `links` table.

**Usage:**

You can get an instance of the `Shorturl` through Laravel `Facades`:

```php

// Default driver is local
$url = 'http://www.domain.com/here/is/a/long/url';
$short_url = \Shorturl::shorten($url); // http://www.domain.com/abde

// Expand shortened url
$expanded = \Shorturl::expand('http://www.domain.com/abde') // http://www.domain.com/here/is/a/long/url


// Or you can specify the driver
$short_url = \Shorturl::onDriver('local')->shorten($url); // http://www.domain.com/abde
$short_url = \Shorturl::onDriver('bitly')->shorten($url); // http://bit.ly/shortened

// You can add some custom properties when using local driver for later access on the url
$short_url = \Shorturl::onDriver('local')
                  ->withProperties(['key' => value])
                  ->shorten($url); // http://www.domain.com/abde
                  
```

Every time a url is expanded the `clicks` counter for given url is incremented, so you can 
make some statistics of the links.

You can use `\Ako\Shorturl\Models\Link` model as an `Eloquent` model to get number of `clicks` of each url, stored
`properties` or any other staff on the links. 
