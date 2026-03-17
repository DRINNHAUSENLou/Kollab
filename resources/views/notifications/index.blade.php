@extends('layouts.app')

@section('title', 'Notifications | Kollab')

@section('content')
    <div class="w-full flex flex-col items-center">
    <div class="w-full max-w-2xl">
        <!-- Titre et bouton -->
        <div class="flex items-center justify-between mb-10">
            <h2 class="text-2xl md:text-2xl font-bold text-purple-400 drop-shadow tracking-tight">
                Notifications
            </h2>
            @if(!$notifications->isEmpty())
                <form action="{{ route('notifications.lire_tout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="bg-gradient-to-r from-blue-600 to-purple-700 text-white font-semibold px-6 py-2 rounded-xl shadow border-none hover:scale-105 transition">
                        Tout marquer comme lu
                    </button>
                </form>
            @endif
        </div>

        @if($notifications->isEmpty())
            <div class="bg-gray-900/70 rounded-2xl shadow border border-gray-800 py-20 flex flex-col items-center">
            <svg class="h-20 w-20 text-amber-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" fill="currentColor">
                <path d="M320 64C302.3 64 288 78.3 288 96L288 99.2C215 114 160 178.6 160 256L160 277.7C160 325.8 143.6 372.5 113.6 410.1L103.8 422.3C98.7 428.6 96 436.4 96 444.5C96 464.1 111.9 480 131.5 480L508.4 480C528 480 543.9 464.1 543.9 444.5C543.9 436.4 541.2 428.6 536.1 422.3L526.3 410.1C496.4 372.5 480 325.8 480 277.7L480 256C480 178.6 425 114 352 99.2L352 96C352 78.3 337.7 64 320 64zM258 528C265.1 555.6 290.2 576 320 576C349.8 576 374.9 555.6 382 528L258 528z"/>
            </svg>
                <p class="text-gray-400 text-lg font-medium mt-5">Vous n'avez aucune notification.</p>
            </div>
        @else
            <div class="flex flex-col gap-8 items-center">
                @foreach($notifications as $notification)
                    <div class="w-full bg-gray-900/80 rounded-2xl shadow-md border-none px-8 py-5 flex flex-col">
                        <p class="font-semibold text-purple-200 text-lg leading-snug mb-4 text-left">
                            {{ $notification->data }}
                        </p>
                        <div class="flex w-full justify-between items-center">
                            <span class="text-xs text-gray-400">{{ $notification->created_at->locale('fr')->diffForHumans() }}</span>
                            <span class="px-4 py-1 rounded-full text-sm font-medium {{ is_null($notification->read_at) ? 'bg-blue-700/20 text-blue-300 border border-blue-700/40' : 'bg-gray-800/60 text-gray-400 border border-gray-700/20' }}">
                                {{ is_null($notification->read_at) ? 'Nouveau' : 'Lu' }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

@endsection
