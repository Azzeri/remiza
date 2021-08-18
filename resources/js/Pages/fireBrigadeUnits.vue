<template>
    <Head title="Remizy" />

    <BreezeAuthenticatedLayout>
        <Card>
            <FloatingButton @openModal="openModal"></FloatingButton>

            <div v-if="$page.props.flash.message" class="mt-2 font-xl text-green-600 font-semibold">
                {{ $page.props.flash.message }}
            </div>

            <Table :data="data" :throws="throws" @edit="edit" @deleteRow="deleteRow" height="h-10" margin="mb-4">
                <tr v-for="row in data" :key="row.id" class="flex flex-col flex-no wrap sm:table-row mb-4 sm:mb-0 hover:bg-gray-100">
                    <td class="h-10 sm:h-auto border-grey-light border p-3">{{ row.name }}</td>
                    <td class="h-10 sm:h-auto border-grey-light border p-3">{{ row.address }}</td>
                    <td class="h-10 sm:h-auto border-grey-light border text-center p-3">
                        <i @click="edit(row)" class="far fa-edit fa-lg "></i>
                        <i @click="deleteRow(row)" class="far fa-trash-alt fa-lg text-red-700 ml-2"></i>
                    </td>
                </tr>
            </Table>
        </Card>
    </BreezeAuthenticatedLayout>
    <Modal :isOpen="isOpen" :editMode="editMode" :form="form" @save="save" @update="update" @closeModal="closeModal">
        <form @submit.prevent="save, update"> 
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
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
                <div v-show="!editMode">
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
                        <BreezeLabel for="phoneField" value="Phone" />
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
        FloatingButton
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
                phone: null
            },
            throws:['Nazwa','Adres','Działania'],
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
                address: null,
                username: null,
                surname: null,
                email: null,
                phone: null
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
            if (!confirm('Na pewno?')) return;
            data._method = 'DELETE';
            this.$inertia.post('/cathegories/' + data.id, data)
            this.reset();
            this.closeModal();
        }
    }
}
</script>
