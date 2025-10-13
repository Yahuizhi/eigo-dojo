<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class DatabaseMigrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function stored_questions_table_has_expected_columns()
    {
        // Assertions
        $this->assertTrue(Schema::hasTable('stored_questions'));

        $this->assertTrue(Schema::hasColumns('stored_questions', [
            'id',
            'Q',
            'A',
            'created_at',
            'updated_at',
        ]));
    }
}