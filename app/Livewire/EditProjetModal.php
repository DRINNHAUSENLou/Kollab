<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Projet;

class EditProjetModal extends Component
{
    public $projet;
    public $nom, $description, $date_debut, $date_fin_prevue, $statut, $priorite;
    public $showModal = false;
    public $confirmDelete = false;

    protected $rules = [
        'nom' => 'required|string',
        'description' => 'nullable|string',
        'date_debut' => 'nullable|date',
        'date_fin_prevue' => 'nullable|date',
        'statut' => 'required|string',
        'priorite' => 'required|string',
    ];

    public function mount(Projet $projet)
    {
        $this->projet = $projet;

        $this->nom = $projet->nom;
        $this->description = $projet->description;
        $this->date_debut = $projet->date_debut ? date('Y-m-d\TH:i', strtotime($projet->date_debut)) : null;
        $this->date_fin_prevue = $projet->date_fin_prevue ? date('Y-m-d\TH:i', strtotime($projet->date_fin_prevue)) : null;
        $this->statut = $projet->statut;
        $this->priorite = $projet->priorite;
    }

    public function save()
    {
        $this->validate();
        $this->projet->update([
            'nom' => $this->nom,
            'description' => $this->description,
            'date_debut' => $this->date_debut,
            'date_fin_prevue' => $this->date_fin_prevue,
            'statut' => $this->statut,
            'priorite' => $this->priorite,
        ]);
        session()->flash('success', 'Projet modifié avec succès !');
        $this->showModal = false;
    $this->dispatch('projetUpdated');
    }

    public function openModal()
    {
        $this->showModal = true;
    }
    public function closeModal()
    {
        $this->showModal = false;
        $this->confirmDelete = false;

    }

    public function render()
    {
        return view('livewire.edit-projet-modal');
    }

    public function askDelete()
    {
        $this->confirmDelete = true;
    }
    public function cancelDelete()
    {
        $this->confirmDelete = false;
    }
public function deleteProjet()
{
    if (auth()->id() !== $this->projet->chef_id) {
        abort(403, 'Suppression du projet réservée au chef.');
    }
// Solution préférée : utiliser membresListe pour avoir des Users
$membres = $this->projet->membresListe;

foreach ($membres as $membre) {
    if (!$membre->id) continue; // Ignore si pas d'id utilisateur

    \App\Models\Notification::create([
        'projet_id' => $this->projet->id_projet,
        'type' => 'projet_supprime',
        'notifiable_type' => 'App\Models\User',
        'notifiable_id' => $membre->id, // Toujours existant si User lié
        'data' => "Le projet '{$this->projet->nom}' a été supprimé.",
        'created_at' => now(),
        'updated_at' => now(),
    ]);
}


    // Supprimer le projet
    $this->projet->delete();

    $this->confirmDelete = false;
    session()->flash('success', 'Projet supprimé avec succès !');
    return redirect()->route('projet.index');
}


}
