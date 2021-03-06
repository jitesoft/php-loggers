<?php
declare(strict_types=1);
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  DatabaseLogger.php - Part of the php-logger project.

  © - Jitesoft 2020
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Log;

use Carbon\Carbon;
use Jitesoft\Log\Traits\LogLevelTrait;
use Jitesoft\Log\Traits\TextFormatterTrait;
use PDO;
use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;

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
    use TextFormatterTrait, LoggerTrait, LogLevelTrait;

    // phpcs:ignore
    public const INSERT_STATEMENT = 'INSERT into log_messages (`level`, `message`, `time`) VALUES (:level, :message, :time)';

    protected PDO $pdo;

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
    protected function innerLog(string $level,
                                string $message,
                                array $context = array()): void {
        $message = $this->format($message, $context);
        $time    = Carbon::now()->toIso8601String();

        $this->pdo->prepare(self::INSERT_STATEMENT)->execute(
            [
                ':level'   => $level,
                ':message' => $message,
                ':time'    => $time
            ]
        );
    }

}
