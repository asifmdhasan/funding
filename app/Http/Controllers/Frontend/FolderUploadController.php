<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreFolderRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\SingleFolderRequest;
use App\Models\FtpSetting;
use Illuminate\Support\Facades\Config;

class FolderUploadController extends Controller
{
    // Get Folder API
    public function listofFolders()
    {
        try {
            $basePath = 'uploads'; // storage/app/public/uploads

            $structure = $this->getAllFolder($basePath);
            return $this->responseWithSuccess(
                $structure,
                __('validation.all_folder_lists'),
                200
            );
        } catch (\Exception $e) {
            return $this->responseWithError(
                [
                    'error_message' => $e->getMessage(),
                    'error_line' => $e->getLine(),
                ],
                __('validation.something_went_wrong'),
                500,
            );
        }
    }

    private function getAllFolder($path)
    {
        $directories = Storage::disk('public')->directories($path);
        $result = [];
        foreach ($directories as $directory) {
            $result[] =
                [
                    'folder_name' => basename($directory),
                    'current_path' => $directory, // full relative path
                    'content_type' => 'folder',
                    'children' => $this->getAllFolder($directory),
                ];
        }
        return $result;
    }

    // Create Folder API
    public function storeFolder(StoreFolderRequest $request)
    {
        try {
            // $validated = $request->validated();
            $name  = $request->input('name');
            $folderPath = $request->input('folder_path');

            $fullPath = "uploads/{$folderPath}/{$name}";
            $fullPath = preg_replace('/\/+/', '/', $fullPath); // clean full path again
            Storage::disk('public')->makeDirectory($fullPath);

            return $this->responseWithSuccess(
                [
                    'folder_path' => asset('storage/' . $fullPath),
                ],
                __('validation.folder_stored'),
                200,
            );
        } catch (\Exception $e) {
            return $this->responseWithError(
                [
                    'error_message' => $e->getMessage(),
                    'error_line' => $e->getLine(),
                ],
                __('validation.something_went_wrong'),
                500,
            );
        }
    }

    public function createFtpFolder(StoreFolderRequest $request)
    {
        try {
            // $validated = $request->validated();
            $name  = $request->input('name');
            $folderPath = $request->input('folder_path');

            $fullPath = "{$folderPath}/{$name}";
            $fullPath = preg_replace('/\/+/', '/', $fullPath); // clean full path again

            $sftp = FtpSetting::first(); // Adjust if needed
            
            // Dynamically define the SFTP disk
            Config::set('filesystems.disks.dynamic_sftp', [
                'driver' => 'sftp',
                'host' => $sftp->host,
                'username' => $sftp->username,
                'password' => $sftp->password,
                'port' => $sftp->port,
                'root' => $sftp->root,
                'timeout' => $sftp->timeout,
            ]);
          
            $storage = Storage::disk('dynamic_sftp')->makeDirectory($fullPath);

            if (!$storage) {
                return $this->responseWithError(
                    null,
                    __('validation.something_went_wrong'),
                    409
                );
            }
            return $this->responseWithSuccess(
                [
                    'folder_path' => $fullPath,
                ],
                __('validation.folder_stored'),
                200,
            );
        } catch (\Exception $e) {
            return $this->responseWithError(
                [
                    'error_message' => $e->getMessage(),
                    'error_line' => $e->getLine(),
                ],
                __('validation.something_went_wrong'),
                500,
            );
        }
    }

    // Create Singel Folder API
    public function getSingleFolderStructure(SingleFolderRequest $request)
    {
        try {
            // $validate = $request->validated();
            $path = $request->query('path'); // e.g. A/B/C/D

            $cleanPath = trim($path, '/');
            $basePath = 'uploads/' . $cleanPath; // relative to 'public' disk

            if (!$path || !Storage::disk('public')->exists($basePath)) {
                return $this->responseWithError(
                    null,
                    __('validation.invalid_or_missing_path'),
                    409
                );
            }

            $structure = $this->getFolderContents('public', $basePath);

            return $this->responseWithSuccess(
                [
                    'folder_name' => basename($cleanPath),
                    'current_path' => '/' . $cleanPath,
                    'content_type' => 'folder',
                    'children' => $structure,
                ],
                __('validation.single_folder_contents'),
                200,
            );

            return response()->json([]);
        } catch (\Exception $e) {
            return $this->responseWithError(
                [
                    'error_message' => $e->getMessage(),
                    'error_line' => $e->getLine(),
                ],
                __('validation.something_went_wrong'),
                500,
            );
        }
    }

     public function getFtpSingleFolderStructure(SingleFolderRequest $request)
    {
        try {
            // $validate = $request->validated();
            $path = $request->query('path'); // e.g. A/B/C/D

            $cleanPath = trim($path, '/');
            $basePath = $cleanPath; // relative to 'public' disk

            $sftp = FtpSetting::first(); // Adjust if needed
            // Dynamically define the SFTP disk
             Config::set('filesystems.disks.dynamic_sftp', [
                'driver' => 'sftp',
                'host' => $sftp->host,
                'username' => $sftp->username,
                'password' => $sftp->password,
                'port' => $sftp->port,
                'root' => $sftp->root,
                'timeout' => $sftp->timeout,
            ]);
            

            if (!$path || !Storage::disk('dynamic_sftp')->exists($basePath)) {
                return $this->responseWithError(
                    null,
                    __('validation.invalid_or_missing_path'),
                    409
                );
            }

            $structure = $this->getFolderContents('dynamic_sftp', $basePath);

            return $this->responseWithSuccess($structure,
                __('validation.single_folder_contents'),
                200,
            );

            return response()->json([]);
        } catch (\Exception $e) {
            return $this->responseWithError(
                [
                    'error_message' => $e->getMessage(),
                    'error_line' => $e->getLine(),
                ],
                __('validation.something_went_wrong'),
                500,
            );
        }
    }

    private function getFolderContents($driver = 'public', $path)
    {
        $folders = Storage::disk($driver)->directories($path);
        $files = Storage::disk($driver)->files($path);
        $items = [];

        // Folders
        foreach ($folders as $folder) {
            $items[] = [
                'name' => basename($folder),
                'current_path' => '/' .$folder,
                'content_type' => 'folder',
            ];
        }

        // Files
        foreach ($files as $file) {
            $items[] = [
                'name' => basename($file),
                'current_path' => $file,
                'content_type' => 'file',
            ];
        }

        return $items;
    }
}
