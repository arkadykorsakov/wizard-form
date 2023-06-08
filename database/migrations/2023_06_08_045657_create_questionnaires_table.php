<?php

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
		Schema::create('questionnaires', function (Blueprint $table) {
			$table->id();
			$table->string('surname');
			$table->string('name');
			$table->string('patronymic');
			$table->date('date_birth');
			$table->string('gender');
			$table->string('tel');
			$table->string('city')->nullable();
			$table->string('email');
			$table->string('star');
			$table->json('options');
			$table->text('comment')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('questionnaires');
	}
};
