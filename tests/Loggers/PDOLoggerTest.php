<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  PDOLoggerTest.php - Part of the Jitesoft\Log\Tests\.Loggers project.

  © - Jitesoft 2018
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Log\Tests\Loggers;

use Carbon\Carbon;
use Jitesoft\Log\PDOLogger;
use PDO;
use PHPUnit\Framework\TestCase;

/**
 * PDOLoggerTest
 * @author Johannes Tegnér <johannes@jitesoft.com>
 * @version 1.0.0
 */
class PDOLoggerTest extends TestCase {

    /** @var PDOLogger */
    protected $logger;
    /** @var PDO */
    protected $db;

    protected function setUp() {
        parent::setUp();
        Carbon::setTestNow(Carbon::createFromTimestamp(1513976746099));
        $this->db = new PDO('sqlite::memory:');
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->db->query('CREATE TABLE IF NOT EXISTS log_messages (`level` int, `message` TEXT, `time` TIME )')->execute();
        $this->logger = new PDOLogger($this->db);

    }

    public function testLog() {
        $this->logger->log(
            'TestLevel',
            'Test {with} some {params}. And {nothing}!',
            [ 'with' => 'without', 'params' => 'words']
        );

        $out = $this->db->query('SELECT * FROM log_messages LIMIT 1');
        $out->execute();
        $out = $out->fetch(PDO::FETCH_ASSOC);

        $this->assertEquals('TestLevel', $out['level']);
        $this->assertEquals('Test without some words. And {nothing}!', $out['message']);
        $this->assertEquals(Carbon::now(), Carbon::parse($out['time']));
    }

}