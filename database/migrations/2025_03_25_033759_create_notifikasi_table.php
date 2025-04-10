<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Mahasiswa; // Import Mahasiswa model
use App\Models\Perwalian; // Import Perwalian model
use App\Models\RequestKonseling; // Import RequestKonseling model

class CreateNotifikasiTable extends Migration
{
    public function up()
    {
        Schema::create('notifikasi2', function (Blueprint $table) {
            // Auto-incrementing primary key dengan nama kolom 'ID_Notifikasi'
            $table->id('ID_Notifikasi');

            // Kolom untuk menyimpan pesan notifikasi
            $table->text('Pesan');

            // Kolom is_read untuk status notifikasi, default false (belum dibaca)
            $table->boolean('is_read')->default(false);

            // Kolom untuk menyimpan NIM mahasiswa (string) dan akan digunakan sebagai foreign key
            $table->string('NIM')->nullable();

            // Kolom foreign key untuk Perwalian (opsional), jika terkait dengan perwalian tertentu
            $table->foreignIdFor(Perwalian::class, 'Id_Perwalian')->nullable();

            // Kolom foreign key untuk Request Konseling (opsional), jika terkait dengan perwalian Ajukan Konseling tertentu
            $table->foreignIdFor(RequestKonseling::class, 'Id_Konseling')->nullable();

            // Timestamps (created_at dan updated_at)
            $table->timestamps();

            // Definisikan foreign key constraint untuk kolom NIM
            $table->foreign('NIM')
                ->references('nim')
                ->on('mahasiswa')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifikasi');
    }
}
