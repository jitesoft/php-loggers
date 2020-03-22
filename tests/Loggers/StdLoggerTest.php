<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  StdLoggerTest.php - Part of the php-logger project.

  © - Jitesoft 2017
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Log\Tests\Loggers;

use Carbon\Carbon;
use Jitesoft\Log\StdLogger;
use Jitesoft\Log\Tests\StreamFilter;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class StdLoggerTest extends TestCase {

    /** @var LoggerInterface */
    protected $logger;
    protected $expectedFormat     = "[%s] %s: %s";
    protected $expectedTimeFormat ='H:i:s.v';

    protected function setUp(): void {
        parent::setUp();
        stream_filter_register('catcher', StreamFilter::class);
        Carbon::setTestNow(Carbon::createFromTimestamp(1513976746099));
        $this->logger = new StdLogger();
    }

    public function testLog(): void {
        stream_filter_prepend(STDOUT, 'catcher');
        $this->logger->log(
            'TestLevel',
            'Test {with} some {params}. And {nothing}!',
            [ 'with' => 'without', 'params' => 'words']
        );
        $this->assertEquals(
            sprintf(
                $this->expectedFormat,
                Carbon::getTestNow()->format($this->expectedTimeFormat),
                'TESTLEVEL',
                'Test without some words. And {nothing}!'
            ),
            StreamFilter::$output
        );
    }

}
