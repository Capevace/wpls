@extends('layouts.setup')

@section('content')
<div>        
    <section class="hero is-info is-bold is-fullheight" id="app">
        <div class="hero-body">
            <div class="container">
                <form action="{{ route('setup:create-admin') }}" method="post">
                    @csrf

                    <div style="max-width: 400px;margin: auto;">
                        <h1 class="title">WordPress License Server</h1>
                        <h2 class="subtitle has-text-weight-light is-3">Success</h2>
                        
                        @if(isset($errors) && $errors->any())
                            <div class="notification is-danger">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <pre>{{ $output }}</pre>
                        <br>
                        <p>
                            A connection to the database was established.
                            All you need to do now, is to register your admin account and then you're good to go!
                        </p>
                        <br>

                        <div class="field">
                            <label class="label has-text-light" for="admin_name">Firstname & Lastname</label>
                            <input class="input" type="text" id="admin_name" name="admin_name" placeholder="John Doe" required/>
                        </div>

                        <div class="field">
                            <label class="label has-text-light" for="admin_username">Admin Username</label>
                            <input class="input" type="text" id="admin_username" name="admin_username" placeholder="Administrator" required/>
                        </div>

                        <div class="field">
                            <label class="label has-text-light" for="admin_password">Admin Password</label>
                            <input class="input" type="password" id="admin_password" name="admin_password" placeholder="Password" required/>
                        </div>

                        <div class="field">
                            <label class="label has-text-light" for="admin_email">Support Email</label>
                            <input class="input" type="text" id="admin_email" name="admin_email" placeholder="support@example.com" required/>
                        </div>

                        <div class="field" style="margin-top: 40px; float: right;">
                            <button type="submit" id="submit" name="submit" class="button text-align-right">
                                Create Account
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection