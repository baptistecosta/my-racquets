<?php

namespace AppBundle\Testing;

use AppBundle\Entity\User;
use AppBundle\Testing\Fixtures\FixturesTestCaseTrait;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * API tests must extend this class
 */
class AbstractWebTestCase extends WebTestCase
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var array
     */
    private static $fixturesReferences;

    use PrintClassNameTrait,
        FixturesTestCaseTrait,
        DatabaseTestCaseTrait;

    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->getService('doctrine.orm.default_entity_manager');
    }

    /**
     * @param string $name
     * @param array  $parameters
     *
     * @return string
     */
    protected function generateUrl($name, $parameters = [])
    {
        $router = $this->getService('router');

        return $router->generate($name, $parameters);
    }

    /**
     * Retrieves a User from its email
     *
     * @param string $email
     *
     * @return User
     */
    protected function getUser($email)
    {
        return $this->getService('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:User')
            ->findOneByEmail($email);
    }

    /**
     * {@inheritdoc}
     */
    protected static function getKernelClass()
    {
        $dir = $_SERVER['KERNEL_DIR'];
        $file = sprintf('%s/AppTestKernel.php', $dir);

        require_once $file;

        return 'AppTestKernel';
    }

    /**
     * @return ContainerInterface
     */
    protected function getContainer()
    {
        if (is_null($this->container)) {
            static::bootKernel();
            $this->container = static::$kernel->getContainer();
        }

        return $this->container;
    }

    /**
     * Return a service from the DIC
     *
     * @param string $name
     *
     * @return object
     */
    protected function getService($name)
    {
        return $this->getContainer()->get($name);
    }

    /**
     * Return a parameter
     *
     * @param string $name
     *
     * @return string
     */
    protected function getParameter($name)
    {
        return $this->getContainer()->getParameter($name);
    }

    /**
     * {@inheritdoc}
     */
    protected function checkRequirements()
    {
        parent::checkRequirements();

        $annotations = $this->getAnnotations();

        if (isset($annotations['class']['purgeDatabaseAndLoadFixtures']) ||
            isset($annotations['method']['purgeDatabaseAndLoadFixtures'])
        ) {
            $this->purgeDatabaseAndLoadFixtures();
            self::$fixturesReferences = $this->fixturesLoader->getReferences();
        } elseif (isset(self::$fixturesReferences)) {
            $this->initFixturesLoader(self::$fixturesReferences);
        }
    }

    /**
     * Create a client with a default Authorization header.
     *
     * @param string $username
     * @param string $password
     *
     * @return Client
     */
    protected static function createAuthenticatedClient($username = 'user', $password = 'testtest')
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/login_check',
            [
                'username' => $username,
                'password' => $password,
            ]
        );

        $data = json_decode($client->getResponse()->getContent(), true);

        $client = static::createClient();
        $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data['token']));

        return $client;
    }

    /**
     * @return Client
     */
    protected static function createAdminClient()
    {
        return self::createAuthenticatedClient(User::EMAIL_ADDRESS_ADMIN);
    }

    /**
     * @param string $url
     * @param string $method
     * @param array  $payload
     */
    protected function assertRouteIsForbiddenForNonAdmin($url, $method = 'get', $payload = [])
    {
        $client = static::createAuthenticatedClient(User::EMAIL_ADDRESS_BAPTISTE);

        (new RequestAsserter($this, $client))
            ->$method(
                $url,
                $payload
            )
            ->expectStatusCode(Response::HTTP_FORBIDDEN);
    }
}
