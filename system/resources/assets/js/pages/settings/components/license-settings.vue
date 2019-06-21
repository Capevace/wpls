<template>
	<div>
        <h4 class="subtitle is-4">License Verification</h4>
        <div class="columns">
            <div class="column">
                <h5 class="subtitle is-5">General</h5>

                <div class="field" v-for="(value, index) in config.authorities" :key="index">
                    <label class="label" :for="index | inputId">
                        <input type="checkbox" :id="index | inputId" v-model="config.authorities[index]" />
                        Use {{ index | capitalize }} Verification
                    </label>
                </div>

                <div class="field">
                    <label class="label" for="log-level">
                        Log Level
                    </label>
                    <div class="select">
                        <select id="log-level" v-model="config.logLevel">
                            <option value="none">None</option>
                            <option value="errors">Errors</option>
                            <option value="verification">Verification & Errors</option>
                            <option value="all">All</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="column">
                <h5 class="subtitle is-5">Envato</h5>

                <div class="field">
                    <label class="label" for="envato-api-key">Envato API Key</label>
                    <input class="input" type="text" placeholder="Envato API Key" v-model="config.envatoApiKey" id="envato-api-key">
                </div>
            </div>
        </div>
    </div>
</template>
<script type="text/javascript">
export default {
    props: ['config'],
    filters: {
        inputId(value) {
            return value + '-verification';
        }
    }
};
</script>