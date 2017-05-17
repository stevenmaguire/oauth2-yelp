# Yelp Provider for OAuth 2.0 Client

[![Latest Version](https://img.shields.io/github/release/stevenmaguire/oauth2-yelp.svg?style=flat-square)](https://github.com/stevenmaguire/oauth2-yelp/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/stevenmaguire/oauth2-yelp/master.svg?style=flat-square)](https://travis-ci.org/stevenmaguire/oauth2-yelp)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/stevenmaguire/oauth2-yelp.svg?style=flat-square)](https://scrutinizer-ci.com/g/stevenmaguire/oauth2-yelp/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/stevenmaguire/oauth2-yelp.svg?style=flat-square)](https://scrutinizer-ci.com/g/stevenmaguire/oauth2-yelp)
[![Total Downloads](https://img.shields.io/packagist/dt/stevenmaguire/oauth2-yelp.svg?style=flat-square)](https://packagist.org/packages/stevenmaguire/oauth2-yelp)

This package provides Yelp OAuth 2.0 support for the PHP League's [OAuth 2.0 Client](https://github.com/thephpleague/oauth2-client).

## Installation

To install, use composer:

```
composer require stevenmaguire/oauth2-yelp
```

## Usage

Usage is the same as The League's OAuth client, using `\Stevenmaguire\OAuth2\Client\Provider\Yelp` as the provider.

### Client Credentials Flow

```php
$provider = new Stevenmaguire\OAuth2\Client\Provider\Yelp([
    'clientId'          => '{yelp-client-id}',
    'clientSecret'      => '{yelp-client-secret}'
]);

try {

    // Try to get an access token using the client credentials grant.
    $accessToken = $provider->getAccessToken('client_credentials');

} catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {

    // Failed to get the access token
    exit($e->getMessage());

}
```

For further usage of this package please refer to the [core package documentation on "Client Credentials Grant"](https://github.com/thephpleague/oauth2-client#client-credentials-grant).

Due to the constraints of [Yelp Fusion's OAuth2 implementation](https://www.yelp.com/developers/documentation/v3/authentication), this package currently only supports the Client Credentials Grant and as a result, if you engage with the package for other grant types a `Stevenmaguire\OAuth2\Client\Provider\Exception\ProviderConfigurationException` exception will be thrown.

## Testing

``` bash
$ ./vendor/bin/phpunit
```

## Contributing

Please see [CONTRIBUTING](https://github.com/stevenmaguire/oauth2-yelp/blob/master/CONTRIBUTING.md) for details.


## Credits

- [Steven Maguire](https://github.com/stevenmaguire)
- [All Contributors](https://github.com/stevenmaguire/oauth2-yelp/contributors)


## License

The MIT License (MIT). Please see [License File](https://github.com/stevenmaguire/oauth2-yelp/blob/master/LICENSE) for more information.
