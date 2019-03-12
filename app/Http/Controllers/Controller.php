<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  /*
    getImagesInDirectory($directory) - Return a JSON array of image files in a directory including their full path, filename (no path), and alt text.

    $directory - The directory to get files from. Must be a string folder name inside the storage/ directory. For example, 'default_avatars' will grab all images in the storage/default_avatars/ directory.
  */
  protected function getImagesInDirectory($directory, $alt_prepend="Preview Image"){
    $fs = new Filesystem();

    $images = collect();
    $files = Storage::disk('public')->files($directory);
    for( $i=0; $i<count($files); $i++ ){
      $images->push([
        'src' => asset("storage/".$files[$i]),
        'alt' => $alt_prepend.' '.($i+1),
        'filename' => $fs->basename($files[$i])
      ]);
    }
    return $images->toJson();
  }

  /*
    copyDefaultImage($filename, $source_directory, $destination_directory) - If the destination file doesn't already exist, copy the file from the source folder and put it in the destination folder with the same filename.

    $filename - The filename (no path) of the default image to be copied.
    $source_directory - The directory that the default image exists in inside the storage/ directory. Example: 'default_avatars' will look under `storage/default_avatars`.
    $destination_directory - The directory that the copied file will be placed in, using the `public` disk (i.e storage/). Example: 'avatars' will place the file under `storage/avatars/`.
  */
  protected function copyDefaultImage($filename, $source_directory, $destination_directory){
    $exists = Storage::disk('public')->exists($destination_directory.'/'.$filename);

    if(!$exists){

      Storage::disk('public')->putFileAs(
        $destination_directory,
        new File('storage/'.$source_directory.'/'.$filename), 
        $filename
      );

    }
  }
}
