<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSurat extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('surat', function(Blueprint $table)
		{
			$table->increments('surat_id');
			$table->string('kode_surat', 5)->unique();
			$table->string('keterangan', 50);
			$table->integer('jumlah_segmen');
			$table->string('format', 255);
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
		Schema::drop('surat');
	}

}
