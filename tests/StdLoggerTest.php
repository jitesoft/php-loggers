<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  StdLoggerTest.php - Part of the php-logger project.

  © - Jitesoft 2017
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Log\Tests;

use Carbon\Carbon;
use Jitesoft\Log\StdLogger;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class StdLoggerTest extends TestCase {

    /** @var LoggerInterface */
    protected $logger;
    protected $expectedFormat     = "[%s] %s: %s";
    protected $expectedTimeFormat ='H:i:s.v';

    protected function setUp() {
        parent::setUp();
        stream_filter_register('catcher', StreamFilter::class);
        Carbon::setTestNow(Carbon::createFromTimestamp(1513976746099));
        $this->logger = new StdLogger();
    }

    public function testLogEmergency() {
        stream_filter_prepend(STDERR, 'catcher');
        $this->logger->emergency(
            'Test {with} some {params}. And {nothing}!',
            [ 'with' => 'without', 'params' => 'words']
        );
        $this->assertEquals(
            sprintf(
                $this->expectedFormat,
                Carbon::getTestNow()->format($this->expectedTimeFormat),
                'EMERGENCY',
                'Test without some words. And {nothing}!'
            ),
            StreamFilter::$output
        );
    }

    public function testLogAlert() {
        stream_filter_prepend(STDERR, 'catcher');
        $this->logger->alert(
            'Test {with} some {params}. And {nothing}!',
            [ 'with' => 'without', 'params' => 'words']
        );
        $this->assertEquals(
            sprintf(
                $this->expectedFormat,
                Carbon::getTestNow()->format($this->expectedTimeFormat),
                'ALERT',
                'Test without some words. And {nothing}!'
            ),
            StreamFilter::$output
        );
    }

    public function testLogCritical() {
        stream_filter_prepend(STDERR, 'catcher');
        $this->logger->critical(
            'Test {with} some {params}. And {nothing}!',
            [ 'with' => 'without', 'params' => 'words']
        );
        $this->assertEquals(
            sprintf(
                $this->expectedFormat,
                Carbon::getTestNow()->format($this->expectedTimeFormat),
                'CRITICAL',
                'Test without some words. And {nothing}!'
            ),
            StreamFilter::$output
        );
    }

    public function testLogError() {
        stream_filter_prepend(STDERR, 'catcher');
        $this->logger->error(
            'Test {with} some {params}. And {nothing}!',
            [ 'with' => 'without', 'params' => 'words']
        );
        $this->assertEquals(
            sprintf(
                $this->expectedFormat,
                Carbon::getTestNow()->format($this->expectedTimeFormat),
                'ERROR',
                'Test without some words. And {nothing}!'
            ),
            StreamFilter::$output
        );
    }

    public function testLogWarning() {
        stream_filter_prepend(STDOUT, 'catcher');
        $this->logger->warning(
            'Test {with} some {params}. And {nothing}!',
            [ 'with' => 'without', 'params' => 'words']
        );
        $this->assertEquals(
            sprintf(
                $this->expectedFormat,
                Carbon::getTestNow()->format($this->expectedTimeFormat),
                'WARNING',
                'Test without some words. And {nothing}!'
            ),
            StreamFilter::$output
        );
    }

    public function testLogNotice() {
        stream_filter_prepend(STDOUT, 'catcher');
        $this->logger->notice(
            'Test {with} some {params}. And {nothing}!',
            [ 'with' => 'without', 'params' => 'words']
        );
        $this->assertEquals(
            sprintf(
                $this->expectedFormat,
                Carbon::getTestNow()->format($this->expectedTimeFormat),
                'NOTICE',
                'Test without some words. And {nothing}!'
            ),
            StreamFilter::$output
        );
    }

    public function testLogInfo() {
        stream_filter_prepend(STDOUT, 'catcher');
        $this->logger->info(
            'Test {with} some {params}. And {nothing}!',
            [ 'with' => 'without', 'params' => 'words']
        );
        $this->assertEquals(
            sprintf(
                $this->expectedFormat,
                Carbon::getTestNow()->format($this->expectedTimeFormat),
                'INFO',
                'Test without some words. And {nothing}!'
            ),
            StreamFilter::$output
        );
    }

    public function testLogDebug() {
        stream_filter_prepend(STDOUT, 'catcher');
        $this->logger->debug(
            'Test {with} some {params}. And {nothing}!',
            [ 'with' => 'without', 'params' => 'words']
        );
        $this->assertEquals(
            sprintf(
                $this->expectedFormat,
                Carbon::getTestNow()->format($this->expectedTimeFormat),
                'DEBUG',
                'Test without some words. And {nothing}!'
            ),
            StreamFilter::$output
        );
    }

    public function testLog() {

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
