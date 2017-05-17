<?php

namespace Stevenmaguire\OAuth2\Client\Provider\Exception;

/**
 * Exception thrown if the provider is configured improperly.
 */
class ProviderConfigurationException extends \Exception
{
    /**
     * Creates a new exception highlighting the limitations of this package.
     *
     * @return ProviderConfigurationException
     */
    public static function clientCredentialsOnly()
    {
        return new static('This oauth2 client only supports client credentials grant.');
    }
}
