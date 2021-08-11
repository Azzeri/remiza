<template>
    <Head title="Kategorie" />

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
                                <th class="px-4 py-2">Podkategorie</th>
                                <th class="px-4 py-2">Działania</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="row in data" :key="row.id">
                                <td class="border px-4 py-2">{{ row.name }}</td>
                                <td class="border px-4 py-2">
                                    <ul>
                                        <li v-for="subcat in row.subcathegories" :key="subcat.id">{{subcat.name}}</li>
                                    </ul>
                                </td>
                                <td class="border px-4 py-2">
                                    <button @click="edit(row)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">E</button>
                                    <!-- <button @click="deleteRow(row)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">U</button> -->
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
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="mb-4">
                                <BreezeLabel for="nameField" value="Nazwa" />
                                <BreezeInput id="nameField" type="text" class="mt-1 block w-full" v-model="form.name" placeholder="Wprowadź nazwę" />
                                <div class="text-red-500" v-if="errors.name">{{ errors.name }}</div>
                            </div>    
                            <div class="mb-4">
                                <select v-model="form.parent">
                                    <option value="-1">Brak</option>                                   
                                        <template v-for="row in data" :key="row.id">
                                            <option v-if="row.name != form.name && form.id != row.cathegory_id" :value="row.id">
                                            {{row.name}}
                                            </option> 
                                        </template>                         
                                </select>
                                <span>Selected: {{ form.parent }}</span>
                            </div>                                                        
                        </div>

                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">          
                            <BreezeButton type="submit" v-show="!editMode" @click="save(form)">
                                Zapisz
                            </BreezeButton>
                        </span>
                        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">                         
                            <BreezeButton  v-show="editMode" @click="update(form)">
                                Edytuj
                            </BreezeButton>
                        </span>
                        <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                            <BreezeButton @click="closeModal()">
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

export default {
    props: {
        data: Object,
        errors: Object,
    },
 
    components: {
        BreezeAuthenticatedLayout,
        Head,
        BreezeButton,
        BreezeInput,
        BreezeLabel
    },

    data() {
        return {
            editMode: false,
            isOpen: false,
            form: {
                name: null,
                parent: -1
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
                name: null,
                parent: -1
            }
        },
        save: function (data) {
            this.$inertia.post('/cathegories', data,{
                onSuccess: () => this.closeModal(),
            })
            this.reset();
        },
        edit: function (data) {
            this.form = Object.assign({}, data);
            if(data.cathegory_id != null)
                this.form.parent = data.cathegory_id;
            else
                this.form.parent = -1;
            this.editMode = true;
            this.openModal();
        },
        update: function (data) {
            this.$inertia.put('/cathegories/' + data.id, data,{
                onSuccess: () => this.closeModal()
            });     
        },
        deleteRow: function (data) {
            if (!confirm('Na pewno? Wszystkie przedmioty należące do kategorii również zostaną usunięte!')) return;
            this.$inertia.delete('/cathegories/' + data.id)
            this.reset();
            this.closeModal();
        }
    }
}
</script>
