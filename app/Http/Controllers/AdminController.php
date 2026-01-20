<?php

namespace App\Http\Controllers;

use Log;
use App\Models\Mold;
use App\Models\User;
use App\Models\Donor;
use App\Models\Crisis;
use App\Models\Variant;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Purchase;
use App\Models\Warehouse;
use App\Models\FtpSetting;
use App\Models\Requisition;
use App\Models\Notification;
use App\Models\UploadedFile;
use Illuminate\Http\Request;
use App\Models\HelpseekerPost;
use App\Models\WarehouseStock;
use Illuminate\Support\Carbon;
use App\Models\GmeBusinessForm;
use App\Models\StockTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use SebastianBergmann\CodeCoverage\Report\Thresholds;

class AdminController extends Controller
{
    // public function dashboard() 
    // {
    //     return view('admin.dashboard');
    //     // return redirect()->route('admin.dashboard');
    // }

    public function index(Request $request) 
    {
        $user = auth()->user(); // Logged-in user

        if ($user->username == 'superadmin') {
            // Admin or superadmin - see all files
            $files = UploadedFile::with('user')->latest()->get();
        } else {
            // Normal user - only see own files
            $files = UploadedFile::with('user')
                ->where('user_id', $user->id)
                ->latest()
                ->get();
        }

        return view('admin.files.index', compact('files'));
    }


    public function allFiles(Request $request)
    {
        return view('admin.files.allfiles');
    }



    public function dashboard(Request $request)
    {
   
        $totalCrisis = Crisis::count();
        $totalDonor = Donor::count();
        $totalCategory = Category::count();

    

        return view('admin.dashboard', compact(
            'totalCrisis',
            'totalDonor',
            'totalCategory'
        ));
    }


    //show helpseekerposts
    public function showHelpseekerPosts()
    {
        $posts = HelpseekerPost::with('Helpseeker')->get();
        return view('admin.helpseekerposts.index', compact('posts'));
    }

    //updateStatus
    public function updateStatus(Request $request, HelpseekerPost $post)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $post->status = $request->status;
        $post->save();

        return redirect()
            ->route('admin.helpseekerposts.index')
            ->with('success', 'Post status updated successfully.');
    }


    

}
