<?php

namespace App\Livewire;
use Illuminate\Support\Facades\Auth;


use Livewire\Component;

class UserProfile extends Component
{
    public $user;
    public $form = [
        'name' => '',
        'email' => '',
        'couleur' => '',
    ];
    public $colorPalette = ['#06b6d4', '#8b5cf6', '#c72626ff', '#dd872bff', '#84cc16', '#eab308', '#412919ff', '#4043d1ff', '#ec4899'];

    public function mount()
    {
        $this->user = Auth::user();
        $this->form = [
            'name' => $this->user->name,
            'email' => $this->user->email,
            'couleur' => $this->user->couleur,
        ];
    }

    public function save()
    {
        $this->validate([
            'form.name' => 'required|string|max:255',
            'form.email' => 'required|string|email|max:255|unique:users,email,' . $this->user->id,
            'form.couleur' => 'required|string',
        ]);
        $this->user->update($this->form);
        session()->flash('success', 'Profil modifié avec succès !');
        $this->dispatch('userChanged');

    }

    public function render()
    {
        return view('livewire.user-profile');
    }
}
