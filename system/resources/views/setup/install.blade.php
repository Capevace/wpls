@extends('layouts.setup')

@section('content')
<div>        
    <section class="hero is-info is-bold is-fullheight" id="app">
        <div class="hero-body">
            <div class="container">
                <form action="{{ route('setup:install') }}" method="post">
                    @csrf

                    <div style="margin: auto;">
                        <h1 class="title">WordPress License Server</h1>
                        <h2 class="subtitle has-text-weight-light is-3">Installation</h2>

                        @if (isset($error))
                            <div class="notification is-danger">
                                {{ $error }}
                            </div>
                        @endif

                        <div id="setup-page-1">
                            <p>
                                <i>Dear buyer,</i> <br>
                                thanks for purchasing WordPress License Server!<br>
                                <br>
                                <i>If you've bought WPLS prior to version 3.0, please refer to the README to see how you migrate to this version without causing problems for your users.</i><br>
                                <br>
                                To install WPLS you will be asked to enter your MySQL details and an Envato API key.<br>
                                If you don't know where to get your Envato API key, please check the README for more information.<br>
                                <br>
                                Let's go!
                            </p>
                            
                            <div class="field" style="margin-top: 40px; float: right;">
                                <button class="button text-align-right continue-button">
                                    Continue
                                </button>
                            </div>
                        </div>

                        <div id="setup-page-2" style="display: none;">
                                <div class="columns">
                                    <div class="column">
                                        <div class="field">
                                            <label class="label has-text-light" for="db_host">MySQL Host</label>
                                            <input class="input" type="text" id="db_host" name="db_host" placeholder="MySQL Host" required value="127.0.0.1"/>
                                        </div>
                                    </div>
                                    <div class="column is-4">
                                        <div class="field">
                                            <label class="label has-text-light" for="db_port">Port</label>
                                            <input class="input" type="number" id="db_port" name="db_port" placeholder="Port" required value="3306"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="field">
                                    <label class="label has-text-light" for="db_database">MySQL Database Name</label>
                                    <input class="input" type="text" id="db_database" name="db_database" placeholder="MySQL Database" required  />
                                </div>

                                <div class="field">
                                    <label class="label has-text-light" for="db_user">MySQL Username</label>
                                    <input class="input" type="text" id="db_user" name="db_user" placeholder="MySQL Username" required  />
                                </div> 

                                <div class="field">
                                    <label class="label has-text-light" for="db_pass">MySQL Password</label>
                                    <input class="input" type="password" id="db_pass" name="db_pass" placeholder="MySQL Password" />
                                </div><br><br>

                                <div class="field">
                                    <label class="label has-text-light" for="app_url">Application URL</label>
                                    <input class="input" type="url" id="app_url" name="app_url" placeholder="https://yoururl.com/" required/>
                                </div>

                                <div class="field">
                                    <label class="label has-text-light" for="envato_api_key">Envato API Key</label>
                                    <input class="input" type="password" id="envato_api_key" name="envato_api_key" placeholder="Envato API Key" required/>
                                </div><br><br>

                                <div class="field">
                                    <label class="label has-text-light" for="update_password">Update Password</label>
                                    <input class="input" type="password" id="update_password" name="update_password" placeholder="Password" required/>
                                </div>

                                <div class="field" style="margin-top: 40px; float: right;">
                                    <button type="submit" id="submit" name="submit" class="button text-align-right">
                                        Install now!
                                    </button>
                                </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <script>
        document
            .querySelector('.continue-button')
            .addEventListener('click', function(event) {
                event.preventDefault();

                document
                    .querySelector('#setup-page-1')
                    .style
                    .display = 'none';

                document
                    .querySelector('#setup-page-2')
                    .style
                    .display = 'block';
            });
        </script>
</div>
@endsection