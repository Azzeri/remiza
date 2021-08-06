<template>
    <Head title="Sprzęt" />

    <BreezeAuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-6 bg-white border-b border-gray-200 overflow-hidden shadow-sm sm:rounded-lg">
                    <BreezeButton @click="openModal()">
                        Nowa
                    </BreezeButton>

                    <div v-if="$page.props.flash.message" class="mt-2 text-green-600 font-semibold">
                        {{ $page.props.flash.message }}
                    </div>

                    <table class="table-fixed w-full mt-2">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2">Nazwa</th>
                                <th class="px-4 py-2">Kategoria</th>
                                <th class="px-4 py-2">Remiza</th>
                                <th class="px-4 py-2">Data ważności</th>
                                <th class="px-4 py-2">Działania</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="row in items" :key="row.id">
                                <td class="border px-4 py-2">{{ row.database_items.name }}</td>
                                <td class="border px-4 py-2">{{ row.database_items.cathegory_id }}</td>
                                <td class="border px-4 py-2">{{ row.fire_brigade_unit.name }}</td>
                                <td class="border px-4 py-2">{{ row.expiry_date}}</td>
                                <td class="border px-4 py-2">
                                    <button @click="edit(row)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">E</button>
                                    <button @click="deleteRow(row)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">U</button>
                                    <Link :href="'items/'+row.id">Serwis</Link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- <div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400" v-if="isOpen">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

                <div class="fixed inset-0 transition-opacity">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" >
                    <form>
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="mb-4">
                                <BreezeLabel for="nameField" value="Nazwa" />
                                <BreezeInput id="nameField" type="text" class="mt-1 block w-full" v-model="form.name" placeholder="Wprowadź nazwę" />
                                <div class="text-red-500" v-if="errors.name">{{ errors.name }}</div>
                            </div>                                                         
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
        </div> -->
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
        items: Object,
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
            editMode: false,
            isOpen: false,
            form: {
                name: null,
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
            }
        },
        save: function (data) {
            this.$inertia.post('/cathegories', data)
            this.reset();
            // this.closeModal();
            this.editMode = false;
        },
        edit: function (data) {
            this.form = Object.assign({}, data);
            this.editMode = true;
            this.openModal();
        },
        update: function (data) {
            data._method = 'PUT';
            this.$inertia.post('/cathegories/' + data.id, data)
            this.reset();
            this.closeModal();
        },
        // deleteRow: function (data) {
        //     if (!confirm('Na pewno?')) return;
        //     data._method = 'DELETE';
        //     this.$inertia.post('/cathegories/' + data.id, data)
        //     this.reset();
        //     this.closeModal();
        // }
    }
}
</script>
