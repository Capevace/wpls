const FormattedCustomerContainer = {
    template: `
		<div>
			<span v-if="!customer"></span>
			<div v-for="(value, key) in customer">
				<!--<span class="has-text-weight-bold">{{ key | capitalize }}:</span>-->
				{{value}}
			</div>
		</div>
	`,
    props: ['customer']
};

export default FormattedCustomerContainer;
