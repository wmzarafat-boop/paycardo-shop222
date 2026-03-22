@extends('frontend.layouts.main')
@section('title', $page->title)
@section('content')

<section class="py-4" style="background-color: var(--card); border-bottom: 1px solid var(--border-color);">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-muted-custom">Home</a></li>
                <li class="breadcrumb-item active text-primary-custom">{{ $page->title }}</li>
            </ol>
        </nav>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="mb-4 text-white">{{ $page->title }}</h1>
                <hr style="border-color: var(--border-color);">
                <div class="content" style="color: var(--text-secondary);">
                    {!! $page->content !!}
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
