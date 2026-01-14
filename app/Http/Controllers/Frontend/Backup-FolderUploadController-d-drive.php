<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class FolderUploadController extends Controller
{
    // Get Folder API
    public function listofFolders()
    {
        try {
            $basePath = ''; // storage/app/public/uploads

            $structure = $this->getAllFolder($basePath);
            return $this->responseWithSuccess($structure, 'All Folder Lists.', 200);
        } catch (\Exception $e) {
            return $this->responseWithError(
                [
                    'error_message' => $e->getMessage(),
                    'error_line' => $e->getLine(),
                ],
                'Something went wrong!',
                500,
            );
        } 
    }

    private function getAllFolder($path)
    {
        $directories = Storage::disk('custom_uploads')->directories($path);
        $result = [];
        foreach ($directories as $directory) {
            $result[] = 
            [
                'folder_name' => basename($directory),
                'current_path' => $directory, // full relative path
                'content_type' => 'folder',
                'children' => $this->getAllFolder($directory),
                'last_modified' => Storage::disk('custom_uploads')->lastModified($directory)
                    ? date('Y-m-d H:i:s', Storage::disk('custom_uploads')->lastModified($directory))
                    : null,
            ];
        }
        return $result;
    }

    // Create Folder API
    public function storeFolder(Request $request)
    {
        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'name' => [
                        'required',
                        'string',
                        'regex:/^[a-zA-Z0-9][a-zA-Z0-9@#\-\_\.!$&()\[\]{} ]*$/', // remove special character on start, then underscore/hyphen/space allowed
                        'max:255'
                    ],
                    'folder_path' => 'required|string',
                ],
                [
                    'name.required' => 'The folder name is required.',
                    'name.string' => 'The folder name must be a valid string.',
                    'name.regex' => 'The folder name must start with a letter or number allowed special characters (@ # - _ . ! $ & ( ) [ ] { }).',
                    'name.max' => 'The folder name may not be greater than 255 characters.',
                ],
            );

            if ($validator->fails()) {
                return $this->responseWithError(null, $validator->errors(), 422);
            }
  
            $name  = $request->input('name');
            $folderPath = $request->input('folder_path');

            // $fullPath = "uploads/{$folderPath}/{$name}";
            $fullPath = "{$folderPath}/{$name}";
            $fullPath = preg_replace('/\/+/', '/', $fullPath); // clean full path again
            Storage::disk('custom_uploads')->makeDirectory($fullPath);

            return $this->responseWithSuccess(
                [
                    'folder_path' => asset('uploads/' . $fullPath),
                ],
                'Folder created successfully.',
                200,
            );
        } catch (\Exception $e) {
            return $this->responseWithError(
                [
                    'error_message' => $e->getMessage(),
                    'error_line' => $e->getLine(),
                ],
                'Something went wrong!',
                500,
            );
        }
    }

    // Create Singel Folder API
    public function getSingleFolderStructure(Request $request)
    {
        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'path' => 'required|string',
                ],
                [
                    'path.required' => 'The folder path is required.',
                    'name.string' => 'The folder name must be a valid string.',
                ],
            );

            if ($validator->fails()) {
                return $this->responseWithError(null, $validator->errors(), 422);
            }


            $path = $request->query('path'); // e.g. A/B/C/D
            $cleanPath = trim($path, '/');
            $basePath = $cleanPath; // relative to 'public' disk

            if (!$path || !Storage::disk('custom_uploads')->exists($basePath)) {
                return response()->json(['message' => 'Invalid or missing path'], 400);
            }

            $structure = $this->getFolderContents($basePath);

            return $this->responseWithSuccess(
                [
                    'folder_name' => basename($cleanPath),
                    'current_path' => '/' . $cleanPath,
                    'content_type' => 'folder',
                    'children' => $structure,
                ],
                'Folder structure loaded successfully..',
                200,
            );

            return response()->json([
               
            ]);
        } catch (\Exception $e) {
            return $this->responseWithError(
                [
                    'error_message' => $e->getMessage(),
                    'error_line' => $e->getLine(),
                ],
                'Something went wrong!',
                500,
            );
        }
    }

    private function getFolderContents($path)
    {
        $folders = Storage::disk('custom_uploads')->directories($path);
        $files = Storage::disk('custom_uploads')->files($path);
        $items = [];

        // Folders
        foreach ($folders as $folder) {
            $items[] = [
                'folder_name' => basename($folder),
                'current_path' => $folder,
                // 'current_path' => '/' . ltrim($folder, 'uploads/'),
                'content_type' => 'folder',
                'last_modified' => Storage::disk('custom_uploads')->lastModified($folder)
                    ? date('Y-m-d H:i:s', Storage::disk('custom_uploads')->lastModified($folder))
                    : null,
            ];
        }

        // Files
        foreach ($files as $file) {
            $items[] = [
                'name' => basename($file),
                'current_path' => $file,
                'content_type' => 'file',
                'last_modified' => Storage::disk('custom_uploads')->lastModified($file)
                    ? date('Y-m-d H:i:s', Storage::disk('custom_uploads')->lastModified($file))
                    : null,
            ];
        }

        return $items;
    }

}
