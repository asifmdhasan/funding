<?php

namespace App\Http\Controllers;

use Mpdf\Mpdf;
use App\Models\Donation;
use Illuminate\Http\Request;
use App\Models\HelpseekerPost;

class HelpseekerPostReportController extends Controller
{

public function index(Request $request)
    {
        $posts = Donation::query()
            ->whereNotNull('helpseeker_post_id')
            ->selectRaw('helpseeker_post_id, SUM(amount) as total_amount')
            ->with('helpseekerPost')
            ->when($request->post_id, function ($q) use ($request) {
                $q->where('helpseeker_post_id', $request->post_id);
            })
            ->groupBy('helpseeker_post_id')
            ->paginate(10);

        $postList = HelpseekerPost::orderBy('title')->get();

        return view('helpseekers.posts.report', compact('posts', 'postList'));
    }

    // Detail page for a single post
    public function details(HelpseekerPost $post)
    {
        $donations = Donation::query()
            ->where('helpseeker_post_id', $post->id)
            ->where('status', 'success')
            ->with('donor')
            ->get();

        $totalAmount = $donations->sum('amount');

        return view('helpseekers.posts.post-report-details', compact('post', 'donations', 'totalAmount'));
    }


    
    public function print(HelpseekerPost $post)
    {
        // Get all donations for this post
        $donations = Donation::query()
            ->where('helpseeker_post_id', $post->id)
            ->where('status', 'success')
            ->with('donor')
            ->get();

        $totalAmount = $donations->sum('amount');

        // Load Blade view as HTML
        $html = view('pdf.helpseeker-post-report', compact('post', 'donations', 'totalAmount'))->render();

        // Create PDF
        $mpdf = new Mpdf(['format' => 'A4']);
        $mpdf->WriteHTML($html);

        return $mpdf->Output(
            'helpseeker-post-'.$post->id.'-donations.pdf',
            'I'
        );
    }
}
