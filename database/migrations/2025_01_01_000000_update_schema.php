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
        // Update Users Table
        Schema::table('users', function (Blueprint $table) {
            $table->string('nisn')->nullable()->after('email');
            $table->string('class')->nullable()->after('nisn');
            $table->string('phone')->nullable()->after('class');
            $table->string('username')->nullable()->after('name'); // Admin requirement
        });

        // Update Books Table
        Schema::table('books', function (Blueprint $table) {
            $table->string('file_path')->nullable()->after('cover_image');
        });

        // Update Loans Table
        Schema::table('loans', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
            $table->dropIndex(['student_id']);
            $table->renameColumn('student_id', 'user_id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index('user_id');
        });

        // Update Loans Items Table
        Schema::table('loans_items', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
            $table->dropIndex(['student_id']);
            $table->renameColumn('student_id', 'user_id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index('user_id');
        });

        // Drop Students Table as it's merged into Users
        Schema::dropIfExists('students');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Recreate Students Table
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nisn');
            $table->string('class');
            $table->timestamps();
        });

        // Revert Loans Table
        Schema::table('loans', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropIndex(['user_id']);
            $table->renameColumn('user_id', 'student_id');

            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->index('student_id');
        });

        // Revert Books Table
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn('file_path');
        });

        // Revert Users Table
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nisn', 'class', 'phone', 'username']);
        });
    }
};
