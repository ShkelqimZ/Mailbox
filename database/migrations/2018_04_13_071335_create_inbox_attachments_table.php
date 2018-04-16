<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInboxAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inbox_attachments', function (Blueprint $table) {
            $table->increments('inbox_attachment_id');
            $table->unsignedInteger('inbox_id');
            $table->string('title');
            $table->string('path');
            $table->timestamps();

            $table->foreign('inbox_id')->references('inbox_id')->on('inboxes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inbox_attachments');
    }
}
