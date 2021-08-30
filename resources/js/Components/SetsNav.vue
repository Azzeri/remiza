<template>
  <Head title="Zestawy" />
  <div class="flex justify-evenly min-h-screen">
    <Card class="w-1/3 min-h-screen">
      <ul>
        <li v-for="row in sets" :key="row.id">
          <Link :href="route('set.details', id=row.id)">{{row.name}}</Link>
        </li>
      </ul>
    </Card>
    <Card> <slot></slot></Card>
  </div>
</template>

<script>
import BreezeButton from "@/Components/Button.vue";
import BreezeInput from "@/Components/Input.vue";
import BreezeLabel from "@/Components/Label.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Card from "@/Components/Card.vue";
import Table from "@/Components/Table.vue";
import Modal from "@/Components/Modal.vue";
import FloatingButton from "@/Components/FloatingButton.vue";

export default {
  props: {
    sets: Object,
  },

  components: {
    Head,
    BreezeButton,
    BreezeInput,
    BreezeLabel,
    Link,
    Card,
    Table,
    Modal,
    FloatingButton,
  },

  data() {
    return {};
  },

  methods: {},
};
</script>
