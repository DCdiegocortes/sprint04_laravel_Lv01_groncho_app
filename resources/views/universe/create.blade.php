<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create your universe') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <p class="text-sm text-gray-600 mb-6">
                    {{ __('Your universe is your aesthetic profile: a name, a description and a vibe that represents you.') }}
                </p>

                <form method="post" action="{{ route('universe.store') }}" class="space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div>
                        <x-input-label for="description" :value="__('Description')" />
                        <textarea id="description" name="description" rows="3" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('description') }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('description')" />
                    </div>

                    <div>
                        <x-input-label for="style" :value="__('Style / vibe')" />
                        <x-text-input id="style" name="style" type="text" class="mt-1 block w-full" :value="old('style')" placeholder="{{ __('e.g. mermaidcore, dark academia, minimalist') }}" />
                        <x-input-error class="mt-2" :messages="$errors->get('style')" />
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Create universe') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
