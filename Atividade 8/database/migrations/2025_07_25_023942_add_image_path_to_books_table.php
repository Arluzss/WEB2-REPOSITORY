<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    Schema::table('books', function (Blueprint $table) {
        $table->string('image')->nullable()->after('published_year');
    });
}

public function down(): void
{
    Schema::table('books', function (Blueprint $table) {
        $table->dropColumn('image');
    });
}
};
