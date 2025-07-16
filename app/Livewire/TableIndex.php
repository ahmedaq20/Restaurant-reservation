<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class TableIndex extends Component
{

     use withPagination;
    
    public $modelClass;
    public $id;

    public  $confirming = false;
    public $message = '';
    public string $modelRoute;
     public function mount($modelClass)
    {
        
        $this->modelClass = $modelClass;
        
    }

    public function confirmDelete($id){
        $this->id = $id;
    }
    
    public function delete()
    {
       
        $model = $this->modelClass::find($this->id);
        if ($model) {

            // dd('1');
            $model->delete();
            $this->message = 'Item deleted successfully.';
            // $this->dispatch('staffDeleted');
        } else {

            // dd('2');
            $this->message = 'Item not found.';
        }
    session()->flash('deleted', $this->message);
        
      $this->dispatch('close-modal');
    }

    public function render()
    {
        return view('livewire.table-index',[
             'items' => $this->modelClass::paginate(10),
             'columns' => (new $this->modelClass)->getFillable(),
        ]);
    }
}