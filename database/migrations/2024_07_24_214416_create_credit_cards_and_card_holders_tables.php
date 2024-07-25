<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('card_holders', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('payment_status');
            $table->string('description');
            $table->string('document');
            $table->timestamps();
        });

        Schema::create('credit_cards', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('card_number');
            $table->string('security_code');
            $table->string('expiration_date');
            $table->string('card_holder_id');
            $table->foreign('card_holder_id')->references('id')->on('card_holders')->onDelete('cascade');
            $table->timestamps();
        });

        // Insert initial data into card_holders table
        DB::table('card_holders')->insert([
            ['id' => 'CARD_cg1l9jkk0e22b8.35746198', 'payment_status' => 'APRO', 'description' => 'Pagamento aprovado', 'document' => '12345678909'],
            ['id' => 'CARD_cg1l9jkk0e22b8.35746199', 'payment_status' => 'OTHE', 'description' => 'Recusado por erro geral', 'document' => '12345678909'],
            ['id' => 'CARD_cg1l9jkk0e22b8.35746200', 'payment_status' => 'CONT', 'description' => 'Pagamento pendente', 'document' => ''],
            ['id' => 'CARD_cg1l9jkk0e22b8.35746201', 'payment_status' => 'CALL', 'description' => 'Recusado com validação para autorizar', 'document' => ''],
            ['id' => 'CARD_cg1l9jkk0e22b8.35746202', 'payment_status' => 'FUND', 'description' => 'Recusado por quantia insuficiente', 'document' => ''],
            ['id' => 'CARD_cg1l9jkk0e22b8.35746203', 'payment_status' => 'SECU', 'description' => 'Recusado por código de segurança inválido', 'document' => ''],
            ['id' => 'CARD_cg1l9jkk0e22b8.35746204', 'payment_status' => 'EXPI', 'description' => 'Recusado por problema com a data de vencimento', 'document' => ''],
            ['id' => 'CARD_cg1l9jkk0e22b8.35746205', 'payment_status' => 'FORM', 'description' => 'Recusado por erro no formulário', 'document' => ''],
        ]);

        // Insert initial data into credit_cards table
        DB::table('credit_cards')->insert([
            ['id' => 'CRED_cg1l9jkk0e22b8.35746198', 'card_number' => '5031433215406351', 'security_code' => '123', 'expiration_date' => '11/25', 'card_holder_id' => 'CARD_cg1l9jkk0e22b8.35746198'],
            ['id' => 'CRED_cg1l9jkk0e22b8.35746199', 'card_number' => '4235647728025682', 'security_code' => '123', 'expiration_date' => '11/25', 'card_holder_id' => 'CARD_cg1l9jkk0e22b8.35746198'],
            ['id' => 'CRED_cg1l9jkk0e22b8.35746200', 'card_number' => '375365153556885', 'security_code' => '1234', 'expiration_date' => '11/25', 'card_holder_id' => 'CARD_cg1l9jkk0e22b8.35746198'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('credit_cards');
        Schema::dropIfExists('card_holders');
    }
};
