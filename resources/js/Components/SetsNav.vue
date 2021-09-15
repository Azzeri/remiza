<template>
	<Head title="Zestawy" />
	<Card>
		<FloatingButton v-if="$page.props.auth.user.privilege_id  != 1" @click="open()" class="mb-4"></FloatingButton>

		<div class="text-tertiary font-bold text-lg mb-4 pl-1">
			<h3>Zestawy przedmiotów</h3>
		</div>
    <div class="bg-tertiary rounded p-2 text-text-200">
      <div class="font-bold hover:bg-primary-200 hover:text-tertiary p-1 rounded transition duration-500 ease-in-out" v-for="row in sets" :key="row.id">
        <Link :href="route('set.details', id=row.id)">{{row.name}}</Link>
      </div>
    </div>
		
		<slot></slot>
	</Card>
</template>

<script>
import { Head, Link } from "@inertiajs/inertia-vue3";
import Card from "@/Components/Card.vue";
import FloatingButton from "@/Components/FloatingButton.vue";

export default {
  props: {
    sets: Object,
  },

  components: {
    Head,
    Link,
    Card,
    FloatingButton
  },

  data() {
    return {};
  },

  methods: {
    open(){
      this.$emit('open-modal');
    }
  },
};
</script>
