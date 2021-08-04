<template>
    <Head title="Użytkownicy" />

    <BreezeAuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                    <button v-if="$page.props.auth.user.privilege_id == 2" @click="openModal()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-3">Nowy</button>
                    
                    <div v-if="$page.props.flash.message" class="alert">
                        {{ $page.props.flash.message }}
                     </div>

                    <table class="table-fixed w-full">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2">Imię</th>
                                <th class="px-4 py-2">Nazwisko</th>
                                <th class="px-4 py-2">Email</th>
                                <th class="px-4 py-2">Telefon</th>                               
                                <th class="px-4 py-2">Remiza</th>
                                <th class="px-4 py-2">Rola</th>
                                <th class="px-4 py-2">Działania</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="row in users" :key="row.id">
                                <td class="border px-4 py-2">{{ row.name }}</td>
                                <td class="border px-4 py-2">{{ row.surname }}</td>
                                <td class="border px-4 py-2">{{ row.email }}</td>
                                <td class="border px-4 py-2">{{ row.phone }}</td>
                                <td class="border px-4 py-2">{{ row.privilege.name }}</td>
                                <td class="border px-4 py-2">{{ row.fire_brigade_unit.name }}</td>
                                <td class="border px-4 py-2">
                                    <button @click="edit(row)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">E</button>
                                    <button v-if="$page.props.auth.user.id != row.id" @click="deleteRow(row)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">U</button>
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
                <!-- This element is to trick the browser into centering the modal contents. -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>​
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                    <form> 
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="">
                            <div class="mb-4">
                                <label for="nameField" class="block text-gray-700 text-sm font-bold mb-2">Imię:</label>
                                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="nameField" placeholder="Wprowadź imię" v-model="form.name">
                                <div class="text-red-500" v-if="errors.name">{{ errors.name }}</div>
                            </div>
                             <div class="mb-4">
                                <label for="surnameField" class="block text-gray-700 text-sm font-bold mb-2">Nazwisko:</label>
                                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="surnameField" placeholder="Wprowadź nazwisko" v-model="form.surname">
                                <div class="text-red-500" v-if="errors.surname">{{ errors.surname }}</div>
                            </div>
                            <div class="mb-4">
                                <label for="emailField" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="emailField" placeholder="Wprowadź email" v-model="form.email">
                                <div class="text-red-500" v-if="errors.email">{{ errors.email }}</div>
                            </div>
                            <div class="mb-4">
                                <label for="phoneField" class="block text-gray-700 text-sm font-bold mb-2">Telefon:</label>
                                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="nameField" placeholder="Wprowadź nr telefonu" v-model="form.phone">
                                <div class="text-red-500" v-if="errors.phone">{{ errors.phone }}</div>
                            </div>                                                             
                        </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                            <button wire:click.prevent="store()" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5" v-show="!editMode" @click="save(form)">
                            Save
                            </button>
                        </span>
                        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                            <button wire:click.prevent="store()" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5" v-show="editMode" @click="update(form)">
                            Update
                            </button>
                        </span>
                        <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                            
                            <button @click="closeModal()" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                            Cancel
                            </button>
                        </span>
                        </div>
                    </form>
                    
                </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import { Head } from '@inertiajs/inertia-vue3';

export default {
    props: {
        users: Object,
        errors: Object,
    },

    // created(){
    //     console.log(this.errors);
    // },

    components: {
        BreezeAuthenticatedLayout,
        Head,
    },

    data() {
            return {
                editMode: false,
                isOpen: false,
                form: {
                    name: null,
                    surname: null,
                    email: null,
                    phone: null
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
                    surname: null,
                    email: null,
                    phone: null
                }
            },
            save: function (data) {
                this.$inertia.post('/users', data)
                this.reset();
                this.closeModal();
                this.editMode = false;
            },
             edit: function (data) {
                this.form = Object.assign({}, data);
                this.editMode = true;
                this.openModal();
            },
            update: function (data) {
                data._method = 'PUT';
                this.$inertia.post('/users/' + data.id, data)
                this.reset();
                this.closeModal();
            },
            deleteRow: function (data) {
                if (!confirm('Na pewno?')) return;
                data._method = 'DELETE';
                this.$inertia.post('/users/' + data.id, data)
                this.reset();
                this.closeModal();
            }
        }
}
</script>
