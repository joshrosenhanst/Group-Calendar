<?php

namespace App\Jobs;

use PDF;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GenerateEventFlyer implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
  protected $event;
  public $tries = 5;
  public $deleteWhenMissingModels = true;

  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct(\App\Event $event)
  {
    $this->event = $event;
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    $pdf_filename = $this->generate_flyer_pdf($this->event);
    if($pdf_filename && Storage::disk('public')->exists('flyers/'.$pdf_filename)){
      $this->event->timestamps = false;
      $this->event->flyer_url = $pdf_filename;
      $this->event->save();
    }
  }

  private function generate_flyer_pdf($event){
    if($event){
      $pdf = PDF::loadView('events.flyer', [
        'event' => $event
      ]);
      $token = (string) Str::uuid();
      $filename = $token.'.pdf';
      $pdf->save(storage_path('app/public/flyers/'.$filename));
    
      return $filename;
    }else{
      return null;
    }
  }
}
