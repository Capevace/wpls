export default {
    template: `
        <div class="notification-overlay">
            <div v-for="notification in notifications" :class="{'notification notification-fixed': true, [notification.type]: true}">
                {{ notification.message }} 
            </div>
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