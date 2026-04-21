@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<div class="relative bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto">
        <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32 pt-16 md:pt-24 px-4 sm:px-6 lg:px-8">
            <main class="mx-auto max-w-7xl">
                <div class="sm:text-center lg:text-left">
                    <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl mb-6">
                        <span class="block">Encontre o seu imóvel</span>
                        <span class="block text-brand-600">perfeito em Angola</span>
                    </h1>
                    <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0 mb-8">
                        A plataforma mais completa para compra, venda e arrendamento de imóveis. Casas, apartamentos, terrenos e espaços comerciais.
                    </p>
                    
                    <!-- Search Widget -->
                    <div class="bg-white p-4 rounded-2xl shadow-lg border border-gray-100 max-w-2xl">
                        <form action="{{ route('properties.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                            <div class="flex-grow">
                                <label for="q" class="sr-only">Pesquisar</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                    </div>
                                    <input type="text" name="q" id="q" placeholder="Ex: Luanda, Talatona, T3..." class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-brand-500 focus:border-brand-500 sm:text-sm transition duration-150 ease-in-out">
                                </div>
                            </div>
                            <div>
                                <select name="purpose" class="block w-full pl-3 pr-10 py-3 text-base border-gray-300 border focus:outline-none focus:ring-brand-500 focus:border-brand-500 sm:text-sm rounded-xl">
                                    <option value="">Comprar ou Arrendar</option>
                                    <option value="sale">Comprar</option>
                                    <option value="rent">Arrendar</option>
                                </select>
                            </div>
                            <button type="submit" class="w-full sm:w-auto flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-brand-600 hover:bg-brand-700 md:py-3 md:text-lg md:px-10 transition-colors shadow-sm">
                                Buscar
                            </button>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <div class="hidden lg:block lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
        <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full" src="https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" alt="Casa moderna">
        <div class="absolute inset-0 bg-gradient-to-r from-white to-transparent"></div>
    </div>
</div>

<!-- Categories Section -->
<div class="bg-gray-50 py-12 sm:py-16 border-t border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h2 class="text-2xl font-bold text-gray-900">Explore por categorias</h2>
            <p class="mt-2 text-gray-600">Encontre exatamente o tipo de imóvel que procura.</p>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
            @php
                $categories = [
                    ['name' => 'Apartamentos', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4', 'val' => 'apartamento'],
                    ['name' => 'Casas', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', 'val' => 'casa'],
                    ['name' => 'Vivendas', 'icon' => 'M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z', 'val' => 'vivenda'],
                    ['name' => 'Terrenos', 'icon' => 'M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7', 'val' => 'terreno'],
                    ['name' => 'Escritórios', 'icon' => 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z', 'val' => 'escritorio'],
                ];
            @endphp
            @foreach($categories as $cat)
                <a href="{{ route('properties.index', ['property_type' => $cat['val']]) }}" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:border-brand-500 hover:shadow-md transition-all flex flex-col items-center justify-center text-center group">
                    <div class="w-12 h-12 bg-brand-50 text-brand-600 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $cat['icon'] }}"/></svg>
                    </div>
                    <span class="font-medium text-gray-900">{{ $cat['name'] }}</span>
                </a>
            @endforeach
        </div>
    </div>
</div>

<!-- Featured Properties -->
<div class="py-12 sm:py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-end mb-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Imóveis Recentes</h2>
                <p class="mt-2 text-gray-600">As mais recentes oportunidades no mercado.</p>
            </div>
            <a href="{{ route('properties.index') }}" class="hidden sm:inline-flex text-brand-600 font-medium hover:text-brand-700 items-center gap-1">
                Ver todos
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
        </div>

        @if($featuredProperties->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($featuredProperties as $property)
                    <a href="{{ route('properties.show', $property->slug) }}" class="group bg-white rounded-2xl overflow-hidden border border-gray-200 shadow-sm hover:shadow-md transition-all duration-200 flex flex-col h-full hover:-translate-y-1">
                        <div class="relative w-full pb-[70%] bg-gray-100 overflow-hidden">
                            @if($property->main_image)
                                <img src="{{ asset('storage/' . ($property->main_image->thumbnail_path ?? $property->main_image->image_path)) }}" alt="{{ $property->title }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @endif
                            <div class="absolute top-3 left-3">
                                <span class="px-2 py-1 text-xs font-semibold rounded-md shadow-sm {{ $property->purpose === 'sale' ? 'bg-brand-100 text-brand-700' : 'bg-emerald-100 text-emerald-700' }}">
                                    {{ $property->purpose_label }}
                                </span>
                            </div>
                        </div>
                        <div class="p-4 flex flex-col flex-grow">
                            <div class="text-xs font-medium text-brand-600 mb-1 uppercase tracking-wider">{{ ucfirst($property->property_type) }}</div>
                            <h4 class="font-semibold text-gray-900 text-sm mb-1 line-clamp-1 group-hover:text-brand-600 transition-colors">{{ $property->title }}</h4>
                            <div class="flex items-center text-xs text-gray-500 mb-2 truncate gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                {{ $property->city }}
                            </div>
                            <div class="mt-auto pt-2 font-bold text-gray-900">
                                {{ $property->formatted_price }}
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            
            <div class="mt-8 sm:hidden text-center">
                <a href="{{ route('properties.index') }}" class="inline-flex text-brand-600 font-medium hover:text-brand-700 items-center gap-1">
                    Ver todos os imóveis
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>
        @else
            <div class="text-center py-12 bg-gray-50 rounded-2xl border border-gray-200 border-dashed">
                <p class="text-gray-500">Nenhum imóvel disponível de momento.</p>
            </div>
        @endif
    </div>
</div>

<!-- CTA Announce -->
<div class="bg-brand-900">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
        <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
            <span class="block">É proprietário ou consultor?</span>
            <span class="block text-brand-200">Anuncie gratuitamente no Angorenda.</span>
        </h2>
        <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0">
            <div class="inline-flex rounded-xl shadow">
                <a href="/signup" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-xl text-brand-900 bg-white hover:bg-brand-50 transition-colors">
                    Criar conta grátis
                </a>
            </div>
            <div class="ml-3 inline-flex rounded-xl shadow">
                <a href="/admin/login" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-brand-800 hover:bg-brand-700 transition-colors">
                    Entrar
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
