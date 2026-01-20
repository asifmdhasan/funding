<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HelpseekerPost;

class HelpseekerPostController extends Controller
{
    public function publicIndex()
    {
        $posts = HelpseekerPost::with(['helpseeker', 'donations'])
            ->where('status', 'approved')
            ->latest()
            ->get();

        return view('frontend.helpseeker.posts.public_index', compact('posts'));
    }
    public function show(HelpseekerPost $post)
    {
        $post = HelpseekerPost::with(['helpseeker', 'donations.donor'])
            ->where('id', $post->id)
            ->where('status', 'approved')
            ->firstOrFail();

        return view('frontend.helpseeker.posts.show', compact('post'));
    }
    //helpDonate
    public function donate(HelpseekerPost $post)
    {
        return view('frontend.helpseeker.posts.donate', compact('post'));
    }

    public function index()
    {
        $posts = auth('helpseeker')->user()->posts()->latest()->get();
        return view('frontend.helpseeker.posts.index', compact('posts'));
    }

    public function donations(HelpseekerPost $post)
    {
        // Check if the logged-in helpseeker owns this post
        if ($post->helpseeker_id !== auth('helpseeker')->id()) {
            abort(403);
        }

        // Get donations for this post
        $donations = $post->donations()->with('donor')->latest()->get();

        // Total collected amount
        $totalAmount = $donations->sum('amount');

        return view('frontend.helpseeker.posts.donations', compact('post', 'donations', 'totalAmount'));
    }

    public function printDonations(HelpseekerPost $post)
    {
        // Ensure the logged-in helpseeker owns this post
        if ($post->helpseeker_id !== auth('helpseeker')->id()) {
            abort(403);
        }

        // Get donations
        $donations = $post->donations()->with('donor')->latest()->get();
        $totalAmount = $donations->sum('amount');

        // Load Blade view as HTML
        $html = view('frontend.helpseeker.posts.donations-print', compact('post', 'donations', 'totalAmount'))->render();

        // Create PDF
        $mpdf = new \Mpdf\Mpdf([
            'format' => 'A4',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 10,
            'margin_bottom' => 10,
        ]);

        $mpdf->WriteHTML($html);

        // Output PDF in browser
        return $mpdf->Output("Donations_{$post->title}.pdf", 'I');
    }




    public function create()
    {
        return view('frontend.helpseeker.posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'           => 'required|string|max:255',
            'reason'          => 'required|string',
            'required_amount' => 'required|numeric|min:1',
            'file'            => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf,webp,doc,docx|max:5120',
        ]);

        $data = $request->only(['title','reason','required_amount']);

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('assets/files/help_posts'), $fileName);
            $data['file_path'] = 'assets/files/help_posts/' . $fileName;
        }

        auth('helpseeker')->user()->posts()->create($data + ['status' => 'pending']);

        return redirect()->route('helpseeker.posts.index')->with('success', 'Post created successfully.');
    }


    public function edit(HelpseekerPost $post)
    {
        //no authorize needed as route model binding with auth user
        $post = HelpseekerPost::where('id', $post->id)
            ->where('helpseeker_id', auth('helpseeker')->id())
            ->firstOrFail();
        
        return view('frontend.helpseeker.posts.edit', compact('post'));
    }

    public function update(Request $request, HelpseekerPost $post)
    {
        $post = HelpseekerPost::where('id', $post->id)
            ->where('helpseeker_id', auth('helpseeker')->id())
            ->firstOrFail();

        $request->validate([
            'title'           => 'required|string|max:255',
            'reason'          => 'required|string',
            'required_amount' => 'required|numeric|min:1',
            'file'            => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf,doc,docx,webp|max:5120',
        ]);

        $data = $request->only(['title','reason','required_amount']);

        // Handle file upload (replace old if exists)
        if ($request->hasFile('file')) {
            // Delete old file if exists
            if ($post->file_path && file_exists(public_path($post->file_path))) {
                unlink(public_path($post->file_path));
            }

            $file = $request->file('file');
            $fileName = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('assets/files/help_posts'), $fileName);
            $data['file_path'] = 'assets/files/help_posts/' . $fileName;
        }

        $post->update($data + ['status' => 'pending']);

        return redirect()->route('helpseeker.posts.index')->with('success', 'Post updated successfully.');
    }

    public function destroy(HelpseekerPost $post)
    {
        //no authorize needed as route model binding with auth user need normally
        $post = HelpseekerPost::where('id', $post->id)
            ->where('helpseeker_id', auth('helpseeker')->id())
            ->firstOrFail();

        $post->delete();

        return redirect()->route('helpseeker.posts.index')->with('success', 'Post deleted successfully.');
    }


    //helpDonate
    // public function helpDonate(HelpseekerPost $post)
    // {
    //     return view('frontend.helpseeker.posts.donate', compact('post'));
    // }
    
}
