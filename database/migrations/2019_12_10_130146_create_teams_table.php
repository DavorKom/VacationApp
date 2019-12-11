<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('project_manager_id')->unsigned()->nullable();
            $table->bigInteger('team_lead_id')->unsigned()->nullable();
            $table->string('name');
            $table->timestamps();

            $table->foreign('project_manager_id')->references('id')->on('users');
            $table->foreign('team_lead_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teams');
    }
}
