<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class TableIndex extends Component
{

     use withPagination;
    
    public $modelId;
    public $modelClass;

    public  $confirming = false;
    public $message = '';
    
     public function mount($modelClass)
    {
        
        $this->modelClass = $modelClass;
        
    }

    
    // Add this property for event listening reliability
    // protected $listeners = ['showDeleteModal' => 'openModal'];
    // #[On('openModal')]
    public function openModal($id)
    {
         $this->modelId = $id;
        $this->confirming = true;
    }

    public function delete()
    {
        
        if (!$this->modelClass || !$this->modelId) {
            $this->confirming = false;
            return;
        }

        $model = $this->modelClass::find($this->modelId);

        if ($model) {
            $model->delete();
            $this->message = 'Item deleted successfully.';
            $this->dispatch('staffDeleted');
        } else {
            $this->message = 'Item not found.';
        }
        session()->flash('deleted', 'Staff deleted successfully.');
        $this->confirming = false;
    }

    public function render()
    {
        return view('livewire.table-index',[
             'items' => $this->modelClass::paginate(10),
             'columns' => (new $this->modelClass)->getFillable(),
        ]);
    }
}