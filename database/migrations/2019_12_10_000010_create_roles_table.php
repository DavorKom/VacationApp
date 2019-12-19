<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Role;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('slug')->unique();
        });

        DB::table('roles')->insert([
            'name' => 'Admin',
            'slug' => Role::ADMIN,
        ]);

        DB::table('roles')->insert([
            'name' => 'Project Manager / Team Lead',
            'slug' => Role::APPROVER,
        ]);

        DB::table('roles')->insert([
            'name' => 'Zaposlenik',
            'slug' => Role::EMPLOYEE,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
