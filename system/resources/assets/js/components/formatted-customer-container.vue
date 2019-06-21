<template>
	<div>
		<div v-if="customer" v-for="(value, key) in customer">
			<!--<span class="has-text-weight-bold">{{ key | capitalize }}:</span>-->
			{{value}}
		</div>
	</div>
</template>