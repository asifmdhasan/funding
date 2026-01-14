<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;

class FileUploadController extends Controller
{

    // Create File with Folder API
    public function store(Request $request)
    {
        try {
            // App::setLocale($request->header('Accept-Language', 'en'));

            $validator = Validator::make(
                $request->all(),
                [
                    'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                    'folder_path' => 'required|string',
                    'file_name_type' => 'required|in:datetime,time,customfilename',
                    // 'file_name' => 'customfilename|string|max:255',
                    'file_name' => [
                        'required_if:file_name_type,customfilename',
                        'string',
                        'max:255',
                        'regex:/^[^\\\\\\/\\:*?"\'<>|]*$/',
                    ],
                    'naming_conflict_type' => 'required_if:file_name_type,customfilename',
                ],
                [
                    'file_name.regex' => __('messages.file_name_invalid'),
                ]
            );

            if ($validator->fails()) {
                return $this->responseWithError(null, $validator->errors()->first(), 422);
            }

            $folderPath = $request->input('folder_path');
            $file = $request->file('file');
            $fileNameType = $request->input('file_name_type');
            $namingConflictType = $request->input('naming_conflict_type');

            $extension = $file->getClientOriginalExtension();
            
            if ($fileNameType === 'time') {
                $timestamp = now()->format('His'); // Generate filename like IMG_20250402_153030.jpg (from doc)
                $newFileName = "IMG_{$timestamp}." . $extension;
            } elseif ($fileNameType === 'customfilename') {
                if($namingConflictType === 'overwrite'){
                    $customName = $request->input('file_name');
                    $newFileName = $customName . '.' . $extension;
                } 
                elseif($namingConflictType === 'warn-ask'){
                    $customName = $request->input('file_name');
                    $newFileName = $customName . '.' . $extension;
                    $relativePath = "{$folderPath}/{$newFileName}";
                
                    if (Storage::disk('custom_uploads')->exists($relativePath)) {
                        return $this->responseWithError(
                            null,
                            "A file named '{$newFileName}' already exists in this folder.",
                            409
                        );
                    } 
                }
            } else {
                $timestamp = now()->format('Ymd_His'); // Generate filename like IMG_20250402_153030.jpg (from doc)
                $newFileName = "IMG_{$timestamp}." . $extension;
            }

            $filePath = $file->storeAs("{$folderPath}", $newFileName, 'custom_uploads');
            // dd($filePath);
            
            $filePath = ltrim($filePath, '/'); // start from "/"
            $filePath = preg_replace('/\/+/', '/', $filePath); // remove extra '/'
            $fileUrl = asset("uploads/{$filePath}");
            return $this->responseWithSuccess(
                [
                    'file_path' => $fileUrl,
                    // 'file_path' => Storage::disk('custom_uploads')->url($filePath),
                ],
                'Files and folders added successfully.',
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

    // Show File and Folder API
    public function listFilesAndFolders()
    {
        try {
            $basePath = ''; // storage/app/public/uploads

            $structure = $this->getFolderStructure($basePath);
            return $this->responseWithSuccess($structure, 'Files and folders added successfully.', 200);
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

    private function getFolderStructure($path)
    {
        $items = Storage::disk('custom_uploads')->files($path);
        $directories = Storage::disk('custom_uploads')->directories($path);
        $result = [];

        // Folders
        foreach ($directories as $directory) {
            $result[] = [
                'name' => basename($directory),
                // 'current_path' => ltrim($directory, 'uploads'),
                'current_path' => $directory, // full relative path
                'content_type' => 'folder',
                'children' => $this->getFolderStructure($directory),
                // 'item_count' => count($children), //  item count
                'last_modified' => Storage::disk('custom_uploads')->lastModified($directory)
                    ? date('Y-m-d H:i:s', Storage::disk('custom_uploads')->lastModified($directory))
                    : null,
            ];
        }

        // Files
        foreach ($items as $file) {
            $result[] = [
                'name' => pathinfo($file, PATHINFO_BASENAME), // with extension
                'current_path' => $file,  // full relative path
                'content_type' => 'file',
                'last_modified' => Storage::disk('custom_uploads')->lastModified($file)
                    ? date('Y-m-d H:i:s', Storage::disk('custom_uploads')->lastModified($file))
                    : null,
            ];
        }

        return $result;
    }

    // Rename File API
    public function renameFile(Request $request)
    {
        try{

            $file_exists = false;
            $message = '';
            
            $validator = Validator::make(
                $request->all(),
                [
                    'file_path' => 'required|string',  // Ex: uploads/profile_pics/old_name.jpg
                    'new_name' => [
                        'required',
                        'string',
                        'max:255',
                        'regex:/^[^\\\\\\/\\:*?"\'<>|]*$/',
                    ]
                    ],
                    [
                        'new_name.regex' => 'A file name can not contain any of the following characters: * : ? " /\' < > |',
                    ]
            );

            if ($validator->fails()) {
                return $this->responseWithError(null, $validator->errors()->first(), 422);
            }

            $currentPath = $request->input('file_path');
            $newName = $request->input('new_name');

            $disk = Storage::disk('custom_uploads');

            $extension = pathinfo($currentPath, PATHINFO_EXTENSION);
            $directory = pathinfo($currentPath, PATHINFO_DIRNAME);
            $newFileName = $newName;
            $newPath = $directory . '/' . $newFileName;
            // Check file exists
            if(!$disk->exists($currentPath)) {
                $message = 'File not found.';
                return $this->responseWithError(null, $message, 404);
            }
            // If same name exist:
            elseif($disk->exists($newPath)) {
                $message = 'File name already exists.';
                $file_exists = true;
                return $this->responseWithError(null, $message, 404);
            }
            // Rename file
            else{
                $disk->move($currentPath, $newPath);
                $message = 'File renamed successfully.';
                $file_exists = true;
            }
        
            return $this->responseWithSuccess(
                [
                    'new_path' => asset('uploads/' . $newPath),
                    'file_exists' => $file_exists,
                ],
                $message,
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
}
