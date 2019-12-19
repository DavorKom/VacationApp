<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Carbon;
use App\Models\Role;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('role_id')->unsigned();
            $table->unsignedBigInteger('team_id')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->date('contract_date');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('team_id')->references('id')->on('teams')->onDelete('set null');
        });

        DB::table('users')->insert([
            'role_id' => Role::where('slug', Role::ADMIN)->first()->id,
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'contract_date' => Carbon::parse(now())->format('Y-m-d'),
            'email' => 'test@gmail.com',
            'password' => bcrypt('test1234'),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
