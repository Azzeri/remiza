<template>
  <Head title="Dashboard" />

  <BreezeAuthenticatedLayout>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <p class="error">{{ error }}</p>
            <qr-stream @decode="onDecode" class="mb">
              <div style="color: red" class="frame"></div>
            </qr-stream>
            {{ data }}
            <Link :href="data">Przejdź</Link>
          </div>
        </div>
      </div>
    </div>
  </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head } from "@inertiajs/inertia-vue3";
import { defineComponent, reactive, toRefs } from "vue";
import { QrStream, QrCapture } from "vue3-qr-reader";
import { Link } from "@inertiajs/inertia-vue3";

export default {
  props: {
    user: Object,
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
    Link,
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
  },
};
</script>
