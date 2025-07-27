<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRequestedStartDateToLoans extends Migration
{
    public function up()
    {
        $this->forge->addColumn('loans', [
            'requested_start_date' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'notes'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('loans', 'requested_start_date');
    }
} 