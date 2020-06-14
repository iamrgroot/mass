<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class DatabaseTest extends TestCase
{
    use DatabaseTransactions;

    public function testDatabaseConnections(): void
    {
        /** @var Illuminate\Database\Connection $connection */
        $connection = DB::connection('mysql');
        $this->assertEquals('mass', $connection->getDatabaseName());

        $connection = DB::connection('sonarr_sqlite');

        dd($connection->getDatabaseName());
        $this->assertEquals('mass', $connection->getDatabaseName());
    }

    public function testDatabaseTables(): void
    {
        /** @var Illuminate\Database\Connection $connection */
        $connection = DB::connection();
        $database_name = $connection->getDatabaseName();

        $tables = $connection->select('SHOW TABLES');

        $tables = array_map(fn($table) => $table->{"Tables_in_{$database_name}"}, $tables);
        $tables = array_unique($tables);

        $this->assertEquals(
            [
                'failed_jobs',
                'migrations',
                'password_resets',
                'users',
            ], 
            $tables
        );
    }
}
