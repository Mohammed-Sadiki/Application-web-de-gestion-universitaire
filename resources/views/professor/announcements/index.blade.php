<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Mes Annonces') }}
            </h2>
            <a href="{{ route('professor.announcements.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                + Nouvelle Annonce
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($announcements->isEmpty())
                        <p class="text-gray-500 italic text-center py-4">Aucune annonce publiée pour le moment.</p>
                    @else
                        <div class="space-y-6">
                            @foreach($announcements as $announcement)
                                <div class="p-5 border rounded-lg hover:shadow-sm transition bg-gray-50">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <span class="text-xs font-semibold text-indigo-600 uppercase tracking-wider bg-indigo-50 px-2 py-1 rounded">
                                                {{ $announcement->module->name }}
                                            </span>
                                            <span class="text-xs text-gray-500 ml-2">
                                                Publiée le {{ $announcement->created_at->format('d/m/Y à H:i') }}
                                            </span>
                                        </div>
                                        <form method="POST" action="{{ route('professor.announcements.destroy', $announcement) }}" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette annonce ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-sm text-red-600 hover:text-red-900 font-medium">
                                                Supprimer
                                            </button>
                                        </form>
                                    </div>
                                    <div class="mt-3 text-gray-700 whitespace-pre-line">
                                        {{ $announcement->content }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
