const ActivationEntry = {
    template: `
		<tr>
            <td>{{ created_at }}</td>
			<td>{{ packageName }}</td>
			<td>{{ activation.license_key }}</td>
			<td>{{ activation.site_url }}</td>
			<td>
                <span class="is-block is-size-7" v-if="activation.site_last_package_version">
                    Package v{{ activation.site_last_package_version }}
                </span>
				<span class="is-block is-size-7" v-if="activation.site_last_wp_version">
                    WordPress v{{ activation.site_last_wp_version }}
                </span>
                <span class="is-block is-size-7" v-if="activation.site_last_php_version">
                    PHP v{{ activation.site_last_php_version }}
                </span>

				<template v-for="(entry, key) in customerData">
                    <span class="is-block is-size-7">
                        {{ entry }}
                    </span>
                </template>
			</td>
		</tr>
	`,
    props: ['activation'],
    computed: {
        created_at() {
            const d = new Date(this.activation.created_at);
            return d.toLocaleString();
        },
        packageName() {
            return this.activation.package_slug in this.$store.state.plugins
                ? this.$store.state.plugins[this.activation.package_slug].name
                : `Unknown Package (${this.activation.package_slug})`
        },
        customerData() {
            return JSON.parse(this.activation.license_customer_data);
        }
    }
};

export default ActivationEntry;
