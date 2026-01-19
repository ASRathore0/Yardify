<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftDeletesToExpenseGroupsTable extends Migration
{
    public function up()
    {
        Schema::table('expense_groups', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::table('expense_groups', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });
    }
}
