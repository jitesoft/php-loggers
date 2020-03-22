<?php

namespace Jitesoft\Log\Tests\Loggers;

use Jitesoft\Log\CallbackLogger;
use Jitesoft\Log\MultiLogger;
use Jitesoft\Log\NullLogger;
use Jitesoft\Log\StdLogger;
use Jitesoft\Log\SysLogLogger;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class MultiLoggerTest extends TestCase {
    private MultiLogger $logger;

    protected function setUp(): void {
        parent::setUp();

        $this->logger = new MultiLogger([new NullLogger()]);
    }

    public function testAddLogger(): void {

        $rc = new ReflectionClass($this->logger);
        $prop = $rc->getProperty('loggers');
        $prop->setAccessible(true);
        $this->assertCount(1, $prop->getValue($this->logger));
        $this->logger->addLogger(new StdLogger());
        $this->logger->addLogger(new CallbackLogger(static function(){}));
        $this->logger->addLogger(new SysLogLogger());
        $this->logger->addLogger(new NullLogger(), 'secondary');
        $this->assertCount(5, $prop->getValue($this->logger));
    }


    public function testRemoveLogger(): void {
        $rc = new ReflectionClass($this->logger);
        $prop = $rc->getProperty('loggers');
        $prop->setAccessible(true);
        $this->assertCount(1, $prop->getValue($this->logger));
        $this->logger->removeLogger(new NullLogger());
        $this->assertCount(0, $prop->getValue($this->logger));
    }

    public function testLog(): void {
        $data = [];
        $this->logger->addLogger(new CallbackLogger(static function (...$args) use(&$data) {
            $data = $args;
        }));

        $this->logger->log(
            'TestLevel',
            'Test {with} some {params}. And {nothing}!',
            [ 'with' => 'without', 'params' => 'words']
        );

        $this->assertEquals('TestLevel', $data[0]);
        $this->assertEquals(
            'Test without some words. And {nothing}!',
            $data[1]
        );
        $this->assertEquals(
            'Test {with} some {params}. And {nothing}!',
            $data[2]
        );
        $this->assertEquals(
            [ 'with' => 'without', 'params' => 'words'],
            $data[3]
        );
    }

}
