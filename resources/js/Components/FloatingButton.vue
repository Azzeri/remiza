<template>
    <button @click="openModal()" class="fixed right-10 bottom-10 sm:right-0 sm:bottom-0 sm:relative text-white hover:bg-gray-700 bg-gray-800 rounded-full sm:rounded-md h-12 w-12 sm:w-12 sm:h-8 flex items-center justify-center transition ease-in-out duration-150">
        <i class="fas fa-plus"></i>
    </button>
</template>

<script>
export default {
    methods:{
        openModal(){
            this.$emit('open-modal')
        }
    }
}
</script>

<style>

</style>