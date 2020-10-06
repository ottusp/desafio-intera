<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcessosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('processos', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('empresa_id');
            $table->unsignedInteger('squad_id');

            $table->string('nome_da_vaga');
            $table->string('nome_da_empresa');

            $table->boolean('is_ativo');
            $table->boolean('tem_meta');

            $table->unsignedInteger('inscricoes')->nullable();
            $table->unsignedInteger('entrevistas')->nullable();
            $table->unsignedInteger('aprovados')->nullable();

            $table->dateTime('data_de_entrega')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('processos');
    }
}
