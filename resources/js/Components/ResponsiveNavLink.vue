<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';

export default {
    components: {
        Link,
    },

    props: ['href', 'active'],

    computed: {
        classes() {
            return this.active
                ? 'block pl-3 pr-4 py-2 border-l-4 border-primary-200 text-base font-medium text-primary-200 bg-tertiary focus:outline-none transition duration-150 ease-in-out'
                : 'block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-text-200 hover:text-text-100 hover:bg-tertiary hover:border-primary-100 focus:outline-none transition duration-150 ease-in-out'
        }
    }
}
</script>
