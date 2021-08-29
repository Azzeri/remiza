<template>
  <Head title="Historia logowań" />

  <BreezeAuthenticatedLayout>
    <Card> 
        <ul>
            <li v-for="row in history" :key="row.id">
                {{row.created_at}}
            </li>
        </ul>
    </Card>
  </BreezeAuthenticatedLayout>

  {{ history }}
</template>

<script>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head } from "@inertiajs/inertia-vue3";
import Card from "@/Components/Card.vue";

export default {
  props: {
    history: Object,
  },
  components: {
    BreezeAuthenticatedLayout,
    Head,
    Card,
  },
};
</script>

<style>
</style>