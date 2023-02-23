<?php
namespace Henrotaym\LaravelBelgianProvinceFinder\Tests\Database\Migrations;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->json('address');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('clients');
    }
}