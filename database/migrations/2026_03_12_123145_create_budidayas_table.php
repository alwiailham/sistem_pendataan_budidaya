<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('budidayas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rumah_id')->constrained()->onDelete('cascade');
            $table->foreignId('kategori_id')->constrained('kategoris')->onDelete('cascade');
            $table->string('nama_budidaya');
            $table->integer('jumlah');
            $table->string('satuan');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('budidayas');
    }
};