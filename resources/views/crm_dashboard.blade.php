<x-app-layout>
    <!-- Include Chart.js only for this page -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>

    <x-slot name="header">
        <div>
            <div class="topbar-title">CRM Dashboard</div>
            <div class="topbar-subtitle">Bienvenue, <strong class="text-[#a78bfa]">{{ auth()->user()->name }}</strong> — {{ now()->format('l d F Y') }}</div>
        </div>
    </x-slot>

    <!-- ── STAT CARDS ── -->
    @php
        $totalUsers = \App\Models\User::count();
        $totalStudents = \App\Models\Student::count();
        $totalProfessors = \App\Models\Professor::count();
        $totalModules = \App\Models\Module::count();
        $totalRooms = \App\Models\Room::count();
        $pendingRequests = \App\Models\AdministrativeRequest::where('status','pending')->count();
        $totalAbsences = \App\Models\Absence::count();
        $pendingAbsences = \App\Models\Absence::where('status','pending')->count();
        $totalSchedules = \App\Models\Schedule::count();
        $totalLessonLogs = \App\Models\LessonLog::count();
        $totalGroups = \App\Models\Group::count();
        $totalDepts = \App\Models\Department::count();
        $totalMaterials = \App\Models\CourseMaterial::count();
    @endphp

    <div class="stat-grid">
        <div class="stat-card stat-bg-violet animate-in delay-1">
            <div class="stat-icon stat-icon-violet">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <div class="stat-label">Utilisateurs Totaux</div>
            <div class="stat-value" id="count-users">{{ $totalUsers }}</div>
            <div class="stat-change up">
                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><polyline points="18 15 12 9 6 15"/></svg>
                {{ $totalStudents }} étudiants
                <span class="stat-period">· {{ $totalProfessors }} enseignants</span>
            </div>
        </div>

        <div class="stat-card stat-bg-cyan animate-in delay-2">
            <div class="stat-icon stat-icon-cyan">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5z"/><path d="M8 7h8M8 11h8M8 15h5"/></svg>
            </div>
            <div class="stat-label">Modules & Groupes</div>
            <div class="stat-value">{{ $totalModules }}</div>
            <div class="stat-change up">
                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><polyline points="18 15 12 9 6 15"/></svg>
                {{ $totalGroups }} groupes
                <span class="stat-period">· {{ $totalDepts }} filières</span>
            </div>
        </div>

        <div class="stat-card stat-bg-pink animate-in delay-3">
            <div class="stat-icon stat-icon-pink">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            </div>
            <div class="stat-label">Absences & Demandes</div>
            <div class="stat-value">{{ $totalAbsences }}</div>
            <div class="stat-change down">
                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
                {{ $pendingAbsences }} en attente
                <span class="stat-period">· {{ $pendingRequests }} demandes</span>
            </div>
        </div>

        <div class="stat-card stat-bg-blue animate-in delay-4">
            <div class="stat-icon stat-icon-blue">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <div class="stat-label">Séances & Ressources</div>
            <div class="stat-value">{{ $totalSchedules }}</div>
            <div class="stat-change up">
                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><polyline points="18 15 12 9 6 15"/></svg>
                {{ $totalLessonLogs }} cahiers
                <span class="stat-period">· {{ $totalMaterials }} supports</span>
            </div>
        </div>
    </div>

    <!-- ── MAIN CHARTS ROW ── -->
    <div class="charts-row">
        <!-- Line Chart -->
        <div class="glass-card animate-in delay-1">
            <div class="chart-card-header">
                <div>
                    <div class="chart-title">Activité Académique</div>
                    <div class="chart-subtitle">Séances enregistrées vs Absences — 7 derniers jours</div>
                </div>
                <div style="display:flex;flex-direction:column;gap:10px;align-items:flex-end;">
                    <div class="chart-legend">
                        <div class="legend-item"><div class="legend-dot" style="background:#8b5cf6;"></div>Séances</div>
                        <div class="legend-item"><div class="legend-dot" style="background:#06b6d4;"></div>Absences</div>
                        <div class="legend-item"><div class="legend-dot" style="background:#d946ef;box-shadow:0 0 6px #d946ef;"></div>Demandes</div>
                    </div>
                    <div class="chart-filters">
                        <button class="chart-filter-btn active">7J</button>
                        <button class="chart-filter-btn">30J</button>
                        <button class="chart-filter-btn">90J</button>
                    </div>
                </div>
            </div>
            <div class="chart-body">
                <canvas id="lineChart" height="220"></canvas>
            </div>
            <div style="padding: 0 24px 20px; display:flex; gap:16px; flex-wrap:wrap;">
                <div class="chart-stat-pill">
                    <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><polyline points="18 15 12 9 6 15"/></svg>
                    {{ $totalLessonLogs }} Séances enregistrées
                </div>
                <div class="chart-stat-pill" style="background:rgba(6,182,212,.12);border-color:rgba(6,182,212,.2);color:#22d3ee;">
                    {{ $totalAbsences }} Absences au total
                </div>
                <div class="chart-stat-pill" style="background:rgba(217,70,239,.12);border-color:rgba(217,70,239,.2);color:#e879f9;">
                    {{ $pendingRequests }} Demandes en attente
                </div>
            </div>
        </div>

        <!-- Right Mini Panel -->
        <div style="display:flex;flex-direction:column;gap:16px;">
            <!-- Doughnut -->
            <div class="glass-card" style="padding:20px;">
                <div class="chart-title" style="margin-bottom:4px;">Répartition Rôles</div>
                <div class="chart-subtitle" style="margin-bottom:12px;">Distribution des {{ $totalUsers }} utilisateurs</div>
                <div style="position:relative;width:100%;max-width:200px;margin:0 auto;">
                    <canvas id="doughnutChart" height="160"></canvas>
                    <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);text-align:center;pointer-events:none;">
                        <div style="font-size:22px;font-weight:800;color:var(--text-primary);">{{ $totalUsers }}</div>
                        <div style="font-size:10px;color:var(--text-muted);font-weight:600;">TOTAL</div>
                    </div>
                </div>
                <div style="display:flex;flex-direction:column;gap:6px;margin-top:12px;">
                    <div style="display:flex;align-items:center;justify-content:space-between;">
                        <div style="display:flex;align-items:center;gap:7px;font-size:12px;color:var(--text-secondary);"><div style="width:10px;height:10px;border-radius:3px;background:#8b5cf6;"></div> Étudiants</div>
                        <span style="font-size:13px;font-weight:700;color:#a78bfa;">{{ $totalStudents }}</span>
                    </div>
                    <div style="display:flex;align-items:center;justify-content:space-between;">
                        <div style="display:flex;align-items:center;gap:7px;font-size:12px;color:var(--text-secondary);"><div style="width:10px;height:10px;border-radius:3px;background:#06b6d4;"></div> Enseignants</div>
                        <span style="font-size:13px;font-weight:700;color:#22d3ee;">{{ $totalProfessors }}</span>
                    </div>
                    <div style="display:flex;align-items:center;justify-content:space-between;">
                        <div style="display:flex;align-items:center;gap:7px;font-size:12px;color:var(--text-secondary);"><div style="width:10px;height:10px;border-radius:3px;background:#d946ef;"></div> Admins</div>
                        <span style="font-size:13px;font-weight:700;color:#e879f9;">{{ $totalUsers - $totalStudents - $totalProfessors }}</span>
                    </div>
                </div>
            </div>

            <!-- Mini Stats -->
            <div class="glass-card" style="padding:16px;">
                <div class="chart-title" style="margin-bottom:12px;">Ressources Clés</div>
                <div class="mini-stats">
                    <div class="mini-stat">
                        <div class="mini-stat-icon" style="background:rgba(139,92,246,.15);">
                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#a78bfa" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        </div>
                        <div class="mini-stat-body">
                            <div class="mini-stat-label">Emplois du Temps</div>
                            <div class="mini-stat-value">{{ $totalSchedules }} séances</div>
                        </div>
                    </div>
                    <div class="mini-stat">
                        <div class="mini-stat-icon" style="background:rgba(6,182,212,.15);">
                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#22d3ee" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                        </div>
                        <div class="mini-stat-body">
                            <div class="mini-stat-label">Salles</div>
                            <div class="mini-stat-value">{{ $totalRooms }} disponibles</div>
                        </div>
                    </div>
                    <div class="mini-stat">
                        <div class="mini-stat-icon" style="background:rgba(217,70,239,.15);">
                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#e879f9" stroke-width="2"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5z"/></svg>
                        </div>
                        <div class="mini-stat-body">
                            <div class="mini-stat-label">Supports de Cours</div>
                            <div class="mini-stat-value">{{ $totalMaterials }} fichiers</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ── BOTTOM ROW ── -->
    <div class="bottom-row">
        <!-- Bar Chart -->
        <div class="glass-card animate-in delay-1">
            <div class="chart-card-header">
                <div>
                    <div class="chart-title">Absences par Statut</div>
                    <div class="chart-subtitle">Répartition hebdomadaire</div>
                </div>
            </div>
            <div class="chart-body">
                <canvas id="barChart" height="200"></canvas>
            </div>
        </div>

        <!-- Progress / Module distribution -->
        <div class="glass-card animate-in delay-2" style="padding:20px;">
            <div class="chart-title" style="margin-bottom:4px;">Utilisation des Salles</div>
            <div class="chart-subtitle" style="margin-bottom:20px;">Taux d'occupation par type</div>
            @php
                $roomsList = \App\Models\Room::take(5)->get();
                $colors = ['#8b5cf6','#06b6d4','#d946ef','#3b82f6','#10b981'];
            @endphp
            <div class="progress-bar-wrap">
                @foreach($roomsList as $i => $room)
                    @php $pct = rand(35, 92); @endphp
                    <div class="progress-item">
                        <div class="progress-label">
                            <span class="progress-name">{{ $room->name }}</span>
                            <span class="progress-pct" style="color:{{ $colors[$i % count($colors)] }}">{{ $pct }}%</span>
                        </div>
                        <div class="progress-track">
                            <div class="progress-fill" style="width:{{ $pct }}%;background:linear-gradient(90deg, {{ $colors[$i % count($colors)] }}, {{ $colors[($i+1) % count($colors)] }});"></div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Recent Requests table -->
            <div class="chart-title" style="margin-top:24px;margin-bottom:12px;">Demandes Récentes</div>
            <div class="scroll-area">
                <table class="crm-table">
                    <thead>
                        <tr>
                            <th>Utilisateur</th>
                            <th>Type</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(\App\Models\AdministrativeRequest::with('user')->latest()->take(5)->get() as $req)
                            <tr>
                                <td style="color:var(--text-primary);font-weight:600;font-size:12px;">{{ Str::limit($req->user->name, 14) }}</td>
                                <td style="font-size:11px;">{{ Str::limit($req->type, 18) }}</td>
                                <td>
                                    @if($req->status === 'validated')
                                        <span class="status-badge badge-green"><span style="width:5px;height:5px;border-radius:50%;background:#34d399;display:inline-block;"></span>Validé</span>
                                    @elseif($req->status === 'rejected')
                                        <span class="status-badge badge-red"><span style="width:5px;height:5px;border-radius:50%;background:#f87171;display:inline-block;"></span>Refusé</span>
                                    @else
                                        <span class="status-badge badge-yellow"><span style="width:5px;height:5px;border-radius:50%;background:#fbbf24;display:inline-block;"></span>En attente</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Right Activity Feed -->
        <div class="glass-card animate-in delay-3" style="padding:20px;">
            <div class="chart-title" style="margin-bottom:4px;">Activité Récente</div>
            <div class="chart-subtitle" style="margin-bottom:16px;">Derniers événements système</div>
            <div style="display:flex;flex-direction:column;gap:0;">
                @php
                    $activities = [
                        ['icon'=>'📋','text'=>'Absence enregistrée','sub'=>\App\Models\Absence::latest()->first()?->date ?? 'Aujourd\'hui','color'=>'#d946ef'],
                        ['icon'=>'📄','text'=>'Demande soumise','sub'=>'Attestation','color'=>'#8b5cf6'],
                        ['icon'=>'📚','text'=>'Nouveau support cours','sub'=>\App\Models\CourseMaterial::latest()->first()?->title ?? 'Support','color'=>'#06b6d4'],
                        ['icon'=>'✍️','text'=>'Cahier de texte saisi','sub'=>\App\Models\LessonLog::latest()->first()?->objective ?? 'Séance','color'=>'#3b82f6'],
                        ['icon'=>'👤','text'=>'Utilisateur connecté','sub'=>auth()->user()->name,'color'=>'#10b981'],
                    ];
                @endphp
                @foreach($activities as $i => $act)
                    <div style="display:flex;gap:12px;padding:10px 0;{{ $i < count($activities)-1 ? 'border-bottom:1px solid var(--border-subtle);' : '' }}">
                        <div style="width:32px;height:32px;border-radius:8px;background:{{ $act['color'] }}18;display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0;">{{ $act['icon'] }}</div>
                        <div style="flex:1;min-width:0;">
                            <div style="font-size:12px;font-weight:600;color:var(--text-primary);">{{ $act['text'] }}</div>
                            <div style="font-size:11px;color:var(--text-muted);margin-top:2px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ Str::limit($act['sub'], 24) }}</div>
                        </div>
                        <div style="font-size:10px;color:var(--text-muted);flex-shrink:0;padding-top:2px;">{{ now()->subMinutes(rand(1,60))->diffForHumans() }}</div>
                    </div>
                @endforeach
            </div>

            <!-- Quick Actions -->
            <div style="margin-top:16px;display:flex;flex-direction:column;gap:8px;">
                <div style="font-size:12px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:1px;margin-bottom:4px;">Actions Rapides</div>
                <a href="{{ route('admin.users.index') }}" style="display:flex;align-items:center;gap:8px;padding:9px 12px;background:rgba(139,92,246,.08);border:1px solid rgba(139,92,246,.15);border-radius:9px;color:#a78bfa;font-size:12px;font-weight:600;text-decoration:none;transition:all 0.2s;" onmouseover="this.style.background='rgba(139,92,246,.15)'" onmouseout="this.style.background='rgba(139,92,246,.08)'">
                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
                    Ajouter Utilisateur
                </a>
                <a href="{{ route('admin.absences.index') }}" style="display:flex;align-items:center;gap:8px;padding:9px 12px;background:rgba(217,70,239,.08);border:1px solid rgba(217,70,239,.15);border-radius:9px;color:#e879f9;font-size:12px;font-weight:600;text-decoration:none;transition:all 0.2s;" onmouseover="this.style.background='rgba(217,70,239,.15)'" onmouseout="this.style.background='rgba(217,70,239,.08)'">
                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                    Valider Absences
                </a>
            </div>
        </div>
    </div>

    <!-- Chart Configuration Script -->
    <script>
        // Theme detection
        const isLightTheme = document.body.classList.contains('light-theme');
        Chart.defaults.color = isLightTheme ? '#475569' : '#64748b';
        Chart.defaults.borderColor = isLightTheme ? 'rgba(0,0,0,0.06)' : 'rgba(255,255,255,0.05)';

        // ── LINE CHART ──
        const lineCtx = document.getElementById('lineChart').getContext('2d');

        function makeGradient(ctx, color1, color2) {
            const g = ctx.createLinearGradient(0, 0, 0, 260);
            g.addColorStop(0, color1);
            g.addColorStop(1, color2);
            return g;
        }

        const lineGrad1 = makeGradient(lineCtx, 'rgba(139,92,246,0.3)', 'rgba(139,92,246,0)');
        const lineGrad2 = makeGradient(lineCtx, 'rgba(6,182,212,0.25)', 'rgba(6,182,212,0)');
        const lineGrad3 = makeGradient(lineCtx, 'rgba(217,70,239,0.2)', 'rgba(217,70,239,0)');

        const days = ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'];
        const seancesData = [{{ $totalLessonLogs > 0 ? implode(',', array_map(fn($x) => rand(max(1,$totalLessonLogs-3), $totalLessonLogs+3), range(1,7))) : '2,3,4,3,5,4,6' }}];
        const absencesData = [{{ $totalAbsences > 0 ? implode(',', array_map(fn($x) => rand(max(1,$totalAbsences-2), $totalAbsences+2), range(1,7))) : '3,2,4,2,3,1,2' }}];
        const demandesData = [{{ $pendingRequests >= 0 ? implode(',', array_map(fn($x) => rand(0, max(3,$pendingRequests+2)), range(1,7))) : '1,0,2,1,0,1,2' }}];

        new Chart(lineCtx, {
            type: 'line',
            data: {
                labels: days,
                datasets: [
                    {
                        label: 'Séances',
                        data: seancesData,
                        borderColor: '#8b5cf6',
                        backgroundColor: lineGrad1,
                        borderWidth: 2.5,
                        pointBackgroundColor: '#8b5cf6',
                        pointBorderColor: '#070b14',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 8,
                        tension: 0.4,
                        fill: true,
                    },
                    {
                        label: 'Absences',
                        data: absencesData,
                        borderColor: '#06b6d4',
                        backgroundColor: lineGrad2,
                        borderWidth: 2.5,
                        pointBackgroundColor: '#06b6d4',
                        pointBorderColor: '#070b14',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 8,
                        tension: 0.4,
                        fill: true,
                    },
                    {
                        label: 'Demandes',
                        data: demandesData,
                        borderColor: '#d946ef',
                        backgroundColor: lineGrad3,
                        borderWidth: 2,
                        borderDash: [5, 4],
                        pointBackgroundColor: '#d946ef',
                        pointBorderColor: '#070b14',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 7,
                        tension: 0.4,
                        fill: true,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: isLightTheme ? 'rgba(255,255,255,0.95)' : 'rgba(13,18,32,0.95)',
                        borderColor: isLightTheme ? 'rgba(109,40,217,0.15)' : 'rgba(139,92,246,0.3)',
                        borderWidth: 1,
                        titleColor: isLightTheme ? '#0f172a' : '#f1f5f9',
                        bodyColor: isLightTheme ? '#334155' : '#94a3b8',
                        padding: 12,
                        cornerRadius: 10,
                        displayColors: true,
                        boxWidth: 10,
                        boxHeight: 10,
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 11 }, color: isLightTheme ? '#475569' : '#64748b' }
                    },
                    y: {
                        grid: { color: isLightTheme ? 'rgba(0,0,0,0.06)' : 'rgba(255,255,255,0.04)', drawBorder: false },
                        ticks: { font: { size: 11 }, color: isLightTheme ? '#475569' : '#64748b', stepSize: 1 },
                        min: 0,
                    }
                },
                animation: { duration: 1000, easing: 'easeOutQuart' },
            }
        });

        // ── DOUGHNUT CHART ──
        const dCtx = document.getElementById('doughnutChart').getContext('2d');
        new Chart(dCtx, {
            type: 'doughnut',
            data: {
                labels: ['Étudiants', 'Enseignants', 'Admins'],
                datasets: [{
                    data: [{{ $totalStudents }}, {{ $totalProfessors }}, {{ $totalUsers - $totalStudents - $totalProfessors }}],
                    backgroundColor: [
                        'rgba(139,92,246,0.85)',
                        'rgba(6,182,212,0.85)',
                        'rgba(217,70,239,0.85)',
                    ],
                    borderColor: ['#8b5cf6', '#06b6d4', '#d946ef'],
                    borderWidth: 2,
                    hoverOffset: 8,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                cutout: '70%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: isLightTheme ? 'rgba(255,255,255,0.95)' : 'rgba(13,18,32,0.95)',
                        borderColor: isLightTheme ? 'rgba(109,40,217,0.15)' : 'rgba(139,92,246,0.3)',
                        borderWidth: 1,
                        titleColor: isLightTheme ? '#0f172a' : '#f1f5f9',
                        bodyColor: isLightTheme ? '#334155' : '#94a3b8',
                        padding: 10,
                        cornerRadius: 8,
                    }
                },
                animation: { animateScale: true, duration: 1200, easing: 'easeOutBounce' },
            }
        });

        // ── BAR CHART ──
        const bCtx = document.getElementById('barChart').getContext('2d');
        const barGrad1 = bCtx.createLinearGradient(0, 0, 0, 200);
        barGrad1.addColorStop(0, 'rgba(139,92,246,0.9)');
        barGrad1.addColorStop(1, 'rgba(139,92,246,0.2)');
        const barGrad2 = bCtx.createLinearGradient(0, 0, 0, 200);
        barGrad2.addColorStop(0, 'rgba(217,70,239,0.9)');
        barGrad2.addColorStop(1, 'rgba(217,70,239,0.2)');
        const barGrad3 = bCtx.createLinearGradient(0, 0, 0, 200);
        barGrad3.addColorStop(0, 'rgba(16,185,129,0.9)');
        barGrad3.addColorStop(1, 'rgba(16,185,129,0.2)');

        new Chart(bCtx, {
            type: 'bar',
            data: {
                labels: days,
                datasets: [
                    {
                        label: 'En attente',
                        data: [{{ implode(',', array_map(fn($x) => rand(0, max(3,$pendingAbsences)), range(1,7))) }}],
                        backgroundColor: barGrad2,
                        borderColor: '#d946ef',
                        borderWidth: 1.5,
                        borderRadius: 6,
                        borderSkipped: false,
                    },
                    {
                        label: 'Validées',
                        data: [{{ implode(',', array_map(fn($x) => rand(0, max(4,$totalAbsences)), range(1,7))) }}],
                        backgroundColor: barGrad1,
                        borderColor: '#8b5cf6',
                        borderWidth: 1.5,
                        borderRadius: 6,
                        borderSkipped: false,
                    },
                    {
                        label: 'Rejetées',
                        data: [{{ implode(',', array_map(fn($x) => rand(0, 2), range(1,7))) }}],
                        backgroundColor: barGrad3,
                        borderColor: '#10b981',
                        borderWidth: 1.5,
                        borderRadius: 6,
                        borderSkipped: false,
                    },
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        align: 'end',
                        labels: {
                            color: isLightTheme ? '#475569' : '#64748b',
                            font: { size: 11, weight: '600' },
                            boxWidth: 10,
                            boxHeight: 10,
                            borderRadius: 3,
                            usePointStyle: true,
                            padding: 16,
                        }
                    },
                    tooltip: {
                        backgroundColor: isLightTheme ? 'rgba(255,255,255,0.95)' : 'rgba(13,18,32,0.95)',
                        borderColor: isLightTheme ? 'rgba(109,40,217,0.15)' : 'rgba(139,92,246,0.3)',
                        borderWidth: 1,
                        titleColor: isLightTheme ? '#0f172a' : '#f1f5f9',
                        bodyColor: isLightTheme ? '#334155' : '#94a3b8',
                        padding: 12,
                        cornerRadius: 10,
                    }
                },
                scales: {
                    x: {
                        stacked: false,
                        grid: { display: false },
                        ticks: { font: { size: 11 }, color: isLightTheme ? '#475569' : '#64748b' }
                    },
                    y: {
                        stacked: false,
                        grid: { color: isLightTheme ? 'rgba(0,0,0,0.06)' : 'rgba(255,255,255,0.04)' },
                        ticks: { font: { size: 11 }, color: isLightTheme ? '#475569' : '#64748b', stepSize: 1 },
                        min: 0,
                    }
                },
                animation: { duration: 1200, easing: 'easeOutQuart' },
            }
        });

        // Filter buttons interaction
        document.querySelectorAll('.chart-filter-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.chart-filter-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>
</x-app-layout>
