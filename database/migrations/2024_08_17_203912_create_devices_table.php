<?php

use App\Models\Brand;
use App\Models\Device;
use App\Models\Sector;
use App\Models\Supply;
use App\State;
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
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('sku');
            $table->dateTime('entry_year');
            $table->enum('state', array_column(State::cases(), 'value'));
            $table->foreignIdFor(Sector::class)->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(Brand::class)->nullable()->constrained()->nullOnDelete();
            $table->morphs('deviceable');
            $table->timestamps();
        });

        Schema::create('pcs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        Schema::create('printers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        Schema::create('monitors', function (Blueprint $table) {
            $table->id();
            $table->boolean('has_vga')->default(false);
            $table->boolean('has_dp')->default(false);
            $table->boolean('has_hdmi')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitors');
        Schema::dropIfExists('printers');
        Schema::dropIfExists('pcs');
        Schema::dropIfExists('devices');
    }
};
