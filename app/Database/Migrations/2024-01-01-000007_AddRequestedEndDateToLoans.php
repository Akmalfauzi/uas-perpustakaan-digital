<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRequestedEndDateToLoans extends Migration
{
    public function up()
    {
        $this->forge->addColumn('loans', [
            'requested_end_date' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'requested_start_date'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('loans', 'requested_end_date');
    }
} 