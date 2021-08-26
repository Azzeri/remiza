<template>
  <BreezeAuthenticatedLayout>
    <Head title="Historia" />
    <div class="flex flex-col md:flex-row md:justify-evenly">
      <Card>
        <h1 class="text-xl font-semibold">Serwisy</h1>
        <ul>
          <li v-for="service in services" :key="service.id">     
            <template v-if="service.is_performed == 1">
              <div class="border-b-2 mt-4">
                Nazwa serwisu: {{ service.service_database.name }}<br />
                Opis: {{ service.description }}<br />
                Data: {{ service.perform_date }}<br />
                Wykonawca: {{ service.user.name }} {{ service.user.surname }}<br />
              </div>
            </template>
          </li>
        </ul>
      </Card>
      <Card>
        <h1 class="text-xl font-semibold">Użycia</h1>
        <ul>
          <li v-for="usage in usages" :key="usage.id">     
            <div class="border-b-2 mt-4">
              Użytkownik: {{ usage.user.name }}<br />
              Data i godzina: {{ usage.usage_date }}<br />
              Czas trwania: {{ usage.usage_minutes }} minut<br />
              Opis: {{ usage.description }}<br />
            </div>
          </li>
        </ul> 
      </Card>
    </div>
  </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import BreezeLabel from "@/Components/Label.vue";
import { Head } from "@inertiajs/inertia-vue3";
import Card from "@/Components/Card.vue";
import Pagination from "@/Components/Pagination.vue";

export default {
  props: {
    services: Object,
    usages: Object
  },

  components: {
    BreezeAuthenticatedLayout,
    Head,
    BreezeLabel,
    Card,
    Pagination,
  },
};
</script>
