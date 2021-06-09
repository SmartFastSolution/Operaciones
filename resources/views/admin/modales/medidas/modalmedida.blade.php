<!-- Vertically Center -->
<div wire:ignore.self class="modal fade" id="createMedida" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="createMedidaLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">@if ($editMode)
          Actualizar @else Crear
        @endif Unidad De Medida</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="resetInput">
        <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-row">
          <div class="form-group col-md-12">
            <label for="inputAddress">Magnitud</label>
            <input type="text" wire:model.defer="magnitud_medida" class="form-control @error('magnitud_medida') is-invalid @enderror"  placeholder="Magnitud">
            @error('magnitud_medida')
            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
            @enderror
          </div>
          <div class="form-group col-md-12">
            <label for="inputAddress">Unidad</label>
            <input type="text" wire:model.defer="unidad_medida" class="form-control @error('unidad_medida') is-invalid @enderror"  placeholder="Unidad">
            @error('unidad_medida')
            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
            @enderror
          </div>
          <div class="form-group col-md-12">
            <label for="inputAddress">Simbolo</label>
            <input type="text" wire:model.defer="icono_medida" class="form-control @error('icono_medida') is-invalid @enderror"  placeholder="Simbolo o Abreviatura">
            @error('icono_medida')
            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
            @enderror
          </div>
          <div class="form-group col-md-12">
            <label for="inputEmail4">Descripción</label>
            <textarea name="" id="" cols="30" rows="10" wire:model.defer="descripcion_medida" class="form-control @error('descripcion_medida') is-invalid @enderror"></textarea>
            @error('descripcion_medida')
            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
            @enderror
          </div>
        </div>
        <div class="selectgroup selectgroup-pills">
          Estado:
          <label class="selectgroup-item">
            <input type="radio" wire:model="estado" name="estado" value="on" class="selectgroup-input">
            <span class="selectgroup-button selectgroup-button-icon"><i class="fas fa-toggle-on"></i></span>
          </label>
          <label class="selectgroup-item">
            <input type="radio" wire:model="estado" name="estado" value="off" class="selectgroup-input">
            <span class="selectgroup-button selectgroup-button-icon"><i class="fas fa-toggle-off"></i></span>
          </label>
          <span class="badge @if ($estado == 'on')
            badge-success @else badge-danger
          @endif">{{ $estado }}</span>
        </div>
      </div>
      <div class="modal-footer br">
        @if ($editMode)
        <button type="button" class="btn btn-warning" wire:click="updateMedida">Actualizar Medida</button>
        @else
        <button type="button" class="btn btn-primary" wire:click="crearMedida">Crear Medida</button>
        @endif
        {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
      </div>
    </div>
  </div>
</div>
<!-- CONVERSION DE MEDIDA -->
<div wire:ignore.self class="modal fade" id="createConversion" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="createConversionLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Conversiones de Unidades</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="resetConversiones">
        <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        @isset ($medida)
        <div class="form-row">
          <div class="form-group col-lg-4 col-sm-12">
            <label for="">Unidad de Medida</label>
            <input type="text" disabled="" value="{{ $medida->unidad }}" class="form-control ">
          </div>
          <div class="form-group col-lg-4 col-sm-12">
            <label for="">Unidad a Convertir</label>
            @if ($editConversion)
            <input type="text" disabled="" value="{{ $conversion }}" class="form-control ">
            @else
              <select name="" id="" class="form-control @error('medida_conversion') is-invalid @enderror" wire:model="medida_conversion">
              <option value="" selected="" disabled="">Selecciona una Unidad</option>
              @foreach ($conversiones as $con)
              <option value="{{ $con->id }}">{{ $con->unidad }}</option>
              @endforeach
            </select>
            @error('medida_conversion')
            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
            @enderror
            @endif
            
          </div>
          <div class="form-group col-lg-4 col-sm-12">
            <label for="">Factor</label>
            <input type="number"  value="" wire:model.defer="factor" class="form-control @error('factor') is-invalid @enderror">
            @error('factor')
            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
            @enderror
          </div>
   {{--        <div class="form-group col-lg-6 col-sm-12">
            <label for="">Operacion</label>
            <select name="" id="" class="form-control @error('operacion') is-invalid @enderror" wire:model.defer="operacion">
              <option value="" selected="" disabled="">Selecciona una accion</option>
              <option value="multiplicar">Multiplicar</option>
              <option value="dividir">Division</option>
            </select>
            @error('operacion')
            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
            @enderror
          </div> --}}
        </div>
        <div class="row justify-content-center">
          @if ($editConversion)
          <button wire:click.prevent="updateConversion" class="btn btn-info">Actualizar Conversión</button><button class="btn btn-danger" wire:click="cancelEdit"><i class="fa fa-window-close"></i></button>
          @else
          <button wire:click.prevent="createCon" class="btn btn-success">Crear Conversión</button>
          @endif
        </div>
        @endisset
        <div class="mt-3" style="height: 300px; overflow-y: scroll;">
          <h4 class="text-center text-danger">CONVERSIONES</h4>
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Unidad</th>
                <th>Conversión</th>
                {{-- <th>Operacion</th> --}}
                <th class="text-center" colspan="2">Acciones</th>
              </tr>
            </thead>
            <tbody>
              @isset ($medida)
              @foreach($medida->conversiones as $c => $conversion)
              <tr>
                <td>{{ $conversion->medida->unidad }}</td>
                <td>{{ $conversion->factor }}</td>
                {{-- <td>{{ $conversion->accion }}</td> --}}
                <td width="50"><a href="" wire:click.prevent="editarConversion({{ $c }})" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i> </a></td>
                <td width="50"><a href="" wire:click.prevent="eliminarConversion({{ $medida->id}},{{ $conversion->id }})" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> </a></td>
              </tr>
              @endforeach
              @endisset
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer br">
        
      </div>
    </div>
  </div>
</div>