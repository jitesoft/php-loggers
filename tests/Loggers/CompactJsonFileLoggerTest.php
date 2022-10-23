<?php
// phpcs:ignoreFile -- Test file
namespace Jitesoft\Log\Tests\Loggers;

use Carbon\Carbon;
use Jitesoft\Log\CompactJsonFileLogger;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use PHPUnit\Framework\TestCase;

class CompactJsonFileLoggerTest extends TestCase {
    protected vfsStreamDirectory $fs;
    protected CompactJsonFileLogger $logger;
    protected string $expectedFormat     = '{"@t":"%s","@l":"Information","@m":"%s","@mt":"%s","@r":%s,%s}';

    protected function setUp(): void {
        parent::setUp();

        $this->fs = vfsStream::setUp('rootDir');
        Carbon::setTestNow(Carbon::createFromTimestamp(1513976746));
        $this->logger = new CompactJsonFileLogger($this->fs->url() . '/log.clef');
    }

    public function testLog(): void {
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
                json_encode([ 'with' => 'without', 'params' => 'words']),
                '"_with":"without","_params":"words"'
            ) . PHP_EOL,
            file_get_contents($this->fs->url() . '/log.clef')
        );
    }

}
