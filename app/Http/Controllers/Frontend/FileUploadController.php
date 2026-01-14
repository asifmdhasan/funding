<?php

namespace App\Http\Controllers\Frontend;

use App\Models\FtpSetting;
use App\Models\UploadedFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\RenameFileRequest;
use App\Http\Requests\UploadFileRequest;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;

class FileUploadController extends Controller
{
    // Create File with Folder API
    public function store(UploadFileRequest  $request)
    {
        try {
            Log::error("Started Message", [
                'ALlInfo' => $request->all(),
            ]);

            // $validated = $request->validated();

            $folderPath = $request->input('folder_path');
            $file = $request->file('file');
            $fileNameType = $request->input('file_name_type');
            $namingConflictType = $request->input('naming_conflict_type');

            $extension = $file->getClientOriginalExtension();

            if ($fileNameType === 'time') {
                $timestamp = now()->format('His'); // Generate filename like IMG_20250402_153030.jpg (from doc)
                $newFileName = "IMG_{$timestamp}." . $extension;
            } elseif ($fileNameType === 'customfilename') {
                if ($namingConflictType === 'overwrite') {
                    $customName = $request->input('file_name');
                    // $customName = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $customName); // clean special chars
                    $newFileName = $customName . '.' . $extension;
                } elseif ($namingConflictType === 'warn-ask') {
                    $customName = $request->input('file_name');
                    $newFileName = $customName . '.' . $extension;
                    $relativePath = "uploads/{$folderPath}/{$newFileName}";

                    if (Storage::disk('public')->exists($relativePath)) {
                        return $this->responseWithError(
                            null,
                            __('validation.file_exists', ['filename' => $newFileName]),
                            409
                        );
                    }
                }
            } else {
                $timestamp = now()->format('Ymd_His'); // Generate filename like IMG_20250402_153030.jpg (from doc)
                $newFileName = "IMG_{$timestamp}." . $extension;
            }

            // From server
            $filePath = $file->storeAs("uploads/{$folderPath}", $newFileName, 'public');

            $filePath = ltrim($filePath, '/'); // start from "/"
            $filePath = preg_replace('/\/+/', '/', $filePath); // remove extra '/'
            $fileUrl = asset("storage/{$filePath}");
            // return auth('api')->id();
            Log::error('File upload error', [
                'file' => $file ? $file->getClientOriginalName() : null,
                'folder_path' => $folderPath,
                'exception' => isset($e) ? $e->getMessage() : null,
            ]);
            if (null !== auth('api')->id()) {
                $uploadedFile = UploadedFile::create([
                    'user_id' => auth('api')->id(),
                    'folder_path' => $folderPath,
                    'file_name' => $newFileName,
                    'file_url' => $fileUrl,
                ]);
            }

            // return $uploadedFile;
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

            $structure = $this->getFolderStructure('public', $basePath);
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

    public function getFtpFilesAndFolders()
    {
        try {
            $basePath = '/'; // storage/app/public/uploads

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

            $structure = $this->getFolderStructure('dynamic_sftp', $sftp->root);
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

    private function getFolderStructure($disk = 'public', $root_path)
    {
        $directories = Storage::disk($disk)->directories($root_path);
        $items = Storage::disk($disk)->files($root_path);
        $result = [];

        // Folders
        if (!is_array($directories)) {
            $directories = [];
        }
        foreach ($directories as $directory) {
            $result[] = [
                'name' => basename($directory),
                'current_path' => ltrim($directory, 'uploads'), // start from "/"
                // 'current_path' => $directory, // full relative path
                'content_type' => 'folder',
                'children' => $this->getFolderStructure($disk, $directory),
            ];
        }

        // Files
        if (!is_array($items)) {
            $items = [];
        }
        foreach ($items as $file) {
            $result[] = [
                'name' => pathinfo($file, PATHINFO_BASENAME), // with extension
                'current_path' => $file,  // full relative path
                'content_type' => 'file',
            ];
        }

        return $result;
    }

    public function getFtpFileUrl()
    {
        $filename = \request()->path;

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

        $disk = Storage::disk('dynamic_sftp');

        if (!$disk->exists($filename)) {
            abort(404, 'File not found.');
        }

        $fileContent = $disk->get($filename);

        return Response::make($fileContent, 200, [
            'Content-Type' => $disk->mimeType($filename),
            'Content-Disposition' => 'inline; filename="' . basename($filename) . '"',
        ]);
    }

    public function storeInFTP(UploadFileRequest  $request)
    {
        try {
            Log::error("Started Message", [
                'ALlInfo' => $request->all(),
            ]);

            // $validated = $request->validated();

            $folderPath = $request->input('folder_path');
            $file = $request->file('file');
            $fileNameType = $request->input('file_name_type');
            $namingConflictType = $request->input('naming_conflict_type');

            $extension = $file->getClientOriginalExtension();

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

            if ($fileNameType === 'time') {
                $timestamp = now()->format('His'); // Generate filename like IMG_20250402_153030.jpg (from doc)
                $newFileName = "IMG_{$timestamp}." . $extension;
            } elseif ($fileNameType === 'customfilename') {
                if ($namingConflictType === 'overwrite') {
                    $customName = $request->input('file_name');
                    // $customName = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $customName); // clean special chars
                    $newFileName = $customName . '.' . $extension;
                } elseif ($namingConflictType === 'warn-ask') {
                    $customName = $request->input('file_name');
                    $newFileName = $customName . '.' . $extension;
                    $relativePath = "{$folderPath}/{$newFileName}";

                    if (Storage::disk('dynamic_sftp')->exists($relativePath)) {
                        return $this->responseWithError(
                            null,
                            __('validation.file_exists', ['filename' => $newFileName]),
                            409
                        );
                    }
                }
            } else {
                $timestamp = now()->format('Ymd_His'); // Generate filename like IMG_20250402_153030.jpg (from doc)
                $newFileName = "IMG_{$timestamp}." . $extension;
            }

            // From server
            // $filePath = $file->storeAs("{$folderPath}", $newFileName, 'public');
            // dump(file_get_contents($file));
            $newFileName = $folderPath . '/' . $newFileName;
            $stored = Storage::disk('dynamic_sftp')->put($newFileName, file_get_contents($file));

            if (!$stored) {
                Log::error('stored Storage error', [
                    'file' => $file ? $file->getClientOriginalName() : null,
                    'folder_path' => $folderPath,
                    'exception' => 'File not stored',
                    'stored' => $stored,
                ]);
                
                return $this->responseWithError(
                    null,
                    __('validation.file_not_stored'),
                    500
                );
            }
            $fileUrl = url("ftp/get-file?path={$newFileName}");

            if (auth('api')->id() !== null) {

                

                $uploadedFile = UploadedFile::create([
                    'user_id' => auth('api')->id(),
                    'folder_path' => $folderPath,
                    'file_name' => $newFileName,
                    'file_url' => $fileUrl,
                ]);
                Log::error('File upload error', [
                    'data' => $uploadedFile,
                ]);
            }


            // return $uploadedFile;
            return $this->responseWithSuccess(
                [
                    'file_path' => $fileUrl,
                    // 'file_path' => asset('storage/' . $filePath)
                ],
                __('validation.file_stored'),
                200,
            );
        } catch (\Exception $e) {
            Log::error('Exception', [
                'exception' => $e->getMessage(),
                'line' => $e->getLine(),
            ]);
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

    public function renameFile(RenameFileRequest $request)
    {
        try {

            $file_exists = false;
            $message = '';
            // $validated = $request->validated();
            $currentPath = $request->input('file_path');
            $newName = $request->input('new_name');

            $disk = Storage::disk('public');

            $extension = pathinfo($currentPath, PATHINFO_EXTENSION);
            $directory = pathinfo($currentPath, PATHINFO_DIRNAME);
            $newFileName = $newName;
            $newPath = $directory . '/' . $newFileName;
            // Check file exists
            if (!$disk->exists($currentPath)) {
                $message =  __('validation.file_not_found');
                return $this->responseWithError(null, $message, 404);
            } elseif ($disk->exists($newPath)) {
                $message = __('validation.file_exist');
                $file_exists = true;
                return $this->responseWithError(null, $message, 404);
            }
            // Rename file
            else {
                $disk->move($currentPath, $newPath);
                $message = __('validation.file_renamed');
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
                'validation.something_went_wrong',
                500,
            );
        }
    }

    public function renameFtpFile(RenameFileRequest $request)
    {
        try {

            $file_exists = false;
            $message = '';
            // $validated = $request->validated();
            $currentPath = $request->input('file_path');
            $newName = $request->input('new_name');

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

            $disk = Storage::disk('dynamic_sftp');

            $extension = pathinfo($currentPath, PATHINFO_EXTENSION);
            $directory = pathinfo($currentPath, PATHINFO_DIRNAME);
            $newFileName = $newName;
            $newPath = $directory . '/' . $newFileName;
            // Check file exists
            if (!$disk->exists($currentPath)) {
                $message =  __('validation.file_not_found');
                return $this->responseWithError(null, $message, 404);
            } elseif ($disk->exists($newPath)) {
                $message = __('validation.file_exist');
                $file_exists = true;
                return $this->responseWithError(null, $message, 404);
            }
            // Rename file
            else {
                $moved = $disk->move($currentPath, $newPath);
                if ($moved) {
                    $message = __('validation.file_renamed');
                    $file_exists = true;
                    return $this->responseWithSuccess(
                        [
                            'new_path' => url('/ftp/get-file?path=' . $newPath),
                            'file_exists' => $file_exists,
                        ],
                        $message,
                        200,
                    );
                } else {
                    $message = __('validation.file_not_renamed');
                    return $this->responseWithError(null, $message, 500);
                }
            }
        } catch (\Exception $e) {
            return $this->responseWithError(
                [
                    'error_message' => $e->getMessage(),
                    'error_line' => $e->getLine(),
                ],
                'validation.something_went_wrong',
                500,
            );
        }
    }



    public function server()
    {
        $directories = Storage::disk('ftp')->allDirectories('/'); // Get all directories including subdirectories
        $files = Storage::disk('ftp')->allFiles('/upload'); // Get all files including those in subdirectories

        $directories = [
            'directories' => $directories,
            'files' => $files,
        ];

        return response()->json($directories);
    }
}
