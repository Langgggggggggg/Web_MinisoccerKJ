@extends('landing_page.utama')

@section('content')
<section class="py-12 bg-gray-50 min-h-[70vh]">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">Informasi & Berita</h2>
            <div class="w-20 h-1 bg-rose-500 mx-auto"></div>
            <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">Temukan informasi terbaru dan berita penting dari kami
            </p>
        </div>

        <!-- Cards Container -->
        <div class="grid grid-cols-1 gap-8">
            @foreach ($informations as $info)
            <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg border border-gray-100">
                <div class="flex flex-col md:flex-row">
                    <!-- Image Container -->
                    @if ($info->thumbnail)
                    <div class="md:w-1/3 lg:w-1/4 flex-shrink-0">
                        <div class="h-full">
                            <img src="{{ asset('storage/' . $info->thumbnail) }}" alt="{{ $info->title }}"
                                class="w-full h-full object-cover object-center md:h-full" style="min-height: 200px">
                        </div>
                    </div>
                    @endif

                    <!-- Content Container -->
                    <div class="flex-1 p-6 md:p-8 flex flex-col justify-between">
                        <div>
                            <!-- Date & Category -->
                            <div class="flex items-center mb-3 flex-wrap">
                                <span class="flex items-center text-gray-500 text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ \Carbon\Carbon::parse($info->created_at)->format('d M Y') }}
                                </span>
                                <span
                                    class="ml-3 bg-rose-500 text-white px-3 py-1 rounded-full text-xs font-medium">
                                    {{ $info->category }}
                                </span>
                            </div>

                            <!-- Title -->
                            <h3 class="text-xl md:text-2xl font-bold text-gray-900 mb-3">{{ $info->title }}</h3>

                            <!-- Content Preview -->
                            <div class="text-gray-600 mb-4 line-clamp-3">
                                {{ \Illuminate\Support\Str::limit(strip_tags($info->content), 150) }}
                            </div>
                        </div>

                        <!-- Read More Button -->
                        <div class="mt-4">
                            <a href="{{ route('information.show', $info->slug) }}"
                                class="inline-flex items-center px-4 py-2 bg-rose-500 hover:bg-rose-600 text-white rounded-lg transition-colors duration-200">
                                <span>Baca Selengkapnya</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination if needed -->
        @if(isset($informations) && method_exists($informations, 'links'))
        <div class="mt-10">
            {{ $informations->links() }}
        </div>
        @endif
    </div>
</section>
@endsection