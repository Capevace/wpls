<template>
	<div :class="{'modal': true, 'is-active': visible}">
		<div class="modal-background" @click="toggle"></div>
		<div class="modal-content">
			<div class="card">
				<div class="card-content">
					<div class="content">
						<h2>Invalidate Envato Purchase Code</h2>
						<form @submit.prevent="submit">
							<div class="field">
								<label class="label">Plugin</label>
								<div class="select">
									<select class="select" v-model="slug" required :disabled="loading">
										<option v-for="plugin in plugins" :value="plugin.slug" >{{ plugin.slug }}</option>
									</select>
								</div>
							</div>

							<div class="field">
								<label class="label">Purchase Code</label>
								<div class="columns">
									<div class="column is-one">
										<input class="input" type="text" placeholder="Purchase Code" v-model="license" :disabled="loading" required/>
									</div>
								</div>
							</div>

							<div class="field">
								<label class="label">Note</label>
								<input class="input" type="text" placeholder="Note" v-model="customer" :disabled="loading" />
							</div>

							<div class="level">
								<div class="level-left"></div>
								<div class="level-right">
									<div class="level-item">
										<button :class="{'button is-info': true, 'is-loading': loading}" type="submit" :disabled="loading">Invalidate Purchase Code</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<button aria-label="close" class="modal-close is-large" @click="toggle"></button>
	</div>
</template>
<script type="text/javascript">
import { addLicense } from '../../../http';
import { formatMonth } from '../../../utils';

export default {
    data() {
        return {
            license: '',
            customer: '',
            slug: '',
            loading: false
        };
    },
    props: ['visible'],
    methods: {
        toggle() {
            this.$emit('toggle');
        },
        submit() {
            this.loading = true;

            const date = new Date();
            date.setUTCFullYear(date.getUTCFullYear() - 1);

            const dateString =
                date.getFullYear() +
                '-' +
                formatMonth(date.getMonth()) +
                '-' +
                date.getDate();

            addLicense({
                license: this.license,
                slug: this.slug,
                supportedUntil: dateString,
                customerInfo: {
                    customer: this.customer,
                    invalidationNotice: 'Envato Invalidation'
                }
            })
                .then(response => {
                    console.log(response);
                    this.loading = false;

                    this.license = '';
                    this.customer = '';
                    this.slug = '';

                    this.$store.dispatch('pushNotification', {
                        message: 'Purchase Code was successfully invalidated.',
                        type: 'is-success',
                        duration: 2000
                    });

                    this.$emit('success');
                })
                .catch(error => {
                    console.log(error);
                    this.loading = false;

                    let errorMessage = 'An unknown error occurred.';

                    if (error.response.data.error)
                        errorMessage = error.response.data.error.message;

                    this.$store.dispatch('pushNotification', {
                        message: errorMessage,
                        type: 'is-danger',
                        duration: 2000
                    });

                    this.$emit('success');
                });
        }
    },
    computed: {
        plugins() {
            return this.$store.state.plugins;
        }
    }
};
</script>