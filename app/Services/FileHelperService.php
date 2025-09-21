<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\File;
use Illuminate\Support\Collection;

class FileHelperService {
  /*
    getImagesInDirectory($directory) - Return a collection of image files in a directory including their full path, filename (no path), and alt text.

    $directory - The directory to get files from. Must be a string folder name inside the storage/ directory. For example, 'default_avatars' will grab all images in the storage/default_avatars/ directory.
  */
  public static function getImagesInDirectory(string $directory, string $alt_prepend="Preview Image"): Collection
  {
    $fs = new Filesystem();

    $images = collect([]);
    $files = Storage::disk('public')->files($directory);

    for( $i=0; $i<count($files); $i++ ){
      $images->push([
        'src' => asset("storage/".$files[$i]),
        'alt' => $alt_prepend.' '.($i+1),
        'filename' => $fs->basename($files[$i])
      ]);
    }
    
    return $images;
  }

  /*
    getRandomImageFromDirectory($source_directory, $destination_directory) - Grab a random file from the source_directory, copy it to the destintation_directory, and return the filename. Returns null if source directory or the destination directory doesnt exist.

    $source_directory - The directory that the original file is in, inside the storage/app/public/ folder. Example: 'default_avatars' will look under `storage/default_avatars`.
    $destination_directory - The directory that the copied file will be placed in, using the `public` disk (i.e storage/). Example: 'avatars' will place the file under `storage/avatars/`.
  */
  public static function getRandomImageFromDirectory(string $source_directory, string $destination_directory): ?string
  {
    $fs = new Filesystem();
    
    if(
      Storage::disk('public')->exists($source_directory) && Storage::disk('public')->exists($destination_directory)
    ){
      $files = Storage::disk('public')->files($source_directory);
      $file = array_rand($files);
      $filename = $fs->basename($files[$file]);
  
      return self::copyDefaultImage(
        $filename, 
        $source_directory, 
        $destination_directory
      );
    }
    
    return null;
  }

   /*
    copyDefaultImage($filename, $source_directory, $destination_directory) - If the destination file doesn't already exist, copy the file from the source folder and put it in the destination folder with the same filename.

    $filename - The filename (no path) of the default image to be copied.
    $source_directory - The directory that the default image exists in inside the storage/ directory. Example: 'default_avatars' will look under `storage/default_avatars`.
    $destination_directory - The directory that the copied file will be placed in, using the `public` disk (i.e storage/). Example: 'avatars' will place the file under `storage/avatars/`.
  */
  public static function copyDefaultImage(string $filename, string $source_directory, string $destination_directory): string
  {
    $source_file = $source_directory.'/'.$filename;
    $destination_file = $destination_directory.'/'.$filename;

    if(
      Storage::disk('public')->exists($source_file) &&
      ! Storage::disk('public')->exists($destination_file)
    ){
      Storage::disk('public')->copy(
        $source_file, 
        $destination_file
      );
    }

    return $filename;
  }
}