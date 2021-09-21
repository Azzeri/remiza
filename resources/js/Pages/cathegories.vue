<template>
    <BreezeAuthenticatedLayout>
    <Head title="Kategorie" />
        <Card>
            <Message>
                {{ $page.props.flash.message }}
            </Message>

            <FloatingButton v-show="$page.props.auth.user.privilege_id == $page.props.privileges.IS_GLOBAL_ADMIN" @openModal="openModal"></FloatingButton>

            <Table :data="data.data.length" :throws="throws" @edit="edit" @deleteRow="deleteRow" height="h-16" margin="mb-4">
                <tr v-for="row in data.data" :key="row.id" class="flex flex-col flex-no wrap sm:table-row mb-4 sm:mb-0 hover:bg-secondary-50 bg-tertiary justify-center text-text-200">
                    <td class="h-16 sm:h-auto border-primary-200 border p-1 flex justify-center cursor-pointer">
                        <img class="w-14 h-14 sm:w-20 sm:h-20" :src="row.photo_path" @click="openPhotoModal(row)">
                    </td>
                    <td class="h-16 sm:h-auto border-primary-200 border p-3">{{ row.name }}</td>
                    <td v-if="row.subcathegories.length" class="h-16 sm:h-auto border-primary-200 border p-3">                       
                        <span v-for="subcat in row.subcathegories" :key="subcat.id">{{subcat.name}} <span class="text-red-700"> | </span></span>
                    </td>
                    <td v-else class="h-16 sm:h-auto border-primary-200 border p-3">Brak</td>
                    <td v-html="isTrue(row.fillable)" class="h-16 sm:h-auto border-primary-200 border p-3 text-center"></td>
                    <td class="h-16 sm:h-auto border-primary-200 border text-center p-3">
                        <i @click="edit(row)" class="far fa-edit fa-lg cursor-pointer" v-show="$page.props.auth.user.privilege_id == $page.props.privileges.IS_GLOBAL_ADMIN"></i>
                        <i @click="deleteRow(row)" class="far fa-trash-alt fa-lg text-red-700 ml-2 cursor-pointer" v-show="$page.props.auth.user.privilege_id == $page.props.privileges.IS_GLOBAL_ADMIN"></i>
                    </td>
                </tr>
            </Table>
            <pagination class="mt-6" :links="data.links" />
        </Card>
    
        <Modal :isOpen="isOpen" :editMode="editMode" :form="form" @save="save" @update="update" @closeModal="closeModal">
            <form @submit.prevent="save, update"> 
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="mb-4">
                        <BreezeLabel for="nameField" value="Nazwa" />
                        <BreezeInput id="nameField" type="text" class="mt-1 block w-full" v-model="form.name" placeholder="Wprowadź nazwę" />
                        <div class="text-red-500" v-if="errors.name">{{ errors.name }}</div>
                    </div>    
                    <div class="mb-4">
                        <BreezeLabel for="parentField" value="Kategoria nadrzędna" />
                        <select class="border-gray-300 w-full focus:border-primary-200 focus:ring focus:ring-primary-200 focus:ring-opacity-50 rounded-md shadow-sm" id="parentField" v-model="form.parent">
                            <option value="-1">Brak</option>                                   
                            <template v-for="row in data.data" :key="row.id">
                                <option v-if="row.name != form.name && form.id != row.cathegory_id" :value="row.id">
                                    {{row.name}}
                                </option> 
                            </template>                         
                        </select>
                    </div>
                    <div class="mb-4 flex">
                        <Checkbox id="fillableField" v-model="form.fillable" :checked="form.fillable == 1 ? true : false"></Checkbox>
                        <BreezeLabel for="fillableField" value="Napełnialna" class="ml-2"/>
                    </div>
                </div>
            </form>
        </Modal>
        <PhotoForm :cathegory="cathegory" v-if="isPhotoOpen" @closePhotoModal="closePhotoModal"></PhotoForm>
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import BreezeButton from '@/Components/Button.vue'
import BreezeInput from '@/Components/Input.vue'
import BreezeLabel from '@/Components/Label.vue'
import Checkbox from '@/Components/Checkbox.vue'
import { Head } from '@inertiajs/inertia-vue3';
import Card from "@/Components/Card.vue";
import Table from "@/Components/Table.vue";
import Modal from "@/Components/Modal.vue";
import FloatingButton from "@/Components/FloatingButton.vue";
import Pagination from "@/Components/Pagination.vue";
import Message from "@/Components/Message.vue";
import PhotoForm from "@/Components/PhotoForm.vue";

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
        Message,
        PhotoForm,
        Checkbox
    },

    data() {
        return {
            editMode: false,
            isOpen: false,
            isPhotoOpen: false,
            cathegory: this.data.data[0],
            form: {
                name: null,
                avatar: null,
                parent: -1,
                fillable: false
            },
            throws:['Zdjęcie','Nazwa','Podkategorie','Napełnialna','Działania'],
        }
    },

    methods: {
        isTrue(attr){
            return attr ? '<i class="fas fa-check fa-lg text-green-700"></i>': '<i class="fas fa-times fa-lg text-red-700"></i>'
        },
        openModal: function () {
            this.isOpen = true;
        },
        closeModal: function () {
            this.isOpen = false;
            this.reset();
            this.editMode=false;
        },
        openPhotoModal: function (cathegory) {
            this.cathegory = cathegory
            this.isPhotoOpen = true;
        },
        closePhotoModal: function () {
            this.isPhotoOpen = false;
        },
        reset: function () {
            this.form = {
                name: null,
                avatar: null,
                parent: -1,
                fillable: false
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
            // this.data.avatar = this.form.avatar;
            this.editMode = true;
            this.openModal();
        },
        update: function (data) {
            // data.photo_path = this.form.avatar;
            // data.avatar = this.form.avatar;
            console.log(data.avatar)
            this.$inertia.put('/cathegories/' + data.id, data, {
                onSuccess: () => this.closeModal()
            });     
        },
        deleteRow: function (data) {
            if (!confirm('Na pewno? Wszystkie przedmioty należące do kategorii również zostaną usunięte!')) return;
            this.$inertia.delete('/cathegories/' + data.id)
            this.reset();
            this.closeModal();
        },
    }
}
</script>
