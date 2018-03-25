<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  FileLoggerTest.php - Part of the php-logger project.

  © - Jitesoft 2017
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Log\Tests\Loggers;

use Carbon\Carbon;
use Jitesoft\Log\FileLogger;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use PHPUnit\Framework\TestCase;

class FileLoggerTest extends TestCase {

    /** @var vfsStreamDirectory */
    protected $fs;
    /** @var FileLogger */
    protected $logger;
    protected $expectedFormat     = "[%s] %s: %s";
    protected $expectedTimeFormat ='H:i:s.v';

    protected function setUp() {
        parent::setUp();

        $this->fs = vfsStream::setUp('rootDir');
        Carbon::setTestNow(Carbon::createFromTimestamp(1513976746099));
        $this->logger = new FileLogger($this->fs->url() . '/log.txt');
    }

    public function testLog() {
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
                'Test without some words. And {nothing}!' . PHP_EOL
            ),
            file_get_contents($this->fs->url() . '/log.txt')
        );
    }

}
