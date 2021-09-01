<template>
    <button :type="type" class="inline-flex items-center px-4 py-2 bg-primary-200 border border-transparent rounded-md font-semibold text-xs text-tertiary uppercase tracking-widest hover:bg-primary-100 active:bg-primary-200 focus:outline-none focus:border-primary-200 focus:shadow-outline-red transition ease-in-out duration-150">
        <slot />
    </button>
</template>

<script>
export default {
    props: {
        type: {
            type: String,
            default: 'submit',
        },
    }
}
</script>
