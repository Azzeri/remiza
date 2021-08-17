<template>
  <Head title="Strona główna" />

  <BreezeAuthenticatedLayout>
    <Card>
      <h3 class="font-semibold text-xl">Witaj {{ user.name }}</h3>
		<Link :href="route('scanner')" class="">
			<BreezeButton class="mb-2">
				Zeskanuj przedmiot
			</BreezeButton>
		</Link>
		<h3 v-if="services.length" class="font-semibold">Nadchodzące serwisy</h3>
		<h3 v-else class="font-semibold">Brak nadchodzących serwisów</h3>
      <ul>
        <li v-for="service in services" :key="service.id">
        	<div class="border-b-2 mt-4">
				<div> {{ service.service_database.name }}</div>	
				<div class="text-sm">{{ service.perform_date }}</div>
				<Link :href="'items/'+service.item.id" class="">
					<BreezeButton class="mb-2">
						Zobacz
					</BreezeButton>
				</Link>
          </div>
        </li>
      </ul>
    </Card>
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
	BreezeButton
  },
};
</script>
