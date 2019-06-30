<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  DatabaseLogger.php - Part of the php-logger project.

  © - Jitesoft 2017
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Log;

use Carbon\Carbon;
use Jitesoft\Log\Traits\LoggerPassThroughTrait;
use Jitesoft\Log\Traits\LogLevelTrait;
use Jitesoft\Log\Traits\TextFormatterTrait;
use PDO;
use Psr\Log\LoggerInterface;

/**
 * A logger which outputs messages into a PDO instance using prepared statements.
 *
 * If the logger is used without changing the static $insert sql insert string to create logs, a table is required.
 * The table (or insert command if changed) should contain the following columns:
 * The default database table called is 'log_messages' but can be changed by changing the static $insert field.
 *
 * <pre>
 * level   - varchar(255)
 * message - text
 * time    - datetime
 * </pre>
 *
 * The insert call will use the following bound parameters:
 *
 * <pre>
 * level   - string
 * message - string
 * time    - string
 * </pre>
 */
class PDOLogger implements LoggerInterface {
    use TextFormatterTrait;
    use LoggerPassThroughTrait;
    use LogLevelTrait;

    // phpcs:ignore
    public static $insert = 'INSERT into log_messages (`level`, `message`, `time`) VALUES (:level, :message, :time)';

    protected $pdo;

    /**
     * PDOLogger constructor.
     *
     * @param PDO $databaseConnection PDO Connection.
     */
    public function __construct(PDO $databaseConnection) {
        $this->pdo = $databaseConnection;
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed  $level   Log level to use.
     * @param string $message Message to log.
     * @param array  $context Context data.
     *
     * @return void
     */
    // phpcs:ignore Squiz.Commenting.FunctionComment
    public function log($level, $message, array $context = array()) {
        if (!$this->shouldLog($level)) {
            return;
        }

        $message = $this->format($message, $context);
        $time    = Carbon::now()->toIso8601String();

        $this->pdo->prepare(self::$insert)->execute([
            ':level'   => $level,
            ':message' => $message,
            ':time'    => $time
        ]);
    }

}
