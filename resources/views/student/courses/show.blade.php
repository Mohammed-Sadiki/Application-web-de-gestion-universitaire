<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $module->name }} — Classroom
            </h2>
            <a href="{{ route('student.courses.index') }}" class="text-sm text-blue-600 hover:underline">← Retour</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Course Materials --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">📄 Supports de cours</h3>
                    @if($materials->isEmpty())
                        <p class="text-gray-500 text-sm">Aucun support disponible pour ce module.</p>
                    @else
                        <div class="grid gap-3 sm:grid-cols-2">
                            @foreach($materials as $material)
                                <a href="{{ asset('storage/' . $material->file_path) }}" target="_blank"
                                   class="flex items-center gap-3 p-3 border rounded-lg hover:bg-gray-50 transition">
                                    <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center text-red-600 font-bold text-sm">PDF</div>
                                    <div>
                                        <p class="font-medium text-sm text-gray-800">{{ $material->title }}</p>
                                        <p class="text-xs text-gray-500">{{ $material->created_at->format('d/m/Y') }}</p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            {{-- Announcements & Comments --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">📢 Annonces</h3>
                    @if(session('success'))
                        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded text-sm">{{ session('success') }}</div>
                    @endif
                    @if($announcements->isEmpty())
                        <p class="text-gray-500 text-sm">Aucune annonce pour ce module.</p>
                    @else
                        <div class="space-y-6">
                            @foreach($announcements as $announcement)
                                <div class="border rounded-lg p-4">
                                    <div class="flex items-start justify-between mb-2">
                                        <div>
                                            <h4 class="font-semibold text-gray-900">{{ $announcement->title }}</h4>
                                            <p class="text-xs text-gray-500">Par {{ $announcement->professor->user->name }} — {{ $announcement->created_at->format('d/m/Y') }}</p>
                                        </div>
                                    </div>
                                    <p class="text-gray-700 text-sm mb-4">{{ $announcement->content }}</p>

                                    {{-- Comments --}}
                                    @if($announcement->comments->isNotEmpty())
                                        <div class="border-t pt-3 space-y-2">
                                            @foreach($announcement->comments as $comment)
                                                <div class="bg-gray-50 rounded p-2 text-sm">
                                                    <span class="font-medium text-gray-800">{{ $comment->user->name }}</span>
                                                    <span class="text-gray-500 text-xs ml-2">{{ $comment->created_at->diffForHumans() }}</span>
                                                    <p class="text-gray-700 mt-1">{{ $comment->content }}</p>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    {{-- Add comment form --}}
                                    <form action="{{ route('student.courses.comment', $announcement) }}" method="POST" class="mt-3 flex gap-2">
                                        @csrf
                                        <input type="text" name="content" placeholder="Ajouter un commentaire..." required
                                               class="flex-1 border-gray-300 rounded-md text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-700">Commenter</button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
