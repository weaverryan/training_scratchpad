<?php

namespace AppBundle\Serializer;

use Psr\Log\LoggerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class OurSerializer implements SerializerInterface
{
    private $serializer;
    private $logger;

    public function __construct(SerializerInterface $serializer, LoggerInterface $logger)
    {
        $this->serializer = $serializer;
        $this->logger = $logger;
    }

    public function serialize($data, $format, array $context = array())
    {
        $this->logger->info('serializing!');

        $this->serializer->serialize($data, $format, $context);
    }

    public function deserialize($data, $type, $format, array $context = array())
    {
        $this->serializer->deserialize($data, $format, $context);
    }

}
