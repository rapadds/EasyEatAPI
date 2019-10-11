<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_providers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nom', 150);
            $table->string('prenom', 150);
            $table->string('sexe', 10);
            $table->date('dateNaissance');
            $table->string('adresse', 200);
            $table->string('email', 200);
            $table->text('telephone');
            $table->text('coordonneBancaireInJson');
            $table->timestamps();
        });

        Schema::table('service_providers', function (Blueprint $table) {
            $table->unsignedBigInteger('authClientId');

            $table->foreign('authClientId')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_providers');
    }
}
