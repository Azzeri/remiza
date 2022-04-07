<template>
    <Head title="Sprzęt" />

    <BreezeAuthenticatedLayout>
        <Card>
            <Message>
                {{ $page.props.flash.message }}
            </Message>

            <FloatingButton @openModal="openModal"></FloatingButton>

            <Table :data="dbitems.data.length" :throws="throws" @edit="edit" @deleteRow="deleteRow" height="h-10" margin="mb-4">
                <tr v-for="row in dbitems.data" :key="row.id" class="flex flex-col flex-no wrap sm:table-row mb-4 sm:mb-0 hover:bg-secondary-50 bg-tertiary justify-center text-text-20">
                    <td class="h-10 sm:h-auto border-primary-200 border p-3 overflow-auto">{{ row.stencil_name }}</td>
                    <td class="h-10 sm:h-auto border-primary-200 border p-3 overflow-auto">{{ row.cathegory.name }}</td>
                    <td v-html="isTrue(row.name)" class="h-10 sm:h-auto text-center border-primary-200 border p-3 overflow-auto"></td>
                    <td v-html="isTrue(row.construction_number)" class="h-10 sm:h-auto border-primary-200 text-center border p-3 overflow-auto"></td>
                    <td v-html="isTrue(row.inventory_number)" class="h-10 sm:h-auto border-primary-200 text-center border p-3 overflow-auto"></td>
                    <td v-html="isTrue(row.identification_number)" class="h-10 sm:h-auto border-primary-200 text-center border p-3 overflow-auto"></td>
                    <td v-html="isTrue(row.date_production)" class="h-10 sm:h-auto border-primary-200 text-center border p-3 overflow-auto"></td>
                    <td v-html="isTrue(row.date_expiry)" class="h-10 sm:h-auto border-primary-200 text-center border p-3 overflow-auto"></td>
                    <td v-html="isTrue(row.date_legalisation)" class="h-10 sm:h-auto border-primary-200 text-center border p-3 overflow-auto"></td>
                    <td v-html="isTrue(row.date_legalisation_due)" class="h-10 sm:h-auto border-primary-200 text-center border p-3 overflow-auto"></td>
                    <td v-html="isTrue(row.manufacturer)" class="h-10 sm:h-auto border-primary-200 text-center border p-3 overflow-auto"></td>
                    <td v-html="isTrue(row.vehicle)" class="h-10 sm:h-auto border-primary-200 text-center border p-3 overflow-auto"></td>
                    <td class="h-10 sm:h-auto border-primary-200 border text-center p-3">
                        <i v-show="($page.props.auth.user.privilege_id == $page.props.privileges.IS_GLOBAL_ADMIN)" @click="edit(row)" class="far fa-edit fa-lg "></i>
                        <i v-show="($page.props.auth.user.privilege_id == $page.props.privileges.IS_GLOBAL_ADMIN)" @click="deleteRow(row)" class="far fa-trash-alt fa-lg text-red-700 ml-2 cursor-pointer"></i>
                    </td>
                </tr>
            </Table>
            <pagination class="mt-6" :links="dbitems.links" />
        </Card>
    </BreezeAuthenticatedLayout>
    <Modal :isOpen="isOpen" :editMode="editMode" :form="form" @save="save" @update="update" @closeModal="closeModal">
        <form @submit.prevent="save, update">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">

                <div class="text-text-200 font-bold text-lg mb-4">
					<h3>{{title}}</h3>
				</div>

                <div v-if="!editMode" class="mb-4">
                    <BreezeLabel for="cathegoryField" value="Kategoria" />
                    <select id="cathegoryField" v-model="form.cathegory_id" class="border-gray-300 w-full focus:border-primary-200 focus:ring focus:ring-primary-200 focus:ring-opacity-50 rounded-md shadow-sm">
                        <template v-for="row in cathegories" :key="row.id">
                            <option :value="row.id">
                                {{row.name}}
                            </option>
                        </template>                         
                    </select>
                    <div class="text-red-500" v-if="form.errors.cathegory">{{ form.errors.cathegory }}</div>
                </div>

                <div class="mb-6">                 
                    <BreezeLabel for="stencilNameField" value="Nazwa szablonu" />
                    <BreezeInput id="stencilNameField" type="text" class="mt-1 block w-full" v-model="form.stencil_name" placeholder="Wpisz nazwę szablonu" /> 
                    <div class="text-red-500" v-if="form.errors.stencil_name">{{ form.errors.stencil_name }}</div>
                </div>

                <div class="text-text-200 font-bold text-mf mb-4">
					<h3>Wybierz pola</h3>
				</div>

                <div v-for="row in fields" :key="row.value" class="mb-4">
                    <div class="flex">       
                        <Checkbox :id="row.value" v-model="form[row.value]" :checked="form[row.value] == 1 ? true : false"></Checkbox>
                        <BreezeLabel :for="row.value" :value="row.name" class="ml-4" />
                    </div> 
                    <div class="text-red-500" v-if="form.errors[row.value]">{{ form.errors[row.value] }}</div>
                </div>

            </div>    
        </form> 
        <!-- {{form}} -->
    </Modal>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import BreezeButton from '@/Components/Button.vue'
import BreezeInput from '@/Components/Input.vue'
import BreezeLabel from '@/Components/Label.vue'
import Checkbox from '@/Components/Checkbox.vue'
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import Card from "@/Components/Card.vue";
import Table from "@/Components/Table.vue";
import Modal from "@/Components/Modal.vue";
import FloatingButton from "@/Components/FloatingButton.vue";
import Message from "@/Components/Message.vue";
import Pagination from "@/Components/Pagination.vue";
import { ref, computed } from "vue";
import { Inertia } from "@inertiajs/inertia";

export default {
    props: {
        dbitems: Object,
        dbservices: Object,
        cathegories: Object,
        errors: Object,
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
        Pagination,
        Checkbox
    },

    setup(props) {
        const editMode = ref(false)
        const isOpen = ref(false)
        const form = useForm({
            cathegory_id: props.cathegories[0].id,
            stencil_name: null,
            construction_number: false,
            inventory_number: false,
            identification_number: false,
            name:false,
            date_production:false,
            date_expiry:false,
            date_legalisation:false,
            date_legalisation_due:false,
            manufacturer:false,
            vehicle: false,
        })
        const throws = [
            'Nazwa szablonu', 'Kategoria','Nazwa','Nr fabryczny', 
            'Nr inwentarzowy','Nr ewidencyjny', 'Data produkcji', 
            'Data ważności', 'Data legalizacji','Termin legalizacji',
            'Producent', 'Samochód', 'Działania'
        ]
        const fields = [
            {name:'Nr fabryczny', value:'construction_number'},
            {name:'Nr inwentarzowy', value:'inventory_number'},
            {name:'Nr ewidencyjny', value:'identification_number'},
            {name:'Nazwa', value:'name'},
            {name:'Data produkcji', value:'date_production'},
            {name:'Data ważności', value:'date_expiry'},
            {name:'Data legalizacji', value:'date_legalisation'},
            {name:'Termin legalizacji', value:'date_legalisation_due'},
            {name:'Producent', value:'manufacturer'},
            {name:'Samochód', value:'vehicle'}
        ]
        const defaultCathegory = computed(
            () => {
                if (props.cathegories.length)
                return props.cathegories[0].id
            }
        )
        // Czy może tak być, jeśli jest tylko editMode ???
        const title = computed(
            () => {
                return !props.editMode ? 'Dodawanie szablonu' : 'Edycja szablonu'
            }
        )
        const isTrue = (attr) => {
            return attr ? '<i class="fas fa-check fa-lg text-green-700"></i>'
                        : '<i class="fas fa-times fa-lg text-red-700"></i>'
        }
        const openModal = (_) => {
            isOpen.value = true
        }
        const closeModal = (_) => {
            isOpen.value = false
            reset()
        }
        const reset = (_) => {
            form.reset()
            form.clearErrors()
            editMode.value = false
        }
        const save = (_) => {
            form.post(route("stencils.store"), {
                onSuccess: () => closeModal()
            })
        }
        // Nie działa edycja !!!
        const edit = (row) => {
            editMode.value = true
            openModal()
            form.id = row.id
            form.cathegory_id = row.cathegory.id
            form.stencil_name = row.stencil_name
            form.construction_number = row.construction_number
            form.inventory_number = row.inventory_number
            form.identification_number = row.identification_number
            form.name = row.name
            form.date_production = row.date_production
            form.date_expiry = row.date_expiry
            form.date_legalisation = row.date_legalisation
            form.date_legalisation_due = row.date_legalisation_due
            form.manufacturer = row.manufacturer
            form.vehicle = row.vehicle
        }
        const update = (data) => {
            form.put(route("stencils.update", data.id), {
                onSuccess: () => closeModal()
            })
        }
        const deleteRow = (data) => {
            if (!confirm('Na pewno? Usuniesz również przypisane przedmioty i serwisy!')) return;
            Inertia.delete(route("stencils.destroy", data.id))
            form.reset()
        }
        return {
            editMode,
            isOpen,
            form,
            throws,
            fields,
            defaultCathegory,
            title,
            computed,
            isTrue,
            openModal,
            closeModal,
            reset,
            save,
            edit,
            update,
            deleteRow,
        }
    }

    // created(){
    //     this.reset();
    // },
    // data() {
    //     return {
    //         editMode: false,
    //         isOpen: false,
    //         form: {
    //             cathegory_id: this.defaultCathegory,
    //             stencil_name: null,
    //             construction_number: false,
    //             inventory_number: false,
    //             identification_number: false,
    //             name:false,
    //             date_production:false,
    //             date_expiry:false,
    //             date_legalisation:false,
    //             date_legalisation_due:false,
    //             manufacturer:false,
    //             vehicle: false,
    //         },
    //         throws:['Nazwa szablonu', 'Kategoria','Nazwa','Nr fabryczny', 'Nr inwentarzowy','Nr ewidencyjny', 'Data produkcji',
    //         'Data ważności', 'Data legalizacji','Termin legalizacji','Producent', 'Samochód', 'Działania'],
    //         fields:[
    //             {name: 'Nr fabryczny', value: 'construction_number'},
    //             {name: 'Nr inwentarzowy', value: 'inventory_number'},
    //             {name: 'Nr ewidencyjny', value: 'identification_number'},
    //             {name: 'Nazwa', value: 'name'},
    //             {name: 'Data produkcji', value: 'date_production'},
    //             {name: 'Data ważności', value: 'date_expiry'},
    //             {name: 'Data legalizacji', value: 'date_legalisation'},
    //             {name: 'Termin legalizacji', value: 'date_legalisation_due'},
    //             {name: 'Producent', value: 'manufacturer'},
    //             {name: 'Samochód', value: 'vehicle'},
    //         ]
    //     }
    // },
    // computed: {
    //     defaultCathegory() {
    //         if (this.cathegories.length)
    //             return this.cathegories[0].id
    //     },
        
    //     title() {
    //         return !this.editMode ? 'Dodawanie szablonu' : 'Edycja szablonu'
    //     }
    // },
    // methods: {
    //     isTrue(attr){
    //         return attr ? '<i class="fas fa-check fa-lg text-green-700"></i>': '<i class="fas fa-times fa-lg text-red-700"></i>'
    //     },

    //     openModal: function () {
    //         this.isOpen = true;
    //     },
    //     closeModal: function () {
    //         this.isOpen = false;
    //         this.reset();
    //         this.editMode = false;
    //     },
    //     reset: function () {
    //       this.form = {
    //             cathegory_id: this.defaultCathegory,
    //             stencil_name: null,
    //             construction_number: false,
    //             inventory_number: false,
    //             identification_number: false,
    //             name:false,
    //             date_production:false,
    //             date_expiry:false,
    //             date_legalisation:false,
    //             date_legalisation_due:false,
    //             manufacturer:false,
    //             vehicle: false,
    //         }
    //     },
    //     save: function (data) {
    //         this.$inertia.post('/stencils', data,{
    //             onSuccess: () => this.closeModal()
    //         })
    //     },
    //     edit: function (data) {
    //         this.form = Object.assign({}, data);
    //         this.editMode = true;
    //         this.openModal();
    //     },
    //     update: function (data) {
    //         this.$inertia.put('/stencils/' + data.id, data,{
    //             onSuccess: () => this.closeModal()
    //         });     
    //     },
    //     deleteRow: function (data) {
    //         if (!confirm('Na pewno? Usuniesz również przypisane przedmioty i serwisy!')) return;
    //         this.$inertia.delete('/stencils/' + data.id)
    //         this.reset();
    //     }
    // }
}
</script>
