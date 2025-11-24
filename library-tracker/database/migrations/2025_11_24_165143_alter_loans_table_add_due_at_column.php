<?php

use App\Models\Loan;
use Carbon\Carbon;
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
        Schema::table('loans', function(Blueprint $table) {
            $table->timestamp('due_at')
                ->default(Carbon::now()->addDays(14));
        });

        $loans = Loan::all();

        foreach ($loans as $loan) { // improve to chunks
            $loan->due_at = $loan->loaned_at->addDays(14);
            $loan->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loans', function(Blueprint $table) {
            $table->dropColumn('due_at');
        });
    }
};
