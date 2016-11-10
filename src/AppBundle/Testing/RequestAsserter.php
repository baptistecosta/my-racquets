<?php

namespace AppBundle\Testing;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Yaml\Parser;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Allows to chain call and assertions
 */
class RequestAsserter
{
    /**
     * @var FunctionalTestCaseInterface
     */
    private $functionalTestCase;

    /**
     * @var Client
     */
    private $client;

    /**
     * @var array
     */
    private $serverParameters;

    /**
     * @var Response
     */
    private $response;

    /**
     * Constructor
     *
     * @param AbstractWebTestCase $functionalTestCase
     * @param Client              $client
     * @param array               $serverParameters
     */
    public function __construct(AbstractWebTestCase $functionalTestCase, Client $client, array $serverParameters = [])
    {
        $this->functionalTestCase = $functionalTestCase;
        $this->client = $client;
        $this->serverParameters = $serverParameters;
    }

    /**
     * Calls an URI with GET method
     *
     * @param string $uri
     * @param array  $serverParameters
     * @param string $content
     *
     * @return $this
     */
    public function get($uri, array $serverParameters = [], $content = null)
    {
        return $this->request('GET', $uri, [], [], $serverParameters, $content);
    }

    /**
     * Calls an URI with GET method
     *
     * @param string $uri
     * @param array  $requestParameters
     * @param array  $fileParameters
     * @param array  $serverParameters
     * @param string $content
     *
     * @return $this
     */
    public function post($uri, array $requestParameters, array $fileParameters = [], array $serverParameters = [], $content = null)
    {
        return $this->request('POST', $uri, $requestParameters, $fileParameters, $serverParameters, $content);
    }

    /**
     * Calls an URI with PUT method
     *
     * @param string $uri
     * @param array  $requestParameters
     * @param array  $serverParameters
     * @param string $content
     *
     * @return $this
     */
    public function put($uri, array $requestParameters, array $serverParameters = [], $content = null)
    {
        return $this->request('PUT', $uri, $requestParameters, [], $serverParameters, $content);
    }

    /**
     * Calls an URI with PATCH method
     *
     * @param string $uri
     * @param array  $requestParameters
     * @param array  $serverParameters
     * @param string $content
     *
     * @return $this
     */
    public function patch($uri, array $requestParameters = [], array $serverParameters = [], $content = null)
    {
        return $this->request('PATCH', $uri, $requestParameters, [], $serverParameters, $content);
    }

    /**
     * Calls an URI with DELETE method
     *
     * @param string $uri
     * @param array  $serverParameters
     * @param string $content
     *
     * @return $this
     */
    public function delete($uri, array $serverParameters = [], $content = null)
    {
        return $this->request('DELETE', $uri, [], [], $serverParameters, $content);
    }

    /**
     * Calls an URI
     *
     * @param string $method
     * @param string $uri
     * @param array  $requestParameters
     * @param array  $fileParameters
     * @param array  $serverParameters
     * @param string $content
     *
     * @return $this
     */
    public function request($method, $uri, array $requestParameters = [], array $fileParameters = [], array $serverParameters = [], $content = null)
    {
        $serverParameters = array_merge($serverParameters, $this->serverParameters);

        $this->client->request(
            $method,
            $uri,
            $requestParameters,
            $fileParameters,
            $serverParameters,
            $content
        );

        $this->response = $this->client->getResponse();

        return $this;
    }

    /**
     * Asserts response status code
     *
     * @param int $statusCode
     *
     * @return $this
     */
    public function expectStatusCode($statusCode)
    {
        $this->functionalTestCase->assertEquals(
            $statusCode,
            $this->response->getStatusCode(),
            $this->response->getContent()
        );

        return $this;
    }

    /**
     * Asserts response string content exactly
     *
     * @param string $expectedContent
     *
     * @return $this
     */
    public function expectStringContent($expectedContent)
    {
        $this->functionalTestCase->assertEquals($this->response->getContent(), $expectedContent);

        return $this;
    }

    /**
     * Asserts response string content
     *
     * @param string $expectedContent
     *
     * @return $this
     */
    public function expectContentContains($expectedContent)
    {
        $this->functionalTestCase->assertContains($expectedContent, $this->response->getContent());

        return $this;
    }

    /**
     * Returns JSON content as an array
     *
     * @return array
     */
    public function getJsonContent()
    {
        $content = $this->response->getContent();

        return json_decode($content, true);
    }

    /**
     * Asserts response JSON content
     *
     * @param array $expectedContent
     *
     * @return $this
     */
    public function expectJsonContent(array $expectedContent)
    {
        $this->assertValue($this->getJsonContent(), $expectedContent);

        return $this;
    }

    /**
     * Asserts response JSON content from a Yaml file
     *
     * @param string $path
     *
     * @return $this
     */
    public function expectJsonContentFromYaml($path)
    {
        $yaml = new Parser();
        $expectedContent = $yaml->parse(file_get_contents($path));

        return $this->expectJsonContent($expectedContent);
    }

    /**
     * Asserts JSON nodes count
     *
     * @param int    $expectedCount
     * @param string $propertyPath
     *
     * @return $this
     */
    public function expectJsonNodesCount($expectedCount, $propertyPath)
    {
        $accessor = PropertyAccess::createPropertyAccessor();

        $this->functionalTestCase->assertCount($expectedCount, $accessor->getValue($this->getJsonContent(), $propertyPath));

        return $this;
    }

    /**
     * Asserts value
     *
     * @param mixed $responseContent
     * @param mixed $expectedContent
     * @param array $path
     */
    private function assertValue($responseContent, $expectedContent, array $path = [])
    {
        $basePath = $path;

        foreach ($expectedContent as $expectedKey => $expectedValue) {
            $path = $basePath;
            // Check if index exists
            $this->functionalTestCase->assertEquals(
                true,
                array_key_exists($expectedKey, $responseContent),
                sprintf(
                    'Index "%s" is not defined in response.',
                    implode(' > ', $path).' > '.$expectedKey
                )
            );

            $path[] = $expectedKey;

            // Recursive call if value in an array
            if (is_array($expectedValue)) {
                $this->assertValue($responseContent[$expectedKey], $expectedValue, $path);
            } else {
                $this->functionalTestCase->assertEquals(
                    $expectedValue,
                    $responseContent[$expectedKey],
                    sprintf(
                        'Value in result array does not match with expected one for key "%s".',
                        implode(' > ', $path)
                    )
                );
            }
        }
    }
}
