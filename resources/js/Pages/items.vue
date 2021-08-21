<template>
    <Head title="Sprzęt" />

    <BreezeAuthenticatedLayout>
        <Card>
            <FloatingButton @openModal="openModal"></FloatingButton>

            <div v-if="$page.props.flash.message" class="mt-2 font-xl text-green-600 font-semibold">
                {{ $page.props.flash.message }}
            </div>

            <Table :data="items" :throws="throws" @edit="edit" @deleteRow="deleteRow" height="h-10" margin="mb-4">
                <tr v-for="row in items" :key="row.id" class="flex flex-col flex-no wrap sm:table-row mb-4 sm:mb-0 hover:bg-gray-100">
                    <td class="h-10 sm:h-auto border-grey-light border p-3">{{ row.database_items.name }}</td>
                    <td class="h-10 sm:h-auto border-grey-light border p-3">{{ row.cathegory.cathegory.name }}</td>
                    <td class="h-10 sm:h-auto border-grey-light border p-3">{{ row.manufacturer.manufacturer.name }}</td>
                    <td class="h-10 sm:h-auto border-grey-light border p-3">{{ row.fire_brigade_unit.name }}</td>
                    <td v-if="row.expiry_date != '9999-01-01'" class="h-10 sm:h-auto border-grey-light border p-3">{{ row.expiry_date}}</td>
                    <td v-else class="h-10 sm:h-auto border-grey-light border p-3">Ważny bezterminowo</td>
                    <td class="h-10 sm:h-auto border-grey-light border text-center p-3">
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
                <div class="mb-4">
                    <BreezeLabel for="cathegoryField" value="Kategoria" />
                    <select class="border-gray-300 w-full focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" id="cathegoryField" v-model="cathegory">
                        <template v-for="row in cathegories" :key="row.id">
                            <option v-if="row.itemsdb.length" :value="row.id">
                                {{row.name}}
                            </option> 
                        </template>                         
                    </select>
                </div>
                <div class="mb-4">
                    <BreezeLabel for="itemField" value="Przedmiot" />
                    <select class="border-gray-300 focus:border-indigo-300 w-full focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" id="itemField" v-model="form.item">
                        <template v-for="row in dbitems" :key="row.id">
                            <option v-if="row.cathegory_id == cathegory" :value="row.id">
                                {{row.name}}
                            </option> 
                        </template>                         
                    </select>
                    <div class="text-red-500" v-if="errors.item">{{ errors.item }}</div>
                </div>
                <div class="mb-4 flex">
                    <input type="checkbox" id="checkbox" v-model="form.checked" />              
                    <BreezeLabel for="checkbox" value="Ważny bezterminowo" class="ml-2"/>  
                </div>
                <div class="mb-4" v-if="!form.checked">
                    <BreezeLabel for="dateField" value="Data ważności" />                
                    <input id="dateField" type="date" v-model="form.date" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                </div>
                <!-- <ul>
                    <li v-for="cathegory in cathegories" :key="cathegory">
                        {{cathegory.name}}
                        <span v-if="cathegory.subcathegories.length">posiada</span>
                    </li>
                </ul> -->

                <!-- <select v-model="cathegory">
                    <template v-for="row in cathegories" :key="row.id">
                        <option v-if="row.cathegory_id == null" :value="row.id">
                            {{row.name}}
                        </option> 
                    </template>                         
                </select><br> -->
<!-- <span v-if="cathegory.subcathegories.length">posiada</span> -->
                <!-- <select v-if="cathegory.subcathegories && cathegory.subcathegories.length" v-model="cathegory">
                    <template v-for="row in cathegories" :key="row.id">
                        <option v-if="row.cathegory_id == cathegory" :value="row.id">
                            {{row.name}}
                        </option> 
                    </template>                         
                </select><br> -->

                <!-- <select v-model="cathegory">
                    <template v-for="row in cathegories" :key="row.id">
                        <option v-if="row.cathegory_id == cathegory" :value="row.id">
                            {{row.name}}
                        </option> 
                    </template>                         
                </select><br> -->

                <!-- <br><span>Selected Cath: {{ cathegory }}</span><br> 
                
                <span>Selected Item: {{ form.item }}</span><br> -->
                
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
        Card,
        Table,
        Modal,
        FloatingButton
    },

    data() {
        return {
            editMode: false,
            isOpen: false,
            cathegory: null,
            form: {
                item: null,
                date: null,
                checked: true
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
                checked: true
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
            if (!confirm('Na pewno? Usuniesz również historię serwisów!')) return;
            this.$inertia.delete('/items/' + data.id)
            this.reset();
            this.closeModal();
        }
    }
}
</script>
