<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string("mobile")->after('email');
            $table->string("address")->after('mobile');
            $table->string("city")->after('address');
            $table->string("state")->after('city');
            $table->bigInteger("country_id")->unsigned()->nullable()->after('state');
            $table->string("postcode")->after('country_id');
            $table->tinyInteger('status')->after('password')->default('0');

            $table->foreign('country_id')->references('id')->on('countries')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('mobile');
            $table->dropColumn('address');
            $table->dropColumn('city');
            $table->dropColumn('state');
            $table->dropColumn('country_id');
            $table->dropColumn('postcode');
            $table->dropColumn('status');
        });
    }
};
