

@extends('layouts.app')

@section('title', 'Roadmap - ' . $projet->nom . ' | Kollab')

@push('styles')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css' rel='stylesheet' />
@endpush

@section('content')
<header class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4 mx-5 mt-3">
    <div>
        <h1 class="text-2xl font-bold text-purple-400 tracking-tight">
            Calendrier des sprints: <span class="font-bold">{{ $projet->nom }}</span>
        </h1>
        <p class="text-gray-400 text-sm">Gérez vos sprints et visualisez leurs tâches associées</p>
    </div>

    <div class="flex flex-wrap gap-4 justify-center md:justify-end mt-4">
        <a href="{{ route('projet.show', $projet->id_projet) }}"
           class="group relative inline-flex items-center gap-2 bg-gray-900/60 text-gray-200 border border-gray-700 rounded-xl px-5 py-2.5 shadow-md hover:bg-gray-800 hover:shadow-lg transition duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-purple-300 group-hover:-translate-x-1 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            <span>Retour</span>
        </a>
        @auth
            @if(Auth::id() === $projet->chef_id)
                <a href="{{ route('projet.sprints.create', $projet->id_projet) }}"
                   class="group relative inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-purple-700 text-white font-medium px-5 py-2.5 rounded-xl shadow-lg hover:shadow-2xl hover:scale-[1.03] transition duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 group-hover:rotate-6 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Nouveau sprint</span>
                </a>
            @endif
        @endauth
    </div>
</header>

<div class="mx-auto w-full max-w-[1400px]">
    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <div class="bg-gradient-to-br from-blue-900/40 to-blue-800/20 border border-blue-700/50 rounded-xl p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-300 text-sm font-medium">Total sprints</p>
                    <p class="text-3xl font-bold text-blue-100 mt-1">{{ $sprints->count() }}</p>
                </div>
                <div class="bg-blue-600/30 p-3 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-green-900/40 to-green-800/20 border border-green-700/50 rounded-xl p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-300 text-sm font-medium">En cours</p>
                    <p class="text-3xl font-bold text-green-100 mt-1">
                        {{ $sprints->filter(function($s) {
                            $now = \Carbon\Carbon::now();
                            $debut = \Carbon\Carbon::parse($s->date_debut);
                            $fin = \Carbon\Carbon::parse($s->date_fin)->endOfDay(); // <-- Correction ici
                            return $now->greaterThanOrEqualTo($debut) && $now->lessThanOrEqualTo($fin);
                        })->count() }}
                    </p>
                </div>
                <div class="bg-green-600/30 p-3 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-green-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-purple-900/40 to-purple-800/20 border border-purple-700/50 rounded-xl p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-300 text-sm font-medium">À venir</p>
                    <p class="text-3xl font-bold text-purple-100 mt-1">
                        {{ $sprints->filter(function($s) {
                            return \Carbon\Carbon::parse($s->date_debut)->isFuture();
                        })->count() }}
                    </p>
                </div>
                <div class="bg-purple-600/30 p-3 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-purple-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
<div class="grid grid-cols-1 md:grid-cols-4 gap-8 items-start">
    <!-- Calendrier (prend toute la largeur si Livewire absent) -->
    @if($sprints->count() === 0)
        <div class="md:col-span-4 bg-gray-900/60 border border-gray-700 rounded-xl p-6 w-full mx-auto">
            <div id="calendar"></div>
        </div>
    @else
        <div class="md:col-span-3 bg-gray-900/60 border border-gray-700 rounded-xl p-6 w-full max-w-full">
            <div id="calendar"></div>
        </div>
        <!-- Colonne Livewire à droite seulement si contenu -->
        <div class="bg-gray-800/60 border border-gray-700 rounded-xl p-5 w-full max-w-[320px] mx-auto md:mx-0">
            @livewire('sprint-board', ['projet' => $projet])
        </div>
    @endif
</div>

</div>


<!-- Pop up -->
<div id="sprint-modal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
    <div class="bg-gray-900 rounded-xl border border-gray-700 p-8 w-full max-w-xl shadow-lg relative">
            <button id="close-modal"
            class="absolute w-10 h-10 top-3 right-3 text-gray-400 hover:text-white text-3xl font-bold flex items-center justify-center leading-none">
            &times;
        </button>
        <h2 id="modal-sprint-title" class="text-2xl font-bold text-purple-400 mb-2"></h2>
        <p class="text-gray-400 mb-2 text-sm">
            <span id="modal-sprint-dates"></span>
        </p>
        <p id="modal-sprint-objectif" class="text-gray-300 text-md mb-2"></p>
        <hr class="border-t-2 border-purple-800 my-3 rounded">

            <div class="mb-2">
                <div class="flex items-center gap-2 mb-1">
                    <svg class="w-4 h-4 text-purple-400" fill="none" viewBox="0 0 20 20">
                        <circle cx="10" cy="10" r="7" fill="currentColor"/>
                    </svg>
                    <span class="text-gray-300 text-sm mb-1">Epics liés au sprint</span>
                </div>
                    <div id="modal-sprint-content" class="overflow-y-auto max-h-[400px] pr-2 custom-scrollbar"></div>
            </div>

        <a href="#" id="modal-sprint-link"
            class="mt-5 inline-block bg-gradient-to-r from-blue-600 to-purple-700 hover:scale-[1.03] text-white px-5 py-2 rounded-xl transition duration-200 font-normal text-center w-full">
            Voir le sprint
        </a>
    </div>
</div>

@endsection

@push('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/locales/fr.global.min.js'></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'fr',
        firstDay: 1,
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek'
        },
        buttonText: {
            today: "Aujourd'hui",
            month: 'Mois',
            week: 'Semaine',
        },
        events: [
@foreach($sprints as $sprint)
    @php
        $dateDebut = \Carbon\Carbon::parse($sprint->date_debut);
        $dateFin = \Carbon\Carbon::parse($sprint->date_fin);
        $now = \Carbon\Carbon::now();

        if ($now->lt($dateDebut)) {
            // À venir :
            $color = '#6c0f83';
            $border = '#8819a3ff';
            $textColor = '#e9d5ff';
        } elseif ($now->between($dateDebut, $dateFin->endOfDay())) {
            // En cours :
            $color = '#096647ff';
            $border = '#2fb170ff';
            $textColor = '#d1fae5';
        } else {
            // Terminé :
            $color = '#455a86';
            $border = '#374151';
            $textColor = '#e5e7eb';
        }

    @endphp
    {
        id: '{{ $sprint->id_sprint }}',
        title: '{{ addslashes($sprint->nom) }}',
        start: '{{ \Carbon\Carbon::parse($sprint->date_debut)->format('Y-m-d') }}',
        end: '{{ \Carbon\Carbon::parse($sprint->date_fin)->addDay()->format('Y-m-d') }}',
        backgroundColor: '{{ $color }}',
        borderColor: '{{ $border }}',
        textColor: '{{ $textColor }}',
        objectif: "{{ addslashes($sprint->objectif) }}",
        date_debut: "{{ $dateDebut->format('d/m/Y') }}",
        date_fin: "{{ $dateFin->format('d/m/Y') }}",
        url: '{{ route('tache.index', $projet->id_projet) }}?sprint_id={{ $sprint->id_sprint }}'
    },
@endforeach

        ],
        eventContent: function(arg) {
    // Le titre du Sprint
    let title = document.createElement('span');
    title.innerText = arg.event.title;
    title.className = 'font-bold text-left';

    // Bouton personnalisé
    let button = document.createElement('button');
    button.innerText = 'Voir';
    button.className = 'ml-2 bg-gradient-to-r from-blue-600 to-purple-700 px-3 py-1 rounded-md border-2 border-purple-300 text-white text-xs font-medium shadow hover:scale-[1.03] transition duration-200';

    button.onclick = function(e) {
        e.preventDefault();
        const modal = document.getElementById('sprint-modal');
        document.getElementById('modal-sprint-title').innerText = arg.event.title;
        document.getElementById('modal-sprint-objectif').innerText = arg.event.extendedProps.objectif || "Aucun objectif précisé";
        document.getElementById('modal-sprint-link').href = arg.event.url;
        document.getElementById('modal-sprint-dates').innerText =
            "Du " + (arg.event.extendedProps.date_debut || "—") +
            " au " + (arg.event.extendedProps.date_fin || "—");
        modal.classList.remove('hidden');
    };

    // Conteneur horizontal avec Flex
    let container = document.createElement('div');
    container.className = 'flex items-center'; // important, alignement horizontal
    container.appendChild(title);
    container.appendChild(button);

    return { domNodes: [container] };
},

eventClick: function(info) {
    info.jsEvent.preventDefault();

    const sprintId = info.event.id; // ID du sprint cliqué
    const modal = document.getElementById('sprint-modal');
fetch('/sprints/details/' + sprintId)
  .then(res => res.json())
  .then(data => {
    document.getElementById('modal-sprint-title').textContent = data.nom;
    document.getElementById('modal-sprint-objectif').textContent = data.objectif || "Aucun objectif précisé";
    document.getElementById('modal-sprint-link').href = '{{ route("tache.index", $projet->id_projet) }}?sprint_id=' + sprintId;
    document.getElementById('modal-sprint-dates').textContent =
      "Du " + (info.event.extendedProps.date_debut || "—") +
      " au " + (info.event.extendedProps.date_fin || "—");

    let html = '';
    if (!data.epics || data.epics.length === 0) {
      // Aucun epic présent
      html = `<div class="italic text-gray-500">Aucun epic</div>`;
    } else {
      data.epics.forEach(epic => {
        html += `
          <div class="mb-4 p-4 border border-gray-700 rounded-xl">
            <div class="text-purple-300 font-semibold">
              Epic : ${epic.epic}
            </div>
            <ul class="ml-4 list-disc text-gray-200">
              ${
                epic.taches.length
                ? epic.taches.map(t => `<li>${t.titre} <span class="text-xs text-gray-400">(${t.statut})</span></li>`).join('')
                : `<li class="italic text-gray-500">Aucune tâche pour cet epic</li>`
              }
            </ul>
          </div>
        `;
      });
    }
    document.getElementById('modal-sprint-content').innerHTML = html;

    modal.classList.remove('hidden');
  });

    document.getElementById('close-modal').onclick = () => modal.classList.add('hidden');
    modal.onclick = (e) => {
        if (e.target === modal) modal.classList.add('hidden');
    };
},

        dayMaxEvents: true,
        eventDisplay: 'block',
        displayEventTime: false,
        height: 'auto'
    });
    calendar.render();

    // Style Tailwind ajusté
    const style = document.createElement('style');
    style.textContent = `
        #calendar { color: #e5e7eb; }
        .fc { background: transparent; }
        .fc-theme-standard td, .fc-theme-standard th { border-color: #374151; }
        .fc-col-header-cell { background: #1f2937; color: #9ca3af; font-weight: 600; text-transform: uppercase; font-size: 0.75rem; padding: 0.75rem; border-color: #374151; }
        .fc-daygrid-day { background: #111827; }
        .fc-daygrid-day:hover { background: #1f2937; }
        .fc-day-today { background: #1e293b !important; }
        .fc-day-today .fc-daygrid-day-number { background: #6366f1; color: white; border-radius: 50%; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; }
        .fc-daygrid-day-number { color: #d1d5db; padding: 0.5rem; font-weight: 500; }
        .fc-button { margin-right: 0.5rem; background: #374151 !important; border-color: #4b5563 !important; color: #e5e7eb !important; text-transform: capitalize !important; font-weight: 500 !important; padding: 0.5rem 1rem !important; border-radius: 0.5rem !important; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important; }
        .fc-button:hover { background: #4b5563 !important; }
        .fc-button:disabled { opacity: 0.5 !important; }
        .fc-button-active { background: linear-gradient(to right, #2563eb, #7c3aed) !important; border-color: #6366f1 !important; }
        .fc-toolbar-title { color: #f3f4f6 !important; font-size: 1.5rem !important; font-weight: 700 !important; }
        .fc-toolbar-chunk { gap: 0.75rem; display: flex; align-items: center; }
        .fc-toolbar > .fc-toolbar-chunk > .fc-button-group { gap: 0.75rem; }
        .fc-event { border-radius: 0.375rem !important; padding: 0.25rem 0.5rem !important; font-size: 0.875rem !important; font-weight: 600 !important; cursor: pointer !important; transition: all 0.2s !important; border-width: 2px !important; }
        .fc-event:hover { opacity: 0.85 !important; transform: translateY(-2px) !important; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3) !important; }
        .fc-daygrid-day-frame { min-height: 100px; }
        .fc-scrollgrid { border-color: #374151 !important; }
        .fc-list { background: #111827; border-color: #374151 !important; }
        .fc-list-event:hover td { background: #1f2937 !important; }
        .fc-list-day-cushion { background: #1f2937 !important; color: #9ca3af !important; }
        .fc-prev-button, .fc-next-button { margin-right: 0.5rem; }
     `;
    document.head.appendChild(style);
});
document.addEventListener('keydown', function(e) {
    const modal = document.getElementById('sprint-modal');
    if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
        modal.classList.add('hidden');
    }
});

</script>
<script>
    window.addEventListener('sprintChanged', () => {
        window.location.reload();
    });
</script>
<style>
.custom-scrollbar::-webkit-scrollbar {
  width: 8px;
}

.custom-scrollbar::-webkit-scrollbar-track {
  background: #000000ff;
  border-radius: 10px;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
  background: #240f57ff;
  border-radius: 10px;
  border: 1px solid #000000;
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
  background: #2d2d2d;
}

.custom-scrollbar {
  scrollbar-width: thin;
  scrollbar-color: #240f57ff #000000;
}

</style>

@endpush


