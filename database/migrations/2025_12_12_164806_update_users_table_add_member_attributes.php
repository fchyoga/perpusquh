<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nim')->nullable()->after('email');
            $table->string('prodi')->nullable()->after('nim');
            $table->string('jurusan')->nullable()->after('prodi');
            $table->string('semester')->nullable()->after('jurusan');
            $table->dropColumn(['nisn', 'class']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nim', 'prodi', 'jurusan', 'semester']);
            $table->string('nisn')->nullable();
            $table->string('class')->nullable();
        });
    }
};
