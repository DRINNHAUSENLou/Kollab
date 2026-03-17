@extends('layouts.app')
@section('title', 'Profil utilisateur - ' . $user->name . ' | Kollab')
@section('content')
    @livewire('user-profile')
<script>
    window.addEventListener('userChanged', () => {
        window.location.reload();
    });
</script>

@endsection
