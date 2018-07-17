@extends('layouts.setup')

@section('content')
<div>        
    <section class="hero is-info is-bold is-fullheight" id="app">
        <div class="hero-body">
            <div class="container">
                <div style="max-width: 400px;margin: auto;">
                    <h1 class="title">WordPress License Server</h1>
                    <h2 class="subtitle has-text-weight-light is-3">Status</h2>
                    
                    @if(isset($errors) && $errors->any())
                        <div class="notification is-danger">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <pre>{{ $output }}</pre>

                    <br>
                    <div class="field" style="margin-top: 40px; float: right;">
                        <a href="{{ route('admin:index') }}" class="button text-align-right">
                            Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection