<?php
declare(strict_types=1);
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  DatabaseLogger.php - Part of the php-logger project.

  © - Jitesoft 2021
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Log;

use Carbon\Carbon;
use Jitesoft\Log\Traits\LogLevelTrait;
use Jitesoft\Log\Traits\TextFormatterTrait;
use PDO;
use Psr\Log\AbstractLogger;
use Psr\Log\LogLevel;

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
 * @since 1.1.0
 */
class PDOLogger extends AbstractLogger {
    use TextFormatterTrait, LogLevelTrait;

    // phpcs:ignore
    public const INSERT_STATEMENT = 'INSERT INTO log_messages (`level`, `message`, `time`) VALUES (:level, :message, :time)';

    protected PDO $pdo;

    /**
     * PDOLogger constructor.
     *
     * @param PDO $databaseConnection PDO Connection.
     */
    public function __construct(PDO $databaseConnection) {
        $this->pdo = $databaseConnection;
    }

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
