<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('programmes', function (Blueprint $table) {
        $table->boolean('programme_valide')->default(0); // 0 = non validé, 1 = validé
    });
}

public function down()
{
    Schema::table('programmes', function (Blueprint $table) {
        $table->dropColumn('programme_valide');
    });
}
};
