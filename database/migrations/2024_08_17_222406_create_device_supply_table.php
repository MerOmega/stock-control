<?php

use App\Models\Device;
use App\Models\Supply;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('device_supply', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Supply::class)->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(Device::class)->nullable()->constrained()->nullOnDelete();
            $table->integer('quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_supply');
    }
};
