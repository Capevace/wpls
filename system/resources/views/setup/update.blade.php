@extends('layouts.setup')

@section('content')
<div>        
    <section class="hero is-info is-bold is-fullheight" id="app">
        <div class="hero-body">
            <div class="container">
                <form action="{{ route('update:update') }}" method="post">
                    @csrf

                    <div style="max-width: 400px;margin: auto;">
                        <h1 class="title">WordPress License Server</h1>
                        <h2 class="subtitle has-text-weight-light is-3">Update</h2>
                        
                        @if(isset($error))
                            <div class="notification is-danger">
                                {{ $error }}
                            </div>
                        @endif

                        <div class="field">
                            <label class="label has-text-light" for="password">Update Password</label>
                            <input class="input" type="password" id="password" name="password" placeholder="Password" required/>
                        </div>

                        <div class="field" style="margin-top: 40px; float: right;">
                            <button type="submit" id="submit" name="submit" class="button text-align-right">
                                Update now!
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection