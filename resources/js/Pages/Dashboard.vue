<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <!-- <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template> -->

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <qr-stream @decode="onDecode" class="mb">
                            <div style="color: red;" class="frame"></div>
                        </qr-stream>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import { Head } from '@inertiajs/inertia-vue3';
import { defineComponent, reactive, toRefs } from 'vue';
import { QrStream, QrCapture } from 'vue3-qr-reader';

export default {
    props: {
        user: Object,
    },
    components: {
        BreezeAuthenticatedLayout,
        Head,
        QrStream,
        QrCapture
    },

    setup() {
    const state = reactive({
      data: null
    })
    function onDecode(data) {
      state.data = data
    }
    return {
      ...toRefs(state),
      onDecode
    }
  }
}
</script>
