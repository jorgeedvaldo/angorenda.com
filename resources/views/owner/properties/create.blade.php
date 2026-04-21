@extends('layouts.app')

@section('title', 'Adicionar Novo Imóvel - Angorenda')

@section('content')
<div class="bg-gray-50 flex-grow py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8">
            <nav class="flex text-sm text-gray-500 font-medium mb-4" aria-label="Breadcrumb">
                <a href="{{ route('owner.dashboard') }}" class="hover:text-gray-900">Os Meus Imóveis</a>
                <span class="mx-2">/</span>
                <span class="text-gray-900">Novo Imóvel</span>
            </nav>
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                Adicionar Novo Imóvel
            </h2>
        </div>

        @if ($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg">
                <div class="flex">
                    <div class="ml-3">
                        <ul class="text-sm text-red-700 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('owner.properties.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8 divide-y divide-gray-200 bg-white p-6 sm:p-10 rounded-2xl border border-gray-100 shadow-sm">
            @csrf

            <div class="space-y-8 divide-y divide-gray-200">
                <div>
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Informações Gerais</h3>
                        <p class="mt-1 text-sm text-gray-500">Detalhes principais que atraem as pessoas na pesquisa.</p>
                    </div>

                    <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        <div class="sm:col-span-6">
                            <label for="title" class="block text-sm font-medium text-gray-700">Título do Anúncio</label>
                            <div class="mt-1">
                                <input type="text" name="title" id="title" required value="{{ old('title') }}" class="shadow-sm focus:ring-brand-500 focus:border-brand-500 block w-full sm:text-sm border-gray-300 rounded-xl px-4 py-2 border">
                            </div>
                        </div>

                        <div class="sm:col-span-6">
                            <label for="description" class="block text-sm font-medium text-gray-700">Descrição</label>
                            <div class="mt-1">
                                <textarea id="description" name="description" rows="4" required class="shadow-sm focus:ring-brand-500 focus:border-brand-500 block w-full sm:text-sm border border-gray-300 rounded-xl px-4 py-2">{{ old('description') }}</textarea>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="purpose" class="block text-sm font-medium text-gray-700">Finalidade</label>
                            <div class="mt-1">
                                <select id="purpose" name="purpose" required class="shadow-sm focus:ring-brand-500 focus:border-brand-500 block w-full sm:text-sm border-gray-300 rounded-xl border px-3 py-2 bg-white">
                                    <option value="sale" {{ old('purpose') == 'sale' ? 'selected' : '' }}>Venda</option>
                                    <option value="rent" {{ old('purpose') == 'rent' ? 'selected' : '' }}>Arrendamento</option>
                                </select>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="property_type" class="block text-sm font-medium text-gray-700">Tipo de Imóvel</label>
                            <div class="mt-1">
                                <select id="property_type" name="property_type" required class="shadow-sm focus:ring-brand-500 focus:border-brand-500 block w-full sm:text-sm border-gray-300 rounded-xl border px-3 py-2 bg-white">
                                    <option value="apartamento" {{ old('property_type') == 'apartamento' ? 'selected' : '' }}>Apartamento</option>
                                    <option value="casa" {{ old('property_type') == 'casa' ? 'selected' : '' }}>Casa</option>
                                    <option value="vivenda" {{ old('property_type') == 'vivenda' ? 'selected' : '' }}>Vivenda</option>
                                    <option value="terreno" {{ old('property_type') == 'terreno' ? 'selected' : '' }}>Terreno</option>
                                    <option value="armazem" {{ old('property_type') == 'armazem' ? 'selected' : '' }}>Armazém</option>
                                    <option value="escritorio" {{ old('property_type') == 'escritorio' ? 'selected' : '' }}>Escritório</option>
                                    <option value="loja" {{ old('property_type') == 'loja' ? 'selected' : '' }}>Loja</option>
                                    <option value="edificio" {{ old('property_type') == 'edificio' ? 'selected' : '' }}>Edifício</option>
                                    <option value="fazenda" {{ old('property_type') == 'fazenda' ? 'selected' : '' }}>Fazenda</option>
                                    <option value="outro" {{ old('property_type') == 'outro' ? 'selected' : '' }}>Outro</option>
                                </select>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="price" class="block text-sm font-medium text-gray-700">Preço</label>
                            <div class="mt-1 relative rounded-xl shadow-sm border border-gray-300 overflow-hidden flex">
                                <input type="number" name="price" id="price" required min="0" value="{{ old('price', 0) }}" class="flex-1 focus:ring-brand-500 focus:border-brand-500 block w-full min-w-0 sm:text-sm border-0 px-4 py-2 border-r border-gray-300 outline-none">
                                <select name="currency" class="focus:ring-brand-500 focus:border-brand-500 pl-3 pr-8 py-2 border-transparent bg-gray-50 text-gray-500 sm:text-sm outline-none">
                                    <option value="AOA" {{ old('currency') == 'AOA' ? 'selected' : '' }}>AOA</option>
                                    <option value="USD" {{ old('currency') == 'USD' ? 'selected' : '' }}>USD</option>
                                    <option value="EUR" {{ old('currency') == 'EUR' ? 'selected' : '' }}>EUR</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-8">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Características & Localização</h3>
                    </div>
                    <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        <div class="sm:col-span-2">
                            <label for="bedrooms" class="block text-sm font-medium text-gray-700">Quartos</label>
                            <div class="mt-1">
                                <input type="number" name="bedrooms" id="bedrooms" required min="0" value="{{ old('bedrooms', 0) }}" class="shadow-sm focus:ring-brand-500 focus:border-brand-500 block w-full sm:text-sm border-gray-300 border rounded-xl px-4 py-2">
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="bathrooms" class="block text-sm font-medium text-gray-700">Casas de Banho</label>
                            <div class="mt-1">
                                <input type="number" name="bathrooms" id="bathrooms" required min="0" value="{{ old('bathrooms', 0) }}" class="shadow-sm focus:ring-brand-500 focus:border-brand-500 block w-full sm:text-sm border-gray-300 border rounded-xl px-4 py-2">
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="area" class="block text-sm font-medium text-gray-700">Área Útil (m²)</label>
                            <div class="mt-1">
                                <input type="number" name="area" id="area" min="0" value="{{ old('area', 0) }}" class="shadow-sm focus:ring-brand-500 focus:border-brand-500 block w-full sm:text-sm border-gray-300 border rounded-xl px-4 py-2">
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="city" class="block text-sm font-medium text-gray-700">Bairro / Município / Cidade</label>
                            <div class="mt-1">
                                <input type="text" name="city" id="city" required value="{{ old('city') }}" placeholder="Ex: Luanda, Talatona..." class="shadow-sm focus:ring-brand-500 focus:border-brand-500 block w-full sm:text-sm border-gray-300 border rounded-xl px-4 py-2">
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="address" class="block text-sm font-medium text-gray-700">Endereço Descritivo</label>
                            <div class="mt-1">
                                <input type="text" name="address" id="address" required value="{{ old('address') }}" class="shadow-sm focus:ring-brand-500 focus:border-brand-500 block w-full sm:text-sm border-gray-300 border rounded-xl px-4 py-2">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-8 mb-4">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Galeria de Fotos</h3>
                        <p class="mt-1 text-sm text-gray-500">Faça o upload múltiplo de imagens para captar os detalhes do imóvel.</p>
                    </div>
                    <div class="mt-6 mb-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Selecione Múltiplas Ficheiros</label>
                        <input type="file" name="images[]" multiple accept="image/*" class="block w-full text-sm text-gray-500
                            file:mr-4 file:py-2.5 file:px-4
                            file:rounded-xl file:border-0
                            file:text-sm file:font-semibold
                            file:bg-brand-50 file:text-brand-700
                            hover:file:bg-brand-100
                            border border-gray-200 rounded-xl p-2 bg-gray-50 cursor-pointer
                        "/>
                        <p class="mt-2 text-xs text-gray-500">As imagens serão geradas em alta performance (JPG, PNG).</p>
                    </div>
                </div>
            </div>

            <div class="pt-5 border-t border-gray-200 mt-6 flex justify-end gap-3">
                <a href="{{ route('owner.dashboard') }}" class="bg-white py-2.5 px-4 border border-gray-300 rounded-xl shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500">
                    Cancelar
                </a>
                <button type="submit" class="inline-flex justify-center py-2.5 px-6 border border-transparent shadow-sm text-sm font-medium rounded-xl text-white bg-brand-600 hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500">
                    Publicar Imóvel
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
