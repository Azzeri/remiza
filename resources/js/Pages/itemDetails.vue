<template>
    <Head title="Przedmiot" />

    <BreezeAuthenticatedLayout>
   <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
             <div v-if="$page.props.flash.message" class="mt-2 text-green-600 font-semibold">
                    {{ $page.props.flash.message }}
                </div>
            <div class="p-6 bg-white border-b border-gray-200 overflow-hidden shadow-sm sm:rounded-lg">
                <div>{{item.database_items.name}}</div>
                <ul>
                    <li v-for="service in dbservices" :key="service.id">{{service.name}}</li>
                </ul>
            </div>
            <div class="flex">
                <div class="p-6 bg-white border-b border-gray-200 overflow-hidden shadow-sm sm:rounded-lg">
                    <ul>
                        <li v-for="service in services" :key="service.id">
                            <template v-if="service.is_performed == 0">
                                Id: {{service.id}}<br>
                                Opis: {{service.description}}<br>
                                Data: {{service.perform_date}}<br>
                                Zakończono: {{service.is_performed}}<br>
                                Wykonawca: {{service.user_id}}<br>
                                Nazwa serwisu: {{service.service_database.name}}<br>

                                <form >
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <input type="hidden" v-model="form.id">
                                        <div class="mb-4">
                                            <BreezeLabel for="descField" value="Opis" /> 
                                            <BreezeInput id="descField" type="text" class="mt-1 block w-full" v-model="form.desc" placeholder="Wprowadź opis"/>
                                            <div class="text-red-500" v-if="errors.desc">{{ errors.desc }}</div>
                                        </div>    
                                        <span  class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">          
                                            <BreezeButton @click="save(form, service.id)">
                                                Zapisz
                                            </BreezeButton>
                                        </span>                                                     
                                    </div>
                                </form>
                            </template>
                        </li>
                    </ul>
                </div>
                <div class="p-6 bg-white border-b border-gray-200 overflow-hidden shadow-sm sm:rounded-lg">
                    <ul>
                        <li v-for="service in services" :key="service.id">
                            <template v-if="service.is_performed == 1">
                                Id: {{service.id}}<br>
                                Opis: {{service.description}}<br>
                                Data: {{service.perform_date}}<br>
                                Zakończono: {{service.is_performed}}<br>
                                Wykonawca: {{service.user_id}}<br>
                                Nazwa serwisu: {{service.service_database.name}}<br>
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
      dbservices: Object,
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
