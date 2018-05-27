export default {
    template: `
        <div class="columns">
            <div class="column"></div>
            <div class="column" :style="marginStyle">
                <div v-for="notification in notifications" :class="{'notification': true, [notification.type]: true}">
                    {{ notification.message }}
                </div>
            </div>
            <div class="column"></div>
        </div>
    `,
    computed: {
        notifications() {
            return this.$store.state.notifications;
        },
        marginStyle() {
            return Object.keys(this.$store.state.notifications).length > 0
                ? 'padding-top: 30px;'
                : '';
        }
    }
};