import Navbar from './Navbar';
import Footer from './Footer';
import Notifications from './notification-overlay';

export default {
    template: `
        <div>
            <section class="hero is-info is-bold">
                <div class="hero-body">
                    <div class="container">
                        <admin-navbar></admin-navbar>
                    </div>
                </div>
            </section>
            <section class="section is-paddingless">
                <div class="container">
                    <admin-notifications></admin-notifications>
                    <router-view></router-view>
                </div>
            </section>
            <!--<admin-footer></admin-footer>-->
        </div>
    `,
    components: {
        'admin-navbar': Navbar,
        'admin-footer': Footer,
        'admin-notifications': Notifications
    },
    computed: {
        notifications() {
            return this.$store.state.notifications;
        }
    }
};