<?php

namespace AppBundle\Service;

use Gl3n\SerializationGroupBundle\Resolver;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer;

/**
 * Serialize entities using "Gl3nSerialisationGroupResolver" and "JMSSerializer".
 */
class GroupSerializer
{
    /**
     * @var Resolver
     */
    private $serializationGroupResolver;

    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * @param Resolver   $serializationGroupResolver
     * @param Serializer $serializer
     */
    public function __construct(Resolver $serializationGroupResolver, Serializer $serializer)
    {
        $this->serializationGroupResolver = $serializationGroupResolver;
        $this->serializer = $serializer;
    }

    /**
     * @param mixed  $data
     * @param string $group
     * @param string $format
     * @return string
     */
    public function serialize($data, $group, $format = 'json')
    {
        $groups = $this->serializationGroupResolver->resolve($group);
        $context = SerializationContext::create()->setGroups($groups);
        $context->setSerializeNull(true);

        $serializedData = $this->serializer->serialize($data, $format, $context);

        return $serializedData;
    }
}
