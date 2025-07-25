<?php
// database/migrations/xxxx_xx_xx_create_tenants_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // e.g., recruitment, accounting, etc.
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};