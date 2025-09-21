<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($product) ? __('Editar Produto') : __('Novo Produto') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">


                @if ($errors->any())
                    <div class="mb-4 p-4 rounded bg-red-50">
                        <h4 class="font-semibold mb-2 text-red-700">Erros encontrados:</h4>
                        <ul class="list-disc list-inside text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                <form method="POST"
                    action="{{ isset($product) ? route('products.update', $product) : route('products.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    @if (isset($product))
                        @method('PUT')
                    @endif

                    <div class="mb-4">
                        <label class="block font-medium">Nome</label>
                        <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}"
                            class="w-full border-gray-300 rounded">
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Descrição</label>
                        <textarea name="description" rows="3" class="w-full border-gray-300 rounded">{{ old('description', $product->description ?? '') }}</textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block font-medium">Preço</label>
                            <input type="number" step="0.01" name="price"
                                value="{{ old('price', $product->price ?? '') }}"
                                class="w-full border-gray-300 rounded">
                        </div>
                        <div>
                            <label class="block font-medium">Estoque</label>
                            <input type="number" name="stock" value="{{ old('stock', $product->stock ?? '') }}"
                                class="w-full border-gray-300 rounded">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Categoria</label>
                        <select name="category_id" class="w-full border-gray-300 rounded">
                            <option value="">Selecione</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat['id'] }}"
                                    {{ old('category_id', $product->category_id ?? '') == $cat['id'] ? 'selected' : '' }}>
                                    {{ $cat['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Imagens</label>
                        <input type="file" name="images[]" multiple class="w-full border-gray-300 rounded">
                        @if (isset($product) && $product->images)
                            <div class="flex gap-2 mt-2">
                                @foreach ($product->images as $img)
                                    <img src="{{ $img }}" alt="Imagem"
                                        class="w-16 h-16 object-cover rounded">
                                @endforeach
                            </div>
                        @endif
                    </div>


                    <div class="flex justify-end gap-2">
                        <a href="{{ route('products.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">
                            Voltar
                        </a>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">
                            {{ isset($product) ? 'Atualizar' : 'Cadastrar' }}
                        </button>
                    </div>
                </form>

                @if (session('api_response'))
                    <div class="mt-6 p-4 border rounded bg-gray-50">
                        <h4 class="font-semibold mb-2">Resposta da API:</h4>
                        <pre class="text-sm text-gray-700">{{ print_r(session('api_response'), true) }}</pre>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
