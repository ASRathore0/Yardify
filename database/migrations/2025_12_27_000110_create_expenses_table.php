<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained('expense_groups')->onDelete('cascade');
            $table->unsignedBigInteger('payer_id')->nullable();
            $table->string('payer_name')->nullable();
            $table->decimal('amount', 12, 2);
            $table->string('currency', 10)->nullable();
            $table->string('split_method')->default('equal');
            $table->json('splits')->nullable();
            $table->string('category')->nullable();
            $table->text('note')->nullable();
            $table->timestamp('spent_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expenses');
    }
}
