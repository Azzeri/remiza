<template>
    <Head title="Przedmiot" />

    <BreezeAuthenticatedLayout>
   <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
             <div v-if="$page.props.flash.message" class="mt-2 text-green-600 font-semibold">
                    {{ $page.props.flash.message }}
                </div>
            <!-- <div class="p-6 bg-white border-b border-gray-200 overflow-hidden shadow-sm sm:rounded-lg">
                <div>{{item.database_items.name}}</div>
                <ul>
                    <li v-for="service in dbservices" :key="service.id">{{service.name}}</li>
                </ul>
            </div> -->
            <div class="flex justify-evenly">
                <div class="p-6 bg-white border-b border-gray-200 overflow-hidden shadow-sm sm:rounded-lg">
                    <h1 class="text-xl font-semibold text-green-600">Nadchodzące</h1>
                    <ul>
                        <li v-for="service in services" :key="service.id">
                            <template v-if="service.is_performed == 0">
                                <div class="border-b-2 mt-4">
                                    Data: {{service.perform_date}}<br>
                                    Nazwa serwisu: {{service.service_database.name}}<br>
                                    <form >
                                        <input type="hidden" v-model="form.id">
                                        <div class="mb-4">
                                            <BreezeInput id="descField" type="textarea" class="mt-1 block w-full" v-model="form.desc" placeholder="Wprowadź opis"/>
                                            <div class="text-red-500" v-if="errors.desc">{{ errors.desc }}</div>
                                        </div>    
                                        <BreezeButton class="mb-2" @click="save(form, service.id)">
                                            Potwierdź wykonanie
                                        </BreezeButton>
                                    </form>
                                </div>
                            </template>
                        </li>
                    </ul>
                </div>
                <div class="p-6 bg-white border-b border-gray-200 overflow-hidden shadow-sm sm:rounded-lg">
                    <h1 class="text-xl font-semibold">Historia</h1>
                    <ul>
                        <li v-for="service in services" :key="service.id">
                            <template v-if="service.is_performed == 1">
                                <div class="border-b-2 mt-4">
                                <!-- Id: {{service.id}}<br> -->
                                Nazwa serwisu: {{service.service_database.name}}<br>                               
                                Opis: {{service.description}}<br>
                                Data: {{service.perform_date}}<br>
                                <!-- Zakończono: {{service.is_performed}}<br> -->
                                Wykonawca: {{service.user.name}} {{service.user.surname}}<br>
                                </div>
                            </template>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
     </div> 

    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import BreezeButton from '@/Components/Button.vue'
import BreezeInput from '@/Components/Input.vue'
import BreezeLabel from '@/Components/Label.vue'
import { Head } from '@inertiajs/inertia-vue3';
import { Link } from '@inertiajs/inertia-vue3'

export default {
    props: {
    //   dbservices: Object,
        item: Object,
        services: Object,
        errors: Object,
    },

    components: {
        BreezeAuthenticatedLayout,
        Head,
        BreezeButton,
        BreezeInput,
        BreezeLabel,
        Link
    },

    data() {
        return {
            form: {
                desc: null,
                id: null
            },
        }
    },
    methods: {
        
        reset: function () {
            this.form = {
                desc: null,
            }
        },
        save: function (data, id) {
            this.form.id = id
            this.$inertia.post('/services/finish', data)
            this.reset();
        }
    }
}
</script>
