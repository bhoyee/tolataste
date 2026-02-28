@extends('layout')
@section('title')
    <title>{{ $seo_setting->seo_title }}</title>
@endsection
@section('meta')
    <meta name="description" content="{{ $seo_setting->seo_description }}">
@endsection

@section('public-content')


    <!--=============================
        BREADCRUMB START
    ==============================-->
    <section class="wsus__breadcrumb" style="background: url({{ asset($breadcrumb) }});">
        <div class="wsus__breadcrumb_overlay">
            <div class="container">
                <div class="wsus__breadcrumb_text">
                    <h1>{{__('user.Our Blogs')}}</h1>
                    <ul>
                        <li><a href="{{ route('home') }}">{{__('user.Home')}}</a></li>
                        <li><a href="{{ route('blogs') }}">{{__('user.Our Blogs')}}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
        BREADCRUMB END
    ==============================-->


        <!--=============================
        BLOG PAGE START
    ==============================-->
    <section class="wsus__blog_page mt_120 xs_mt_65 mb_100 xs_mb_70">
        <div class="container">
            @if ($blogs->count() == 0)
                <div class="row">
                    <div class="col-12 text-center">
                        <h2 class="text-danger text-center">{{__('user.Blog Not Found')}}</h2>
                    </div>
                </div>
            @else
                <div class="row">
                    @foreach ($blogs as $index => $single_blog)
                        <div class="col-xl-4 col-sm-6 col-lg-4 wow fadeInUp" data-wow-duration="1s">
                            <div class="wsus__single_blog">
                                <a href="{{ route('show-blog', $single_blog->slug) }}" class="wsus__single_blog_img">
                                    <img src="{{ asset($single_blog->image) }}" alt="blog" class="img-fluid w-100">
                                </a>
                                <div class="wsus__single_blog_text">
                                    <a class="category" href="{{ route('blogs', ['category' => $single_blog->category->slug ]) }}">{{ $single_blog->category->name_translated }}</a>
                                    <ul class="d-flex flex-wrap mt_15">
                                        <li><i class="fas fa-user"></i>{{__('user.by admin')}}</li>
                                        <li><i class="fas fa-calendar-alt"></i> {{ $single_blog->created_at->format('d M Y') }}</li>
                                        <li><i class="fas fa-comments"></i> {{ $single_blog->total_comment }}{{__('user.comment')}}</li>
                                    </ul>
                                    <a class="title" href="{{ route('show-blog', $single_blog->slug) }}">{{ $single_blog->title_translated }}</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="wsus__pagination mt_35">
                    {{ $blogs->links('custom_paginator') }}
                </div>
            @endif
        </div>
    </section>
    <!--=============================
        BLOG PAGE END
    ==============================-->


@endsection
