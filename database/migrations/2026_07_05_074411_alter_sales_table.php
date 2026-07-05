<?php

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
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn(['customer_name']);
            $table->foreignId('customer_id')->after('sale_no')->nullable()->constrained()->nullOnDelete();
            $table->enum('status', [
                'draft',
                'confirmed',
                'delivered',
                'cancelled',
            ])->default('draft');

            $table->decimal('discount', 12, 2)->after('total_amount')->default(0);

            $table->decimal('tax', 12, 2)->after('discount')->default(0);

            $table->decimal('grand_total', 12, 2)->after('tax')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->string('customer_name')->nullable();
            $table->dropForeign(['customer_id']);
            $table->dropColumn(['customer_id', 'status', 'discount', 'tax', 'grand_total']);
        });
    }
};
