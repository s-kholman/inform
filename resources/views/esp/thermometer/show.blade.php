@extends('layouts.base')
@section('title', 'Термометры')

@section('info')

    <div class="container gx-4">
            <div class="row">
                <div class="col-6">
                    @dump($thermometers)
                </div>
            </div>
    </div>
@endsection('info')
