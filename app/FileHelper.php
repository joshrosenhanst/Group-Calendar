<?php

namespace App;

use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\File;

class FileHelper {
  /*
    getImagesInDirectory($directory) - Return a JSON array of image files in a directory including their full path, filename (no path), and alt text.

    $directory - The directory to get files from. Must be a string folder name inside the storage/ directory. For example, 'default_avatars' will grab all images in the storage/default_avatars/ directory.
  */
  public function getImagesInDirectory($directory, $alt_prepend="Preview Image"){
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
    getRandomImageFromDirectory($source_directory, $destination_directory) - Grab a random file from the source_directory, copy it to the destintation_directory, and return the filename.

    $source_directory - The directory that the original file is in, inside the storage/app/public/ folder. Example: 'default_avatars' will look under `storage/default_avatars`.
    $destination_directory - The directory that the copied file will be placed in, using the `public` disk (i.e storage/). Example: 'avatars' will place the file under `storage/avatars/`.
  */
  public function getRandomImageFromDirectory($source_directory, $destination_directory){
    $fs = new Filesystem();

    $files = Storage::disk('public')->files($source_directory);
    $file = array_rand($files);
    $filename = $fs->basename($files[$file]);

    $this->copyDefaultImage($filename, $source_directory, $destination_directory);

    return $filename;
  }

   /*
    copyDefaultImage($filename, $source_directory, $destination_directory) - If the destination file doesn't already exist, copy the file from the source folder and put it in the destination folder with the same filename.

    $filename - The filename (no path) of the default image to be copied.
    $source_directory - The directory that the default image exists in inside the storage/ directory. Example: 'default_avatars' will look under `storage/default_avatars`.
    $destination_directory - The directory that the copied file will be placed in, using the `public` disk (i.e storage/). Example: 'avatars' will place the file under `storage/avatars/`.
  */
  public function copyDefaultImage($filename, $source_directory, $destination_directory){
    $source_exists = Storage::disk('public')->exists($source_directory.'/'.$filename);
    $destination_exists = Storage::disk('public')->exists($destination_directory.'/'.$filename);

    if($source_exists && !$destination_exists){
      $filepath = storage_path('app/public/'.$source_directory.'/'.$filename);
      //$file = new File('storage/app/public/'.$source_directory.'/'.$filename);
      $file = new File($filepath);
      Storage::disk('public')->putFileAs($destination_directory, $file, $filename);
    }
  }
}