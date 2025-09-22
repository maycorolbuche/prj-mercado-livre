<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Token Mercado Livre') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

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

                <form method="POST" action="{{ route('token.storeOrUpdate') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block font-medium">Client ID</label>
                        <input type="text" name="client_id" class="w-full border-gray-300 rounded""
                            value="{{ old('client_id', $token->client_id ?? '') }}" required>
                        @error('client_id')
                            <div class="text-red-600 text-sm">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Client Secret</label>
                        <input type="text" name="client_secret" class="w-full border-gray-300 rounded""
                            value="{{ old('client_secret', $token->client_secret ?? '') }}" required>
                        @error('client_secret')
                            <div class="text-red-600 text-sm">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">URL de Redirecionamento</label>
                        <input type="text" name="redirect_uri" class="w-full border-gray-300 rounded""
                            value="{{ old('redirect_uri', $token->redirect_uri ?? '') }}" required>
                        @error('redirect_uri')
                            <div class="text-red-600 text-sm">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-2">
                        @if ($token)
                            <a href="{{ $url_meli }}" class="bg-yellow-500 text-white px-4 py-2 rounded">
                                Conectar ao Mercado Livre
                            </a>
                        @endif
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">
                            {{ $token ? 'Atualizar' : 'Salvar' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
