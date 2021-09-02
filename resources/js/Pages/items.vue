<template>
    <Head title="Sprzęt" />

    <BreezeAuthenticatedLayout>
        <Card>
            <Message>
                {{ $page.props.flash.message }}
            </Message>

            <FloatingButton @openModal="openModal"></FloatingButton>

            <Table :data="items" :throws="throws" @edit="edit" @deleteRow="deleteRow" height="h-10" margin="mb-4">
                <tr v-for="row in items" :key="row.id" class="flex flex-col flex-no wrap sm:table-row mb-4 sm:mb-0 hover:bg-secondary-50 bg-tertiary justify-center text-text-20">
                    <td class="h-10 sm:h-auto border-primary-200 border p-3">{{ row.database_items.name }}</td>
                    <td class="h-10 sm:h-auto border-primary-200 border p-3">{{ row.cathegory.cathegory.name }}</td>
                    <td class="h-10 sm:h-auto border-primary-200 border p-3">{{ row.manufacturer.manufacturer.name }}</td>
                    <td class="h-10 sm:h-auto border-primary-200 border p-3">{{ row.fire_brigade_unit.name }}</td>
                    <td v-if="row.expiry_date != '9999-01-01'" class="h-10 sm:h-auto border-primary-200 border p-3">{{ row.expiry_date}}</td>
                    <td v-else class="h-10 sm:h-auto border-primary-200 border p-3">Ważny bezterminowo</td>
                    <td class="h-10 sm:h-auto border-primary-200 border text-center p-3">
                        <i @click="edit(row)" class="far fa-edit fa-lg "></i>
                        <i @click="deleteRow(row)" class="far fa-trash-alt fa-lg text-red-700 ml-2"></i>
                        <Link :href="'items/'+row.id"><i class="far fa-eye fa-lg ml-2"></i></Link>
                    </td>
                </tr>
            </Table>
        </Card>
    </BreezeAuthenticatedLayout>
    <Modal :isOpen="isOpen" :editMode="editMode" :form="form" @save="save" @update="update" @closeModal="closeModal">
        <form @submit.prevent="save, update">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div v-if="!editMode" class="mb-4">
                    <BreezeLabel for="cathegoryField" value="Kategoria" />
                    <select class="border-gray-300 w-full focus:border-primary-200 focus:ring focus:ring-primary-200 focus:ring-opacity-50 rounded-md shadow-sm" id="cathegoryField" v-model="cathegory">
                        <template v-for="row in cathegories" :key="row.id">
                            <option v-if="row.itemsdb.length" :value="row.id">
                                {{row.name}}
                            </option> 
                        </template>                         
                    </select>
                </div>
                <div v-if="!editMode" class="mb-4">
                    <BreezeLabel for="itemField" value="Przedmiot" />
                    <select class="border-gray-300 w-full focus:border-primary-200 focus:ring focus:ring-primary-200 focus:ring-opacity-50 rounded-md shadow-sm" id="itemField" v-model="form.item">
                        <template v-for="row in dbitems" :key="row.id">
                            <option v-if="row.cathegory_id == cathegory" :value="row.id">
                                {{row.name}}
                            </option> 
                        </template>                         
                    </select>
                    <div class="text-red-500" v-if="errors.item">{{ errors.item }}</div>
                </div>
                <div class="mb-4 flex">
                    <input type="checkbox" id="checkbox" v-model="form.checked" class="rounded" />              
                    <BreezeLabel for="checkbox" value="Ważny bezterminowo" class="ml-2"/>  
                </div>
                <div class="mb-4" v-if="!form.checked">
                    <BreezeLabel for="dateField" value="Data ważności" />                
                    <input id="dateField" type="date" v-model="form.date" class="border-gray-300 w-full focus:border-primary-200 focus:ring focus:ring-primary-200 focus:ring-opacity-50 rounded-md shadow-sm">
                </div>
                <div v-show="$page.props.auth.user.privilege_id == 1 && !editMode" class="mb-4">
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
import { Head, Link } from '@inertiajs/inertia-vue3';
import Card from "@/Components/Card.vue";
import Table from "@/Components/Table.vue";
import Modal from "@/Components/Modal.vue";
import FloatingButton from "@/Components/FloatingButton.vue";
import Message from "@/Components/Message.vue";

export default {
    props: {
        items: Object,
        cathegories: Object,
        dbitems: Object,
        errors: Object,
        units: Object,
    },
 
    components: {
        BreezeAuthenticatedLayout,
        Head,
        BreezeButton,
        BreezeInput,
        BreezeLabel,
        Link,
        Card,
        Table,
        Modal,
        FloatingButton,
        Message
    },

    data() {
        return {
            editMode: false,
            isOpen: false,
            cathegory: null,
            form: {
                item: null,
                date: null,
                checked: true,
                unit: this.units[0].id
            },
            throws:['Nazwa','Kategoria','Producent', 'Remiza', 'Data ważności', 'Działania'],
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
                checked: true,
                unit: this.units[0].id
            }
        },
        save: function (data) {
            this.$inertia.post('/items', data,{
                onSuccess: () => this.closeModal(),
            })
            this.reset();
        },
        edit: function (data) {
            this.form = Object.assign({}, data);
            this.form.date = data.expiry_date;
            this.editMode = true;
            this.openModal();
        },
        update: function (data) {
            this.$inertia.put('/items/' + data.id, data,{
                onSuccess: () => this.closeModal()
            });     
        },
        deleteRow: function (data) {
            if (!confirm('Na pewno? Usuniesz również historię serwisów!')) return;
            this.$inertia.delete('/items/' + data.id)
            this.reset();
            this.closeModal();
        }
    }
}
</script>
