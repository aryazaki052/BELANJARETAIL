<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('purchase_orders', function (Blueprint $table) {
            // Menambahkan kolom distributor_id setelah store_id dan sifatnya boleh kosong (nullable)
            $table->foreignId('distributor_id')->nullable()->after('store_id')->constrained('distributors')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('purchase_orders', function (Blueprint $table) {
            // Menghapus foreign key dan kolom jika migrasi di-rollback
            $table->dropForeign(['distributor_id']);
            $table->dropColumn('distributor_id');
        });
    }
};