<?php

namespace Stevenmaguire\OAuth2\Client\Test\Provider;

use League\OAuth2\Client\Tool\QueryBuilderTrait;
use Mockery as m;

class YelpTest extends \PHPUnit_Framework_TestCase
{
    use QueryBuilderTrait;

    protected $provider;

    protected function setUp()
    {
        $this->provider = new \Stevenmaguire\OAuth2\Client\Provider\Yelp([
            'clientId' => 'mock_client_id',
            'clientSecret' => 'mock_secret',
        ]);
    }

    protected function getJsonFile($file, $encode = false)
    {
        $json = file_get_contents(dirname(dirname(dirname(__FILE__))).'/'.$file);
        $data = json_decode($json, true);

        if ($encode && json_last_error() == JSON_ERROR_NONE) {
            return $data;
        }

        return $json;
    }

    public function tearDown()
    {
        m::close();
        parent::tearDown();
    }

    /**
     * @expectedException Stevenmaguire\OAuth2\Client\Provider\Exception\ProviderConfigurationException
     **/
    public function testAuthorizationUrl()
    {
        $url = $this->provider->getAuthorizationUrl();
    }

    /**
     * @expectedException Stevenmaguire\OAuth2\Client\Provider\Exception\ProviderConfigurationException
     **/
    public function testBaseAuthorizationUrl()
    {
        $url = $this->provider->getBaseAuthorizationUrl();
    }

    public function testGetBaseAccessTokenUrl()
    {
        $params = [];

        $url = $this->provider->getBaseAccessTokenUrl($params);
        $uri = parse_url($url);

        $this->assertEquals('api.yelp.com', $uri['host']);
        $this->assertEquals('/oauth2/token', $uri['path']);
    }

    public function testGetAccessToken()
    {
        $accessToken = $this->getJsonFile('access_token_response.json');
        $response = m::mock('Psr\Http\Message\ResponseInterface');
        $response->shouldReceive('getBody')->andReturn($accessToken);
        $response->shouldReceive('getHeader')->andReturn(['content-type' => 'json']);
        $response->shouldReceive('getStatusCode')->andReturn(200);

        $client = m::mock('GuzzleHttp\ClientInterface');
        $client->shouldReceive('send')->times(1)->andReturn($response);
        $this->provider->setHttpClient($client);

        $token = $this->provider->getAccessToken('client_credentials');

        $this->assertEquals('mock_access_token', $token->getToken());
        $this->assertNotNull($token->getExpires());
        $this->assertNull($token->getRefreshToken());
        $this->assertNull($token->getResourceOwnerId());
    }

    /**
     * @expectedException Stevenmaguire\OAuth2\Client\Provider\Exception\ProviderConfigurationException
     **/
    public function testUserData()
    {
        $token = m::mock('League\OAuth2\Client\Token\AccessToken');
        $user = $this->provider->getResourceOwner($token);
    }

    /**
     * @expectedException League\OAuth2\Client\Provider\Exception\IdentityProviderException
     **/
    public function testExceptionThrownWhenErrorObjectReceived()
    {
        $status = rand(401,599);
        $error = $this->getJsonFile('error_response.json');
        $postResponse = m::mock('Psr\Http\Message\ResponseInterface');
        $postResponse->shouldReceive('getBody')->andReturn($error);
        $postResponse->shouldReceive('getHeader')->andReturn(['content-type' => 'json']);
        $postResponse->shouldReceive('getStatusCode')->andReturn($status);
        $postResponse->shouldReceive('getStatusCode')->andReturn($status);
        $client = m::mock('GuzzleHttp\ClientInterface');
        $client->shouldReceive('send')
            ->times(1)
            ->andReturn($postResponse);
        $this->provider->setHttpClient($client);
        $token = $this->provider->getAccessToken('client_credentials');
    }
}
