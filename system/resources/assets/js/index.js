import './utils/fa-solid';
import './utils/fa';
import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import store from './store';

import WPLSPage from './components/wpls-page';
import WPLicenseServer from './components/wp-license-server';

import ActivationsPage from './pages/activations';
import LicensesPage from './pages/licenses';
import PackagesPage from './pages/packages';
import PackagePage from './pages/package';
import AnnouncementsPage from './pages/announcements';
import CreateAnnouncementPage from './pages/create-announcement';
import SitesPage from './pages/sites';
import AnnouncementPage from './pages/announcement';
import SettingsPage from './pages/settings';

Vue.filter('capitalize', function(value) {
    if (!value) return '';
    value = value.toString();
    return value.charAt(0).toUpperCase() + value.slice(1);
});

Vue.filter('limit', function(value, limit = 25, suffix = '') {
    if (!value) return '';

    if (value.length <= limit)
        suffix = '';

    return value.substring(0, limit) + suffix;
});

Vue.filter('add', function(value, text = '') {
    return value + text;
});

Vue.component('wpls-page', WPLSPage);
Vue.component('wp-license-server', WPLicenseServer);

const routes = [
    { path: '/', component: ActivationsPage },
    { path: '/licenses', component: LicensesPage },
    { path: '/packages', component: PackagesPage },
    { path: '/packages/:slug', component: PackagePage },
    { path: '/sites', component: SitesPage },
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
