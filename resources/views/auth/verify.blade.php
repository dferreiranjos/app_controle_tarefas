@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Falta pouco agora!') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Um email com um link de validação foi enviado para você') }}
                        </div>
                    @endif

                    {{ __('Antes de continuar, verifique o link enviado para o seu email') }}.<br>
                    {{ __('Caso não tenha recebido o email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('Click aqui para enviar outro email') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
