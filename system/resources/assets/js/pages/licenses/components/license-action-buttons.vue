<template>
	<div :class="{'field is-pulled-right': true, 'has-addons': true}">
        <p class="control" v-if="supported">
            <action-button :license-key="entry.license_key" action="invalidate" @success="onActionSuccess">Invalidate</action-button>
        </p>
        <p class="control">
            <action-button :license-key="entry.license_key" action="delete" @success="onActionSuccess">Delete</action-button>
        </p>
    </div>
</template>
<script type="text/javascript">
import ActionButton from './license-action-button';

export default {
    props: ['entry', 'column'],
    components: {
        'action-button': ActionButton
    },
    computed: {
        supported() {
            return (
                new Date(this.entry.supported_until).getTime() > Date.now()
            );
        }
    }
};
</script>