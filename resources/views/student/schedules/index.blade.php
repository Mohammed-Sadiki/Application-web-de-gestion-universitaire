<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <div>
                <div class="topbar-title">{{ __('app.my_schedule') }}</div>
                <div class="topbar-subtitle">{{ __('app.student_schedule_sub') }}</div>
            </div>
        </div>
    </x-slot>

    @php
        $dayKeys = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
        $dayMap  = [
            'Monday'    => ['abbr' => __('app.day_monday')],
            'Tuesday'   => ['abbr' => __('app.day_tuesday')],
            'Wednesday' => ['abbr' => __('app.day_wednesday')],
            'Thursday'  => ['abbr' => __('app.day_thursday')],
            'Friday'    => ['abbr' => __('app.day_friday')],
            'Saturday'  => ['abbr' => __('app.day_saturday')],
        ];

        $palette = [
            '#8b5cf6','#06b6d4','#d946ef',
            '#3b82f6','#10b981','#f59e0b',
            '#ef4444','#ec4899',
        ];

        // Group schedules by day
        $byDay = [];
        foreach ($dayKeys as $day) {
            $byDay[$day] = $schedules->where('day', $day)->sortBy('start_time')->values();
        }

        // Assign stable color per module
        $moduleColors = [];
        $ci = 0;
        foreach ($dayKeys as $day) {
            foreach ($byDay[$day] as $s) {
                $mid = $s->module_id;
                if (!isset($moduleColors[$mid])) {
                    $moduleColors[$mid] = $palette[$ci % count($palette)];
                    $ci++;
                }
            }
        }

        // Week dates
        $today     = \Carbon\Carbon::now();
        $weekStart = $today->copy()->startOfWeek(\Carbon\Carbon::MONDAY);
        $dayOffsets = ['Monday'=>0,'Tuesday'=>1,'Wednesday'=>2,'Thursday'=>3,'Friday'=>4,'Saturday'=>5];
        $weekDates = [];
        foreach ($dayOffsets as $d => $offset) {
            $weekDates[$d] = $weekStart->copy()->addDays($offset);
        }

        $startHour  = 8;
        $endHour    = 19;
        $totalHours = $endHour - $startHour;
        $slotH      = 60;

        $hasSchedules = $schedules->isNotEmpty();
    @endphp

    <div class="py-6 animate-fade-in">

        @if(!$hasSchedules)
            <div class="dark-card rounded-3xl p-16 text-center border border-white/5">
                <span class="text-6xl">📅</span>
                <p class="text-gray-400 italic mt-4 text-sm">{{ __('app.no_schedules_list') }}</p>
            </div>
        @else

        {{-- Legend & week header --}}
        <div class="dark-card rounded-3xl border border-white/5 mb-4 px-6 py-4 flex items-center justify-between flex-wrap gap-3">
            <div class="flex items-center gap-3">
                <span class="text-2xl">📅</span>
                <div>
                    <div class="text-base font-bold text-white">
                        {{ $weekStart->translatedFormat('d') }} –
                        {{ $weekStart->copy()->addDays(5)->translatedFormat('d M Y') }}
                    </div>
                    <div class="text-xs text-gray-400">{{ __('app.current_week') }}</div>
                </div>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                @foreach($moduleColors as $mid => $color)
                    @php
                        $modName = null;
                        foreach ($dayKeys as $day) {
                            foreach ($byDay[$day] as $s) {
                                if ($s->module_id == $mid) { $modName = $s->module->name; break 2; }
                            }
                        }
                    @endphp
                    @if($modName)
                        <span class="flex items-center gap-1.5 text-[11px] font-semibold px-2.5 py-1 rounded-full border"
                              style="background: {{ $color }}15; border-color: {{ $color }}35; color: {{ $color }}">
                            <span class="w-2 h-2 rounded-full flex-shrink-0" style="background:{{ $color }}"></span>
                            {{ Str::limit($modName, 22) }}
                        </span>
                    @endif
                @endforeach
            </div>
        </div>

        {{-- Calendar Grid --}}
        <div class="dark-card rounded-3xl border border-white/5 overflow-hidden">

            {{-- Day Headers --}}
            <div class="grid border-b border-white/10 sticky top-0 z-10"
                 style="grid-template-columns: 60px repeat(6, 1fr);">
                <div class="border-r border-white/5 bg-[#0d1220]"></div>
                @foreach($dayKeys as $day)
                    @php
                        $date    = $weekDates[$day];
                        $isToday = $date->isToday();
                    @endphp
                    <div class="py-3 px-2 text-center border-r border-white/5 last:border-r-0
                                {{ $isToday ? 'bg-[#8b5cf6]/10' : 'bg-[#0d1220]' }}">
                        <div class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">
                            {{ $dayMap[$day]['abbr'] }}
                            <span class="text-gray-600 ml-1 text-[9px]">{{ $date->format('d/m') }}</span>
                        </div>
                        <div class="text-xl font-black mt-0.5 {{ $isToday ? 'text-[#8b5cf6]' : 'text-white' }}">
                            {{ $date->format('d') }}
                        </div>
                        @if($isToday)
                            <div class="w-1.5 h-1.5 rounded-full bg-[#8b5cf6] mx-auto mt-1 animate-pulse shadow-[0_0_6px_#8b5cf6]"></div>
                        @endif
                    </div>
                @endforeach
            </div>

            {{-- Time + Event Grid --}}
            <div class="grid overflow-y-auto" style="grid-template-columns: 60px repeat(6, 1fr); max-height: 680px;">

                {{-- Hour labels --}}
                <div class="border-r border-white/5 bg-[#0d1220]">
                    @for($h = $startHour; $h <= $endHour; $h++)
                        <div class="flex items-start justify-center text-[11px] text-gray-600 font-bold border-b border-white/[0.04]"
                             style="height:{{ $slotH }}px; padding-top:6px;">
                            {{ str_pad($h, 2, '0', STR_PAD_LEFT) }}h
                        </div>
                    @endfor
                </div>

                {{-- Day columns --}}
                @foreach($dayKeys as $day)
                    <div class="relative border-r border-white/5 last:border-r-0"
                         style="height:{{ $totalHours * $slotH }}px;">

                        {{-- Grid lines --}}
                        @for($h = 0; $h <= $totalHours; $h++)
                            <div class="absolute left-0 right-0 border-t {{ $h === 0 ? 'border-white/10' : 'border-white/[0.04]' }}"
                                 style="top:{{ $h * $slotH }}px;"></div>
                        @endfor
                        @for($h = 0; $h < $totalHours; $h++)
                            <div class="absolute left-0 right-0 border-t border-dashed border-white/[0.02]"
                                 style="top:{{ $h * $slotH + $slotH / 2 }}px;"></div>
                        @endfor

                        {{-- Today column tint --}}
                        @if($weekDates[$day]->isToday())
                            <div class="absolute inset-0 bg-[#8b5cf6]/[0.03] pointer-events-none"></div>
                        @endif

                        {{-- Event blocks --}}
                        @foreach($byDay[$day] as $schedule)
                            @php
                                [$sh, $sm] = explode(':', $schedule->start_time);
                                [$eh, $em] = explode(':', $schedule->end_time);
                                $startMin = (int)$sh * 60 + (int)$sm;
                                $endMin   = (int)$eh * 60 + (int)$em;
                                $topPx    = (($startMin - $startHour * 60) / 60) * $slotH;
                                $heightPx = max(32, (($endMin - $startMin) / 60) * $slotH - 4);
                                $color    = $moduleColors[$schedule->module_id] ?? '#8b5cf6';
                            @endphp
                            <div class="absolute left-1 right-1 rounded-xl overflow-hidden cursor-pointer group
                                        transition-all duration-200 hover:scale-[1.02] hover:z-20 hover:shadow-2xl z-10"
                                 style="top:{{ $topPx + 2 }}px; height:{{ $heightPx }}px;
                                        background: linear-gradient(135deg, {{ $color }}dd 0%, {{ $color }}88 100%);
                                        border-left: 3px solid {{ $color }};
                                        box-shadow: 0 2px 14px {{ $color }}28;"
                                 title="{{ $schedule->module->name }} — {{ $schedule->professor->user->name }} — {{ $schedule->room->name }}">
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
                                            <div class="text-[10px] text-white/70 truncate flex items-center gap-1">
                                                <span>🎓</span> {{ $schedule->professor->user->name }}
                                            </div>
                                            <div class="text-[10px] text-white/60 truncate flex items-center gap-1">
                                                <span>📍</span> {{ $schedule->room->name }}
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
        @endif
    </div>
</x-app-layout>
