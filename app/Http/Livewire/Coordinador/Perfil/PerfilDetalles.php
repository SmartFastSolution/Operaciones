<?php

namespace App\Http\Livewire\Coordinador\Perfil;

use App\Document;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class PerfilDetalles extends Component
{
	use WithPagination;
    use WithFileUploads;

	protected $paginationTheme = 'bootstrap';
	protected $listeners       = ['guardarUbicacion', 'guardarDatos', 'eliminarDocumento', 'enviarImagenes'];
	public $user;
    public $foto;
    public $photos = [];
    public $documentos = [];
    public $imagenes = [];
    public function render()
    {
        $this->user = Auth::user();
        $this->documentos = $this->user->documentos->whereNotIn('extension', ['png','jpeg', 'jpg']);
        $this->imagenes = $this->user->documentos->whereIn('extension',  ['png','jpeg', 'jpg'])->pluck('archivo');


        return view('livewire.coordinador.perfil.perfil-detalles');
    }
    public function enviarImagenes()
    {
        $user = Auth::user();
        $this->imagenes = $user->documentos->whereIn('extension',  ['png','jpeg', 'jpg'])->pluck('archivo');
        $this->emit('imagenes',['mensaje' => $this->imagenes]);

    }
    public function guardarUbicacion($position)
    {
    	$user  = Auth::user();
    	$user->latitud = $position['lat'];
    	$user->longitud = $position['lng'];
    	$user->save();


        $this->emit('success',['mensaje' => 'Ubicacion Guardada Correctamente']);
    	
    	
    }
    public function guardarDatos($datos)
    {   
        $user                     = Auth::user();
        $user->telefono           = $datos['telefono'];
        $user->domicilio          = $datos['direccion'];
        $user->sector_id          = $datos['sector'];
        $user->actividad_personal = $datos['actividad_personal'];
        $user->detalle_actividad  = $datos['detalle_actividad'];
        $user->horario_atencion   = $datos['horario_atencion'];
    	$user->save();

        $this->emit('success',['mensaje' => 'Datos Actualizados Correctamente']);
    }
    public function guardarAvatar()
    {
        $this->validate([
            'foto'      => 'required|image|max:1024', // 1MB Max
        ],[
            'foto.max'  => 'El tamaño de la imagen excede el limite', // 1MB Max
            'foto.image'  => 'El archivo no es una imagen', // 1MB Max
        ]);
        if ($this->user->avatar) {
            $image_path = public_path().$this->user->avatar;
               unlink($image_path);
        }
        $nombre   = time().'_'.$this->foto->getClientOriginalName();
        $urlimagen  = '/img/avatar/'.$nombre;

        $this->foto->storeAs('img/avatar',  $nombre, 'public_upload');
        $user                     = Auth::user();
        $user->avatar = $urlimagen;
        $user->save();
        $this->emit('actualizar',['avatar' => $urlimagen]);
        $this->emit('success',['mensaje' => 'Avatar Actualizado Correctamente']);
        $this->foto = null;

    }
    public function guardarDocumentos()
    {
         $this->validate([
            'foto.*' => 'max:51200', 
        ]);
        foreach ($this->photos as $photo) {
        $nombre   = time().'_'.$photo->getClientOriginalName();
        $urldocumento  = '/documentos/'.$nombre;
        $photo->storeAs('documentos',  $nombre, 'public_upload');
        $user = Auth::user();
        $documento = new Document(['nombre'=> $photo->getClientOriginalName(), 'extension'=> pathinfo($urldocumento, PATHINFO_EXTENSION), 'archivo'=>$urldocumento]);
        $user->documentos()->save($documento);
        }
        $this->photos = [];
        $this->emit('success',['mensaje' => 'Archivos Guardados Correctamente', 'modal' => '#cargarArchivo']);
        $this->enviarImagenes();
    }
    public function resetInput()
    {
        $this->photos = [];
    }
    public function eliminarDocumento($id)
    {
        $documento = Document::find($id);
        $image_path = public_path().$documento->archivo;
        unlink($image_path);
        $documento->delete();
        $this->emit('info',['mensaje' => 'Archivo Eliminado Correctamente']);
    }
}
