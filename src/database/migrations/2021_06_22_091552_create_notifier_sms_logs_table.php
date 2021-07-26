<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotifierSmsLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifier_sms_logs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sms_template_id')->comment('realated:notifier_sms_templates, column: id');
            $table->bigInteger('user_id')->nullable()->comment('realated:users, column: id');
            $table->string('driver');
            $table->text('sms_text');
            $table->string('receiver')->nullable();
            $table->string('method')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('notifier_sms_logs');
    }
}
