<template>
	<Head title="Skaner" />

		<BreezeAuthenticatedLayout>
			<Card class="text-center">
				<h1 class="text-xl font-semibold text-green-600">Zeskanuj kod QR</h1>
				<div class="w-52 h-52 border-2 mx-auto mt-5">
					<qr-stream @decode="onDecode" class="mb">
						<div style="color: red" class="frame"></div>
					</qr-stream>
              <p class="error">{{ error }}</p>

				</div>
				<h1 v-show="data" class="text-lg font-medium">Rozpoznano kod QR</h1>
				<Link v-show="data" :href="data"><BreezeButton>Przejdź</BreezeButton></Link>
			</Card>
	</BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { reactive, toRefs } from "vue";
import { QrStream, QrCapture } from "vue3-qr-reader";
import Card from "@/Components/Card.vue";
import BreezeButton from "@/Components/Button.vue";
// http://localhost:3000/items/1
export default {
  props: {
    user: Object,
    items: Object
  },
  data() {
    return {
      error: "",
    };
  },
  components: {
    BreezeAuthenticatedLayout,
    Head,
    QrStream,
    QrCapture,
    Card,
	Link,
	BreezeButton
  },
  methods: {
    hasSet() {

    }
  },

  setup() {
    const state = reactive({
      data: null,
    });
    function onDecode(data) {
      state.data = data;
    }
    return {
      ...toRefs(state),
      onDecode,
    };
  }

};
</script>
