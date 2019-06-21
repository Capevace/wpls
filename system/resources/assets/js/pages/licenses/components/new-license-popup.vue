<template>
	<div :class="{'modal': true, 'is-active': visible}">
		<div class="modal-background" @click="toggle"></div>
		<div class="modal-content">
			<div class="card">
				<div class="card-content">
					<div class="content">
						<h2>Add new License</h2>
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
								<label class="label">License</label>
								<div class="columns">
									<div class="column is-two-thirds">
										<input class="input" type="text" placeholder="License" v-model="license" :disabled="loading" required/>
									</div>
									<div class="column is-one-third">
										<button class="button" @click.prevent="generateLicense" :disabled="loading">Generate License</button>
									</div>
								</div>
							</div>

							<div class="field">
								<label class="label">Supported until</label>
								<input class="input" type="date" placeholder="Supported until" v-model="supportedUntil" :min="minSupportedUntil" :disabled="loading" />
							</div>

							<div class="field">
								<label class="label">Customer</label>
								<input class="input" type="text" placeholder="Customer" v-model="customer" :disabled="loading" />
                            </div>
                            
                            <div class="field">
								<label class="label">Amount of Possible Activations</label>
								<input class="input" type="number" placeholder="Possible Activations" min="1" v-model="maxActivations" :disabled="loading" />
							</div>

							<div class="level">
								<div class="level-left"></div>
								<div class="level-right">
									<div class="level-item">
										<button :class="{'button is-info': true, 'is-loading': loading}" type="submit" :disabled="loading">Create License</button>
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
import { formatMonth, generateLicense } from '../../../utils';

export default {
    data() {
        const formatMonth = month => {
            let monthNumber = month + 1;
            return monthNumber < 10
                ? '0' + String(monthNumber)
                : String(monthNumber);
        };

        const now = new Date();
        const dateString =
            now.getFullYear() +
            '-' +
            formatMonth(now.getMonth()) +
            '-' +
            now.getDate();

        return {
            license: generateLicense(),
            customer: '',
            slug: '',
            supportedUntil: dateString,
            maxActivations: 1,
            minSupportedUntil: dateString,
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

            addLicense({
                license: this.license,
                slug: this.slug,
                supportedUntil: this.supportedUntil,
                maxActivations: this.maxActivations,
                customerInfo: {
                    customer: this.customer
                }
            })
                .then(response => {
                    console.log(response);
                    this.loading = false;

                    this.license = generateLicense();
                    this.customer = '';
                    this.slug = '';
                    this.maxActivations = 1;

                    this.$store.dispatch('pushNotification', {
                        message: 'License was successfully created.',
                        type: 'is-success',
                        duration: 2000
                    });

                    this.$emit('success');
                })
                .catch(error => {
                    console.log(error);
                    this.loading = false;

                    this.$store.dispatch('pushNotification', {
                        message: 'Unknown Error.',
                        type: 'is-danger',
                        duration: 2000
                    });

                    this.$emit('success');
                });
        },
        generateLicense() {
            this.license = generateLicense();
        }
    },
    computed: {
        plugins() {
            return this.$store.state.plugins;
        }
    }
};
</script>