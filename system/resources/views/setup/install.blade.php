@extends('layouts.setup')

@section('content')
<div>        
    <section class="hero is-info is-bold is-fullheight" id="app">
        <div class="hero-body">
            <div class="container">
                <form action="{{ route('setup:install') }}" method="post">
                    @csrf

                    <div style="max-width: 400px;margin: auto;">
                        <h1 class="title">WordPress License Server</h1>
                        <h2 class="subtitle has-text-weight-light is-3">Installation</h2>
                        
                        @if(isset($errors) && $errors->any())
                            <div class="notification is-danger">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        @if (session('db-error'))
                            <div class="notification is-danger">
                                {{ session('db-error') }}
                            </div>
                        @endif

                        <div v-if="page === 0">
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
                            
                            <continue-button>Continue</continue-button>
                        </div>

                        <div v-if="page === 1">
                                <div class="columns">
                                    <div class="column">
                                        <div class="field">
                                            <label class="label has-text-light" for="db_host">MySQL Host</label>
                                            <input class="input" type="text" id="db_host" name="db_host" placeholder="MySQL Host" required v-model="mysqlHost"/>
                                        </div>
                                    </div>
                                    <div class="column is-4">
                                        <div class="field">
                                            <label class="label has-text-light" for="db_port">Port</label>
                                            <input class="input" type="number" id="db_port" name="db_port" placeholder="Port" required v-model="mysqlPort"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="field">
                                    <label class="label has-text-light" for="db_database">MySQL Database Name</label>
                                    <input class="input" type="text" id="db_database" name="db_database" placeholder="MySQL Database" required v-model="mysqlDatabase"/>
                                </div>

                                <div class="field">
                                    <label class="label has-text-light" for="db_user">MySQL Username</label>
                                    <input class="input" type="text" id="db_user" name="db_user" placeholder="MySQL Username" required v-model="mysqlUsername"/>
                                </div> 

                                <div class="field">
                                    <label class="label has-text-light" for="db_pass">MySQL Password</label>
                                    <input class="input" type="password" id="db_pass" name="db_pass" placeholder="MySQL Password" v-model="mysqlPassword" required/>
                                </div><br><br>

                                <div class="field">
                                    <label class="label has-text-light" for="app_url">Application URL</label>
                                    <input class="input" type="url" id="app_url" name="app_url" placeholder="https://yoururl.com/" v-model="url" required/>
                                </div>

                                <div class="field">
                                    <label class="label has-text-light" for="envato_api_key">Envato API Key</label>
                                    <input class="input" type="password" id="envato_api_key" name="envato_api_key" placeholder="Envato API Key" v-model="envatoApiKey" required/>
                                </div><br><br>
                                
                                <div class="field">
                                    <label class="label has-text-light" for="admin_username">Admin Username</label>
                                    <input class="input" type="text" id="admin_username" name="admin_username" placeholder="Username" v-model="adminUsername" required/>
                                </div>

                                <div class="field">
                                    <label class="label has-text-light" for="admin_password">Admin Password</label>
                                    <input class="input" type="password" id="admin_password" name="admin_password" placeholder="Password" v-model="adminPassword" required/>
                                </div>
                                
                                <br>

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
    <script src="https://unpkg.com/vue@2.5.16/dist/vue.min.js"></script>
    <script>
            let app;
            
            Vue.component('page', {
                template: '<slot></slot></div>'
            });

            Vue.component('continue-button', {
                template: '<div class="field" style="margin-top: 40px; float: right;"><button @click.prevent="app.page += 1;" class="button text-align-right"><slot></slot></button></div>'
            });

            app = new Vue({
                el: '#app',
                data: {
                    page: 1,
                    envatoApiKey: '',
                    mysqlHost: '127.0.0.1',
                    mysqlPort: '3306',
                    mysqlDatabase: '',
                    mysqlUsername: '',
                    mysqlPassword: '',
                    url: '',
                    adminUsername: '',
                    adminPassword: ''
                }
            });
        </script>
</div>
@endsection