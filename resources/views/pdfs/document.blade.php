<!DOCTYPE html>
<html>
<head>
    <title>{{ $request->type }}</title>
    <style>
        body { font-family: sans-serif; }
        .header { text-align: center; margin-bottom: 50px; }
        .content { line-height: 1.6; }
        .footer { margin-top: 100px; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Université Polytechnique de Fès</h1>
        <h2>{{ $request->type }}</h2>
    </div>

    <div class="content">
        <p>Je soussigné, l'administration de l'UPF, certifie par la présente que :</p>
        <p><strong>Nom et Prénom :</strong> {{ $request->user->name }}</p>
        <p><strong>Email :</strong> {{ $request->user->email }}</p>
        
        @if($request->user->isStudent())
            <p><strong>Filière :</strong> {{ $request->user->student->group->department->name }}</p>
            <p><strong>Groupe :</strong> {{ $request->user->student->group->name }}</p>
            
            @if($request->type === 'Relevé de notes')
                <p>A obtenu les notes requises et validé son année universitaire 2025/2026.</p>
            @else
                <p>Est régulièrement inscrit(e) au sein de notre établissement pour l'année universitaire 2025/2026.</p>
            @endif
        @elseif($request->user->isProfessor())
            <p><strong>Qualité :</strong> Professeur Enseignant</p>
            @if($request->type === 'Attestation de travail')
                <p>Est employé(e) au sein de notre établissement en tant que Professeur pour l'année universitaire 2025/2026.</p>
            @elseif($request->type === 'Ordre de mission')
                @php $details = json_decode($request->reason, true); @endphp
                @if($details)
                    <p>Est autorisé(e) à effectuer une mission officielle :</p>
                    <p><strong>Destination :</strong> {{ $details['destination'] ?? '' }}</p>
                    <p><strong>Période :</strong> du {{ \Carbon\Carbon::parse($details['start_date'] ?? '')->format('d/m/Y') }} au {{ \Carbon\Carbon::parse($details['end_date'] ?? '')->format('d/m/Y') }}</p>
                    <p><strong>Motif de la mission :</strong> {{ $details['motif'] ?? '' }}</p>
                @else
                    <p>Est autorisé(e) à effectuer une mission officielle pour le compte de l'UPF.</p>
                @endif
            @endif
        @endif
        
        <p>Fait à Fès, le {{ date('d/m/Y') }}</p>
    </div>

    <div class="footer">
        <p>Signature et Cachet de la Direction</p>
    </div>
</body>
</html>