<div wire:ignore.self class="modal fade" id="crearIngreso" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="crearIngresoLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-light" id="exampleModalCenterTitle">Crear Ingreso</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="resetInput">
        <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h3 class="text-center font-weight-bold">DATOS DEL INGRESO</h3>
        <div class="form-row">
          <div class="form-group col-lg-2 col-sm-12">
            <label for="">CODIGO</label>
            <input type="text" class="form-control" wire:model.defer="codigo_ingreso">
            @error('codigo_ingreso') <span class="error text-danger">{{ $message }}</span> @enderror
          </div>
          <div class="form-group col-lg-2 col-sm-12">
            <label for="">VALOR TOTAL</label>
            <input type="number" class="form-control" wire:model.defer="total_ingreso">
            @error('total_ingreso') <span class="error text-danger">{{ $message }}</span> @enderror
          </div>
          <div class="form-group col-lg-8 col-sm-12">
            <label for="">DESCRIPCIÓN</label>
            <input type="text" class="form-control" wire:model.defer="descripcion_ingreso">
            @error('descripcion_ingreso') <span class="error text-danger">{{ $message }}</span> @enderror
          </div>
        </div>
        <div class="border p-2">
          <h3 class="text-center">PRODUCTO</h3>
          <div class="form-row justify-content-center">
            <div class="form-group col-lg-4 col-sm-12">
              <select name="" id="" class="custom-select" wire:model.defer="producto_id">
                <option value="" selected="" disabled="">Seleccione un Producto</option>
                @foreach ($productos as $producto)
                <option value="{{ $producto->id }}">{{ $producto->nombre }}, {{ $producto->presentacion }} {{ $producto->medida->simbolo }}</option>
                @endforeach
              </select>
              @error('producto_id') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group col-lg-3 col-sm-12">
              <input type="number" class="form-control text-right" wire:model.defer="producto_cantidad" placeholder="Cantidad">
              @error('producto_cantidad') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group col-lg-3 col-sm-12">
              <input type="number" class="form-control text-right" wire:model.defer="producto_precio" placeholder="Precio">
              @error('producto_precio') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group col-lg-2 col-sm-12">
              <label for=""></label>
              <button class="btn btn-success" wire:click="agregarItem">Agregar</button>
            </div>
          </div>
          <h3 class="text-danger font-italic text-center">Productos</h3>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead class="text-light-all bg-dark">
                <tr>
                  <th>Producto</th>
                  <th>Cantidad</th>
                  <th>Precio</th>
                  <th>Total($)</th>
                  <th>Borrar</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($items as $key => $item)
                <tr>
                  <td>{{ $item['nombre'] }}</td>
                  <td width="150">
                    <div class="input-group input-group-sm mb-1 mt-1">
                      <div class="input-group-prepend">
                        <button class="input-group-text" id="inputGroup-sizing-sm" wire:click="decrementar({{ $key }})">-</button>
                      </div>
                      <input type="number" class="form-control text-center" wire:change="changeCantidad({{ $key }})"  wire:model="items.{{ $key }}.cantidad" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                      <div class="input-group-prepend">
                        <button class="input-group-text" id="inputGroup-sizing-sm" wire:click="incrementar({{ $key }})">+</button>
                      </div>
                    </div>
                  </td>
                  <td>{{ $item['precio'] }}</td>
                  <td>{{ $item['total'] }}</td>
                  <td width="25"><button class="btn btn-danger"><i class="fa fa-trash"></i></button></td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer br">
        @if ($exportando)
        <button class="btn btn-primary" type="button" disabled>
        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        Cargando...
        </button>
        @else
        <button type="button" class="btn btn-primary" wire:click="generarIngreso">Generar Ingreso</button>
        @endif
      </div>
    </div>
  </div>
</div>