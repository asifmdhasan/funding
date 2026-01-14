<?php

namespace App\Http\Controllers;

use Log;
use App\Models\Mold;
use App\Models\User;
use App\Models\Variant;
use App\Models\Customer;
use App\Models\Purchase;
use App\Models\Warehouse;
use App\Models\FtpSetting;
use App\Models\Requisition;
use App\Models\Notification;
use App\Models\UploadedFile;
use Illuminate\Http\Request;
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

    public function edit(UploadedFile $file)
    {
        return view('admin.files.edit', compact('file'));
    }

    public function allFiles(Request $request)
    {
        return view('admin.files.allfiles');
    }

    public function update(Request $request, UploadedFile $file)
    {
        $request->validate([
            'file_name' => 'required|string|max:255',
        ]);

        $file->update([
            'file_name' => $request->file_name,
        ]);

        // return redirect()->route('files.edit', $file)->with('success', 'File updated successfully!');
        return redirect()->route('files.index', $file)->with('success',  __('layouts.updated_successfully'));
    }

    // Delete 
    // public function destroy(UploadedFile $file)
    // {
    //     $filePath = str_replace(asset('storage') . '/', '', $file->file_url);

    //     if ($filePath && Storage::disk('public')->exists($filePath)) {
    //         Storage::disk('public')->delete($filePath);
    //     } else {
    //         Log::warning("File not found at: " . $filePath);
    //     }
        
    //     $file->delete();
    //     return redirect()->back()->with('success', __('layouts.deleted_successfully'));
    // }

    // public function latestNotifications()
    // {
    //     $notifications = Notification::where('read', 0)
    //         ->latest()
    //         ->take(5)
    //         ->get();

    //     $count = Notification::where('read', false)->count();

    //     // return response()->json($notifications);
    //     return response()->json([
    //         'count' => $count,
    //         'data' => $notifications
    //     ]);
    // }

    // public function markAsRead($id)
    // {
    //     $notification = Notification::findOrFail($id);
    //     $notification->read = 1;
    //     $notification->save();

    //     return response()->json(['success' => true]);
    // }



    public function dashboard(Request $request)
    {
   
        $totalCustomers = Customer::where('status', 1)->where('is_otp_verified', 1)->count();
        $totalBusinesses = GmeBusinessForm::count();
        $approvedBusinesses = GmeBusinessForm::where('status', 'approved')->count();

    

        return view('admin.dashboard', compact(
            'totalBusinesses',
            'totalCustomers',
            'approvedBusinesses'
        ));
    }


    // public function stockEntryChart(Request $request)
    // {
    //     $filter = $request->get('filter', 'month'); // week, month, year

    //     $query = StockTransaction::where('activity_type', 'IN');

    //     $labels = [];
    //     $data = ['direct' => [], 'qc_passed' => [], 'transfer' => []];

    //     if ($filter === 'week') {
    //         $start = now()->startOfWeek();
    //         $end = now()->endOfWeek();

    //         $dates = [];
    //         for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
    //             // $dates[] = $date->format('M, d');
    //             $dates[] = $date->format('l');
    //         }
    //         $labels = $dates;

    //         $records = $query
    //             ->select(
    //                 DB::raw("DATE_FORMAT(created_at, '%b, %d') as date"),
    //                 DB::raw("SUM(CASE WHEN type='direct_entry' THEN quantity ELSE 0 END) as direct_entry"),
    //                 DB::raw("SUM(CASE WHEN type='qc_passed' THEN quantity ELSE 0 END) as qc_passed_entry"),
    //                 DB::raw("SUM(CASE WHEN type='transfer' THEN quantity ELSE 0 END) as transfer_entry")
    //             )
    //             ->whereBetween('created_at', [$start, $end])
    //             ->groupBy('date')
    //             ->get()
    //             ->keyBy('date');

    //         foreach ($labels as $label) {
    //             $data['direct'][] = $records[$label]->direct_entry ?? 0;
    //             $data['qc_passed'][] = $records[$label]->qc_passed_entry ?? 0;
    //             $data['transfer'][] = $records[$label]->transfer_entry ?? 0;
    //         }
    //     }
    //     elseif ($filter === 'month') {
    //         $start = now()->startOfMonth();
    //         $end = now()->endOfMonth();
    //         $totalDays = $start->diffInDays($end) + 1;
    //         $weeks = ceil($totalDays / 7);

    //         $labels = [];
    //         for ($i = 1; $i <= $weeks; $i++) $labels[] = "Week $i";

    //         $records = $query
    //             ->select(
    //                 DB::raw("FLOOR((DAY(created_at)-1)/7)+1 as week"),
    //                 DB::raw("SUM(CASE WHEN type='direct_entry' THEN quantity ELSE 0 END) as direct_entry"),
    //                 DB::raw("SUM(CASE WHEN type='qc_passed' THEN quantity ELSE 0 END) as qc_passed_entry"),
    //                 DB::raw("SUM(CASE WHEN type='transfer' THEN quantity ELSE 0 END) as transfer_entry")
    //             )
    //             ->whereBetween('created_at', [$start, $end])
    //             ->groupBy('week')
    //             ->get()
    //             ->keyBy('week');

    //         foreach (range(1, $weeks) as $w) {
    //             $data['direct'][] = $records[$w]->direct_entry ?? 0;
    //             $data['qc_passed'][] = $records[$w]->qc_passed_entry ?? 0;
    //             $data['transfer'][] = $records[$w]->transfer_entry ?? 0;
    //         }
    //     }
    //     elseif ($filter === 'year') {
    //         $labels = [];
    //         for ($i = 1; $i <= 12; $i++) $labels[$i] = Carbon::create()->month($i)->format('F');

    //         $records = $query
    //             ->select(
    //                 DB::raw("MONTH(created_at) as month"),
    //                 DB::raw("SUM(CASE WHEN type='direct_entry' THEN quantity ELSE 0 END) as direct_entry"),
    //                 DB::raw("SUM(CASE WHEN type='qc_passed' THEN quantity ELSE 0 END) as qc_passed_entry"),
    //                 DB::raw("SUM(CASE WHEN type='transfer' THEN quantity ELSE 0 END) as transfer_entry")
    //             )
    //             ->whereYear('created_at', now()->year)
    //             ->groupBy('month')
    //             ->get()
    //             ->keyBy('month');

    //         foreach (range(1,12) as $m) {
    //             $data['direct'][] = $records[$m]->direct_entry ?? 0;
    //             $data['qc_passed'][] = $records[$m]->qc_passed_entry ?? 0;
    //             $data['transfer'][] = $records[$m]->transfer_entry ?? 0;
    //         }

    //         $labels = array_values($labels);
    //     }

    //     return response()->json([
    //         'labels' => $labels,
    //         'direct' => $data['direct'],
    //         'qc_passed' => $data['qc_passed'],
    //         'transfer' => $data['transfer'],
    //     ]);
    // }

    // public function stockOutChart(Request $request)
    // {
    //     $filter = $request->get('filter', 'month'); // week, month, year

    //     $query = StockTransaction::where('activity_type', 'OUT');

    //     $labels = [];
    //     $data = ['requisition' => [], 'transfer' => []];

    //     if ($filter === 'week') {
    //         $start = now()->startOfWeek();
    //         $end = now()->endOfWeek();

    //         $dates = [];
    //         for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
    //             // $dates[] = $date->format('M, d');
    //             $dates[] = $date->format('l');
    //         }
    //         $labels = $dates;

    //         $records = $query
    //             ->select(
    //                 DB::raw("DATE_FORMAT(created_at, '%b, %d') as date"),
    //                 DB::raw("SUM(CASE WHEN type='requisition' THEN quantity ELSE 0 END) as requisition_stockout"),
    //                 DB::raw("SUM(CASE WHEN type='transfer' THEN quantity ELSE 0 END) as transfer_stockout")
    //             )
    //             ->whereBetween('created_at', [$start, $end])
    //             ->groupBy('date')
    //             ->get()
    //             ->keyBy('date');

    //         foreach ($labels as $label) {
    //             $data['requisition'][] = $records[$label]->requisition_stockout ?? 0;
    //             $data['transfer'][] = $records[$label]->transfer_stockout ?? 0;
    //         }
    //     }
    //     elseif ($filter === 'month') {
    //         $start = now()->startOfMonth();
    //         $end = now()->endOfMonth();
    //         $totalDays = $start->diffInDays($end) + 1;
    //         $weeks = ceil($totalDays / 7);

    //         $labels = [];
    //         for ($i = 1; $i <= $weeks; $i++) $labels[] = "Week $i";

    //         $records = $query
    //             ->select(
    //                 DB::raw("FLOOR((DAY(created_at)-1)/7)+1 as week"),
    //                 DB::raw("SUM(CASE WHEN type='requisition' THEN quantity ELSE 0 END) as requisition_stockout"),
    //                 DB::raw("SUM(CASE WHEN type='transfer' THEN quantity ELSE 0 END) as transfer_stockout")
    //             )
    //             ->whereBetween('created_at', [$start, $end])
    //             ->groupBy('week')
    //             ->get()
    //             ->keyBy('week');

    //         foreach (range(1, $weeks) as $w) {
    //             $data['requisition'][] = $records[$w]->requisition_stockout ?? 0;
    //             $data['transfer'][] = $records[$w]->transfer_stockout ?? 0;
    //         }
    //     }
    //     elseif ($filter === 'year') {
    //         $labels = [];
    //         for ($i = 1; $i <= 12; $i++) $labels[$i] = Carbon::create()->month($i)->format('F');

    //         $records = $query
    //             ->select(
    //                 DB::raw("MONTH(created_at) as month"),
    //                 DB::raw("SUM(CASE WHEN type='requisition' THEN quantity ELSE 0 END) as requisition_stockout"),
    //                 DB::raw("SUM(CASE WHEN type='transfer' THEN quantity ELSE 0 END) as transfer_stockout")
    //             )
    //             ->whereYear('created_at', now()->year)
    //             ->groupBy('month')
    //             ->get()
    //             ->keyBy('month');

    //         foreach (range(1,12) as $m) {
    //             $data['requisition'][] = $records[$m]->requisition_stockout ?? 0;
    //             $data['transfer'][] = $records[$m]->transfer_stockout ?? 0;
    //         }

    //         $labels = array_values($labels);
    //     }

    //     return response()->json([
    //         'labels' => $labels,
    //         'requisition' => $data['requisition'],
    //         'transfer' => $data['transfer'],
    //     ]);
    // }

    // public function stockInOutChart(Request $request)
    // {
    //     $filter = $request->get('filter', 'month'); // week, month, year

    //     $labels = [];
    //     $data = ['stock_in' => [], 'stock_out' => []];

    //     $query = StockTransaction::query();

    //     if ($filter === 'week') {
    //         $start = now()->startOfWeek();
    //         $end = now()->endOfWeek();

    //         $dates = [];
    //         for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
    //             // $dates[] = $date->format('M, d');
    //             $dates[] = $date->format('l');
    //         }
    //         $labels = $dates;

    //         $records = $query
    //             ->select(
    //                 DB::raw("DATE_FORMAT(created_at, '%b, %d') as date"),
    //                 DB::raw("SUM(CASE WHEN activity_type='IN' THEN quantity ELSE 0 END) as stock_in"),
    //                 DB::raw("SUM(CASE WHEN activity_type='OUT' THEN quantity ELSE 0 END) as stock_out")
    //             )
    //             ->whereBetween('created_at', [$start, $end])
    //             ->groupBy('date')
    //             ->get()
    //             ->keyBy('date');

    //         foreach ($labels as $label) {
    //             $data['stock_in'][] = $records[$label]->stock_in ?? 0;
    //             $data['stock_out'][] = $records[$label]->stock_out ?? 0;
    //         }
    //     }
    //     elseif ($filter === 'month') {
    //         $start = now()->startOfMonth();
    //         $end = now()->endOfMonth();
    //         $totalDays = $start->diffInDays($end) + 1;
    //         $weeks = ceil($totalDays / 7);

    //         $labels = [];
    //         for ($i = 1; $i <= $weeks; $i++) $labels[] = "Week $i";

    //         $records = $query
    //             ->select(
    //                 DB::raw("FLOOR((DAY(created_at)-1)/7)+1 as week"),
    //                 DB::raw("SUM(CASE WHEN activity_type='IN' THEN quantity ELSE 0 END) as stock_in"),
    //                 DB::raw("SUM(CASE WHEN activity_type='OUT' THEN quantity ELSE 0 END) as stock_out")
    //             )
    //             ->whereBetween('created_at', [$start, $end])
    //             ->groupBy('week')
    //             ->get()
    //             ->keyBy('week');

    //         foreach (range(1, $weeks) as $w) {
    //             $data['stock_in'][] = $records[$w]->stock_in ?? 0;
    //             $data['stock_out'][] = $records[$w]->stock_out ?? 0;
    //         }
    //     }
    //     elseif ($filter === 'year') {
    //         $labels = [];
    //         for ($i = 1; $i <= 12; $i++) $labels[$i] = Carbon::create()->month($i)->format('F');

    //         $records = $query
    //             ->select(
    //                 DB::raw("MONTH(created_at) as month"),
    //                 DB::raw("SUM(CASE WHEN activity_type='IN' THEN quantity ELSE 0 END) as stock_in"),
    //                 DB::raw("SUM(CASE WHEN activity_type='OUT' THEN quantity ELSE 0 END) as stock_out")
    //             )
    //             ->whereYear('created_at', now()->year)
    //             ->groupBy('month')
    //             ->get()
    //             ->keyBy('month');

    //         foreach (range(1, 12) as $m) {
    //             $data['stock_in'][] = $records[$m]->stock_in ?? 0;
    //             $data['stock_out'][] = $records[$m]->stock_out ?? 0;
    //         }

    //         $labels = array_values($labels);
    //     }

    //     return response()->json([
    //         'labels' => $labels,
    //         'stock_in' => $data['stock_in'],
    //         'stock_out' => $data['stock_out'],
    //     ]);
    // }

    // public function purchaseRequisitionChart(Request $request)
    // {
    //     $filter = $request->get('filter', 'month'); // week, month, year

    //     $labels = [];
    //     $data = ['purchases' => [], 'requisitions' => []];

    //     if ($filter === 'week') {
    //         $start = now()->startOfWeek();
    //         $end = now()->endOfWeek();

    //         $dates = [];
    //         for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
    //             $dates[] = $date->format('l'); // Full weekday name (Monday, Tuesday...)
    //         }
    //         $labels = $dates;

    //         $purchaseRecords = DB::table('purchase_details')
    //             ->select(
    //                 DB::raw("DAYNAME(created_at) as day"),
    //                 DB::raw("SUM(quantity) as total")
    //             )
    //             ->whereBetween('created_at', [$start, $end])
    //             ->groupBy('day')
    //             ->pluck('total', 'day');

    //         $requisitionRecords = DB::table('requisition_details')
    //             ->select(
    //                 DB::raw("DAYNAME(created_at) as day"),
    //                 DB::raw("SUM(quantity) as total")
    //             )
    //             ->whereBetween('created_at', [$start, $end])
    //             ->groupBy('day')
    //             ->pluck('total', 'day');

    //         foreach ($labels as $day) {
    //             $data['purchases'][] = $purchaseRecords[$day] ?? 0;
    //             $data['requisitions'][] = $requisitionRecords[$day] ?? 0;
    //         }
    //     }
    //     elseif ($filter === 'month') {
    //         $start = now()->startOfMonth();
    //         $end = now()->endOfMonth();
    //         $totalDays = $start->diffInDays($end) + 1;
    //         $weeks = ceil($totalDays / 7);

    //         $labels = [];
    //         for ($i = 1; $i <= $weeks; $i++) $labels[] = "Week $i";

    //         $purchaseRecords = DB::table('purchase_details')
    //             ->select(
    //                 DB::raw("FLOOR((DAY(created_at)-1)/7)+1 as week"),
    //                 DB::raw("SUM(quantity) as total")
    //             )
    //             ->whereBetween('created_at', [$start, $end])
    //             ->groupBy('week')
    //             ->pluck('total', 'week');

    //         $requisitionRecords = DB::table('requisition_details')
    //             ->select(
    //                 DB::raw("FLOOR((DAY(created_at)-1)/7)+1 as week"),
    //                 DB::raw("SUM(quantity) as total")
    //             )
    //             ->whereBetween('created_at', [$start, $end])
    //             ->groupBy('week')
    //             ->pluck('total', 'week');

    //         foreach (range(1, $weeks) as $w) {
    //             $data['purchases'][] = $purchaseRecords[$w] ?? 0;
    //             $data['requisitions'][] = $requisitionRecords[$w] ?? 0;
    //         }
    //     }
    //     elseif ($filter === 'year') {
    //         $labels = [];
    //         for ($i = 1; $i <= 12; $i++) $labels[$i] = Carbon::create()->month($i)->format('F');

    //         $purchaseRecords = DB::table('purchase_details')
    //             ->select(
    //                 DB::raw("MONTH(created_at) as month"),
    //                 DB::raw("SUM(quantity) as total")
    //             )
    //             ->whereYear('created_at', now()->year)
    //             ->groupBy('month')
    //             ->pluck('total', 'month');

    //         $requisitionRecords = DB::table('requisition_details')
    //             ->select(
    //                 DB::raw("MONTH(created_at) as month"),
    //                 DB::raw("SUM(quantity) as total")
    //             )
    //             ->whereYear('created_at', now()->year)
    //             ->groupBy('month')
    //             ->pluck('total', 'month');

    //         foreach (range(1, 12) as $m) {
    //             $data['purchases'][] = $purchaseRecords[$m] ?? 0;
    //             $data['requisitions'][] = $requisitionRecords[$m] ?? 0;
    //         }

    //         $labels = array_values($labels);
    //     }

    //     return response()->json([
    //         'labels' => $labels,
    //         'purchases' => $data['purchases'],
    //         'requisitions' => $data['requisitions'],
    //     ]);
    // }

}
