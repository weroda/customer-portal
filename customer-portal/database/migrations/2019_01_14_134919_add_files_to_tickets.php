<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFilesToTickets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
            Schema::table('tickets', function($table) {
                $table->string('attachment_1');
                $table->string('attachment_2');
                $table->string('attachment_3');
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tickets', function (Blueprint $table) {
            Schema::table('tickets', function($table) {
                $table->dropColumn('attachment_1');
                $table->dropColumn('attachment_2');
                $table->dropColumn('attachment_3');
            });
        });
    }
}
