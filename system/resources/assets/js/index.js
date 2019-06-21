import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import store from './store';

import WPLSPage from './components/wpls-page';
import WPLicenseServer from './components/wp-license-server';

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

// const routes = [
//     { path: '/', component: ActivationsPage },
//     { path: '/licenses', component: LicensesPage },
//     { path: '/packages', component: PackagesPage },
//     { path: '/packages/:slug', component: PackagePage },
//     { path: '/sites', component: SitesPage },
//     { path: '/announcements', component: AnnouncementsPage },
//     { path: '/announcements/create', component: CreateAnnouncementPage },
//     { path: '/announcements/:id', component: AnnouncementPage },
//     { path: '/settings', component: SettingsPage }
// ];

const routes = [
    { path: '/', component: () => import('./pages/activations' /* webpackChunkName: "activations" */) },
    { path: '/licenses', component: () => import('./pages/licenses' /* webpackChunkName: "licenses" */), loading: { template: `<span>LOADING</span>` } },
    { path: '/packages', component: () => import('./pages/packages' /* webpackChunkName: "packages" */) },
    { path: '/packages/:slug', component: () => import('./pages/package' /* webpackChunkName: "package" */) },
    { path: '/sites', component: () => import('./pages/sites' /* webpackChunkName: "sites" */) },
    { path: '/announcements', component: () => import('./pages/announcements' /* webpackChunkName: "announcements" */) },
    { path: '/announcements/create', component: () => import('./pages/create-announcement' /* webpackChunkName: "create-announcement" */) },
    { path: '/announcements/:id', component: () => import('./pages/announcement' /* webpackChunkName: "announcement" */) },
    { path: '/settings', component: () => import('./pages/settings' /* webpackChunkName: "settings" */) }
];

const router = new VueRouter({ routes });
router.beforeResolve((to, from, next) => {
  console.log('before', to, from);
  next()
})

router.afterEach((to, from) => {
    console.log('after', to, from);
})


const app = new Vue({
    store,
    router
});
app.$mount('#app');
