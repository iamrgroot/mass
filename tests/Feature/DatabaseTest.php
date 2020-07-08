<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class DatabaseTest extends TestCase
{
    use DatabaseTransactions;

    public function testDatabaseConnections(): void
    {
        /** @var Illuminate\Database\Connection $connection */
        $connection = DB::connection('mysql');
        $this->assertEquals('mass', $connection->getDatabaseName());

        /** @var Illuminate\Database\Connection $connection */
        $connection = DB::connection('sonarr_sqlite');
        $this->assertEquals('/var/www/docker-compose/sonarr/config/nzbdrone.db', $connection->getDatabaseName());

        /** @var Illuminate\Database\Connection $connection */
        $connection = DB::connection('radarr_sqlite');
        $this->assertEquals('/var/www/docker-compose/radarr/config/nzbdrone.db', $connection->getDatabaseName());
    }

    public function testDatabaseTables(): void
    {
        /** @var Illuminate\Database\Connection $connection */
        $connection    = DB::connection();
        $database_name = $connection->getDatabaseName();

        $tables = $connection->select('SHOW TABLES');

        $tables = array_map(fn ($table) => $table->{"Tables_in_{$database_name}"}, $tables);
        $tables = array_unique($tables);

        $this->assertEquals(
            [
                'failed_jobs',
                'migrations',
                'users',
            ],
            $tables
        );
    }
}
