<template>
    <Head title="Samochody" />

    <BreezeAuthenticatedLayout>
        <Card>
            <Message>
                {{ $page.props.flash.message }}
            </Message>

            <FloatingButton @openModal="openModal"></FloatingButton>

            <Table :data="data.length" :throws="throws" @edit="edit" @deleteRow="deleteRow" height="h-10" margin="mb-4">
                <tr v-for="row in data" :key="row.id" class="flex flex-col flex-no wrap sm:table-row mb-4 sm:mb-0 hover:bg-secondary-50 bg-tertiary justify-center text-text-200">
                    <td class="h-10 sm:h-auto border-primary-200 border p-3 overflow-auto">{{ row.number }}</td>
                    <td class="h-10 sm:h-auto border-primary-200 border p-3 overflow-auto">{{ row.name }}</td>
                    <td class="h-10 sm:h-auto border-primary-200 border p-3 overflow-auto">{{ row.unit.name}}</td>
                    <td class="h-10 sm:h-auto border-primary-200 border p-3 overflow-auto text-center">
                        <i @click="edit(row)" class="far fa-edit fa-lg cursor-pointer"></i>
                        <i @click="deleteRow(row)" class="far fa-trash-alt fa-lg text-red-700 ml-2 cursor-pointer"></i>
                    </td>
                </tr>
            </Table>
        </Card>
    </BreezeAuthenticatedLayout>
    <Modal :isOpen="isOpen" :editMode="editMode" :form="form" @save="save" @update="update" @closeModal="closeModal">
        <form @submit.prevent="save, update"> 
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="mb-2 text-secondary-200 font-semibold">
                    Dodaj samochód
                </div>
                <div class="mb-4">
                    <BreezeLabel for="numberField" value="Numer" />
                    <BreezeInput id="numberField" type="text" class="mt-1 block w-full" v-model="form.number" placeholder="Wprowadź numer" />
                    <div class="text-red-500" v-if="errors.number">{{ errors.number }}</div>
                </div>
                <div class="mb-4">
                    <BreezeLabel for="nameField" value="Nazwa" />
                    <BreezeInput id="nameField" type="text" class="mt-1 block w-full" v-model="form.name" placeholder="Wprowadź nazwę" />
                    <div class="text-red-500" v-if="errors.name">{{ errors.name }}</div>
                </div>
                <div v-show="($page.props.auth.user.privilege_id == $page.props.privileges.IS_GLOBAL_ADMIN || $page.props.auth.user.privilege_id == $page.props.privileges.IS_SUPERIOR_UNIT_ADMIN) && !editMode" class="mb-4">
                    <BreezeLabel for="unitField" value="Remiza" />
                    <select v-model="form.unit" class="border-gray-300 w-full focus:border-primary-200 focus:ring focus:ring-primary-200 focus:ring-opacity-50 rounded-md shadow-sm" id="unitField">
                        <template v-for="fbunit in units" :key="fbunit.id">
                            <option :value="fbunit.id">
                                {{fbunit.name}}
                            </option>
                        </template>
                    </select>
                </div>    
            </div>                
        </form>
    </Modal>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import BreezeButton from '@/Components/Button.vue'
import BreezeInput from '@/Components/Input.vue'
import BreezeLabel from '@/Components/Label.vue'
import { Head } from '@inertiajs/inertia-vue3';
import Card from "@/Components/Card.vue";
import Table from "@/Components/Table.vue";
import Modal from "@/Components/Modal.vue";
import FloatingButton from "@/Components/FloatingButton.vue";
import Message from "@/Components/Message.vue";

export default {
    props: {
        data: Object,
        units: Object,
        errors: Object,
    },
 
    components: {
        BreezeAuthenticatedLayout,
        Head,
        BreezeButton,
        BreezeInput,
        BreezeLabel,
        Card,
        Table,
        Modal,
        FloatingButton,
        Message
    },

    created(){
        this.reset();
    },

    computed: {
        defaultUnit(){
            if (this.units.length)
                return this.units[0].id
        }
    },

    data() {
        return {
            editMode: false,
            isOpen: false,
            form: {
                name: null,
                number: null,
                unit: this.defaultUnit
            },
            throws:['Numer', 'Nazwa', 'Jednostka', 'Działania'],
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
                number:null,
                unit: this.defaultUnit
            }
        },
        save: function (data) {
            this.$inertia.post('/vehicles', data,{
                onSuccess: () => this.closeModal(),
            })
            this.reset();
        },
        edit: function (data) {
            this.form = Object.assign({}, data);
            this.editMode = true;
            this.openModal();
        },
        update: function (data) {
            this.$inertia.put('/vehicles/' + data.id, data,{
                onSuccess: () => this.closeModal()
            });     
        },
        deleteRow: function (data) {
            if (!confirm('Na pewno?')) return;
            this.$inertia.delete('/vehicles/' + data.id)
            this.closeModal();
        }
    }
}
</script>
