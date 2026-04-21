@extends('layouts.app')

@section('title', $property->title . ' - Angorenda')
@section('meta_description', Str::limit($property->description, 160))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-8">
    
    <!-- Breadcrumb -->
    <nav class="flex text-sm text-gray-500 gap-2 mb-6" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="hover:text-gray-900">Início</a>
        <span>/</span>
        <a href="{{ route('properties.index') }}" class="hover:text-gray-900">Imóveis</a>
        <span>/</span>
        <a href="{{ route('properties.index', ['city' => $property->city]) }}" class="hover:text-gray-900">{{ $property->city }}</a>
        <span>/</span>
        <span class="text-gray-900 truncate" aria-current="page">{{ Str::limit($property->title, 30) }}</span>
    </nav>

    <!-- Header -->
    <div class="mb-6">
        <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <span class="px-2.5 py-1 text-xs font-semibold rounded-lg {{ $property->purpose === 'sale' ? 'bg-brand-100 text-brand-700' : 'bg-emerald-100 text-emerald-700' }}">
                        {{ $property->purpose_label }}
                    </span>
                    <span class="px-2.5 py-1 text-xs font-medium bg-gray-100 text-gray-700 rounded-lg uppercase tracking-wide">
                        {{ $property->property_type }}
                    </span>
                </div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">{{ $property->title }}</h1>
                <div class="flex items-center text-gray-500 gap-1.5">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span>{{ $property->address }}, {{ $property->city }}</span>
                </div>
            </div>
            <div class="md:text-right">
                <div class="text-3xl font-bold text-gray-900">{{ $property->formatted_price }}</div>
            </div>
        </div>
    </div>

    <!-- Gallery -->
    <div x-data="{ open: false, activeIndex: 0, images: [
        @foreach($property->images as $image)
            '{{ asset('storage/' . $image->image_path) }}',
        @endforeach
    ] }" class="mb-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-2 md:gap-4 md:h-[500px]">
            @if($property->images->count() > 0)
                <!-- Main Image -->
                <div @click="open = true; activeIndex = 0" class="md:col-span-3 md:col-start-1 relative rounded-2xl overflow-hidden h-64 md:h-full bg-gray-100 group cursor-pointer">
                    <img src="{{ asset('storage/' . $property->images->first()->image_path) }}" alt="{{ $property->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                </div>
                
                <!-- Side Images -->
                <div class="grid grid-cols-3 md:grid-cols-1 md:col-span-1 gap-2 md:gap-4 h-24 md:h-full">
                    @foreach($property->images->skip(1)->take(3) as $key => $image)
                        <div @click="open = true; activeIndex = {{ $key + 1 }}" class="relative rounded-xl overflow-hidden bg-gray-100 h-full group cursor-pointer">
                            <img src="{{ asset('storage/' . ($image->thumbnail_path ?? $image->image_path)) }}" alt="Foto {{ $key + 2 }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @if($loop->last && $property->images->count() > 4)
                                <div class="absolute inset-0 bg-gray-900/40 flex items-center justify-center hover:bg-gray-900/50 transition-colors">
                                    <span class="text-white font-semibold text-lg drop-shadow-md">+{{ $property->images->count() - 4 }}</span>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="md:col-span-4 rounded-2xl border-2 border-dashed border-gray-200 bg-gray-50 flex flex-col items-center justify-center h-64 md:h-full text-gray-400">
                    <svg class="w-16 h-16 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>Sem imagens disponíveis</span>
                </div>
            @endif
        </div>

        <!-- Alpine Lightbox Modal -->
        <template x-teleport="body">
            <div x-show="open" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/95 backdrop-blur-sm" x-cloak 
                 @keydown.escape.window="open = false" 
                 @keydown.left.window="activeIndex = activeIndex > 0 ? activeIndex - 1 : images.length - 1" 
                 @keydown.right.window="activeIndex = activeIndex < images.length - 1 ? activeIndex + 1 : 0">
                
                <!-- Overlay background clickable to close -->
                <div class="absolute inset-0 z-0" @click="open = false"></div>

                <!-- Close Button -->
                <button @click="open = false" class="absolute top-4 right-4 md:top-6 md:right-6 text-white hover:text-gray-300 z-20 transition-colors bg-white/10 hover:bg-white/20 p-2 rounded-full">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>

                <!-- Navigation Controls Desktop -->
                <button @click.stop="activeIndex = activeIndex > 0 ? activeIndex - 1 : images.length - 1" class="absolute left-2 md:left-6 top-1/2 -translate-y-1/2 text-white hover:text-brand-400 z-20 transition-colors bg-white/10 hover:bg-white/20 p-3 rounded-full hidden sm:block">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <button @click.stop="activeIndex = activeIndex < images.length - 1 ? activeIndex + 1 : 0" class="absolute right-2 md:right-6 top-1/2 -translate-y-1/2 text-white hover:text-brand-400 z-20 transition-colors bg-white/10 hover:bg-white/20 p-3 rounded-full hidden sm:block">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>

                <!-- Image Main Container -->
                <div class="w-full max-w-6xl md:max-h-[90vh] px-4 mx-auto flex items-center justify-center relative z-10 pointers-none">
                    <img :src="images[activeIndex]" class="pointers-auto w-auto h-auto max-w-full max-h-[85vh] md:max-h-[90vh] object-contain rounded-lg shadow-2xl transition-opacity duration-300">
                    
                    <!-- Mobile tap left/right regions (Invisible) -->
                    <div @click.stop="activeIndex = activeIndex > 0 ? activeIndex - 1 : images.length - 1" class="absolute left-0 top-0 bottom-0 w-1/3 sm:hidden z-20 pointers-auto"></div>
                    <div @click.stop="activeIndex = activeIndex < images.length - 1 ? activeIndex + 1 : 0" class="absolute right-0 top-0 bottom-0 w-1/3 sm:hidden z-20 pointers-auto"></div>
                </div>

                <!-- Pagination Counter -->
                <div class="absolute bottom-6 left-1/2 -translate-x-1/2 text-white bg-black/60 px-5 py-2 rounded-full text-sm font-medium tracking-widest z-20">
                    <span x-text="activeIndex + 1"></span> / <span x-text="images.length"></span>
                </div>
            </div>
        </template>
    </div>

    <!-- Main Content & Sidebar -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Content -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Overview -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Visão Geral</h3>
                <div class="flex flex-wrap gap-4 sm:gap-8">
                    @if($property->bedrooms > 0)
                    <div class="flex flex-col">
                        <span class="text-sm text-gray-500 mb-1">Quartos</span>
                        <div class="flex items-center gap-2 text-gray-900 font-medium">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            {{ $property->bedrooms }}
                        </div>
                    </div>
                    @endif
                    
                    @if($property->bathrooms > 0)
                    <div class="flex flex-col">
                        <span class="text-sm text-gray-500 mb-1">Casas de banho</span>
                        <div class="flex items-center gap-2 text-gray-900 font-medium">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/></svg>
                            {{ $property->bathrooms }}
                        </div>
                    </div>
                    @endif

                    @if($property->area > 0)
                    <div class="flex flex-col">
                        <span class="text-sm text-gray-500 mb-1">Área útil</span>
                        <div class="flex items-center gap-2 text-gray-900 font-medium">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                            {{ $property->area }} m²
                        </div>
                    </div>
                    @endif
                    
                    <div class="flex flex-col">
                        <span class="text-sm text-gray-500 mb-1">Referência</span>
                        <div class="flex items-center gap-2 text-gray-900 font-medium">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/></svg>
                            REF-{{ str_pad($property->id, 4, '0', STR_PAD_LEFT) }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Descrição do Imóvel</h3>
                <div class="prose prose-gray max-w-none text-gray-600 space-y-4">
                    {!! nl2br(e($property->description)) !!}
                </div>
            </div>
        </div>

        <!-- Sidebar / Contact -->
        <div class="lg:col-span-1">
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm sticky top-24">
                <div class="text-center mb-6">
                    <div class="w-16 h-16 bg-brand-100 text-brand-600 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-3">
                        {{ substr($property->user->name, 0, 1) }}
                    </div>
                    <h4 class="font-semibold text-gray-900">{{ $property->user->name }}</h4>
                    <p class="text-xs text-gray-500 mt-1 uppercase">{{ $property->user->type ?? 'Anunciante' }}</p>
                </div>

                <div class="space-y-3">
                    @php
                        $phone = $property->user->phone ?? '';
                        $waNum = preg_replace('/[^0-9]/', '', $phone);
                        $hasPhone = !empty($phone);
                    @endphp

                    @if($hasPhone)
                        <!-- WhatsApp Button -->
                        <a href="https://wa.me/{{ $waNum }}?text={{ urlencode('Olá! Tenho interesse no imóvel REF-' . str_pad($property->id, 4, '0', STR_PAD_LEFT) . ' - ' . $property->title . ' que está no Angorenda.') }}" target="_blank" class="w-full flex justify-center items-center gap-2 px-4 py-3 bg-[#25D366] text-white font-medium rounded-xl hover:bg-[#20bd5a] transition-colors shadow-sm">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                            WhatsApp
                        </a>
                        
                        <!-- Call Button -->
                        <a href="tel:{{ $phone }}" class="w-full flex justify-center items-center gap-2 px-4 py-3 bg-white text-gray-700 border border-gray-300 font-medium rounded-xl hover:bg-gray-50 transition-colors shadow-sm">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            {{ $phone }}
                        </a>
                    @else
                        <div class="p-4 bg-gray-50 rounded-xl text-center text-sm text-gray-500">
                            Contacto telefónico não disponibilizado pelo anunciante.
                        </div>
                    @endif
                </div>

                <div class="mt-6 pt-4 border-t border-gray-100 flex items-center gap-2 text-xs text-gray-500">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <span>Diga que encontrou no Angorenda ao contactar.</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Properties -->
    @if($relatedProperties->count() > 0)
    <div class="mt-16 pt-10 border-t border-gray-200">
        <h3 class="text-xl font-bold text-gray-900 mb-6">Imóveis que também pode gostar</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($relatedProperties as $relProperty)
                <a href="{{ route('properties.show', $relProperty->slug) }}" class="group bg-white rounded-2xl overflow-hidden border border-gray-200 shadow-sm hover:shadow-md transition-all duration-200 flex flex-col h-full hover:-translate-y-1">
                    <div class="relative w-full pb-[70%] bg-gray-100 overflow-hidden">
                        @if($relProperty->main_image)
                            <img src="{{ asset('storage/' . ($relProperty->main_image->thumbnail_path ?? $relProperty->main_image->image_path)) }}" alt="{{ $relProperty->title }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @endif
                        <div class="absolute top-3 left-3">
                            <span class="px-2 py-1 text-xs font-semibold rounded-md shadow-sm {{ $relProperty->purpose === 'sale' ? 'bg-brand-100 text-brand-700' : 'bg-emerald-100 text-emerald-700' }}">
                                {{ $relProperty->purpose_label }}
                            </span>
                        </div>
                    </div>
                    <div class="p-4 flex flex-col flex-grow">
                        <div class="text-xs font-medium text-brand-600 mb-1 uppercase tracking-wider">{{ ucfirst($relProperty->property_type) }}</div>
                        <h4 class="font-semibold text-gray-900 text-sm mb-1 line-clamp-1 group-hover:text-brand-600 transition-colors">{{ $relProperty->title }}</h4>
                        <div class="flex items-center text-xs text-gray-500 mb-2 truncate gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                            {{ $relProperty->city }}
                        </div>
                        <div class="mt-auto pt-2 font-bold text-gray-900">
                            {{ $relProperty->formatted_price }}
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
