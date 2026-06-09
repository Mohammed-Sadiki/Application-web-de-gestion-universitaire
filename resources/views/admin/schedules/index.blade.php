<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <div>
                <div class="topbar-title">{{ __('Gestion de l\'Emploi du Temps') }}</div>
                <div class="topbar-subtitle">Gérez et visualisez l'ensemble des créneaux horaires</div>
            </div>
            <a href="{{ route('admin.schedules.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-[#8b5cf6] to-[#d946ef] hover:opacity-90 text-white text-xs font-bold rounded-xl shadow-md transition duration-200">
                ➕ Ajouter une séance
            </a>
        </div>
    </x-slot>

    @php
        $dayKeys = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
        $dayMap  = [
            'Monday'    => ['fr'=>'Lundi',    'abbr'=>'LUN'],
            'Tuesday'   => ['fr'=>'Mardi',    'abbr'=>'MAR'],
            'Wednesday' => ['fr'=>'Mercredi', 'abbr'=>'MER'],
            'Thursday'  => ['fr'=>'Jeudi',    'abbr'=>'JEU'],
            'Friday'    => ['fr'=>'Vendredi', 'abbr'=>'VEN'],
            'Saturday'  => ['fr'=>'Samedi',   'abbr'=>'SAM'],
        ];

        $palette = ['#8b5cf6','#06b6d4','#d946ef','#3b82f6','#10b981','#f59e0b','#ef4444','#ec4899'];

        // Group by day
        $byDay = [];
        foreach ($dayKeys as $day) {
            $byDay[$day] = $schedules->where('day', $day)->sortBy('start_time')->values();
        }

        // Stable color per module
        $moduleColors = []; $ci = 0;
        foreach ($dayKeys as $day) {
            foreach ($byDay[$day] as $s) {
                $mid = $s->module_id;
                if (!isset($moduleColors[$mid])) { $moduleColors[$mid] = $palette[$ci % count($palette)]; $ci++; }
            }
        }

        // Week dates
        $today     = \Carbon\Carbon::now();
        $weekStart = $today->copy()->startOfWeek(\Carbon\Carbon::MONDAY);
        $dayOffsets = ['Monday'=>0,'Tuesday'=>1,'Wednesday'=>2,'Thursday'=>3,'Friday'=>4,'Saturday'=>5];
        $weekDates = [];
        foreach ($dayOffsets as $d => $offset) { $weekDates[$d] = $weekStart->copy()->addDays($offset); }

        $startHour = 8; $endHour = 19; $totalHours = $endHour - $startHour; $slotH = 56;
    @endphp

    <div class="py-6 animate-fade-in space-y-6" x-data="{ view: 'calendar' }">

        @if(session('success'))
            <div class="bg-green-500/10 border border-green-500/20 text-green-400 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
                <span>✅</span> {{ session('success') }}
            </div>
        @endif

        {{-- View Toggle --}}
        <div class="flex items-center gap-2">
            <button @click="view = 'calendar'"
                    :class="view==='calendar'
                        ? 'bg-gradient-to-r from-[#8b5cf6] to-[#d946ef] text-white shadow-lg'
                        : 'bg-white/5 border border-white/10 text-gray-400 hover:text-white'"
                    class="flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold transition-all duration-200">
                📅 Vue Calendrier
            </button>
            <button @click="view = 'table'"
                    :class="view==='table'
                        ? 'bg-gradient-to-r from-[#8b5cf6] to-[#d946ef] text-white shadow-lg'
                        : 'bg-white/5 border border-white/10 text-gray-400 hover:text-white'"
                    class="flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold transition-all duration-200">
                📋 Vue Liste
            </button>
        </div>

        {{-- ───── CALENDAR VIEW ───── --}}
        <div x-show="view === 'calendar'" x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">

            {{-- Legend header --}}
            <div class="dark-card rounded-3xl border border-white/5 mb-4 px-6 py-4 flex flex-wrap items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <span class="text-2xl">📅</span>
                    <div>
                        <div class="text-sm font-bold text-white">
                            {{ $weekStart->translatedFormat('d') }} –
                            {{ $weekStart->copy()->addDays(5)->translatedFormat('d M Y') }}
                        </div>
                        <div class="text-xs text-gray-400">Semaine de référence</div>
                    </div>
                </div>
                <div class="flex flex-wrap gap-2">
                    @foreach($moduleColors as $mid => $color)
                        @php $mname = null;
                        foreach ($dayKeys as $dd) { foreach ($byDay[$dd] as $s) { if ($s->module_id==$mid){$mname=$s->module->name;break 2;} } }
                        @endphp
                        @if($mname)
                            <span class="flex items-center gap-1.5 text-[10px] font-semibold px-2.5 py-1 rounded-full border"
                                  style="background:{{ $color }}15;border-color:{{ $color }}35;color:{{ $color }}">
                                <span class="w-2 h-2 rounded-full flex-shrink-0" style="background:{{ $color }}"></span>
                                {{ Str::limit($mname, 20) }}
                            </span>
                        @endif
                    @endforeach
                </div>
            </div>

            {{-- Grid --}}
            <div class="dark-card rounded-3xl border border-white/5 overflow-hidden">
                {{-- Day headers --}}
                <div class="grid border-b border-white/10 sticky top-0 z-10 bg-[#0d1220]"
                     style="grid-template-columns: 64px repeat(6, 1fr);">
                    <div class="border-r border-white/5"></div>
                    @foreach($dayKeys as $day)
                        @php $date = $weekDates[$day]; $isToday = $date->isToday(); @endphp
                        <div class="py-3 px-2 text-center border-r border-white/5 last:border-r-0 {{ $isToday ? 'bg-[#8b5cf6]/10' : '' }}">
                            <div class="text-[9px] font-bold text-gray-500 uppercase tracking-widest">
                                {{ $dayMap[$day]['abbr'] }} · {{ $date->format('d/m') }}
                            </div>
                            <div class="text-lg font-black mt-0.5 {{ $isToday ? 'text-[#8b5cf6]' : 'text-white' }}">
                                {{ $date->format('d') }}
                            </div>
                            @if($isToday)
                                <div class="w-1.5 h-1.5 rounded-full bg-[#8b5cf6] mx-auto mt-0.5 animate-pulse shadow-[0_0_6px_#8b5cf6]"></div>
                            @endif
                        </div>
                    @endforeach
                </div>

                {{-- Time + Events --}}
                <div class="grid overflow-y-auto" style="grid-template-columns: 64px repeat(6, 1fr); max-height: 640px;">
                    {{-- Hour labels --}}
                    <div class="border-r border-white/5 bg-[#0d1220]">
                        @for($h = $startHour; $h <= $endHour; $h++)
                            <div class="flex items-start justify-center text-[10px] text-gray-600 font-bold border-b border-white/[0.04]"
                                 style="height:{{ $slotH }}px; padding-top:5px;">
                                {{ str_pad($h,2,'0',STR_PAD_LEFT) }}h
                            </div>
                        @endfor
                    </div>

                    @foreach($dayKeys as $day)
                        <div class="relative border-r border-white/5 last:border-r-0"
                             style="height:{{ $totalHours * $slotH }}px;">
                            @for($h = 0; $h <= $totalHours; $h++)
                                <div class="absolute left-0 right-0 border-t {{ $h===0 ? 'border-white/10' : 'border-white/[0.04]' }}"
                                     style="top:{{ $h * $slotH }}px;"></div>
                            @endfor
                            @for($h = 0; $h < $totalHours; $h++)
                                <div class="absolute left-0 right-0 border-t border-dashed border-white/[0.025]"
                                     style="top:{{ $h * $slotH + $slotH/2 }}px;"></div>
                            @endfor
                            @if($weekDates[$day]->isToday())
                                <div class="absolute inset-0 bg-[#8b5cf6]/[0.03] pointer-events-none"></div>
                            @endif

                            @foreach($byDay[$day] as $schedule)
                                @php
                                    [$sh,$sm] = explode(':',$schedule->start_time);
                                    [$eh,$em] = explode(':',$schedule->end_time);
                                    $startMin = (int)$sh*60+(int)$sm;
                                    $endMin   = (int)$eh*60+(int)$em;
                                    $topPx    = (($startMin - $startHour*60)/60)*$slotH;
                                    $heightPx = max(32,(($endMin-$startMin)/60)*$slotH - 4);
                                    $color    = $moduleColors[$schedule->module_id] ?? '#8b5cf6';
                                @endphp
                                <div class="absolute left-1 right-1 rounded-xl overflow-hidden group cursor-pointer z-10
                                            transition-all duration-200 hover:scale-[1.02] hover:z-30 hover:shadow-2xl"
                                     style="top:{{ $topPx+2 }}px; height:{{ $heightPx }}px;
                                            background: linear-gradient(135deg, {{ $color }}dd 0%, {{ $color }}88 100%);
                                            border-left: 3px solid {{ $color }};
                                            box-shadow: 0 2px 12px {{ $color }}28;"
                                     title="{{ $schedule->module->name }} | {{ $schedule->professor->user->name }} | {{ $schedule->room->name }}">
                                    <div class="p-1.5 h-full flex flex-col justify-between">
                                        <div>
                                            <div class="text-[10px] font-black text-white/90 leading-tight">
                                                {{ substr($schedule->start_time,0,5) }}–{{ substr($schedule->end_time,0,5) }}
                                            </div>
                                            @if($heightPx > 38)
                                                <div class="text-[11px] font-bold text-white leading-tight mt-0.5 truncate">
                                                    {{ $schedule->module->name }}
                                                </div>
                                            @endif
                                        </div>
                                        @if($heightPx > 70)
                                            <div class="space-y-0.5 mt-1">
                                                <div class="text-[10px] text-white/75 truncate flex items-center gap-1">
                                                    <span>🎓</span> {{ $schedule->professor->user->name }}
                                                </div>
                                                <div class="text-[10px] text-white/60 truncate flex items-center gap-1">
                                                    <span>📍</span> {{ $schedule->room->name }}
                                                </div>
                                                <div class="text-[10px] text-white/55 truncate flex items-center gap-1">
                                                    <span>👥</span> {{ $schedule->group->name }}
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ───── TABLE VIEW ───── --}}
        <div x-show="view === 'table'" x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
            <div class="dark-card rounded-3xl overflow-hidden border border-white/5">
                <div class="p-6 bg-[#17192a]/30 border-b border-white/5 flex items-center justify-between">
                    <h3 class="text-base font-bold text-white flex items-center gap-2">
                        <span class="w-2.5 h-2.5 bg-[#8b5cf6] rounded-full animate-pulse"></span>
                        Liste de toutes les séances planifiées
                    </h3>
                    <span class="text-xs text-gray-400 font-semibold">{{ $schedules->count() }} séance(s)</span>
                </div>
                <div class="p-6">
                    @if($schedules->isEmpty())
                        <p class="text-gray-400 italic text-center py-6">Aucune séance planifiée.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-white/5">
                                <thead>
                                    <tr class="text-left text-xs font-bold text-gray-400 uppercase tracking-wider">
                                        <th class="pb-3">Jour</th>
                                        <th class="pb-3">Créneau</th>
                                        <th class="pb-3">Groupe</th>
                                        <th class="pb-3">Module</th>
                                        <th class="pb-3">Professeur</th>
                                        <th class="pb-3">Salle</th>
                                        <th class="pb-3 text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="text-sm divide-y divide-white/5 text-gray-300">
                                    @php
                                        $dayFr = ['Monday'=>'Lundi','Tuesday'=>'Mardi','Wednesday'=>'Mercredi',
                                                  'Thursday'=>'Jeudi','Friday'=>'Vendredi','Saturday'=>'Samedi'];
                                    @endphp
                                    @foreach($schedules->sortBy([['day','asc'],['start_time','asc']]) as $schedule)
                                        @php $color = $moduleColors[$schedule->module_id] ?? '#8b5cf6'; @endphp
                                        <tr class="hover:bg-white/[0.02] transition-colors">
                                            <td class="py-3.5">
                                                <span class="px-2.5 py-1 rounded-full text-xs font-bold"
                                                      style="background:{{ $color }}15;color:{{ $color }};border:1px solid {{ $color }}30;">
                                                    {{ $dayFr[$schedule->day] ?? $schedule->day }}
                                                </span>
                                            </td>
                                            <td class="py-3.5">
                                                <span class="px-2.5 py-1 bg-[#06b6d4]/10 border border-[#06b6d4]/20 rounded-full text-xs font-semibold text-[#06b6d4]">
                                                    {{ substr($schedule->start_time,0,5) }} – {{ substr($schedule->end_time,0,5) }}
                                                </span>
                                            </td>
                                            <td class="py-3.5 text-gray-300">{{ $schedule->group->name }}</td>
                                            <td class="py-3.5 font-semibold text-white">{{ $schedule->module->name }}</td>
                                            <td class="py-3.5 text-gray-300">{{ $schedule->professor->user->name }}</td>
                                            <td class="py-3.5 font-semibold text-[#8b5cf6]">{{ $schedule->room->name }}</td>
                                            <td class="py-3.5 text-right space-x-2">
                                                <a href="{{ route('admin.schedules.edit', $schedule) }}"
                                                   class="inline-flex items-center px-3 py-1 bg-[#8b5cf6]/10 hover:bg-[#8b5cf6]/20 border border-[#8b5cf6]/20 text-[#8b5cf6] text-xs font-bold rounded-xl transition">
                                                    ✏️ Modifier
                                                </a>
                                                <form action="{{ route('admin.schedules.destroy', $schedule) }}" method="POST" class="inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Supprimer cette séance ?')"
                                                            class="inline-flex items-center px-3 py-1 bg-[#d946ef]/10 hover:bg-[#d946ef]/20 border border-[#d946ef]/20 text-[#d946ef] text-xs font-bold rounded-xl transition">
                                                        🗑️ Supprimer
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>