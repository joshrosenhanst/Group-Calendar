<?php

namespace App\Facades;

use App\Services\FileHelperService;
use Illuminate\Support\Facades\Facade;

/**
 * @see \App\Services\FileHelperService
 */
class FileHelper extends Facade {
  protected static function getFacadeAccessor() {
    return FileHelperService::class;
  }
}
