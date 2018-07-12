@extends('layouts.admin')

@section('content')
<div>
    <section class="hero is-info is-bold is-fullheight">
        <div class="hero-body">
            <div class="container">
                <form action="{{ route('login') }}" method="post">
                    @csrf

                    <div class="" style="max-width: 400px;margin: auto;">
                        <div class="">

                            @if($errors->any())
                                <div class="notification is-danger">
                                    {{ $errors->first() }}
                                </div>
                            @endif

                            <h1 class="title">WordPress License Server</h1>
                            <h2 class="subtitle has-text-weight-light is-3">Login</h2>

                            <div class="field">
                                <label class="label has-text-light" for="username">Username</label>
                                <input class="input {{ $errors->any() ? ' is-danger' : '' }}" type="text" id="username" name="username" placeholder="Username" value="{{ old('email') }}" required autofocus/>
                            </div>

                            <div class="field">
                                <label class="label has-text-light" for="password">Password</label>
                                <input class="input {{ $errors->any() ? ' is-danger' : '' }}" type="password" id="password" name="password" placeholder="Password" required />
                            </div><br>
                            <div class="field">
                                <button class="button is-pulled-right" type="submit">Login</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection