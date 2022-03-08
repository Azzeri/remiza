<template>
    <Head title="Remizy" />

    <BreezeAuthenticatedLayout>
        <Card>
            <Message>
                {{ $page.props.flash.message }}
            </Message>

            <FloatingButton @openModal="openModal"></FloatingButton>

            <Table :data="data.data.length" :throws="throws" @edit="edit" @deleteRow="deleteRow" height="h-10" margin="mb-4">
                <tr v-for="row in data.data" :key="row.id" class="flex flex-col flex-no wrap sm:table-row mb-4 sm:mb-0 hover:bg-secondary-50 bg-tertiary justify-center text-text-200">
                    <td class="h-10 sm:h-auto border-primary-200 border p-3 overflow-auto">{{ row.name }}</td>
                    <td class="h-10 sm:h-auto border-primary-200 border p-3 overflow-auto">{{ row.address }}</td>
                    <td class="h-10 sm:h-auto border-primary-200 border p-3 overflow-auto">{{ superiorUnit(row) }}</td>
                    <td class="h-10 sm:h-auto border-primary-200 border p-3 text-center">
                        <i @click="edit(row)" class="far fa-edit fa-lg cursor-pointer"></i>
                        <i v-if="row.id != $page.props.auth.user.fire_brigade_unit_id" @click="deleteRow(row)" class="far fa-trash-alt fa-lg text-red-700 ml-2 cursor-pointer"></i>
                    </td>
                </tr>
            </Table>
            <pagination class="mt-6" :links="data.links" />
        </Card>
    </BreezeAuthenticatedLayout>
    <Modal :isOpen="isOpen" :editMode="editMode" :form="form" @save="save" @update="update" @closeModal="closeModal">
        <form @submit.prevent="save, update"> 
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="mb-2 text-secondary-200 font-semibold">
                    Jednostka
                </div>
                <div class="mb-4">
                    <BreezeLabel for="nameField" value="Nazwa" />
                    <BreezeInput id="nameField" type="text" class="mt-1 block w-full" v-model="form.name" placeholder="Wprowadź nazwę" />
                    <div class="text-red-500" v-if="errors.name">{{ errors.name }}</div>
                </div>   
                <div class="mb-4">
                    <BreezeLabel for="addressField" value="Adres" />
                    <BreezeInput id="addressField" type="text" class="mt-1 block w-full" v-model="form.address" placeholder="Wprowadź adres" />
                    <div class="text-red-500" v-if="errors.address">{{ errors.address }}</div>
                </div>
                 <div v-show="$page.props.auth.user.privilege_id == $page.props.privileges.IS_GLOBAL_ADMIN && !editMode" class="mb-4">
                        <BreezeLabel for="parentField" value="Jednostka nadrzędna" />
                        <select id="parentField" v-model="form.superior" class="border-gray-300 w-full focus:border-primary-200 focus:ring focus:ring-primary-200 focus:ring-opacity-50 rounded-md shadow-sm">
                            <option value=null>Brak</option>                                   
                            <template v-for="row in data" :key="row.id">
                                <option v-if="!row.superior_unit_id" :value="row.id">
                                    {{row.name}}
                                </option> 
                            </template>                         
                        </select>
                </div>
                <div v-show="!editMode">
                    <div class="mb-2 text-secondary-200 font-semibold">
                        Komendant
                    </div>
                    <div class="mb-4">
                        <BreezeLabel for="userNameField" value="Imię" />
                        <BreezeInput id="userNameField" type="text" class="mt-1 block w-full" v-model="form.username" placeholder="Wprowadź imię" />
                        <div class="text-red-500" v-if="errors.username">{{ errors.username }}</div>
                    </div>
                    <div class="mb-4">
                        <BreezeLabel for="surnameField" value="Nazwisko" />
                        <BreezeInput id="surnameField" type="text" class="mt-1 block w-full" v-model="form.surname" placeholder="Wprowadź nazwisko"  />
                        <div class="text-red-500" v-if="errors.surname">{{ errors.surname }}</div>
                    </div>
                    <div class="mb-4">
                        <BreezeLabel for="emailField" value="Email" />
                        <BreezeInput id="emailField" type="email" class="mt-1 block w-full" v-model="form.email" placeholder="Wprowadź email" />
                        <div class="text-red-500" v-if="errors.email">{{ errors.email }}</div>
                    </div>
                    <div class="mb-4">
                        <BreezeLabel for="phoneField" value="Nr telefonu" />
                        <BreezeInput id="phoneField" type="text" class="mt-1 block w-full" v-model="form.phone" placeholder="Wprowadź nr telefonu" />
                        <div class="text-red-500" v-if="errors.phone">{{ errors.phone }}</div>
                    </div>   
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
import Pagination from "@/Components/Pagination.vue";

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
        BreezeLabel,
        Card,
        Table,
        Modal,
        FloatingButton,
        Pagination,
        Message
    },

    data() {
        return {
            editMode: false,
            isOpen: false,
            form: {
                name: null,
                address: null,
                username: null,
                surname: null,
                email: null,
                phone: null,
                superior: null
            },
            throws:['Nazwa','Adres','Jednostka nadrzędna', 'Działania'],
        }
    },

    computed: {

    },
    
    methods: {
        superiorUnit(unit){
            return unit.superior_unit ? unit.superior_unit.name : 'brak';
        },
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
                address: null,
                username: null,
                surname: null,
                email: null,
                phone: null,
                superior: null
            }
        },
        save: function (data) {
            this.$inertia.post('/fireBrigadeUnits', data,{
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
            this.$inertia.put('/fireBrigadeUnits/' + data.id, data,{
                onSuccess: () => this.closeModal()
            });     
        },
        deleteRow: function (data) {
            if (!confirm('Na pewno? Usuniesz wszystkie dane związane z jednostką!')) return;
            this.$inertia.delete('/fireBrigadeUnits/' + data.id)
            this.closeModal();
        }
    }
}
</script>
