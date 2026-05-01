<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('subscribed_to_product_alerts')->default(false)->after('remember_token');
            $table->json('preferred_product_categories')->nullable()->after('subscribed_to_product_alerts');
            $table->string('preferred_language', 5)->default('en')->after('preferred_product_categories');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['subscribed_to_product_alerts', 'preferred_product_categories', 'preferred_language']);
        });
    }
};
