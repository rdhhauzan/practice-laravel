<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\Email;
use Illuminate\Support\Facades\DB;
use \PDF;


class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $to_email;
    public $bookId;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($to_email, $bookId)
    { 
        //
        $this->to_email = $to_email;
        $this->bookId = $bookId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $books = DB::table('books')
            ->join('genre', 'books.genreId', '=', 'genre.id')
            ->select('books.id AS bookId', 'books.name AS bookName', 'books.price', 'books.description', 'genre.name AS genreName', 'books.image')
            ->where('books.id', $this->bookId)
            ->get();

        $pdf = PDF::loadView('onePdf', compact('books'));

        $mail = new Email();
        Mail::to($this->to_email)->send($mail->attachData($pdf->output(), 'invoice.pdf'));
    }
}