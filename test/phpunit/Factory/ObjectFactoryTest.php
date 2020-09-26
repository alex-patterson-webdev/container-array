<?php

declare(strict_types=1);

namespace ArpTest\ContainerArray\Factory;

use Arp\ContainerArray\Factory\ObjectFactory;
use Arp\ContainerArray\Factory\ServiceFactoryInterface;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Arp\ContainerArray\Factory\ObjectFactory
 *
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package ArpTest\ContainerArray\Factory
 */
final class ObjectFactoryTest extends TestCase
{
    /**
     * Assert that the object factory implements ServiceFactoryInterface
     */
    public function testImplementsServiceFactoryInterface(): void
    {
        $factory = new ObjectFactory();

        $this->assertInstanceOf(ServiceFactoryInterface::class, $factory);
    }
}