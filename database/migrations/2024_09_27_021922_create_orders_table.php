<?php

use App\Models\Client;
use App\Models\PaymentMethod;
use App\Models\Seller;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Client::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Seller::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(PaymentMethod::class)->constrained()->cascadeOnDelete();
            $table->string('notes');
            $table->string('delivery_address');
//            $table->enum('payment_method', ['cash', 'online'])->default('cash');
            $table->enum('order_status', ['pending', 'accepted', 'refused', 'delivered', 'declined'])->default('pending');
            $table->integer('total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
