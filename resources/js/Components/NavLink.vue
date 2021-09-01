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
                ? 'inline-flex items-center px-1 pt-1 border-b-2 border-primary-200 text-sm font-medium leading-5 text-text-200 focus:outline-none focus:border-primary-100 transition  duration-150 ease-in-out'
                : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-text-100 hover:text-text-200 hover:border-primary-100 focus:outline-none focus:text-text-200 focus:border-primary-100 transition duration-150 ease-in-out'
        }
    }
}
</script>
