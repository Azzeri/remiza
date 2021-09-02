<template>
    <BreezeAuthenticatedLayout>
    <Head title="Kategorie" />
        <Card>
            <FloatingButton @openModal="openModal"></FloatingButton>

            <div v-if="$page.props.flash.message" class="mt-2 font-xl text-green-600 font-semibold">
                {{ $page.props.flash.message }}
            </div>

            <Table :data="data.length" :throws="throws" @edit="edit" @deleteRow="deleteRow" height="h-16" margin="mb-4">
                <tr v-for="row in data" :key="row.id" class="flex flex-col flex-no wrap sm:table-row mb-4 sm:mb-0 hover:bg-gray-100">
                    <td class="h-16 sm:h-auto border-grey-light border p-1 flex justify-center"><img class="w-14 h-14 sm:w-20 sm:h-20" :src="row.photo_path"></td>
                    <td class="h-16 sm:h-auto border-grey-light border p-3">{{ row.name }}</td>
                    <td v-if="row.subcathegories.length" class="h-16 sm:h-auto border-grey-light border p-3">                       
                        <span v-for="subcat in row.subcathegories" :key="subcat.id">{{subcat.name}} <span class="text-red-700"> | </span></span>
                    </td>
                    <td v-else class="h-16 sm:h-auto border-grey-light border p-3">Brak</td>
                    <td class="h-16 sm:h-auto border-grey-light border text-center p-3">
                        <i @click="edit(row)" class="far fa-edit fa-lg "></i>
                        <i @click="deleteRow(row)" class="far fa-trash-alt fa-lg text-red-700 ml-2"></i>
                    </td>
                </tr>
            </Table>
            <!-- <pagination class="mt-6" :links="data.links" /> -->
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
                    <select class="border-gray-300 focus:border-indigo-300 w-full focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" id="parentField" v-model="form.parent">
                        <option value="-1">Brak</option>                                   
                        <template v-for="row in data" :key="row.id">
                            <option v-if="row.name != form.name && form.id != row.cathegory_id" :value="row.id">
                                {{row.name}}
                            </option> 
                        </template>                         
                    </select>
                    <!-- <span>Selected: {{ form.parent }}</span> -->
                </div>
                <BreezeButton v-if="editMode" @click="deleteAvatar(form.id)" class="mb-2"> Usuń zdjęcie </BreezeButton>

                <BreezeLabel for="avatarField" value="Zdjęcie" />
                <input class="bg-white" id="avatarField" type="file" @input="form.avatar = $event.target.files[0]" />
                <!-- <input v-if="!editMode" type="file" @input="form.avatar = $event.target.files[0]" /> -->
                <!-- <input v-else type="file" @input="form.avatar" /> -->
                <div class="text-red-500" v-if="errors.avatar">{{ errors.avatar }}</div>
                <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                {{ form.progress.percentage }}%
                </progress>  
            </div>
        </form>
    </Modal>
    </BreezeAuthenticatedLayout>
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
        Pagination
    },

    data() {
        return {
            editMode: false,
            isOpen: false,
            form: {
                name: null,
                avatar: null,
                parent: -1
            },
            throws:['Zdjęcie','Nazwa','Podkategorie','Działania'],
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
                avatar: null,
                parent: -1
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
        deleteAvatar: function(data){
            if (!confirm('Na pewno?')) return;
            this.$inertia.post('cathegories/deletePhoto/' + data)
            this.reset();
            this.closeModal();
        }
    }
}
</script>
