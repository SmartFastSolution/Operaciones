<?php

namespace App\Http\Livewire\Component;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DatosPersonales extends Component
{
	public $user, $telefono, $celular, $domicilio;
    public function render()
    {
		$this->user = Auth::user();
		$this->telefono   = $this->user->telefono;
		$this->celular    = $this->user->celular;
		$this->domicilio  = $this->user->domicilio;
        return view('livewire.component.datos-personales');
    }
    public function updateDate()
    {
		$user            = Auth::user();
		$user->telefono  = $this->telefono;
		$user->celular   = $this->celular;
		$user->domicilio = $this->domicilio;
		$user->save();

     $this->emit('info',['mensaje' => 'Datos ActualizadOS Correctamente']);

    }
}
