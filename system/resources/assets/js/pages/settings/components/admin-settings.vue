<template>
	<div>
        <h4 class="subtitle is-4">Admin Login Settings</h4>
        <div class="columns">
            <div class="column">
                <div class="field">
                    <label class="label" for="user-name">Username</label>
                    <input class="input" id="user-name" required type="text" placeholder="Username" v-model="config.admin.username" />

                </div>
            </div>
            <div class="column">
                <div class="field">
                    <label class="label" for="user-password">Password</label>
                    <input class="input" id="user-password" required type="password" placeholder="Password" v-model="config.admin.password" autocomplete="new-password" />
                </div>
            </div>
        </div>
    </div>
</template>
<script type="text/javascript">
export default {
    props: ['config']
};
</script>