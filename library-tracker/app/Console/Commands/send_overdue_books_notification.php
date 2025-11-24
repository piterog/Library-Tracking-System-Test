<?php

namespace App\Console\Commands;

use App\Mail\GenericMail;
use App\Models\Loan;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class send_overdue_books_notification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send_overdue_books_notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an email reminder to each user with overdue books ';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Query all loans where returned_at is NULL and due_at is past
        $loans = Loan::with('book', 'user')
            ->whereNull('returned_at')
            ->whereDate('due_at', '<', now())
            ->get();

        $loans->chunk(10)->each(function ($chunk) {
            foreach ($chunk as $loan) {
                Mail::to($loan->user->email)
                    ->send(
                        mailable: new GenericMail(
                            'Overdue book',
                            $loan->user->name,
                            'The book ' . $loan->book->title . 'is overdue'
                        )
                    );
            }
        });
    }
}
