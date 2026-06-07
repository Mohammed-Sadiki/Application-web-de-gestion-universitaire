<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Réserver une Salle') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('professor.reservations.store') }}">
                        @csrf

                        <!-- Room Selection -->
                        <div class="mb-4">
                            <x-input-label for="room_id" :value="__('Salle')" />
                            <select id="room_id" name="room_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                                <option value="">Choisir une salle</option>
                                @foreach($rooms as $room)
                                    <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                        {{ $room->name }} (Capacité: {{ $room->capacity }} places)
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('room_id')" class="mt-2" />
                        </div>

                        <!-- Date -->
                        <div class="mb-4">
                            <x-input-label for="date" :value="__('Date')" />
                            <x-text-input id="date" class="block mt-1 w-full" type="date" name="date" :value="old('date', date('Y-m-d'))" required min="{{ date('Y-m-d') }}" />
                            <x-input-error :messages="$errors->get('date')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <!-- Start Time -->
                            <div class="mb-4">
                                <x-input-label for="start_time" :value="__('Heure de début')" />
                                <x-text-input id="start_time" class="block mt-1 w-full" type="time" name="start_time" :value="old('start_time')" required />
                                <x-input-error :messages="$errors->get('start_time')" class="mt-2" />
                            </div>

                            <!-- End Time -->
                            <div class="mb-4">
                                <x-input-label for="end_time" :value="__('Heure de fin')" />
                                <x-text-input id="end_time" class="block mt-1 w-full" type="time" name="end_time" :value="old('end_time')" required />
                                <x-input-error :messages="$errors->get('end_time')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Reason -->
                        <div class="mb-6">
                            <x-input-label for="reason" :value="__('Motif de la réservation')" />
                            <x-text-input id="reason" class="block mt-1 w-full" type="text" name="reason" :value="old('reason')" placeholder="Ex: Séance de rattrapage, réunion de département..." />
                            <x-input-error :messages="$errors->get('reason')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end">
                            <a href="{{ route('professor.reservations.index') }}" class="mr-4 text-sm text-gray-600 hover:text-gray-900 underline">
                                Annuler
                            </a>
                            <x-primary-button>
                                {{ __('Réserver') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
