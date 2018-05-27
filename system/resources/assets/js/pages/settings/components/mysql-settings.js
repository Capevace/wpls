export default {
    template: `
        <div>
            <h4 class="subtitle is-4">MySQL Settings</h4>

            <div class="columns">
                <div class="column">
                    <div class="field">
                        <label class="label" for="database-host">Database Host</label>
                        <input class="input" id="database-host" type="text" placeholder="Host" v-model="config.mysql.host">
                    </div>
                </div>
                <div class="column">
                    <div class="field">
                        <label class="label" for="database-name">Database Name</label>
                        <input class="input" id="database-name" type="text" placeholder="Name" v-model="config.mysql.name">
                    </div>
                </div>
                <div class="column">
                    <div class="field">
                        <label class="label" for="database-username">Database Username</label>
                        <input class="input" id="database-username" type="text" placeholder="Username" v-model="config.mysql.user">
                    </div>
                </div>
                <div class="column">
                    <div class="field">
                        <label class="label" for="database-password">Database Password</label>
                        <input class="input" id="database-password" type="password" placeholder="Password" v-model="config.mysql.pass">
                    </div>
                </div>
            </div>
        </div>
    `,
    props: ['config']
};