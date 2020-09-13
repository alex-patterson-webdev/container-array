<?php

declare(strict_types=1);

namespace Arp\ContainerArray\Adapter;

use Arp\Container\Adapter\AbstractPsrAdapter;
use Arp\Container\Adapter\BuildAwareInterface;
use Arp\Container\Adapter\ContainerAdapterInterface;
use Arp\Container\Adapter\Exception\AdapterException;
use Arp\Container\Adapter\Exception\NotFoundException;
use Arp\Container\Adapter\FactoryClassAwareInterface;
use Arp\ContainerArray\ArrayContainer;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\ContainerArray\Adapter
 */
final class ArrayAdapter extends AbstractPsrAdapter implements FactoryClassAwareInterface, BuildAwareInterface
{
    /**
     * @var ArrayContainer|ContainerInterface
     */
    protected ContainerInterface $container;

    /**
     * @param ArrayContainer $container
     */
    public function __construct(ArrayContainer $container)
    {
        parent::__construct($container);
    }

    /**
     * Set a new service on the container.
     *
     * @param string $name    The name of the service to set.
     * @param mixed  $service The service to register.
     *
     * @return $this
     *
     * @throws AdapterException
     */
    public function setService(string $name, $service): ContainerAdapterInterface
    {
        try {
            $this->container->set($name, $service);
        } catch (ContainerExceptionInterface $e) {
            throw new AdapterException($e->getMessage(), $e->getCode(), $e);
        }

        return $this;
    }

    /**
     * Register a callable factory for the container.
     *
     * @param string   $name    The name of the service to register.
     * @param callable $factory The factory callable responsible for creating the service.
     *
     * @return $this
     *
     * @throws AdapterException
     */
    public function setFactory(string $name, callable $factory): ContainerAdapterInterface
    {
        try {
            $this->container->setFactory($name, $factory);
        } catch (ContainerExceptionInterface $e) {
            throw new AdapterException(
                sprintf('The setting of the factory for service \'%s\' failed : %s', $name, $e->getMessage()),
                $e->getCode(),
                $e
            );
        }

        return $this;
    }

    /**
     * Set the class name of a factory that will create service $name.
     *
     * @param string      $name    The name of the service to set the factory for.
     * @param string      $factory The fully qualified class name of the factory.
     * @param string|null $method  The name of the factory method to call.
     *
     * @return $this
     *
     * @throws AdapterException If the factory class cannot be set
     */
    public function setFactoryClass(string $name, string $factory, string $method = null)
    {
        try {
            $this->container->setFactoryClass($name, $factory);
        } catch (ContainerExceptionInterface $e) {
            throw new AdapterException(
                sprintf('The setting of the factory class for service \'%s\' failed : %s', $name, $e->getMessage()),
                $e->getCode(),
                $e
            );
        }

        return $this;
    }

    /**
     * Create a new service instance with the provided $options.
     *
     * @param string $name
     * @param array  $options
     *
     * @return mixed
     *
     * @throws AdapterException If service cannot be created
     */
    public function build(string $name, array $options = [])
    {
        try {
            return $this->container->b($name, $options);
        } catch (NotFoundExceptionInterface $e) {
            throw new NotFoundException(
                sprintf('The service \'%s\' could not be found : %s', $name, $e->getMessage()),
                $e->getCode(),
                $e
            );
        } catch (ContainerExceptionInterface $e) {
            throw new AdapterException(
                sprintf('The setting of the factory class for service \'%s\' failed : %s', $name, $e->getMessage()),
                $e->getCode(),
                $e
            );
        }
    }
}
