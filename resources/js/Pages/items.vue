<template>
    <Head title="Sprzęt" />

    <BreezeAuthenticatedLayout>
        <Card>
            <Message>
                {{ $page.props.flash.message }}
            </Message>

            <FloatingButton v-if="units.length" @openModal="openModal"></FloatingButton>

            <Table :data="items.data.length" :throws="throws" @edit="edit" @deleteRow="deleteRow" height="h-10" margin="mb-4">
                <tr v-for="row in items.data" :key="row.id" class="flex flex-col flex-no wrap sm:table-row mb-4 sm:mb-0 hover:bg-secondary-50 bg-tertiary justify-center text-text-20">
                    <td class="h-10 sm:h-auto border-primary-200 border p-3">{{ row.cathegory.cathegory.name }}</td>
                    <td class="h-10 sm:h-auto border-primary-200 border p-3">{{ row.name }}</td>
                    <td class="h-10 sm:h-auto border-primary-200 border p-3">{{ row.construction_number }}</td>
                    <td class="h-10 sm:h-auto border-primary-200 border p-3">{{ row.inventory_number }}</td>
                    <td class="h-10 sm:h-auto border-primary-200 border p-3">{{ row.identification_number }}</td>
                    <td class="h-10 sm:h-auto border-primary-200 border p-3">{{ row.date_production }}</td>
                    <td class="h-10 sm:h-auto border-primary-200 border p-3">{{ row.date_expiry }}</td>
                    <td class="h-10 sm:h-auto border-primary-200 border p-3">{{ row.date_legalisation }}</td>
                    <td class="h-10 sm:h-auto border-primary-200 border p-3">{{ row.date_legalisation_due }}</td>
                    <td v-if="row.manufacturer" class="h-10 sm:h-auto border-primary-200 border p-3">{{ row.manufacturer.name }}</td>
                    <td v-else class="h-10 sm:h-auto border-primary-200 border p-3"></td>
                    <td v-if="row.vehicle" class="h-10 sm:h-auto border-primary-200 border p-3">{{ row.vehicle.name }}</td>
                    <td v-else class="h-10 sm:h-auto border-primary-200 border p-3"></td>
                    <td class="h-10 sm:h-auto border-primary-200 border p-3">{{ row.fire_brigade_unit.name }}</td>
                    <td class="h-10 sm:h-auto border-primary-200 border text-center p-3">
                        <i @click="edit(row)" class="far fa-edit fa-lg "></i>
                        <i @click="deleteRow(row)" class="far fa-trash-alt fa-lg text-red-700 ml-2 cursor-pointer"></i>
                        <Link :href="'items/'+row.id"><i class="far fa-eye fa-lg ml-2 cursor-pointer"></i></Link>
                    </td>
                </tr>
            </Table>
            <pagination class="mt-6" :links="items.links" />
        </Card>
    </BreezeAuthenticatedLayout>
    <Modal :isOpen="isOpen" :editMode="editMode" :form="form" @save="save" @update="update" @closeModal="closeModal">
        <form @submit.prevent="save, update">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">

                <div class="text-text-200 font-bold text-lg mb-4">
					<h3>{{title}}</h3>
				</div>

                <div v-if="!editMode" class="mb-4">
                    <BreezeLabel for="stencilField" value="Szablon" />
                    <select @change="checkFields" id="stencilField" v-model="stencil" class="border-gray-300 w-full focus:border-primary-200 focus:ring focus:ring-primary-200 focus:ring-opacity-50 rounded-md shadow-sm">
                        <template v-for="row in dbitems" :key="row.id">
                            <option :value="row">
                                {{row.stencil_name}}
                            </option>
                        </template>                         
                    </select>
                    <div class="text-red-500" v-if="errors.stencil">{{ errors.stencil }}</div>
                </div>

                <template v-for="row in textFields" :key="row.value">
                    <div class="mb-4">                 
                        <BreezeLabel :for="row.value" :value="row.name" />
                        <BreezeInput :id="row.value" type="text" class="mt-1 block w-full" v-model="form[row.value]" :placeholder="row.name" />  
                        <div class="text-red-500" v-if="errors[row.value]">{{ errors[row.value] }}</div>
                    </div>
                </template> 

                <template v-for="row in dateFields" :key="row.value">
                    <div class="mb-4">                 
                        <BreezeLabel :for="row.value" :value="row.name" />
                        <BreezeInput :id="row.value" type="date" class="mt-1 block w-full" v-model="form[row.value]" :placeholder="row.name" /> 
                        <div class="text-red-500" v-if="errors[row.value]">{{ errors[row.value] }}</div>
                    </div>
                </template> 

                <template v-for="row in selectFields" :key="row.value">
                    <div class="mb-4">                 
                        <BreezeLabel :for="row.value" :value="row.name" />
                        <select :id="row.value" v-model="form[row.value]" class="border-gray-300 w-full focus:border-primary-200 focus:ring focus:ring-primary-200 focus:ring-opacity-50 rounded-md shadow-sm">
                            <template v-for="row_data in row.data" :key="row_data.id">
                                <option :value="row_data.id">
                                    {{row_data.name}}
                                </option>
                            </template>
                        </select>
                        <div class="text-red-500" v-if="errors[row.value]">{{ errors[row.value] }}</div>
                    </div>
                </template>

                <div v-show="($page.props.auth.user.privilege_id == $page.props.privileges.IS_GLOBAL_ADMIN || $page.props.auth.user.privilege_id == $page.props.privileges.IS_SUPERIOR_UNIT_ADMIN) && !editMode" class="mb-4">
                    <BreezeLabel for="unitField" value="Remiza" />
                    <select v-model="form.unit" class="border-gray-300 w-full focus:border-primary-200 focus:ring focus:ring-primary-200 focus:ring-opacity-50 rounded-md shadow-sm" id="unitField">
                        <template v-for="fbunit in units" :key="fbunit.id">
                            <option :value="fbunit.id">
                                {{fbunit.name}}
                            </option>
                        </template>
                    </select>
                    <div class="text-red-500" v-if="errors.unit">{{ errors.unit }}</div>
                </div>                                         
            </div>    
        </form>
        <!-- {{form}} -->
        <!-- {{stencil}} -->
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
import Pagination from "@/Components/Pagination.vue";

export default {
    props: {
        items: Object,
        manufacturers: Object,
        vehicles: Object,
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
        Message,
        Pagination
    },
    created(){
        this.reset();
    },

    data() {
        return {
            editMode: false,
            isOpen: false,
            stencil: this.defaultStencil,
            form: {
                construction_number: null,
                inventory_number: null,
                identification_number: null,
                name:null,
                date_production:null,
                date_expiry:null,
                date_legalisation:null,
                date_legalisation_due:null,
                manufacturer:this.defaultManufacturer,
                vehicle: this.defaultVehicle,
                unit: this.defaultUnit,
                stencil:null
            },
            throws:['Kategoria','Nazwa','Nr fabryczny', 'Nr inwentarzowy','Nr ewidencyjny', 'Data produkcji',
            'Data ważności', 'Data Legalizacji','Termin Legalizacji','Producent', 'Samochód', 'Remiza', 'Działania'],
            selectFields: [],
            textFields: [],
            dateFields: []
        }
    },
    computed: {
        defaultUnit() {
            if (this.units.length)
                return this.units[0].id
        },
        defaultStencil() {
            if (this.dbitems.length)
                return this.dbitems[0]
        },
        defaultManufacturer() {
            if (this.manufacturers.length && this.fieldIsTrue(this.stencil.manufacturer))
                return this.manufacturers[0].id
            else return null
        },
        defaultVehicle() {
            if (this.vehicles.length && this.fieldIsTrue(this.stencil.vehicle))
                return this.vehicles[0].id
            else return null
        },
        checkFields() {
            this.textFields = []
            this.selectFields = []
            this.dateFields = []
            this.resetForm()
            this.form.stencil = this.stencil.id

            this.fieldIsTrue(this.stencil.construction_number) ? this.textFields.push({value:'construction_number', name:'Numer fabryczny'}):true;
            this.fieldIsTrue(this.stencil.inventory_number) ? this.textFields.push({value:'inventory_number', name:'Numer inwentarzowy'}):true;
            this.fieldIsTrue(this.stencil.identification_number) ? this.textFields.push({value:'identification_number', name:'Numer ewidencyjny'}):true;
            this.fieldIsTrue(this.stencil.name) ? this.textFields.push({value:'name', name:'Nazwa'}):true;

            this.fieldIsTrue(this.stencil.date_production) ? this.dateFields.push({value:'date_production', name:'Data produkcji'}):true;
            this.fieldIsTrue(this.stencil.date_expiry) ? this.dateFields.push({value:'date_expiry', name:'Data ważności'}):true;
            this.fieldIsTrue(this.stencil.date_legalisation) ? this.dateFields.push({value:'date_legalisation', name:'Data legalizacji'}):true;
            this.fieldIsTrue(this.stencil.date_legalisation_due) ? this.dateFields.push({value:'date_legalisation_due', name:'Termin legalizacji'}):true;

            this.fieldIsTrue(this.stencil.manufacturer) ? this.selectFields.push({value:'manufacturer', name:'Producent', data:this.manufacturers}):true;
            this.fieldIsTrue(this.stencil.vehicle) ? this.selectFields.push({value:'vehicle', name:'Samochód', data:this.vehicles}):true;

        },
        title() {
            return !this.editMode ? 'Dodawanie przedmiotu' : 'Edycja przedmiotu'
        }
    },
    methods: {
        fieldIsTrue: function(field){
            return field ? true:false;
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
            this.stencil = this.defaultStencil
            this.resetForm()
            this.checkFields
        },
        resetForm: function () {
          this.form = {
                construction_number: null,
                inventory_number: null,
                identification_number: null,
                name:null,
                date_production:null,
                date_expiry:null,
                date_legalisation:null,
                date_legalisation_due:null,
                manufacturer:this.defaultManufacturer,
                vehicle: this.defaultVehicle,
                unit: this.defaultUnit,
                stencil:null
            }
        },
        save: function (data) {
            this.$inertia.post('/items', data,{
                onSuccess: () => this.closeModal()
            })
        },
        edit: function (data) {
            this.stencil = data.database_items           
            this.checkFields
            this.form = Object.assign({}, data);
            if(data.manufacturer)
                this.form.manufacturer = data.manufacturer.id
            if(data.vehicle)
                this.form.vehicle = data.vehicle.id
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
