<?php
namespace Conductor\Tests;
use Conductor\Conductor;

class ConductorTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $router = new Conductor();
        $this->assertInstanceOf('Conductor\Conductor', $router);
        $router = new Conductor('method');
        $this->assertInstanceOf('Conductor\Conductor', $router);
    }

    public function testSetMethod()
    {
        $router = new Conductor();
        try {
            $router->setMethod(123);
        } catch (\InvalidArgumentException $e) {
            $this->assertTrue(true);
        }

        $this->assertInstanceOf('Conductor\Conductor', $router->setMethod('method'));
    }
    
    public function testAddRoutes()
    {
        $router = new Conductor();
        try {
            $router->addRoutes(array(), 1);
        } catch (\InvalidArgumentException $e) {
            $this->assertTrue(true);
        }

        $this->assertInstanceOf('Conductor\Conductor', $router->addRoutes(array(), 'method'));
        $this->assertInstanceOf('Conductor\Conductor', $router->addRoutes(array(), 'method'));
    }

    public function testGetRoutes()
    {
        $router = new Conductor();

        try {
            $router->getRoutes();
        } catch (\InvalidArgumentException $e) {
            $this->assertTrue(true);
        }

        $this->assertEquals(array(), $router->getRoutes('method'));

        $router->setMethod('method');
        $this->assertEquals(array(), $router->getRoutes());

        $router->addRoutes(
            array(
                'route_1' => 'action_1',
                'route_2' => 'action_2'
            )
        );

        $router->addRoutes(
            array(
                'route' => 'action',
                'route_2' => 'action_3'
            ),
            'method'
        );

        $expectedRoutes = array(
            'route_1' => 'action_1',
            'route' => 'action',
            'route_2' => 'action_3'
        );
    
        $this->assertEquals($expectedRoutes, $router->getRoutes('method'));
    }

    public function testRun()
    {
        $router = new Conductor('method'); 

        $router->addRoutes(
            array(
                '/' => function () {return 'Success';}
            )
        );
        
        try {
            $router->run(1);
        } catch (\InvalidArgumentException $e) {
            $this->assertTrue(true);
        }

        $this->assertEquals('Success', $router->run('/'));
        
        try {
            $router->run('no route');
        } catch (\RuntimeException $e) {
            $this->assertTrue(true);
        }
    }
}
