<?php
// phpcs:ignoreFile -- Test file
namespace Jitesoft\Log\Tests;

use Jitesoft\Log\Traits\TextFormatterTrait;
use PHPUnit\Framework\TestCase;

class LogFormatterTraitTest extends TestCase {

    protected $testLogger;

    protected function setUp(): void {
        parent::setUp();

        $loggerClass = new class {
            use TextFormatterTrait;

            public function callFormat(string $message, array $context = []) {
                return $this->format($message, $context);
            }
        };

        $this->testLogger = new $loggerClass();
    }

    public function testFormatterPlaceholders(): void {
        $msg = $this->testLogger->callFormat(
            'Test {with} some {params}. And {nothing}!',
            [ 'with' => 'without', 'params' => 'words']
        );
        $this->assertEquals(
            sprintf('Test without some words. And {nothing}!'),
            $msg
        );
    }

}

