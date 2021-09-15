<template>
	<Head title="Skaner" />

		<BreezeAuthenticatedLayout>
			<Card class="text-center">
				<div class="text-center text-tertiary font-bold text-lg mb-4">
						<h3>Zeskanuj kod QR</h3>
				</div>
				<div class="w-52 h-52 border-2 mx-auto mt-5">
					<qr-stream id="QR_Stream" @decode="onDecode" class="mb">
						<div style="color: red" class="frame"></div>
					</qr-stream>
              <p class="error">{{ error }}</p>

				</div>
        <div class="mt-4">
          <h1 v-show="data" class="text-lg font-semibold text-text-200">Rozpoznano kod QR</h1>
          <div v-if="data">
            {{hasSet(data)}}
            <span class="text-tertiary">Przedmiot: </span>
            <Link class="text-md font-semibold text-text-200" v-show="data" :href="data">{{item}}<i class="far fa-eye fa-lg ml-2"></i></Link>
            <div class="flex flex-col">
              <span class="text-tertiary">Zestawy</span>
              <Link v-for="set in sets" :key="set.id" :href="route('set.details',set.id)">{{set.name}}<i class="far fa-eye fa-lg ml-2"></i></Link>
            </div>
          </div>
        </div>
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

export default {
  props: {
    user: Object,
    items: Object,
  },
  data() {
    return {
      error: "",
      sets: null,
      item: ''
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
    hasSet(data) {
      let dataSplit = data.split('/')
      let id = (dataSplit[dataSplit.length-1])
      let item = null

      for (let row of this.items)
        if (row.id == id){
          item = row
          this.item = row.database_items.name
          break
        }

      this.sets = item.sets
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
