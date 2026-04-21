@extends('layouts.app')

@section('title', 'A Minha Conta - Angorenda')

@section('content')
<div class="bg-gray-50 flex-grow py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="md:flex md:items-center md:justify-between mb-8">
            <div class="flex-1 min-w-0">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    Os Meus Imóveis
                </h2>
                <p class="mt-1 text-sm text-gray-500">Faça a gestão dos imóveis que publicou no portal.</p>
            </div>
            <div class="mt-4 flex md:mt-0 md:ml-4">
                <a href="{{ route('owner.properties.create') }}" class="ml-3 inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-brand-600 hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    Adicionar Imóvel
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-r-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="bg-white shadow-sm overflow-hidden sm:rounded-2xl border border-gray-100">
            <ul role="list" class="divide-y divide-gray-200">
                @forelse($properties as $property)
                    <li>
                        <div class="px-4 py-4 sm:px-6 hover:bg-gray-50 transition-colors">
                            <div class="flex items-center justify-between">
                                <div class="flex gap-4 items-center min-w-0">
                                    <div class="w-16 h-16 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                                        @if($property->main_image)
                                            <img src="{{ asset('storage/' . ($property->main_image->thumbnail_path ?? $property->main_image->image_path)) }}" alt="Thumb" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-400"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-sm font-medium text-brand-600 truncate uppercase">{{ ucfirst($property->property_type) }}</p>
                                        <div class="flex items-center mt-1">
                                            <p class="text-base font-semibold text-gray-900 truncate">{{ $property->title }}</p>
                                        </div>
                                        <div class="flex items-center gap-3 mt-1 text-xs text-gray-500">
                                            <span>{{ $property->formatted_price }}</span>
                                            <span>&bull;</span>
                                            <span class="{{ $property->is_active ? 'text-green-600' : 'text-yellow-600' }}">{{ $property->is_active ? 'Visível ao público' : 'Escondido' }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-shrink-0 ml-5 gap-2">
                                    <a href="{{ route('properties.show', $property->slug) }}" target="_blank" class="p-2 border border-blue-200 rounded-lg text-blue-600 hover:bg-blue-50 transition" title="Ver no site">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                    <a href="{{ route('owner.properties.edit', $property) }}" class="p-2 border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-50 transition" title="Editar">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <form action="{{ route('owner.properties.destroy', $property) }}" method="POST" onsubmit="return confirm('Tem a certeza que deseja eliminar completamente este imóvel? Esta ação é irreversível.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 border border-red-200 rounded-lg text-red-600 hover:bg-red-50 transition" title="Eliminar">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </li>
                @empty
                    <li>
                        <div class="px-4 py-12 text-center sm:px-6">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Sem imóveis publicados</h3>
                            <p class="mt-1 text-sm text-gray-500">Comece já a preencher a sua carteira de anúncios criando o seu primeiro imóvel.</p>
                            <div class="mt-6">
                                <a href="{{ route('owner.properties.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-brand-600 hover:bg-brand-700">
                                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                                    Adicionar Imóvel
                                </a>
                            </div>
                        </div>
                    </li>
                @endforelse
            </ul>
        </div>
        
        <div class="mt-6">
            {{ $properties->links('pagination::tailwind') }}
        </div>
    </div>
</div>
@endsection
