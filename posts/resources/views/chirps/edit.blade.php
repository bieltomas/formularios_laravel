<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('chirps.update', $chirp) }}">
            @csrf
            @method('patch')
            <label for="title" class="block text-sm font-medium text-gray-700">{{ __('Titulo de la publicación') }}</label>
            <textarea
                name="title"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >{{ old('title', $chirp->title) }}</textarea>
            <x-input-error :messages="$errors->get('title')" class="mt-2" />
            <br>
            <label for="extract" class="block text-sm font-medium text-gray-700">{{ __('Extracto de la publicación') }}</label>
            <textarea
                name="extract"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >{{ old('extract', $chirp->extract) }}</textarea>
            <x-input-error :messages="$errors->get('extract')" class="mt-2" />
            <br>
            <label for="message" class="block text-sm font-medium text-gray-700">{{ __('Mensaje de la publicación') }}</label>
            <textarea
                name="message"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >{{ old('message', $chirp->message) }}</textarea>
            <x-input-error :messages="$errors->get('message')" class="mt-2" />
            <div class="mt-4 space-x-2">
                <x-primary-button>{{ __('Editar') }}</x-primary-button>
                <a href="{{ route('chirps.index') }}">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>
</x-app-layout>