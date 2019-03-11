@extends('layouts.app ')

@section('title', 'Nuevo pago')

@section('content')
    <h2>Nuevo pago</h2>
    <div class="divider"></div>
    <br/>
    <a class="waves-effect waves-light btn-small" href="{{ url('checkout') }}">Regresar</a>
    <div class="row">
        <form action="{{ url('checkout') }}" method="post" class="col s12">
            @csrf
            <h5>Información del pago</h5>
            <div class="row">
                <div class="input-field col s6">
                    <i class="material-icons prefix">attach_money</i>
                    <input type="text" name="amount" id="amount" value="{{ old('amount') }}" class="{{ $errors->has('amount') ? 'invalid' : null }}">
                    <label for="amount">Valor a pagar</label>
                    @if($errors->has('amount'))
                        <span class="helper-text red-text">{{ $errors->first('amount') }}</span>
                    @endif
                </div>
                <div class="input-field col s6">
                    <i class="material-icons prefix">description</i>
                    <textarea name="description" id="description" class="{{ $errors->has('description') ? 'materialize-textarea invalid' : 'materialize-textarea' }}">{{ old('description') }}</textarea>
                    <label for="description">Descripción del pago</label>
                    @if($errors->has('description'))
                        <span class="helper-text red-text">{{ $errors->first('description') }}</span>
                    @endif
                </div>
            </div>
            <h5>Información personal</h5>
            <div class="row">
                <div class="input-field col s6">
                    <select name="documentType" id="documentType" class="{{ $errors->has('documentType') ? 'invalid' : null }}">
                        <option value="" disabled selected>Seleccione por favor</option>
                        <option value="CC" {{ old('documentType') == 'CC' ? 'selected' : '' }}>CC</option>
                        <option value="CE" {{ old('documentType') == 'CE' ? 'selected' : '' }}>CE</option>
                        <option value="NIT" {{ old('documentType') == 'NIT' ? 'selected' : '' }}>NIT</option>
                        <option value="RUT" {{ old('documentType') == 'RUT' ? 'selected' : '' }}>RUT</option>
                        <option value="TI" {{ old('documentType') == 'TI' ? 'selected' : '' }}>TI</option>
                        <option value="PPN" {{ old('documentType') == 'PPN' ? 'selected' : '' }}>PPN</option>
                    </select>
                    <label for="documentType">Tipo</label>
                    @if($errors->has('documentType'))
                        <span class="helper-text red-text">{{ $errors->first('documentType') }}</span>
                    @endif
                </div>
                <div class="input-field col s6">
                    <input type="text" name="document" id="document" value="{{ old('document') }}" class="{{ $errors->has('document') ? 'invalid' : null }}">
                    <label for="document">Documento</label>
                    @if($errors->has('document'))
                        <span class="helper-text red-text">{{ $errors->first('document') }}</span>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6">
                    <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" class="{{ $errors->has('first_name') ? 'invalid' : null }}">
                    <label for="first_name">Nombres</label>
                    @if($errors->has('first_name'))
                        <span class="helper-text red-text">{{ $errors->first('first_name') }}</span>
                    @endif
                </div>
                <div class="input-field col s6">
                    <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" class="{{ $errors->has('last_name') ? 'invalid' : null }}">
                    <label for="last_name">Apellidos</label>
                    @if($errors->has('last_name'))
                        <span class="helper-text red-text">{{ $errors->first('last_name') }}</span>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="input-field col s3">
                    <i class="material-icons prefix">email</i>
                    <input type="text" name="email" id="email" value="{{ old('email') }}" class="{{ $errors->has('email') ? 'invalid' : null }}">
                    <label for="email">Correo electrónico</label>
                    @if($errors->has('email'))
                        <span class="helper-text red-text">{{ $errors->first('email') }}</span>
                    @endif
                </div>
                <div class="input-field col s3">
                    <i class="material-icons prefix">add_location</i>
                    <input type="text" name="address" id="address" value="{{ old('address') }}" class="{{ $errors->has('address') ? 'invalid' : null }}">
                    <label for="address">Dirección de residencia</label>
                    @if($errors->has('address'))
                        <span class="helper-text red-text">{{ $errors->first('address') }}</span>
                    @endif
                </div>
                <div class="input-field col s3">
                    <i class="material-icons prefix">location_city</i>
                    <input type="text" name="city" id="city" value="{{ old('city') }}" class="{{ $errors->has('city') ? 'invalid' : null }}">
                    <label for="city">Ciudad</label>
                    @if($errors->has('city'))
                        <span class="helper-text red-text">{{ $errors->first('city') }}</span>
                    @endif
                </div>
                <div class="input-field col s3">
                    <i class="material-icons prefix">phone</i>
                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="{{ $errors->has('phone') ? 'invalid' : null }}">
                    <label for="phone">Celular</label>
                    @if($errors->has('phone'))
                        <span class="helper-text red-text">{{ $errors->first('phone') }}</span>
                    @endif
                </div>
            </div>
            <p><a target="_blank" href="{{ url('') }}/files/faq.pdf">FAQ - Preguntas frecuentes</a></p>
            <p>
                <label>
                    <input type="checkbox" name="accepted" id="accepted" value="true" {{old('accepted') ? 'checked' : ''}}/>
                    <span class="{{ $errors->has('accepted') ? 'red-text tooltipped' : 'tooltipped' }}" data-position="top" data-tooltip="Cualquier persona que realice un compra en el sitio http://localhost/ptpcheckout, actuando libre y voluntariamente, autoriza a CheckoutPTP, a través del proveedor del servicio EGM Ingeniería Sin Fronteras S.A.S y/o Place to Pay para que consulte y solicite información del comportamiento crediticio, financiero, comercial y de servicios a terceros, incluso e...">¿Acepta los téminos y condiciones?</span>
                </label>
            </p>
            <button class="btn waves-effect waves-light" type="submit" name="action">Pagar<i class="material-icons right">send</i></button>
        </form>
    </div>
    <a href="http://www.placetopay.com" target="_blank"><img style="max-height:50px" src="https://dev.placetopay.com/web/wp-content/uploads/2019/02/p2p-logo.svg" class="attachment-120x120 size-120x120" alt=""></a>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var elemsSelects = document.querySelectorAll('select');
            var instancesSelects = M.FormSelect.init(elemsSelects);

            var elemsTooltips = document.querySelectorAll('.tooltipped');
            var instancesTooltips = M.Tooltip.init(elemsTooltips);
        });
    </script>
@endsection