<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Produtos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium">Lista de Produtos</h3>
                    <a href="{{ route('products.create') }}"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">
                        Novo Produto
                    </a>
                </div>

                @if (session('success'))
                    <div class="mb-4 p-3 text-green-600">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="mb-4 p-3 text-red-600">
                        {{ session('error') }}
                    </div>
                @endif

                <div style="overflow-x: auto;">
                    <table class="w-full border divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2">ID</th>
                                <th class="px-4 py-2">Nome</th>
                                <th class="px-4 py-2">Preço</th>
                                <th class="px-4 py-2">Estoque</th>
                                <th class="px-4 py-2">Categoria</th>
                                <th class="px-4 py-2">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($products as $product)
                                <tr>
                                    <td class="px-4 py-2 text-end">{{ $product->id }}</td>
                                    <td class="px-4 py-2">{{ $product->name }}</td>
                                    <td class="px-4 py-2 text-end">R$ {{ number_format($product->price, 2, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-2 text-end">{{ $product->stock }}</td>
                                    <td class="px-4 py-2">{{ $product->category_id }}</td>
                                    <td class="px-4 py-2 flex gap-2 justify-end">
                                        <a href="{{ route('products.edit', $product) }}"
                                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded">Editar</a>
                                        <form action="{{ route('products.destroy', $product) }}" method="POST"
                                            onsubmit="return confirm('Tem certeza?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">
                                                Excluir
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-2 text-center text-gray-500">
                                        Nenhum produto cadastrado.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
