<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * The SMTP password is now stored encrypted, which needs more than 100 characters.
     */
    public function up(): void
    {
        DB::statement('ALTER TABLE `generals` MODIFY `mail_password` TEXT NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE `generals` MODIFY `mail_password` VARCHAR(100) NULL');
    }
};
