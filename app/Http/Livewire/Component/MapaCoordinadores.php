<?php

namespace App\Http\Livewire\Component;

use App\User;
use Livewire\Component;
use Livewire\WithPagination;

class MapaCoordinadores extends Component
{
		use WithPagination;
		protected $paginationTheme = 'bootstrap';
		protected $listeners       = ['obtenerMapas'];
		protected $queryString     =
		[
		'search'                   => ['except' => ''],
		'page', 
		'status'                   => ['except' => '']
		];
		public $perPage            = 100;
		public $search             = '';
		public $orderBy            = 'requerimientos.id';
		public $orderAsc           = true;
		public $estado             ='pendiente';
		public $status             = '';
		public $sector_id          ='';
		public $sectorSearch       ='';
		public $conteo             = 0;
		public $rango              = 100;
		public $requerimiento_id   ='';
		public $editMode           = false;
		public $createDisabled     = false;
		public function render()
    {
  	// $coordinador = User::role('coordinador')
   //   	->leftJoin('sectors', 'users.sector_id', '=', 'sectors.id')
   //  	->where(function ($query) {
   //                 $query->where('users.username', 'like', '%'.$this->search.'%')
   //                     ->orWhere('users.cedula', 'like', '%'.$this->search.'%')
   //                     ->orWhere('users.nombres', 'like', '%'.$this->search.'%')
   //                     ->orWhere('users.domicilio', 'like', '%'.$this->search.'%')
   //                     ->orWhere('users.cedula', 'like', '%'.$this->search.'%');
   //      })
   //      ->where(function ($query) {
   //      	if ($this->sectorSearch !== '') {
   //                 $query->where('sectors.nombre', 'like', '%'.$this->sectorSearch.'%');
        		
   //      	}
   //      })
   //              // ->where('sectors.nombre', 'like', '%'.$this->sectorSearch.'%')
   //              ->where('users.estado', 'on')
   //              ->select('users.*', 'sectors.nombre as sector')
   //              ->latest()
   //              ->take($this->rango)
   //              ->get(['id', 'latitud', 'longitud']);

   //              // dd($coordinador);


   //              // $this->conteo = $requerimientos->count();
                $this->obtenerMapas();
        return view('livewire.component.mapa-coordinadores');
    }

        public function obtenerMapas()
    {
   $coordinador = User::role('coordinador')
     	->leftJoin('sectors', 'users.sector_id', '=', 'sectors.id')
    	->where(function ($query) {
                   $query->where('users.username', 'like', '%'.$this->search.'%')
                       ->orWhere('users.cedula', 'like', '%'.$this->search.'%')
                       ->orWhere('users.nombres', 'like', '%'.$this->search.'%')
                       ->orWhere('users.domicilio', 'like', '%'.$this->search.'%')
                       ->orWhere('users.cedula', 'like', '%'.$this->search.'%');
        })
         ->where(function ($query) {
        	if ($this->sectorSearch !== '') {
                   $query->where('sectors.nombre', 'like', '%'.$this->sectorSearch.'%');
        		
        	}
        })
                ->where('users.estado', 'on')
                ->select('users.*', 'sectors.nombre as sector')
                ->latest()
                ->take($this->rango)
                ->get(['id', 'latitud', 'longitud']);


     	$this->emit('mapas',['mapas' => $coordinador]);

    }
}
