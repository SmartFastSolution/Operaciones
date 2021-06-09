<?php

namespace App\Http\Livewire\Admin\Users;

use App\Exports\UserExport;
use App\Imports\UsersImport;
use App\Instituto;
use App\Mail\UserRegister;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Usuarios extends Component
{
	use WithPagination;
    use WithFileUploads;
	protected $paginationTheme = 'bootstrap';
	protected $listeners       = ['eliminarUser'];
	protected $queryString     =['search' => ['except' => ''],
    'page', 'findrole' => ['except' => '']
];
	public $perPage        = 10;
	public $search         = '';
	public $orderBy        = 'id';
	public $orderAsc       = true;
	public $findrole       ='';
	public $role           ='';
	public $rol            ='';
	public $estado         ='on';
	public $permiso        = '';
	public $user_id        ='';
	public $roles          =[];
	public $permissions    = [];
	public $allRoles       = [];
	public $editMode       = false;

    // CREAR Usuarios
    public $reNombres, $reCedula, $reEmail, $reTelefono, $reCelular, $reDireccion, $reUsuario, $file;
    public function render()
    {
    	 $data = User::where('users.id', '!=', 1)
                ->where(function ($query) {
                       $query->where('users.nombres', 'like', '%'.$this->search.'%')
                       ->orWhere('users.cedula', 'like', '%'.$this->search.'%')
                       ->orWhere('users.username', 'like', '%'.$this->search.'%')
                        ->orWhere('users.email', 'like', '%'.$this->search.'%');
                 })
    	 		->where(function ($query) {
                    if ($this->findrole !== '') {
                       $query->role($this->findrole); 
                    }
                 })
                ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
                ->paginate($this->perPage); 
        return view('livewire.admin.users.usuarios', compact('data'));
    }
        public function crearUsuario()
    {
      $this->validate([
            'reNombres'   => 'required',
            'reCedula'    => 'required|unique:users,cedula',
            'reUsuario'    => 'required|unique:users,username',
            'reEmail'     => 'required|email|unique:users,email',
            'rol'         => 'required',

        ],[
            'reNombres.required'   => 'No has agregado el nombre del usuario',
            'reUsuario.required'    => 'No has agregado el usuario',
            'reCedula.required'    => 'No has agregado la cedula o el DNI',
            'reUsuario.unique'      => 'Este usuario ya se encuentra registrado',
            'reCedula.unique'      => 'Esta cedula o DNI ya se encuentra registrado',
            'reEmail.required'     => 'No has agregado el correo',
            'reEmail.email'        => 'Agrega un correo valido',
            'reEmail.unique'       => 'Este correo ya se encuentra en uso',
            'rol.required'         => 'No has selecionado un rol',
    ]);   

     

        // $clave = Str::random(8);
		$clave              = 12345678;
		$user               = new User;
		$user->nombres      = $this->reNombres;
		$user->username     = $this->reUsuario;
		$user->cedula       = $this->reCedula;
		$user->email        = $this->reEmail;
		$user->estado       = 'on';
		$user->activated_at =Carbon::now();
		$user->password     = Hash::make($clave); 
		$user->save();

        $user->assignRole($this->rol);
        $this->resetInput();
        $this->emit('success',['mensaje' => 'Usuario Registrado Correctamente', 'modal' => '#createUser']);

        // Mail::to($user->email)->send(new UserRegister($user, $clave));

    }
        public function resetInput()
    {
		$this->reNombres = null;
		$this->rol       = "";
		$this->user_id   = "";
		$this->estado    = "on";
		$this->reCedula  = null;
		$this->reUsuario = null;
		$this->reEmail   = null;
		$this->editMode  = false;

    }
        public function editUser($id)
    {
		$this->user_id   = $id;
		$user            = User::find($id);
		$this->reNombres = $user->nombres;
		$this->reCedula  = $user->cedula;
		$this->reUsuario = $user->username;
		$this->reEmail   = $user->email;
		$this->estado    = $user->estado;
		$this->editMode  = true;
		 if ($user->hasRole('coordinador')) {
            $this->rol         = "coordinador";
        }elseif ($user->hasRole('operador')) {
            $this->rol         = "operador";
        }elseif ($user->hasRole('admin')) {
            $this->rol         = "admin";
        }
    }
        public function updateUser()
    {
              $this->validate([
            'reNombres'   => 'required',
            'reUsuario'    => 'required|unique:users,cedula,'.$this->user_id,
            'reCedula'    => 'required|unique:users,cedula,'.$this->user_id,
            'reEmail'     => 'required|email|unique:users,email,'.$this->user_id,
            'rol'         => 'required',

        ],[
            'reNombres.required'   => 'No has agregado el nombre del usuario',
            'reCedula.required'    => 'No has agregado la cedula o el DNI',
            'reCedula.unique'      => 'Esta cedula o DNI ya se encuentra registrado',
            'reUsuario.required'   => 'No has agregado el usuario',
            'reUsuario.unique'     => 'Este usuario ya se encuentra registrado',
            'reEmail.required'     => 'No has agregado el correo',
            'reEmail.email'        => 'Agrega un correo valido',
            'reEmail.unique'       => 'Este correo ya se encuentra en uso',
            'rol.required'         => 'No has selecionado un rol',
    ]);  
		$user           = User::find($this->user_id);
		$user->nombres  = $this->reNombres;
		$user->cedula   = $this->reCedula;    
		$user->username = $this->reUsuario;    
		$user->email    = $this->reEmail;
		$user->estado   = $this->estado;
        $user->save();
        $user->syncRoles([$this->rol]);
        $this->resetInput();
        $this->emit('info',['mensaje' => 'Usuario Actualizado Correctamente', 'modal' => '#createUser']);




    }
        public function eliminarUser($id)
    {
          $user = User::find($id);
            $user->delete();
            $this->emit('info',['mensaje' => 'Usuario Eliminado Correctamente']);

    }
     public function estadochange($id)
    {
        $estado =User::find($id);
        if ($estado->estado == 'on') {
            $estado->estado ='off';
            $estado->save();

         $this->emit('info',['mensaje' => 'Estado Desactivado Actualizado']);

         } else {
            $estado->estado = 'on';
         $estado->save();

        $this->emit('info',['mensaje' => 'Estado Activado Actualizado']);

         }
          
 
    }
    public function save()
    {
            $this->validate([
            'file' => 'required|mimes:xlsx,xls', // 1MB Max
        ]);

            Excel::import(new UsersImport, $this->file);
    }
    public function generaExcel()
    {
        $datos = User::where('users.id', '!=', 1)
                ->leftJoin('sectors', 'users.sector_id', '=', 'sectors.id')
                ->where(function ($query) {
                       $query->where('users.nombres', 'like', '%'.$this->search.'%')
                        ->orWhere('users.email', 'like', '%'.$this->search.'%');
                 })
                ->where(function ($query) {
                    if ($this->findrole !== '') {
                       $query->role($this->findrole); 
                    }
                 })
                ->select('users.*', 'sectors.nombre as sector')
                ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
                ->get(); 

        return Excel::download(new UserExport($datos), 'usuarios.xlsx');
        }
}
