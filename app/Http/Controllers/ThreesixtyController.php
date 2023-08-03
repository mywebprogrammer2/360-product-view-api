<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use FFMpeg\FFMpeg;
use FFMpeg\Coordinate\TimeCode;
use Illuminate\Support\Facades\File;
use Symfony\Component\Finder\SplFileInfo;

class ThreesixtyController extends Controller
{
    public function convertMedia(Request $request)
    {
        
       
        $videoFile = $request->file('video');

        // Generate a unique folder name for the video based on the current timestamp and filename without extension
        $fileName = $videoFile->getClientOriginalName();
        $filenameWithoutExtension = pathinfo($fileName, PATHINFO_FILENAME);
        $folderName = time() . '.'  . $filenameWithoutExtension;

        // Move the uploaded video to the public/uploads folder with the desired folder name and the original filename (including extension)
        $destinationPath = 'uploads/' . $folderName . '/';
        $videoPath = $videoFile->move(public_path($destinationPath), $fileName);

        // Export frames from the video
       
        $ffmpeg = FFMpeg::create([
            'ffmpeg.binaries' => 'C:/usr/local/bin/ffmpeg.exe',
            'ffprobe.binaries' => 'C:/usr/local/bin/ffprobe.exe',
        ]);
        
        $video = $ffmpeg->open($videoPath);

        // Define the frame rate (number of frames per second) for the export
        $frameRate = 1; // Change this value according to your requirements (e.g., 1 frame per second)

        // Get the duration of the video
        $duration = $video->getStreams()->first()->get('duration');

        // Define the start time in seconds from which you want to generate frames (3 seconds in this case)
        $startTimeInSeconds = 2;
        $endTimeInSeconds = $duration - 2; // End time before the last 3 seconds of the video
        

        // Calculate the total number of frames to export
        // $totalFrames = ceil($duration * $frameRate);
        $totalFrames = ceil(($endTimeInSeconds - $startTimeInSeconds) * $frameRate);
        
        // Export frames one by one
        for ($i = 1; $i <= $totalFrames; $i++) {
            // Generate the filename for the frame
            $frameFilename = $i . '.jpg';

            // Calculate the time (in seconds) for the current frame
            $timeInSeconds = $startTimeInSeconds + (($i - 1) / $frameRate);

            // Export the frame at the specified time
            $video->frame(TimeCode::fromSeconds($timeInSeconds))
                ->save(public_path($destinationPath . $frameFilename));
        }

        unlink($videoPath);
        
        return response()->json(['message' => '360 View Generated Successfully!']);
    }

    public function getViews($basePath = 'uploads/') 
    {
        $result = array();

    // Ensure the base path ends with a trailing slash
    $basePath = public_path(rtrim($basePath, '/') . '/');

    if (!File::isDirectory($basePath)) {
        return $result;
    }

    $directories = File::directories($basePath);

    if (empty($directories)) {
        return $result;
    }

    $baseURL =  url()->to('/') . '/uploads/';

    $fakeId = 1;
    foreach ($directories as $directory) {
        $directoryName = basename($directory);
        $fileCount = count(File::files($directory));
        $images = array();

        // Get the names of all image files in the directory
        $files = File::files($directory);
        foreach ($files as $file) {
            $fileExtension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])) {
                $images[] = $baseURL . $directoryName . '/' . basename($file);
            }
        }

        $result[] = array(
            'id' => $fakeId,
            'folder_name' => $directoryName,
            'file_count' => $fileCount,
            'images' => $images,
        );
        $fakeId++;
    }

    return array_reverse($result);
        // $result = array();

        // // Ensure the base path ends with a trailing slash
        // $basePath = public_path(rtrim($basePath, '/') . '/');

        // if (!File::isDirectory($basePath)) {
        //     return $result;
        // }

        // $directories = File::directories($basePath);

        // if (empty($directories)) {
        //     return $result;
        // }

        // $fakeId = 1;
        // foreach ($directories as $directory) {
        //     $directoryName = basename($directory);
        //     $fileCount = count(File::files($directory));

        //     $result[] = array(
        //         'id' => $fakeId,
        //         'folder_name' => $directoryName,
        //         'file_count' => $fileCount
        //     );
        //     $fakeId++;
        // }

        // return array_reverse($result);
    }
}
