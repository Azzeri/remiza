<template>
    <button @click="openModal()" class="fixed right-10 bottom-10 sm:right-0 sm:bottom-0 sm:relative text-tertiary hover:bg-primary-100 bg-primary-200 rounded-full h-16 w-16 sm:w-12 sm:h-12 flex items-center justify-center transition ease-in-out duration-150">
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