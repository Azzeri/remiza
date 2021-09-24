<template>
	<BreezeAuthenticatedLayout>
    	<Head title="Historia" />
		<Card>
			<Link :href="route('item.details', item.id)">
				<i class="fas fa-2x text-tertiary fa-arrow-circle-left mb-4 hover:text-primary-200 transition duration-300 ease-in-out cursor-pointer"></i>	
            </Link>
			<div class="flex flex-col">
				<div class="flex w-full bg-primary-200 mb-4 justify-evenly p-3 rounded-lg flex-wrap">
					<button class="w-1/3 text-tertiary font-semibold rounded p-1 px-3 hover:bg-tertiary hover:text-text-200 transition duration-300 ease-in-out" @click="tabSwitch = 0">Serwisy</button>
					<button class="w-1/3 text-tertiary font-semibold rounded p-1 px-3 hover:bg-tertiary hover:text-text-200 transition duration-300 ease-in-out" @click="tabSwitch = 1">Użycia</button>
					<button v-if="item.cathegory.cathegory.fillable" class="w-1/3 text-tertiary font-semibold rounded p-1 px-3 hover:bg-tertiary hover:text-text-200 transition duration-300 ease-in-out" @click="tabSwitch = 2">Napełnienia</button>
				</div>
				<HistoryPanel v-if="tabSwitch == 0" title="Serwisy" :links="services.links" number=0>
					<div v-for="service in services.data" :key="service.id">     
						<div class="mb-5">
							<div class="font-bold text-primary-200">{{ service.service_database.name }}</div>
							<div v-if="service.description">Opis: {{ service.description }}</div>
							<div>Data: {{ service.perform_date }}</div>
							<div>Wykonawca: {{ service.user.name }} {{ service.user.surname }}</div>
						</div>
					</div>
				</HistoryPanel>
				<HistoryPanel v-if="tabSwitch == 1" title="Użycia" :links="usages.links" number=1>
					<div v-for="usage in usages.data" :key="usage.id">     
						<div class="mb-5">
							<div class="font-bold text-primary-200">Użytkownik: {{ usage.user.name }}</div>
							<div>Data i godzina: {{ usage.usage_date }}</div>
							<div>Czas trwania: {{ usage.usage_minutes }} minut</div>
							<div v-if="usage.description">Opis: {{ usage.description }}</div>
						</div>
					</div>
				</HistoryPanel>
				<HistoryPanel v-if="tabSwitch == 2" title="Napełnienia" :links="fills.links" number=2>
					<div v-for="row in fills.data" :key="row.id">     
						<div class="mb-5">
							<div class="font-bold text-primary-200">Użytkownik: {{ row.user.name }}</div>
							<div>Rozpoczęcia napełniania: {{ row.date_start }} {{row.time_start}}</div>
							<div>Zakończenie napełniania: {{ row.date_finish }} {{row.time_finish}}</div>
						</div>
					</div>
				</HistoryPanel>
			</div>
		</Card>
  	</BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import BreezeLabel from "@/Components/Label.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Card from "@/Components/Card.vue";
import HistoryPanel from "@/Components/historyPanel.vue";

export default {
  props: {
    services: Object,
    usages: Object,
	item: Object,
	cathegory: Boolean,
	fills: Object,
	n:String
  },

  components: {
    BreezeAuthenticatedLayout,
    Head,
    BreezeLabel,
    Card,
	Link,
	HistoryPanel
  },

  data() {
	  return {
		  tabSwitch: this.n
	  }
  }
};
</script>
