<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Sprint;

class SprintBoard extends Component
{
    public $projet;
    public $sprints;
    public $editingSprint = null;
    public $popupSprint = null;

    protected $listeners = ['showPopupSprint', 'closeModal'];

    public $form = [
        'nom' => '',
        'date_debut' => '',
        'date_fin' => '',
        'objectif' => '',
    ];

    public function mount($projet)
    {
        $this->projet = $projet;
        $this->sprints = Sprint::where('id_projet', $projet->id_projet)->orderBy('date_debut')->get();
    }

    public function editSprint($id)
    {
        if (auth()->id() !== $this->projet->chef_id) {
            abort(403, 'Modification du sprint réservée au chef.');
        }
        $sprint = Sprint::findOrFail($id);
        $this->editingSprint = $sprint;
        $this->form = [
            'nom' => $sprint->nom,
            'date_debut' => $sprint->date_debut ? $sprint->date_debut->format('Y-m-d') : '',
            'date_fin' => $sprint->date_fin ? $sprint->date_fin->format('Y-m-d') : '',
            'objectif' => $sprint->objectif,
        ];
    }

    public function saveSprint()
    {
        if (auth()->id() !== $this->projet->chef_id) {
            abort(403, 'Modification du sprint réservée au chef.');
        }

        $this->validate([
            'form.nom' => 'required|string|max:255',
            'form.date_debut' => 'required|date',
            'form.date_fin' => 'required|date|after_or_equal:form.date_debut',
            'form.objectif' => 'nullable|string',
        ]);

        $sprint = Sprint::findOrFail($this->editingSprint->id_sprint);
        $sprint->fill($this->form);
        $sprint->save();

        $this->editingSprint = null;
        $this->sprints = Sprint::where('id_projet', $this->projet->id_projet)->orderBy('date_debut')->get();
        session()->flash('success', 'Sprint modifié avec succès !');
        $this->dispatch('sprintChanged');
    }

    public $confirmDelete = false;

    public function askDelete()
    {
        $this->confirmDelete = true;
    }

    public function cancelDelete()
    {
        $this->confirmDelete = false;
    }

    public function deleteSprint()
    {
        if (auth()->id() !== $this->projet->chef_id) {
            abort(403, 'Suppression du sprint réservée au chef.');
        }
        if ($this->editingSprint) {
            $this->editingSprint->delete();
            $this->editingSprint = null;
            $this->confirmDelete = false;
            $this->sprints = Sprint::where('id_projet', $this->projet->id_projet)->orderBy('date_debut')->get();
            session()->flash('success', 'Sprint supprimé avec succès !');
            $this->dispatch('sprintChanged');
        }
    }

    public function closeModal()
    {
        $this->editingSprint = null;
        $this->confirmDelete = false;

    }

    public function render()
    {
        return view('livewire.sprint-board');
    }


    public function showPopupSprint($sprintId)
    {
        $this->popupSprint = $this->sprints->firstWhere('id_sprint', $sprintId);
    }

    public function closePopupSprint()
    {
        $this->popupSprint = null;
    }

}
