<template>
    <Head title="Producenci" />

    <BreezeAuthenticatedLayout>
        <Card>
            <Message>
                {{ $page.props.flash.message }}
            </Message>

            <FloatingButton @openModal="openModal"></FloatingButton>

            <Table :data="data.data.length" :throws="throws" @edit="edit" @deleteRow="deleteRow" height="h-10" margin="mb-4">
                <tr v-for="row in data.data" :key="row.id" class="flex flex-col flex-no wrap sm:table-row mb-4 sm:mb-0 hover:bg-secondary-50 bg-tertiary justify-center text-text-200">
                    <td class="h-10 sm:h-auto border-primary-200 border p-3 overflow-auto">{{ row.name }}</td>
                    <td class="h-10 sm:h-auto border-primary-200 border p-3 text-center">
                        <i v-if="$page.props.auth.user.privilege_id == $page.props.privileges.IS_GLOBAL_ADMIN" @click="edit(row)" class="far fa-edit fa-lg cursor-pointer"></i>
                        <i v-if="$page.props.auth.user.privilege_id == $page.props.privileges.IS_GLOBAL_ADMIN" @click="deleteRow(row)" class="far fa-trash-alt fa-lg text-red-700 ml-2 cursor-pointer"></i>
                    </td>
                </tr>
            </Table>
            <!-- {{ $manufacturers -> links() }} -->
            <pagination class="mt-6" :links="data.links" />
        </Card>
    </BreezeAuthenticatedLayout>
    <Modal :isOpen="isOpen" :editMode="editMode" :form="form" @save="save" @update="update" @closeModal="closeModal">
        <form @submit.prevent="save, update"> 
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="mb-2 text-secondary-200 font-semibold">
                    Dodaj producenta
                </div>
                <div class="mb-4">
                    <BreezeLabel for="nameField" value="Nazwa" />
                    <BreezeInput id="nameField" type="text" class="mt-1 block w-full" v-model="form.name" placeholder="Wprowadź nazwę" />
                    <div class="text-red-500" v-if="errors.name">{{ errors.name }}</div>
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
import Pagination from "@/Components/Pagination.vue";
import Message from "@/Components/Message.vue";


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
            },
            throws:['Nazwa', 'Działania'],
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
            this.$inertia.post('/manufacturers', data,{
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
            this.$inertia.put('/manufacturers/' + data.id, data,{
                onSuccess: () => this.closeModal()
            });     
        },
        deleteRow: function (data) {
            if (!confirm('Na pewno? Usuniesz również wszytkie przedmioty producenta!')) return;
            this.$inertia.delete('/manufacturers/' + data.id)
            this.closeModal();
        }
    }
}

</script>
