@extends('layouts.app')

@section('title', 'Filtrar Imóveis - Angorenda')

@section('content')
<div class="bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Encontre o seu imóvel ideal</h1>
        <p class="text-gray-600 mb-8 max-w-2xl">Pesquise entre milhares de propriedades disponíveis para venda ou arrendamento em Angola.</p>

        <!-- Search Form -->
        <form action="{{ route('properties.index') }}" method="GET" class="bg-gray-50 p-4 md:p-6 rounded-2xl border border-gray-100 shadow-sm">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="md:col-span-2 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Ex: T3 em Talatona, Vivenda no Zango..." class="w-full pl-10 pr-4 py-3 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none transition-all placeholder:text-gray-400">
                </div>
                
                <div>
                    <select name="purpose" class="w-full px-4 py-3 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none appearance-none transition-all">
                        <option value="">Qualquer finalidade</option>
                        <option value="sale" {{ request('purpose') == 'sale' ? 'selected' : '' }}>Comprar</option>
                        <option value="rent" {{ request('purpose') == 'rent' ? 'selected' : '' }}>Arrendar</option>
                    </select>
                </div>

                <div>
                    <select name="property_type" class="w-full px-4 py-3 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none appearance-none transition-all">
                        <option value="">Qualquer tipo</option>
                        <option value="apartamento" {{ request('property_type') == 'apartamento' ? 'selected' : '' }}>Apartamento</option>
                        <option value="casa" {{ request('property_type') == 'casa' ? 'selected' : '' }}>Casa</option>
                        <option value="vivenda" {{ request('property_type') == 'vivenda' ? 'selected' : '' }}>Vivenda</option>
                        <option value="terreno" {{ request('property_type') == 'terreno' ? 'selected' : '' }}>Terreno</option>
                        <option value="escritorio" {{ request('property_type') == 'escritorio' ? 'selected' : '' }}>Escritório</option>
                        <option value="loja" {{ request('property_type') == 'loja' ? 'selected' : '' }}>Loja</option>
                    </select>
                </div>
                
                <div class="md:col-span-full flex justify-between items-center mt-2">
                    <button type="submit" class="px-6 py-3 bg-brand-600 text-white font-medium rounded-xl hover:bg-brand-700 transition-colors shadow-sm w-full md:w-auto flex justify-center items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        Pesquisar Imóveis
                    </button>
                    @if(request()->hasAny(['q', 'purpose', 'property_type', 'city']))
                        <a href="{{ route('properties.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-900 hidden md:block">Limpar filtros</a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    
    <div class="flex justify-between items-end mb-6">
        <div>
            <h2 class="text-xl font-semibold text-gray-900">Resultados da pesquisa</h2>
            <p class="text-sm text-gray-500 mt-1">{{ $properties->total() }} imóveis encontrados</p>
        </div>
    </div>

    @if($properties->count() > 0)
        <!-- Grid de Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($properties as $property)
                <a href="{{ route('properties.show', $property->slug) }}" class="group bg-white rounded-2xl overflow-hidden border border-gray-200 shadow-sm hover:shadow-md transition-all duration-200 flex flex-col h-full hover:-translate-y-1">
                    <!-- Imagem -->
                    <div class="relative w-full pb-[70%] bg-gray-100 overflow-hidden">
                        @if($property->main_image)
                            <img src="{{ asset('storage/' . ($property->main_image->thumbnail_path ?? $property->main_image->image_path)) }}" alt="{{ $property->title }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="absolute inset-0 flex items-center justify-center text-gray-400">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                        @endif
                        
                        <!-- Badges -->
                        <div class="absolute top-3 left-3 flex gap-2">
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-lg shadow-sm {{ $property->purpose === 'sale' ? 'bg-brand-100 text-brand-700' : 'bg-emerald-100 text-emerald-700' }}">
                                {{ $property->purpose_label }}
                            </span>
                        </div>
                        @if($property->images->count() > 1)
                            <div class="absolute bottom-3 right-3 bg-gray-900/70 backdrop-blur-sm text-white text-xs font-medium px-2 py-1 rounded-md flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                {{ $property->images->count() }}
                            </div>
                        @endif
                    </div>

                    <!-- Conteúdo -->
                    <div class="p-5 flex flex-col flex-grow">
                        <div class="text-xs font-medium text-brand-600 mb-1 uppercase tracking-wider">{{ ucfirst($property->property_type) }}</div>
                        <h3 class="font-semibold text-gray-900 text-lg mb-1 line-clamp-1 group-hover:text-brand-600 transition-colors">{{ $property->title }}</h3>
                        
                        <!-- Location -->
                        <div class="flex items-center text-sm text-gray-500 mb-3 gap-1">
                            <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span class="truncate">{{ $property->city }}</span>
                        </div>

                        <!-- Amenities -->
                        <div class="grid grid-cols-3 gap-2 mt-auto pt-3 border-t border-gray-100 text-sm text-gray-600">
                            @if($property->bedrooms > 0)
                            <div class="flex items-center gap-1.5" title="Quartos">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                <span>{{ $property->bedrooms }}</span>
                            </div>
                            @endif
                            @if($property->bathrooms > 0)
                            <div class="flex items-center gap-1.5" title="Casas de banho">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/></svg>
                                <span>{{ $property->bathrooms }}</span>
                            </div>
                            @endif
                            @if($property->area > 0)
                            <div class="flex items-center gap-1.5" title="Área">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                                <span>{{ $property->area }}m²</span>
                            </div>
                            @endif
                        </div>

                        <!-- Price -->
                        <div class="mt-4 text-lg font-bold text-gray-900">
                            {{ $property->formatted_price }}
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <!-- Paginação -->
        <div class="mt-10">
            {{ $properties->links('pagination::tailwind') }}
        </div>
    @else
        <div class="text-center py-20 bg-white rounded-2xl border border-gray-100 shadow-sm">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <h3 class="text-lg font-medium text-gray-900 mb-1">Nenhum imóvel encontrado</h3>
            <p class="text-gray-500">Tente ajustar os seus filtros de pesquisa para ver mais resultados.</p>
            @if(request()->hasAny(['q', 'purpose', 'property_type', 'city']))
                <a href="{{ route('properties.index') }}" class="inline-block mt-4 px-4 py-2 text-sm font-medium text-brand-600 bg-brand-50 rounded-lg hover:bg-brand-100 transition-colors">Limpar filtros</a>
            @endif
        </div>
    @endif
</div>
@endsection
