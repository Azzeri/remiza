<template>
    <div v-if="links.length > 3">
        <div class="flex flex-wrap justify-center">
            <template v-for="(link, p) in links" :key="p">
                <div v-if="link.url === null" class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded"
                    v-html="link.label" />
                <inertia-link v-else
                    class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded text-sec hover:bg-prim hover:text-third focus:border-prim focus:text-third"
                    :class="{ 'bg-prim text-third': link.active }" :href="link.url" v-html="link.label" />
            </template>
        </div>
    </div>
</template>

<script>

import { InertiaLink } from '@inertiajs/inertia-vue3';
export default {
    props: {
        links: Array
    },
    components:{
        InertiaLink
    }
}
</script>