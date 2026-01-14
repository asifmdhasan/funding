<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;

class FileUploadController extends Controller
{
    // Create File with Folder API
    public function store(Request  $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
                    'folder_path' => 'required|string',
                    'file_name_type' => 'required|in:datetime,time,customfilename',
                    // 'file_name' => 'required_if:file_name_type,customfilename|string|max:255',
                    'file_name' => [
                        'required_if:file_name_type,customfilename',
                        'string',
                        // 'max:255',
                        'regex:/^[^\\\\\\/\\:*?"\'<>|]*$/',
                        // 'regex:/^[^\\\/:*?"\'<>|]*$/',
                    ],
                    'naming_conflict_type' => 'required_if:file_name_type,customfilename',
                ],
                [
                    'file.required' => __('validation.custom.file.required'),
                    'file.image' => __('validation.custom.file.image'),
                    'file.mimes' => __('validation.custom.file.mimes'),
                    // 'file.max' => __('validation.custom.file.max'),
                    'folder_path.required' => __('validation.custom.folder_path.required'),
                    'folder_path.string' => __('validation.custom.folder_path.string'),
                    'file_name_type.required' => __('validation.custom.file_name_type.required'),
                    'file_name_type.in' => __('validation.custom.file_name_type.in'),
                    'file_name.required_if' => __('validation.custom.file_name.required_if'),
                    'file_name.string' => __('validation.custom.file_name.string'),
                    // 'file_name.max' => __('validation.custom.file_name.max'),
                    'file_name.regex' => __('validation.custom.file_name.regex'),
                    'naming_conflict_type.required_if' => __('validation.custom.naming_conflict_type.required_if'),
                ]
            );

            if ($validator->fails()) {
                return $this->responseWithError(null, $validator->errors(), 422);
            }

            $validated = $request->validated();

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
                    // $customName = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $customName); // clean special chars
                    $newFileName = $customName . '.' . $extension;
                } 
                elseif($namingConflictType === 'warn-ask'){
                    $customName = $request->input('file_name');
                    $newFileName = $customName . '.' . $extension;
                    $relativePath = "uploads/{$folderPath}/{$newFileName}";
                
                    if (Storage::disk('public')->exists($relativePath)) {
                        return $this->responseWithError(
                            null,
                            __('validation.file_exists', ['filename' => $newFileName]),
                            // "A file named '{$newFileName}' already exists in this folder.",
                            409
                        );
                    } 
                }
            } else {
                $timestamp = now()->format('Ymd_His'); // Generate filename like IMG_20250402_153030.jpg (from doc)
                $newFileName = "IMG_{$timestamp}." . $extension;
            }

            // From Cpanel
            $filePath = $file->storeAs("uploads/{$folderPath}", $newFileName, 'public');            
            $filePath = ltrim($filePath, '/'); // start from "/"
            $filePath = preg_replace('/\/+/', '/', $filePath); // remove extra '/'
            $fileUrl = asset("public/{$filePath}");

            return $this->responseWithSuccess(
                [
                    'file_path' => $fileUrl,
                    // 'file_path' => asset('storage/' . $filePath)
                ],
                __('validation.file_stored'),
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

    public function listFilesAndFolders()
    {
        try {
            $basePath = 'uploads'; // storage/app/public/uploads

            $structure = $this->getFolderStructure($basePath);
            return $this->responseWithSuccess(
                $structure,
                __('validation.file_retrieved'),
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

    private function getFolderStructure($path)
    {
        $items = Storage::disk('public')->files($path);
        $directories = Storage::disk('public')->directories($path);
        $result = [];

        // Folders
        foreach ($directories as $directory) {
            $result[] = [
                'name' => basename($directory),
                'current_path' => ltrim($directory, 'uploads'), // start from "/"
                // 'current_path' => $directory, // full relative path
                'content_type' => 'folder',
                'children' => $this->getFolderStructure($directory),
            ];
        }

        // Files
        foreach ($items as $file) {
            $result[] = [
                'name' => pathinfo($file, PATHINFO_BASENAME), // with extension
                'current_path' => $file,  // full relative path
                'content_type' => 'file',
            ];
        }

        return $result;
    }

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
                        'regex:/^[^\\\\\\/\\:*?"\'<>|]*$/',
                    ]
                    ],
                    [
                        'file_path.required' => __('validation.custom.file_path.required'),
                        'file_path.string' => __('validation.custom.file_path.string'),
                        'new_name.required' => __('validation.custom.new_name.required'),
                        'new_name.string' => __('validation.custom.new_name.string'),
                        // 'new_name.max' => __('validation.custom.new_name.max'),
                        'new_name.regex' => __('validation.custom.new_name.regex'),
                    ]
            );

            if ($validator->fails()) {
                return $this->responseWithError(null, $validator->errors()->first(), 422);
            }

            $currentPath = $request->input('file_path');
            $newName = $request->input('new_name');

            $disk = Storage::disk('public');

            $extension = pathinfo($currentPath, PATHINFO_EXTENSION);
            $directory = pathinfo($currentPath, PATHINFO_DIRNAME);
            $newFileName = $newName;
            $newPath = $directory . '/' . $newFileName;
            // Check file exists
            if(!$disk->exists($currentPath)) {
                $message =  __('validation.file_not_found');
                return $this->responseWithError(null, $message, 404);
            }

            elseif($disk->exists($newPath)) {
                $message = __('validation.file_exist');
                $file_exists = true;
                return $this->responseWithError(null, $message, 404);
            }
            // Rename file
            else{
                $disk->move($currentPath, $newPath);
                $message = __('validation.file_renamed');
                // $message = 'File renamed successfully.';
                $file_exists = true;
            }

            return $this->responseWithSuccess(
                [
                    'new_path' => asset('storage/' . $newPath),
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
