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
        ]);

        auth('helpseeker')->user()->posts()->create([
            'title'           => $request->title,
            'reason'          => $request->reason,
            'required_amount' => $request->required_amount,
            'status'          => 'pending', // default pending
        ]);

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
        //no authorize needed as route model binding with auth user need normally
        $post = HelpseekerPost::where('id', $post->id)
            ->where('helpseeker_id', auth('helpseeker')->id())
            ->firstOrFail();

        $request->validate([
            'title'           => 'required|string|max:255',
            'reason'          => 'required|string',
            'required_amount' => 'required|numeric|min:1',
        ]);

        $post->update($request->only('title','reason','required_amount') + ['status' => 'pending']);

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
    
}
