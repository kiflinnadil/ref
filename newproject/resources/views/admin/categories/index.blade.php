<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">

        @if (session()->has('success'))
        <x-alert message="{{ session('success') }}"></x-alert>
        @endif

        <div class="flex items-center justify-between mt-8">
            <h2 class="font-semibold text-2xl text-gray-700">Category Product</h2>
            
            <a href="{{ route('categories.create') }}">
                <button class="bg-gray-500 text-white px-6 py-2 rounded-md font-semibold hover:bg-gray-600 transition ease-in-out duration-200">Tambah</button>
            </a>
        </div>

        <div class="overflow-x-auto mt-6">
            <table class="min-w-full bg-white table-auto border-collapse border border-gray-200 rounded-lg shadow-md">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 border-b border-gray-200">No</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 border-b border-gray-200">Nama Kategori</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 border-b border-gray-200">Icon</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 border-b border-gray-200">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-700 border-b border-gray-200">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700 border-b border-gray-200">{{ $category->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700 border-b border-gray-200">{{ $category->icon }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700 border-b border-gray-200 flex space-x-2">
                            
                            <a href="{{ route('categories.edit', $category->id) }}">
                                <button type="button" class="bg-green-500 text-white px-4 py-2 rounded-md font-semibold hover:bg-green-600 transition duration-200">
                                    Edit
                                </button>
                            </a>
                            
                            <x-danger-button
                                x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'confirm-category-deletion-{{ $category->id }}')"
                            >
                                {{ __('Delete') }}
                            </x-danger-button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

    @foreach ($categories as $category)
        <x-modal name="confirm-category-deletion-{{ $category->id }}" focusable>
            <form method="POST" action="{{ route('categories.destroy', $category->id) }}" class="p-6">
                @csrf
                @method('DELETE')

                <h2 class="text-lg font-medium text-gray-900">
                    {{ __('Are you sure you want to delete this category?') }}
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    {{ __('Once deleted, this action cannot be undone.') }}
                </p>

                <div class="mt-6 flex justify-end">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        {{ __('Cancel') }}
                    </x-secondary-button>

                    <x-danger-button class="ms-3">
                        {{ __('Delete Category') }}
                    </x-danger-button>
                </div>
            </form>
        </x-modal>
    @endforeach
</x-app-layout>
