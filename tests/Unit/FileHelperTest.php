<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\FileHelper;

class FileHelperTest extends TestCase
{
    /*
        testGetImagesInDirectory() - Test if the getImagesInDirectory() function will properly return a collection if given a real directory.
        Check that each item in the collection has a filename that exists and a valid src + alt property.
    */
    public function testGetImagesInDirectory(){
        $filehelper = new Filehelper;

        $directory = 'avatars';
        $images = $filehelper->getImagesInDirectory($directory);
        $image_count = count(Storage::disk('public')->files($directory));

        $this->assertIsObject($images);
        $this->assertNotEmpty($images);
        $this->assertCount($image_count, $images);

        foreach($images as $image){
            Storage::disk('public')->assertExists($directory."/".$image["filename"]);
            $this->assertIsString($image["alt"]);
            $this->assertIsString($image["src"]);
        }
    }

    /*
        testGetImagesInInvalidDirectory() - Test if the getImagesInDirectory() method will return an empty collection if given an invalid directory.
    */
    public function testGetImagesInInvalidDirectory(){
        $filehelper = new Filehelper;

        $directory = 'fake_invalid_directory';
        $images = $filehelper->getImagesInDirectory($directory);
        
        $this->assertEmpty($images);
        $this->assertCount(0, $images);
    }

    /*
        testGetRandomImageFromDirectory() - Test if the getRandomImageFromDirectory() will take a random file from the source_directory, copy it to the destination_directory, and return the filename.
        The returned filename should exist in both the source and destination directories.
    */
    public function testGetRandomImageFromDirectory(){
        $filehelper = new Filehelper;

        $source_directory = "default_avatars";
        $destination_directory = "avatars";

        $filename = $filehelper->getRandomImageFromDirectory($source_directory, $destination_directory);

        $this->assertIsString($filename);
        Storage::disk('public')->assertExists($source_directory."/".$filename);
        Storage::disk('public')->assertExists($destination_directory."/".$filename);
    }

    /*
        testGetRandomImageFromInvalidDirectory() - Test if the getRandomImageFromDirectory() method will return null if given invalid directories.
    */
    public function testGetRandomImageFromInvalidDirectory(){
        $filehelper = new Filehelper;

        // test 1: invalid source directory
        $filename = $filehelper->getRandomImageFromDirectory("invalid_source_directory", "avatars");
        $this->assertNull($filename);

        // test 2: invalid destination directory
        $filename = $filehelper->getRandomImageFromDirectory("default_avatars", "invalid_destination_directory");
        $this->assertNull($filename);
        
        // test 3: both invalid directories
        $filename = $filehelper->getRandomImageFromDirectory("invalid_source_directory", "invalid_destination_directory");
        $this->assertNull($filename);
    }

    /*
        testCopyDefaultImage() - Test if the copyDefaultImage() method will properly create the file in the destination directory given proper directories.
        The returned filename should exist in both the source and destination directories.
    */
    public function testCopyDefaultImage(){
        $filehelper = new Filehelper;

        $source_directory = "default_avatars";
        $destination_directory = "avatars";
        $filename = "chihuahua-dog-puppy-cute-39317.jpg";
        Storage::disk('public')->assertExists($source_directory."/".$filename);

        $returned_filename = $filehelper->copyDefaultImage($filename, $source_directory, $destination_directory);

        $this->assertIsString($filename);
        Storage::disk('public')->assertExists($source_directory."/".$returned_filename);
        Storage::disk('public')->assertExists($destination_directory."/".$returned_filename);
    }

    /*
        testCopyDefaultImageInvalidFile() - copyDefaultImage() should skip copying the file over since it doesnt exist. Check that the file doesn't exist in the destination directory.
    */
    public function testCopyDefaultImageInvalidFile(){
        $filehelper = new Filehelper;

        $source_directory = "default_avatars";
        $destination_directory = "avatars";
        $filename = "invalid_file_1234.jpg";
        Storage::disk('public')->assertMissing($source_directory."/".$filename);
        Storage::disk('public')->assertMissing($destination_directory."/".$filename);

        $returned_filename = $filehelper->copyDefaultImage($filename, $source_directory, $destination_directory);

        Storage::disk('public')->assertMissing($source_directory."/".$returned_filename);
        Storage::disk('public')->assertMissing($destination_directory."/".$returned_filename);
    }
}
