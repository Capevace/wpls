<!doctype html>
<html>
    <head>
        <title>WPLS Installation</title>
        <link rel="stylesheet" href="../css/index.css">
        <script src="https://unpkg.com/vue@2.5.16/dist/vue.min.js"></script>
    </head>
    <body>
        <section class="hero is-info is-bold is-fullheight" id="app">
            <div class="hero-body">
                <div class="container">
                   

                    <div style="max-width: 400px;margin: auto;">
                        <h1 class="title">WordPress License Server</h1>
                        <h2 class="subtitle has-text-weight-light is-3">Installation</h2>
                        
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
                            <form action="install.php" method="post">
                                <div class="field">
                                    <label class="label has-text-light" for="host">MySQL Host</label>
                                    <input class="input" type="text" id="host" name="host" placeholder="MySQL Host" required v-model="mysqlHost"/>
                                </div>

                                <div class="field">
                                    <label class="label has-text-light" for="database">MySQL Database</label>
                                    <input class="input" type="text" id="database" name="database" placeholder="MySQL Database" required v-model="mysqlDatabase"/>
                                </div>

                                <div class="field">
                                    <label class="label has-text-light" for="username">MySQL Username</label>
                                    <input class="input" type="text" id="username" name="username" placeholder="MySQL Username" required v-model="mysqlUsername"/>
                                </div> 

                                <div class="field">
                                    <label class="label has-text-light" for="password">MySQL Password</label>
                                    <input class="input" type="password" id="password" name="password" placeholder="MySQL Password" v-model="mysqlPassword"/>
                                </div><br><br>

                                <div class="field">
                                    <label class="label has-text-light" for="url">Application URL</label>
                                    <input class="input" type="url" id="url" name="url" placeholder="https://yoururl.com/" v-model="url" required/>
                                </div>

                                <div class="field">
                                    <label class="label has-text-light" for="envato">Envato API Key</label>
                                    <input class="input" type="password" id="envato" name="envato" placeholder="Envato API Key" v-model="envatoApiKey"/>
                                </div><br>

                                <div class="field" style="margin-top: 40px; float: right;">
                                    <button type="submit" id="submit" name="submit" class="button text-align-right">
                                        Install now!
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <script>
            let app;
            
            Vue.component('page', {
                template: '<slot></slot></div>'
            });

            Vue.component('continue-button', {
                template: '<div class="field" style="margin-top: 40px; float: right;"><button @click="app.page += 1;" class="button text-align-right"><slot></slot></button></div>'
            });

            app = new Vue({
                el: '#app',
                data: {
                    page: 0,
                    envatoApiKey: '',
                    mysqlHost: 'localhost',
                    mysqlDatabase: '',
                    mysqlUsername: '',
                    mysqlPassword: '',
                    url: ''
                }
            });
        </script>
    </body>
</html>