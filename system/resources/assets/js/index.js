import './utils/fa-solid';
import './utils/fa';
import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import store from './store';

import WPLSPage from './components/wpls-page';
import WPLicenseServer from './components/wp-license-server';

import DashboardPage from './pages/dashboard';
import LicensesPage from './pages/licenses';
import PluginsPage from './pages/plugins';
import AnnouncementsPage from './pages/announcements';
import CreateAnnouncementPage from './pages/create-announcement';
import AnnouncementPage from './pages/announcement';
import SettingsPage from './pages/settings';

Vue.filter('capitalize', function(value) {
    if (!value) return '';
    value = value.toString();
    return value.charAt(0).toUpperCase() + value.slice(1);
});

Vue.component('wpls-page', WPLSPage);
Vue.component('wp-license-server', WPLicenseServer);

const routes = [
    { path: '/', component: DashboardPage },
    { path: '/licenses', component: LicensesPage },
    { path: '/plugins', component: PluginsPage },
    { path: '/announcements', component: AnnouncementsPage },
    { path: '/announcements/create', component: CreateAnnouncementPage },
    { path: '/announcements/:id', component: AnnouncementPage },
    { path: '/settings', component: SettingsPage }
];

const app = new Vue({
    store,
    router: new VueRouter({ routes })
});
app.$mount('#app');
