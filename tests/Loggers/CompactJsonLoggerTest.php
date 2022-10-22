<?php
// phpcs:ignoreFile -- Test file
namespace Jitesoft\Log\Tests\Loggers;

use Carbon\Carbon;
use Jitesoft\Log\CompactJsonLogger;
use Jitesoft\Log\Tests\StreamFilter;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class CompactJsonLoggerTest extends TestCase {
    protected LoggerInterface $logger;
    protected string $expectedFormat     = '{"@t":"%s","@l":6,"@m":"%s","@mt":"%s","@r":%s}';

    protected function setUp(): void {
        parent::setUp();

        stream_filter_register('catcher', StreamFilter::class);
        Carbon::setTestNow(Carbon::createFromTimestamp(1513976746));
        $this->logger = new CompactJsonLogger();
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
                Carbon::getTestNow()->toIso8601String(),
                'Test without some words. And {nothing}!',
                'Test {with} some {params}. And {nothing}!',
                json_encode([ 'with' => 'without', 'params' => 'words'])
            ),
            StreamFilter::$output
        );
    }

}
