<template>
  <Head title="Historia logowań" />

  <BreezeAuthenticatedLayout>
    <Card> 
		<Table v-if="history.data.length" :data="history.data.length" :throws="throws" height="h-10" margin="mb-4">
			<tr v-for="row in history.data" :key="row" class="flex flex-col flex-no wrap sm:table-row mb-4 sm:mb-0 hover:bg-secondary-50 bg-tertiary justify-center text-text-200">
				<td class="h-10 sm:h-auto border-primary-200 border p-3 overflow-auto"> {{convertDate(row.created_at, 1)}}</td>
        <td class="h-10 sm:h-auto border-primary-200 border p-3 overflow-auto"> {{convertDate(row.created_at, 2)}}</td>
				<td v-if="row.success" class="h-10 sm:h-auto border-primary-200 border p-3 overflow-auto"> Tak</td>
				<td v-else class="h-10 sm:h-auto border-primary-200 border p-3 overflow-auto"> Nie</td>
				<td class="h-10 sm:h-auto border-primary-200 border p-3 overflow-auto"> {{row.ip}}</td>
				<td class="h-10 sm:h-auto border-primary-200 border p-3 overflow-auto"> {{row.browser}}</td>
			</tr>
		</Table>
		<h1 v-else class="text-lg font-semibold text-center text-text-200">Brak danych logowania</h1>
        <pagination class="mt-6 mx-auto" :links="history.links" />
    </Card>
  </BreezeAuthenticatedLayout>

</template>

<script>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head } from "@inertiajs/inertia-vue3";
import Card from "@/Components/Card.vue";
import Pagination from "@/Components/Pagination.vue";
import Table from "@/Components/Table.vue";

export default {
  props: {
    history: Object,
  },
  components: {
    BreezeAuthenticatedLayout,
    Head,
    Card,
    Pagination,
    Table
  },
	data() {
        return {
          throws:['Data','Godzina', 'Sukces','Adres IP','Przeglądarka'],
        }
    },
	methods: {
		convertDate(date, type){
			let convertedDate = date.split('T')[0];
			let convertedHour = date.split('T')[1].split('.')[0];
      let returnData

      type == 1 ? returnData = convertedDate : returnData = convertedHour;

      return returnData
		}
	}
};
</script>

<style>
</style>