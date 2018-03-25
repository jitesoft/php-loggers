<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  LogFormatterTraitTest.php - Part of the Logger project.

  © - Jitesoft 2018
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Log\Tests;

use Jitesoft\Log\Traits\TextFormatterTrait;
use PHPUnit\Framework\TestCase;

/**
 * LogFormatterTraitTest
 * @author Johannes Tegnér <johannes@jitesoft.com>
 * @version 1.0.0
 */
class LogFormatterTraitTest extends TestCase {

    protected $testLogger;

    protected function setUp() {
        parent::setUp();

        $loggerClass = new class {
            use TextFormatterTrait;

            public function callFormat(string $message, array $context = []) {
                return $this->format($message, $context);
            }
        };

        $this->testLogger = new $loggerClass();
    }

    public function testFormatterPlaceholders() {
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

