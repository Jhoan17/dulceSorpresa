@extends('dsadmin.layout')

@section('title','Combo')

@section('scripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.js"></script>
  <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
  <script src="{{asset('dsadmin/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
  <script src="{{asset('dsadmin/plugins/jquery-validation/additional-methods.min.js')}}"></script>
  <script src="{{asset('dsadmin/plugins/jquery-validation/localization/messages_es.min.js')}}"></script>
  <script src="{{asset('dsadmin/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
  <script src="{{asset('dsadmin/pages/scripts/combo/create.js')}}"></script>
  <script src="{{asset('dsadmin/custom/validation-general.js')}}"></script>
  <script>
    $(document).on('click','[data-toggle="lightbox"]', function(event){
      event.preventDefault();
      $(this).ekkoLightbox({
        alwaysShowClose: true
      });
    });
  </script>
  
@endsection

@section('styles')
  <link href="{{asset("dsadmin/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css")}}" rel="stylesheet" type="text/css"/>
  <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
  <link href="{{asset("dsadmin/plugins/icheck-bootstrap/icheck-bootstrap.min.css")}}" rel="stylesheet" type="text/css"/>
  <link href="{{asset("dsadmin/plugins/bootstrap-fileinput/css/fileinput.min.css")}}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')

<section class="content">

  <!-- Default box -->
  <div class="card">
    <!-- form start -->
    <form enctype="multipart/form-data" class="col-md-12" method="POST" action="{{route('combo-store')}}" id="form-general">
    @csrf   
    <div class="card-header">
      <h3 class="card-title"><strong>Crear combo</strong></h3>
      <div class="float-sm-right">
        <a href="{{route('combo-index')}}">Listado</a> / <a class="active">Crear</a>
      </div>  
    </div>
    <div class="card-body">
      @include('includes.form-error')
      @include('includes.messages')
      <div id="toastsContainerTopRight" class="toasts-top-right fixed" style="padding: 2px;">
        <div class="toast bg-info fade show" role="alert" aria-live="assertive" aria-atomic="true">
          <div class="toast-body">
            <strong style="font-size: 20px">Precio sin ganacia: $ <label id="price" data-current-price="0"></label> </strong>
          </div>
        </div>
      </div>
      <div class="row">
          <!-- left column -->
          <div class="col-12 col-sm-12">
            <div class="card card-primary card-outline card-tabs">
              <div class="card-header p-0 pt-1 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-three-home-tab" href="#">Información Basica</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-three-products-tab" href="#">Selección de productos</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-three-bases-tab" href="#">Selección de base</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-three-price-tab" href="#">Precio</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-three-complet-tab" href="#">Completar</a>
                  </li>
                  <li class="nav-item text-right" style="width: 25%;">
                    <a class="nav-link" id="custom-tabs-three-complet-tab" href="#"></a>
                  </li>                
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-three-tabContent">
                  <div class="tab-pane fade active show" id="custom-tabs-three-home" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
                    <div class="row form-group">
                      <div class="col col-md-6">
                        <label for="exampleInputEmail1">Nombre</label>
                        <input type="text" name="combo_name" class="form-control lowercase" id="combo_name" placeholder="Nombre del combo" value="{{old('combo_name')}}" autocomplete="off" {{-- required --}}>
                      </div> 
                      <div class="col col-md-6">
                        <label>Tipo de combo</label>
                        <select class="form-control bs-select" name="combo_type_id" id="combo_type_id" placeholder="hola" {{-- required --}}>
                          <option value="" selected>Seleccione</option>
                          @foreach($combo_types as $combo_type)
                            <option value="{{$combo_type->combo_type_id}}" {{(old("combo_type_id") == $combo_type->combo_type_id ? "selected":"") }} >{{$combo_type->combo_type_name}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div> 
                    <div class="row form-group">                     
                      <div class="col-md-12">
                        <label for="exampleInputEmail1">Descripción</label>
                        <textarea id="combo_description" name="combo_description" class="form-control lowercase" placeholder="Alguna cosa mas que debamos saber sobre el combo">{{old('combo_description')}}</textarea>
                      </div>                                                               
                    </div>
                    <div class="row">
                      <div class="col-md-6 content-self-left">
                      </div>  
                      <div class="row col-md-6 content-self-right">
                        <div class="col-md-6"></div>
                        <a class="col-md-6 col-md-offset-6 nav-button text-center btn btn-primary" id="custom-tabs-three-products-tab" data-toggle="pill" href="#custom-tabs-three-products" data-control="custom-tabs-three-home-tab" role="tab" aria-controls="custom-tabs-three-products" aria-selected="false">Siguiente >></a>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade " id="custom-tabs-three-products" role="tabpanel" aria-labelledby="custom-tabs-three-products-tab" >
                    <div class="row justify-content-center">
                      <div class="row form-group col-md-12">
                        <div class="col-md-6">
                          <a class="col-md-6 nav-button text-center btn btn-primary" id="custom-tabs-three-home-tab" data-toggle="pill" href="#custom-tabs-three-home" role="tab" data-control="custom-tabs-three-products-tab" aria-controls="custom-tabs-three-home" aria-selected="false"><< Atras</a>
                        </div>  
                        <div class="col-md-6 text-right">
                          <a class="col-md-6  nav-button text-center btn btn-primary" id="custom-tabs-three-bases-tab" data-toggle="pill" href="#custom-tabs-three-bases" data-control="custom-tabs-three-products-tab" role="tab" aria-controls="custom-tabs-three-bases" aria-selected="false">Siguiente >></a>
                        </div>
                      </div>
                      <div class="form-group col-md-12">
                        <table class="dataTables_length" id="table-products">
                          <thead>
                            <tr>
                              <th>Imagen</th>
                              <th>Nombre</th>
                              <th>Marca</th>
                              <th>Tipo</th>
                              <th>Precio</th>
                              <th class="text-center">Agregar</th>
                              <th>Cantidad</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($products as $product)
                            <tr>
                              <td>
                                <div class="product-image-thumb" style="width: 42px; height: auto;">
                                  <a href="{{Storage::url("images/products/".$product->product_image_name)}}" data-gallery="product-gallery-{{$product->product_id}}" data-title="{{$product->product_name}} </strong>({{$product->product_description}})" data-toggle="lightbox">
                                  <img src="{{Storage::url("images/products/".$product->product_image_name)}}">
                                  </a>
                                </div>  
                              </td>
                              <td class="align-middle">{{$product->product_name}}</td>
                              <td class="align-middle">{{$product->product_trademark}}</td>
                              <td class="align-middle">{{$product->productType->product_type_name}}</td>
                              <td class="align-middle">${{$product->product_price}}</td>
                              <td class="text-center align-middle">
                                <div class="icheck-primary d-inline">
                                  <input class="checkbox-product" type="checkbox" id="checkbox{{$product->product_id}}"  data-id="{{$product->product_id}}" data-price="{{$product->product_price}}" value="{{$product->product_id}}" name="product_id[]" @if (old("product_id")){{ (in_array($product->product_id, old("product_id")) ? "checked":"") }}@endif>
                                  <label for="checkbox{{$product->product_id}}" >
                                  </label>
                                </div>                          
                              </td>
                              <td>
                                <input class="units-product" name="units[{{$product->product_id}}]" id="units{{$product->product_id}}" data-price="{{$product->product_price}}" type="number" min="0" value="{{ old('units.'.$product->product_id) ?? '0' }}" data-price-count="0" data-id="{{$product->product_id}}"  style="width: 60px; height: 40px; padding: 9px; font-size: 30px; margin: 5px;" disabled>
                              </td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-three-bases" role="tabpanel" aria-labelledby="custom-tabs-three-bases-tab">
                    <div class="row justify-content-center">
                      <div class="row form-group col-md-12">
                        <div class="col-md-6">
                          <a class="col-md-6 nav-button text-center btn btn-primary" id="custom-tabs-three-products-tab" data-toggle="pill" href="#custom-tabs-three-products" role="tab" data-control="custom-tabs-three-bases-tab" aria-controls="custom-tabs-three-products" aria-selected="false"><< Atras</a>
                        </div>  
                        <div class="col-md-6 text-right">
                          <a class="col-md-6  nav-button text-center btn btn-primary" id="custom-tabs-three-price-tab" data-toggle="pill" href="#custom-tabs-three-price" data-control="custom-tabs-three-bases-tab" role="tab" aria-controls="custom-tabs-three-price" aria-selected="false">Siguiente >></a>
                        </div>
                      </div>
                      <div class="form-group col-md-12">
                        <table class="dataTables_length" id="table-bases">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>Imagenes</th>
                              <th>Nombre</th>
                              <th>Medidas</th>
                              <th>Descripción</th>
                              <th>Precio</th>
                              <th class="text-center">Selecciona</th>
                            </tr>
                          </thead>
                          <tbody>@php $count = 1; @endphp
                             <tr>
                                <td>0</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>Sin base</td>
                                <td>$ 0</td>
                                <td class="text-center">
                                  <div class="icheck-primary d-inline">
                                    <input type="radio" class="base" id="radioPrimary0" name="base_id" data-price-before="0" data-price-base="0" value="" {{-- required --}} checked>
                                    <label for="radioPrimary0">
                                    </label>
                                  </div>
                                </td>
                             </tr> 
                            @foreach($bases as $base)
                            <tr>
                              <td class="align-middle">{{$count++}}</td>
                              <td class="justify-content-center">
                                <div class="row">
                                @php $count_image = 0; @endphp
                                @foreach($base->baseImages as $base_image)
                                <div class="product-image-thumb">
                                  <a href="{{Storage::url("images/bases/".$base_image->base_image_name)}}" data-gallery="base-gallery-{{$base->base_id}}" data-title="{{$base->base_name}} </strong>({{$base->base_description}})" data-toggle="lightbox">
                                    <img class="base-image" width="24px" height="32px" src="{{Storage::url("images/bases/".$base_image->base_image_name)}}">
                                  </a>
                                 </div> 
                                 @php $count_image++; @endphp
                                @endforeach                                             
                                </div>
                              </td>
                              <td class="align-middle">{{$base->base_name}}</td>
                              <td class="align-middle">{{$base->base_measure}}</td>
                              <td class="align-middle">{{$base->base_description}}</td>
                              <td class="align-middle">$ {{$base->base_price}}</td>
                              <td class="align-middle text-center">
                                <div class="icheck-primary d-inline">
                                  <input type="radio" class="base" id="radioPrimary{{$base->base_id}}" name="base_id" data-price-before="0" data-price-base="{{$base->base_price}}" value="{{$base->base_id}}" {{(old('base_id') == $base->base_id) ? 'checked' : ''}}{{-- required --}}>
                                  <label for="radioPrimary{{$base->base_id}}">
                                  </label>
                                </div>
                              </td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-three-price" role="tabpanel" aria-labelledby="custom-tabs-three-price-tab">
                   <div class="row form-group">
                      <div class="col-md-3">
                        <label for="exampleInputEmail1">Precio</label>
                        <div class="input-group mb-6">
                          <div class="input-group-prepend">
                            <span class="input-group-text">$</span>
                          </div>
                          <input type="text" name="price-form" class="form-control disabled" id="price-form" placeholder="Precio sin ganancia" value="{{old('price-form') ?? '0'}}" autocomplete="off" {{-- required --}} readonly="readonly">
                        </div>
                      </div>                    
                      <div class="col-md-3">
                        <label for="exampleInputEmail1">Que porcentaje deseas ganar</label>
                        <div class="input-group mb-6">
                          <div class="input-group-prepend">
                            <span class="input-group-text">%</span>
                          </div>
                          <input type="text" name="porcentage" class="form-control" id="porcentage" placeholder="porcentaje" value="{{old('porcentage')}}" autocomplete="off"  {{-- required --}}>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <label for="exampleInputEmail1">ganancia</label>
                        <div class="input-group mb-6">
                          <div class="input-group-prepend">
                            <span class="input-group-text">$</span>
                          </div>
                          <input type="number" name="gain" class="form-control" id="gain" placeholder="Ingrese el porcentaje" value="{{old('gain')}}" autocomplete="off"  {{-- required --}} readonly="readonly">
                        </div>
                      </div>                        
                      <div class="col-md-3">
                        <label for="exampleInputEmail1">Precio más ganancia</label>
                        <div class="input-group mb-6">
                          <div class="input-group-prepend">
                            <span class="input-group-text">$</span>
                          </div>
                          <input type="number" name="combo_price" class="form-control" id="combo_price" placeholder="Ingrese el porcentaje" value="{{old('combo_price')}}" autocomplete="off" {{-- required --}} readonly="readonly">
                        </div>
                      </div>                        
                    </div> 
                    <div class="row">
                      <div class="col-md-6 content-self-left">
                        <a class="col-md-6 col-md-offset-6 nav-button text-center btn btn-primary" id="custom-tabs-three-bases-tab" data-toggle="pill" href="#custom-tabs-three-bases" role="tab" data-control="custom-tabs-three-price-tab" aria-controls="custom-tabs-three-bases" aria-selected="false"><< Atras</a>
                      </div>  
                      <div class="row col-md-6 content-self-right">
                        <div class="col-md-6"></div>
                        <a class="col-md-6 col-md-offset-6 nav-button text-center btn btn-primary" id="custom-tabs-three-complet-tab" data-toggle="pill" href="#custom-tabs-three-complet" data-control="custom-tabs-three-price-tab" role="tab" aria-controls="custom-tabs-three-complet" aria-selected="false">Siguiente >></a>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-three-complet" role="tabpanel" aria-labelledby="custom-tabs-three-complet-tab">
                    <div class="row form-group">                      
                      <div class="col-md-10">
                        <label for="combo_image" id="label-combo-image">Selecciona las imagenes</label>
                          <div class="input-group">
                            <div class="custom-file">
                              <input type="file" multiple="multiple" data-count="4" class="custom-file-input" name="combo_image[]" id="combo_image">
                              <label class="custom-file-label" for="combo_image">da click aquí para seleccionarlas max 4</label>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-2">
                          <div class="form-group">
                            <label for="exampleInputFile">Desactivo/Activo</label>
                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                              <input type="checkbox" checked="checked" class="custom-control-input" id="customSwitch3" name="state">
                              <label class="custom-control-label" for="customSwitch3"></label>
                            </div>
                          </div>
                        </div>
                      </div>                     
                      <div class="row">
                        <div class="col-md-6 content-self-left">
                          <a class="col-md-6 col-md-offset-6 nav-button text-center btn btn-primary" id="custom-tabs-three-price-tab" data-toggle="pill" href="#custom-tabs-three-price" role="tab" data-control="custom-tabs-three-complet-tab" aria-controls="custom-tabs-three-price" aria-selected="false"><< Atras</a>
                        </div>
                        <div class="row col-md-6 content-self-right">
                          <div class="col-md-6"></div>
                            <button type="submit" class="btn btn-primary col-sm-6">Guardar</button>
                        </div>    
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div> 
          </div>
        </div>
        </form>
        <div class="card-footer">
          {{-- Footer --}}
        </div>               
    </div>  

    <!-- /.card-footer-->

</section>

@endsection