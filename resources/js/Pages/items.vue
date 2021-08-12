<template>
    <Head title="Sprzęt" />

    <BreezeAuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-6 bg-white border-b border-gray-200 overflow-hidden shadow-sm sm:rounded-lg">
                    <BreezeButton @click="openModal()">
                        Dodaj
                    </BreezeButton>

                    <div v-if="$page.props.flash.message" class="mt-2 text-green-600 font-semibold">
                        {{ $page.props.flash.message }}
                    </div>

                    <table class="table-fixed w-full mt-2">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2">Nazwa</th>
                                <th class="px-4 py-2">Kategoria</th>
                                <th class="px-4 py-2">Producent</th>
                                <th class="px-4 py-2">Remiza</th>
                                <th class="px-4 py-2">Data ważności</th>
                                <th class="px-4 py-2">Działania</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="row in items" :key="row.id">
                                <td class="border px-4 py-2">{{ row.database_items.name }}</td>
                                <td class="border px-4 py-2">{{ row.cathegory.cathegory.name }}</td>
                                <td class="border px-4 py-2">{{ row.manufacturer.manufacturer.name }}</td>
                                <td class="border px-4 py-2">{{ row.fire_brigade_unit.name }}</td>
                                <td class="border px-4 py-2">{{ row.expiry_date}}</td>
                                <td class="border px-4 py-2">
                                    <button @click="edit(row)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">E</button>
                                    <!-- <button @click="deleteRow(row)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">U</button> -->
                                    <Link :href="'items/'+row.id">Serwis</Link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400" v-if="isOpen">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

                <div class="fixed inset-0 transition-opacity">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" >
                   <form @submit.prevent="save, update">
                        <div class="mb-4">
                            <select v-model="cathegory">
                                <template v-for="row in cathegories" :key="row.id">
                                    <option v-if="row.cathegory_id == null" :value="row.id">
                                        {{row.name}}
                                    </option> 
                                </template>                         
                            </select><br>
                            <select v-model="cathegory">
                                <template v-for="row in cathegories" :key="row.id">
                                    <option v-if="row.cathegory_id == cathegory" :value="row.id">
                                        {{row.name}}
                                    </option> 
                                </template>                         
                            </select><br>

                            <select v-model="form.item">
                                <template v-for="row in dbitems" :key="row.id">
                                    <option v-if="row.cathegory_id == cathegory" :value="row.id">
                                        {{row.name}}
                                    </option> 
                                </template>                         
                            </select>
                            <br><span>Selected Cath: {{ cathegory }}</span><br>
                            <span>Selected Item: {{ form.item }}</span><br>
                            <input type="date" v-model="form.date">
                        </div>    

                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">          
                            <BreezeButton v-show="!editMode" @click="save(form)">
                                Zapisz
                            </BreezeButton>
                        </span>
                        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">                         
                            <BreezeButton  v-show="editMode" @click="update(form)">
                                Edytuj
                            </BreezeButton>
                        </span>
                        <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                            <BreezeButton  @click="closeModal()">
                                Zamknij
                            </BreezeButton>
                        </span>
                        </div>
                    </form>
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
import { Link } from '@inertiajs/inertia-vue3';

export default {
    props: {
        items: Object,
        cathegories: Object,
        dbitems: Object,
        errors: Object,
    },
 
    components: {
        BreezeAuthenticatedLayout,
        Head,
        BreezeButton,
        BreezeInput,
        BreezeLabel,
        Link,
    },

    data() {
        return {
            editMode: false,
            isOpen: false,
            cathegory: 1,
            form: {
                item: null,
                date: null,
            },
        }
    },
    
    methods: {
        openModal: function () {
            this.isOpen = true;
        },
        closeModal: function () {
            this.isOpen = false;
            this.reset();
            this.editMode=false;
        },
        reset: function () {
            this.form = {
                item: null,
                date: null,
            }
        },
        save: function (data) {
            this.$inertia.post('/items', data,{
                onSuccess: () => this.closeModal(),
            })
            this.reset();
        },
        // edit: function (data) {
        //     this.form = Object.assign({}, data);
        //     if(data.cathegory_id != null)
        //         this.form.parent = data.cathegory_id;
        //     else
        //         this.form.parent = -1;
        //     this.editMode = true;
        //     this.openModal();
        // },
        // update: function (data) {
        //     this.$inertia.put('/cathegories/' + data.id, data,{
        //         onSuccess: () => this.closeModal()
        //     });     
        // },
        // deleteRow: function (data) {
        //     if (!confirm('Na pewno? Wszystkie przedmioty należące do kategorii również zostaną usunięte!')) return;
        //     this.$inertia.delete('/cathegories/' + data.id)
        //     this.reset();
        //     this.closeModal();
        // }
    }
}
</script>
