<div class="space-y-6">
    <div class="bg-white shadow-sm rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">
            {{ $editingId ? __('Edit School Type') : __('Add New School Type') }}
        </h3>

        <form wire:submit.prevent="{{ $editingId ? 'update' : 'save' }}" class="space-y-4">
            <div>
                <x-input-label for="category" :value="__('Category')" />
                <select id="category" wire:model="category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">{{ __('Select Category') }}</option>
                    <option value="boarding">{{ __('Boarding') }}</option>
                    <option value="day">{{ __('Day School') }}</option>
                </select>
                <x-input-error :messages="$errors->get('category')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" wire:model="name" type="text" class="mt-1 block w-full" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="description" :value="__('Description')" />
                <textarea id="description" wire:model="description" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>

            <div class="flex justify-end">
                @if($editingId)
                    <x-secondary-button type="button" wire:click="$set('editingId', null)" class="mr-3">
                        {{ __('Cancel') }}
                    </x-secondary-button>
                @endif
                <x-primary-button>
                    {{ $editingId ? __('Update') : __('Save') }}
                </x-primary-button>
            </div>
        </form>
    </div>

    <div class="bg-white shadow-sm rounded-lg">
        <div class="p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('School Types') }}</h3>

            <div class="space-y-6">
                @foreach(['boarding', 'day'] as $categoryType)
                    <div>
                        <h4 class="text-md font-medium text-gray-700 mb-3 capitalize">{{ $categoryType }}</h4>
                        <div class="space-y-2">
                            @forelse($schoolTypes->where('category', $categoryType) as $type)
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div>
                                        <h5 class="font-medium text-gray-900">{{ $type->name }}</h5>
                                        @if($type->description)
                                            <p class="text-sm text-gray-600">{{ $type->description }}</p>
                                        @endif
                                    </div>
                                    <div class="flex space-x-2">
                                        <button wire:click="edit({{ $type->id }})" 
                                            class="text-blue-600 hover:text-blue-900">
                                            {{ __('Edit') }}
                                        </button>
                                        <button wire:click="delete({{ $type->id }})" 
                                            class="text-red-600 hover:text-red-900"
                                            onclick="return confirm('{{ __('Are you sure you want to delete this type?') }}')">
                                            {{ __('Delete') }}
                                        </button>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 text-sm">{{ __('No types added yet.') }}</p>
                            @endforelse
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div> 