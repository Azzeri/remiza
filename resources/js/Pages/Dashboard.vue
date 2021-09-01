<template>
	<BreezeAuthenticatedLayout>
		<Head title="Strona główna" />
		<div class="py-12 text-text-200">
			<div class="mx-auto sm:px-6 lg:px-8 max-w-7xl">
				<div class="bg-secondary sm:rounded-lg">
					<div class="sm:flex sm:rounded-lg mx-auto shadow-sm">
						<div class="p-6 text-center bg-gradient-to-br from-secondary-200 to-primary-200 sm:rounded-l-lg sm:w-1/3">
							<h3 class="font-bold text-lg text-tertiary">Witaj {{ user.name }}</h3>
							<Link :href="route('scanner')" class="">
								<BreezeButton class="mb-2 mt-4">Skanuj</BreezeButton>
							</Link>
						</div>
						<div class="bg-secondary-100 p-6 mt-12 sm:mt-0 sm:rounded-r-lg sm:w-2/3">
							<div class="text-center text-tertiary font-bold text-lg mb-4 sm:text-left sm:pl-5">
								<h3 v-if="services.length">Nadchodzące serwisy</h3>
								<h3 v-else>Brak nadchodzących serwisów</h3>
							</div>
							<div class="flex flex-wrap justify-between">
								<template v-for="service in services" :key="service.id">
									<Link :href="'items/' + service.item.id" class="">
										<div class="ml-5 mb-5 pl-2 pr-2 rounded border-l-4 border-primary-200 hover:border-primary-100 hover:bg-tertiary transition duration-500 ease-in-out">
											<div class="font-semibold">{{ service.service_database.name }}</div>
											<div class="text-sm">{{ service.perform_date }}</div>																																
										</div>
									</Link>		
								</template>														
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import Card from "@/Components/Card.vue";
import BreezeButton from "@/Components/Button.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";

export default {
  props: {
    user: Object,
    services: Object,
  },
  components: {
    BreezeAuthenticatedLayout,
    Head,
    Link,
    Card,
    BreezeButton,
  },
};
</script>
					

					