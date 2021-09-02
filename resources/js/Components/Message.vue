<template>
    <div v-if="$page.props.flash.message" class="mb-4 p-2 rounded border-l-4 border-green-700 font-xl bg-green-200 text-text-200 font-bold inline-block">
        <slot></slot>
    </div>
</template>

<script>
export default {

}
</script>

<style>

</style>