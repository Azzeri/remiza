<template>
    <div class="p-6 text-text-200 bg-tertiary rounded-lg shadow-lg">
        <div class="text-left text-secondary-200 font-bold text-xl mb-4">
            <h1>{{title}}</h1>
        </div>
        <slot></slot>
        <div class="bg-primary-100 p-3 rounded-lg">
            <pagination :links=links></pagination>
        </div>
    </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";

export default {
    props: ['links', 'title', 'number'],
    components: {
        Pagination,
        Link
    },
    methods: {
        replaceChar(origString, replaceChar, index) {
            let firstPart = origString.substr(0, index);
            let lastPart = origString.substr(index + 1);
            
            let newString = firstPart + replaceChar + lastPart;
            return newString;
        }
    },
    created() {
        for(let link of this.links){
            if(link.url != null){
                let index = (link.url.indexOf('?')-1)
                link.url = this.replaceChar(link.url, this.number, index)
            }
        }
    }
}
</script>

<style>

</style>