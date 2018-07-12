import Vue from 'vue';
import Vuex from 'vuex';
import deepAssign from 'deep-assign';
import { updateConfig, saveItemID, getPackages } from './http';

Vue.use(Vuex);

const reducePackages = packages => packages.reduce((sortedPackages, packageObject) => {
    return {
        ...sortedPackages,
        [packageObject.slug]: packageObject
    };
}, {});

const store = new Vuex.Store({
    state: {
        config: deepAssign({}, /*wplsConfig*/{}),
        plugins: reducePackages(wplsPackages),
        savingConfig: false,
        notifications: {},
        itemIdFormLoading: {}
    },
    actions: {
        updateConfig(context, config) {
            context.state.config = config;
            context.state.savingConfig = true;

            updateConfig(config)
                .then(response => {
                    console.log(response);

                    setTimeout(() => {
                        context.state.savingConfig = false;
                        context.dispatch('pushNotification', {
                            message: 'Successfully saved config.',
                            type: 'is-success',
                            duration: 3500
                        });
                    }, 300);
                })
                .catch(error => {
                    console.log(error);

                    setTimeout(() => {
                        context.dispatch('pushNotification', {
                            message: 'An error occurred.',
                            type: 'is-danger',
                            duration: 3500
                        });
                        context.state.savingConfig = false;
                    }, 300);
                });
        },

        pushNotification(context, data) {
            const key = Date.now();
            context.state.notifications = deepAssign(
                {},
                context.state.notifications,
                {
                    [key]: {
                        message: data.message,
                        duration: data.duration,
                        type: data.type
                    }
                }
            );

            setTimeout(
                () => context.dispatch('removeNotification', key),
                data.duration
            );
        },

        removeNotification(context, key) {
            const notifications = deepAssign({}, context.state.notifications);
            delete notifications[key];
            context.state.notifications = notifications;
        },

        updateEnvatoItemID(context, data) {
            context.state.itemIdFormLoading = deepAssign(
                {},
                context.state.itemIdFormLoading,
                {
                    [data.slug]: true
                }
            );

            saveItemID(data.slug, data.itemId)
                .then(response => {
                    console.log(response);

                    setTimeout(() => {
                        context.state.itemIdFormLoading = deepAssign(
                            {},
                            context.state.itemIdFormLoading,
                            {
                                [data.slug]: false
                            }
                        );

                        context.dispatch('pushNotification', {
                            message: 'Successfully saved item id.',
                            type: 'is-success',
                            duration: 2000
                        });
                    }, 300);
                })
                .catch(error => {
                    console.log(error);

                    setTimeout(() => {
                        context.state.itemIdFormLoading = deepAssign(
                            {},
                            context.state.itemIdFormLoading,
                            {
                                [data.slug]: false
                            }
                        );

                        context.dispatch('pushNotification', {
                            message: 'An error occurred.',
                            type: 'is-danger',
                            duration: 3500
                        });
                        context.state.savingConfig = false;
                    }, 300);
                });
        },
        refreshPackages(context) {
            getPackages()
                .then(response => {
                    console.log(response);
                    
                    context.state.plugins = Array.isArray(response.data)
                        ? reducePackages(response.data)
                        : {};
                })
                .catch(error => {
                    console.log(error);

                    context.dispatch('pushNotification', {
                        message: 'Could not fetch packages.',
                        type: 'is-danger',
                        duration: 3500
                    });
                });
        }
    }
});

window.store = store;

export default store;