<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  LogLevelTraitTest.php - Part of the  project.

  © - Jitesoft 2018
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Log\Tests;

use Jitesoft\Log\Traits\LogLevelTrait;
use PHPUnit\Framework\TestCase;

/**
 * LogLevelTraitTest
 * @author Johannes Tegnér <johannes@jitesoft.com>
 * @version 1.0.0
 *
 * Test for Jitesoft\Log\Traits\LogLevelTrait.
 */
class LogLevelTraitTest extends TestCase {

    protected $testLogger;
    protected $logLevel = [ 'debug', 'notice', 'info', 'warning', 'error', 'critical', 'alert', 'emergency' ];

    public function setUp(): void {
        parent::setUp();
        $loggerClass = new class {
            use LogLevelTrait;

            public function callShouldLog($level) {
                return $this->shouldLog($level);
            }
            protected function innerLog(string $level, string $message, array $context): void {}
        };

        $this->testLogger = new $loggerClass();
    }

    public function testDebug(): void {
        $this->runIt(0);
    }

    public function testNotice(): void {
        $this->runIt(1);
    }

    public function testInfo(): void {
        $this->runIt(2);
    }

    public function testWarning(): void {
        $this->runIt(3);
    }

    public function testError(): void {
        $this->runIt(4);
    }

    public function testCritical(): void {
        $this->runIt(5);
    }

    public function testAlert(): void {
        $this->runIt(6);
    }

    public function testEmergency(): void {
        $this->runIt(7);
    }

    private function runIt(int $lev = 99) {
        $this->testLogger->setLogLevel($this->logLevel[$lev]);
        foreach ($this->logLevel as $index => $level) {
            if ($index >= $lev) {
                $this->assertTrue($this->testLogger->callShouldLog($level),
                    sprintf(
                        'Log level %s should return true on %s but did not. (%d)',
                        $lev, $level, $index
                    )
                );
            } else {
                $this->assertFalse($this->testLogger->callShouldLog($level),
                    sprintf(
                        'Log level %s should return false on %s but did not. (%d)',
                        $lev, $level, $index
                    )
                );
            }
        }
    }



}
