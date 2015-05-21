Case Status

---

[![Build Status](https://img.shields.io/travis/NickTomlin/php-case-status.svg?branch=master)](https://travis-ci.org/NickTomlin/php-case-status)


A PHP scraper to programatically check your [USCIS case status](https://egov.uscis.gov/casestatus/landing.do)

```
$client = new CaseStatus\Client('msc1490880727');
$response = $client->get();
print_r($response->text())

Card Was Delivered To Me By The Post Office
	              On June 23, 2014, the Post Office delivered your new card for Receipt Number MSC1490880727, to the address that you gave us.  The tracking number assigned is 9205592338400136799834.
You can use your tracking number at www.USPS.com in the Quick Tools Tracking section.  If you move, go to www.uscis.gov/addresschange to give us your new mailing address.

```

### Installing via Composer

```bash
# Install Composer
curl -sS https://getcomposer.org/installer | php
```

```bash
composer.phar require nicktomlin/case-status
```

After installing, you need to require Composer's autoloader:

```php
require 'vendor/autoload.php';
```

### Tests

```bash
./vendor/bin/phpunit
```
