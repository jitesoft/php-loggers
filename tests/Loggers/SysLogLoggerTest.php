<?php
// phpcs:ignoreFile -- Test file
namespace Jitesoft\Log\Tests\Loggers;

use Jitesoft\Log\SysLogLogger;;
use phpmock\phpunit\PHPMock;
use PHPUnit\Framework\TestCase;

class SysLogLoggerTest extends TestCase {
    use PHPMock;

    public function testLog(): void {
        $mock = $this->getFunctionMock('Jitesoft\Log', 'syslog');
        $oMock = $this->getFunctionMock('Jitesoft\Log', 'openlog');
        $oMock->expects($this->once());
        $mock->expects(($this->once()))->with(LOG_ERR, 'Test without some words. And {nothing}!');

        $logger = new SysLogLogger();
        $logger->log(
            'error',
            'Test {with} some {params}. And {nothing}!',
            [ 'with' => 'without', 'params' => 'words']
        );
    }

}
