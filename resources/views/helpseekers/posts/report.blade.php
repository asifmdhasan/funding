@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <h4 class="fw-bold mb-3">Helpseeker Post Donation Report</h4>

    {{-- Filter --}}
    <div class="card mb-3">
        <div class="card-body row g-3 align-items-end">

            <div class="col-md-6">
                <label class="form-label fw-semibold">Filter by Post</label>
                <form method="GET">
                    <select name="post_id" class="form-select" onchange="this.form.submit()">
                        <option value="">All Posts</option>
                        @foreach($postList as $post)
                            <option value="{{ $post->id }}"
                                {{ request('post_id') == $post->id ? 'selected' : '' }}>
                                {{ $post->title }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>

            <div class="col-md-6">
                <a href="{{ route('helpseekerposts.report') }}" class="btn btn-outline-secondary w-100">Reset Filter</a>
            </div>

        </div>
    </div>

    {{-- Table --}}
    <div class="card">
        <div class="card-body">

            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>Helpseeker</th>
                        <th>Post Title</th>
                        <th>Total Collected</th>
                        <th width="120">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($posts as $row)
                        <tr>
                            <td>{{ $row->helpseekerPost->helpseeker->name ?? 'N/A' }}</td>
                            <td>{{ $row->helpseekerPost->title ?? '' }}</td>
                            <td>{{ number_format($row->total_amount, 2) }} BDT</td>
                            <td>
                                <a href="{{ route('helpseekerposts.report.details', $row->helpseeker_post_id) }}"
                                   class="btn btn-sm btn-primary">
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">No data found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $posts->links() }}

        </div>
    </div>
</div>
@endsection
