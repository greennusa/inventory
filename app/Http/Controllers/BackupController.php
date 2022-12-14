<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Alert;
use Artisan;
use Log;
use Storage;
use Auth;
use Backup;
class BackupController extends Controller
{
    public function index()
    {   
       
        $disk = Storage::disk('backup');
        $files = $disk->files(config('laravel-backup.backup.name'));
        $backups = [];
        // make an array of backup files, with their filesize and creation date
        foreach ($files as $k => $f) {
            // only take the zip files into account
            if (substr($f, -4) == '.zip' && $disk->exists($f)) {
                $time = \DateTime::createFromFormat("U",$disk->lastModified($f));
                $time->setTimeZone(new \DateTimeZone('Asia/Kuala_Lumpur'));
                $backups[] = [
                    'file_path' => $f,
                    'file_name' => str_replace(config('laravel-backup.backup.name').'/', '', $f),
                    'file_size' => $disk->size($f),
                    'last_modified' => $disk->lastModified($f),
                    'time'=>$time
                ];
            }
        }
        // reverse the backups, so the newest one would be on top
        $backups = array_reverse($backups);
        return view("backup.index")->with(compact('backups'));
    }
    public function create()
    {   

        try {
            // start the backup process
            Artisan::call('backup:run');
            $output = Artisan::output();
        
            // log the results
            Log::info("Backpack\BackupManager -- new backup started from admin interface \r\n" . $output);
            // return the results as a response to the ajax call
            
            return redirect()->back();
        } catch (Exception $e) {
            Flash::error($e->getMessage());
            return redirect()->back();
        }
    }
    /**
     * Downloads a backup zip file.
     *
     * TODO: make it work no matter the flysystem driver (S3 Bucket, etc).
     */
    public function download($file_name)
    {   
        
        $file = config('laravel-backup.backup.name') . '/' . $file_name;
        $disk = Storage::disk(config('laravel-backup.backup.destination.disks')[0]);
        if ($disk->exists($file)) {
            $fs = Storage::disk(config('laravel-backup.backup.destination.disks')[0])->getDriver();
            $stream = $fs->readStream($file);

           
            return \Response::stream(function () use ($stream) {
                fpassthru($stream);
            }, 200, [
                "Content-Type" => $fs->getMimetype($file),
                "Content-Length" => $fs->getSize($file),
                "Content-disposition" => "attachment; filename=\"" . basename($file) . "\"",
            ]);
        } else {
            abort(404, "The backup file doesn't exist.");
        }
    }
    /**
     * Deletes a backup file.
     */
    public function delete($file_name)
    {
        $disk = Storage::disk(config('laravel-backup.backup.destination.disks')[0]);
        if ($disk->exists(config('laravel-backup.backup.name') . '/' . $file_name)) {
            $disk->delete(config('laravel-backup.backup.name') . '/' . $file_name);

            
        } 
        return redirect('backup');
    }

    public function restore($file_name)
    {
        $path = public_path(config('laravel-backup.backup.name') . '/' . $file_name);
   
        //Backup::restore($path);
        dd(Backup::getProcessOutput());
        return redirect('backup');
    }
}
