<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('plan_id')->constrained()->cascadeOnDelete();
            $table->string('status')->default('有效');
            $table->date('next_billing_date')->nullable();
            $table->decimal('used_upload_gb', 10, 2)->default(0);
            $table->decimal('used_download_gb', 10, 2)->default(0);
            $table->text('clash_url')->nullable();
            $table->text('shadowrocket_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
