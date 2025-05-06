@extends('landing_page.utama')

@section('content')
<section class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="flex items-center text-sm text-gray-500 mb-6">
            <a href="{{ route('landing.information.index') }}" class="hover:text-rose-600 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span class="align-middle">Beranda</span>
            </a>
            <span class="mx-2">›</span>
            <a href="{{ route('landing.information.index') }}" class="hover:text-rose-600 transition-colors">Informasi & Berita</a>
            <span class="mx-2">›</span>
            <span class="text-gray-700 font-medium truncate">{{ $information->title }}</span>
        </nav>

        <!-- Article Card -->
        <article class="bg-white rounded-2xl shadow-md overflow-hidden border border-gray-100">
            <!-- Header Info -->
            <div class="p-6 sm:p-8">
                <!-- Category & Date -->
                <div class="flex flex-wrap items-center mb-4">
                    <span class="bg-rose-500 text-white text-sm font-medium px-4 py-1.5 rounded-full">
                        {{ $information->category }}
                    </span>
                    <div class="flex items-center text-gray-500 ml-4 text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <time datetime="{{ $information->published_at ? $information->published_at->format('Y-m-d') : '' }}">
                            {{ $information->published_at ? $information->published_at->format('d M Y') : '' }}
                        </time>
                    </div>
                </div>

                <!-- Title -->
                <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">{{ $information->title }}</h1>
            </div>

            <!-- Featured Image -->
            @if ($information->thumbnail)
            <div class="w-full">
                <img src="{{ asset('storage/' . $information->thumbnail) }}" 
                    alt="{{ $information->title }}" 
                    class="w-full rounded-none">
            </div>
            @endif

            <!-- Content -->
            <div class="p-6 sm:p-8">
                <div class="prose prose-lg max-w-none prose-headings:text-gray-900 prose-a:text-rose-600 prose-img:rounded-lg prose-img:my-6">
                    {!! $information->content !!}
                </div>

               
            </div>
        </article>

        <!-- Back Button -->
        <div class="mt-8 text-center">
            <a href="{{ route('landing.information.index') }}" 
               class="inline-flex items-center px-5 py-3 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Informasi & Berita
            </a>
        </div>
    </div>
</section>
@endsection