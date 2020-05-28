<?php
// phpcs:ignoreFile -- Test file
namespace Jitesoft\Log\Tests\Loggers;

use Carbon\Carbon;
use Jitesoft\Log\CallbackLogger;
use PHPUnit\Framework\TestCase;

class CallbackLoggerTest extends TestCase {
    protected string $expectedFormat     = '[%s] %s: %s';
    protected string $expectedTimeFormat ='H:i:s.v';

    protected function setUp(): void {
        parent::setUp();

        Carbon::setTestNow(Carbon::createFromTimestamp(1513976746099));
    }

    public function testLog(): void {
        $data = [];
        (new CallbackLogger(
            static function (...$args) use(&$data) {
                $data = $args;
            }
        ))->log(
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
