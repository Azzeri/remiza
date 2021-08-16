<template>
    <Head title="Zmiana hasła" />

    <BreezeValidationErrors class="mb-4" />

    <form @submit.prevent="submit">
        <div class="mt-4">
            <BreezeLabel for="password_old" value="Old Password" />
            <BreezeInput id="password_old" type="password" class="mt-1 block w-full" v-model="form.password_old" required autofocus/>
        </div>

        <div class="mt-4">
            <BreezeLabel for="password" value="Password" />
            <BreezeInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="new-password" />
        </div>

        <div class="mt-4">
            <BreezeLabel for="password_confirmation" value="Confirm Password" />
            <BreezeInput id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" required autocomplete="new-password" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <BreezeButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Zatwierdź
            </BreezeButton>
        </div>
    </form>
</template>

<script>
import BreezeButton from '@/Components/Button.vue'
import BreezeGuestLayout from '@/Layouts/Guest.vue'
import BreezeInput from '@/Components/Input.vue'
import BreezeLabel from '@/Components/Label.vue'
import BreezeValidationErrors from '@/Components/ValidationErrors.vue'
import { Head } from '@inertiajs/inertia-vue3';

export default {
    layout: BreezeGuestLayout,

    components: {
        BreezeButton,
        BreezeInput,
        BreezeLabel,
        BreezeValidationErrors,
        Head,
    },

    data() {
        return {
            form: this.$inertia.form({
                password_old: '',
                password: '',
                password_confirmation: '',
            })
        }
    },

    methods: {
        submit() {
            this.form.post(this.route('password.change.store'), {
                onSuccess: () => this.$inertia.get('/dashboard')
            })
        }
    }
}
</script>
