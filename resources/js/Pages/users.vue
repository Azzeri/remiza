<template>
    <Head title="Użytkownicy" />

    <BreezeAuthenticatedLayout>
        <Card>
            <Message>
                {{ $page.props.flash.message }}
            </Message>

            <FloatingButton v-if="units.length" @openModal="openModal"></FloatingButton>

            <Table :data="data.data.length" :throws="throws" @edit="edit" @deleteRow="deleteRow" height="h-10" margin="mb-4">
                <tr v-for="row in data.data" :key="row" class="flex flex-col flex-no wrap sm:table-row mb-4 sm:mb-0 hover:bg-secondary-50 bg-tertiary justify-center text-text-200">
                    <td class="h-10 sm:h-auto border-primary-200 border p-3 overflow-auto"> {{row.name}}</td>
                    <td class="h-10 sm:h-auto border-primary-200 border p-3 overflow-auto"> {{row.surname}}</td>
                    <td class="h-10 sm:h-auto border-primary-200 border p-3 overflow-auto"> {{row.email}}</td>
                    <td v-if="row.phone" class="h-10 sm:h-auto border-primary-200 border  p-3 overflow-auto"> {{row.phone}}</td>
                    <td v-else class="h-10 sm:h-auto border-primary-200 border  p-3 overflow-auto"> Brak danych</td>
                    <td class="h-10 sm:h-auto border-primary-200 border  p-3 overflow-auto"> {{row.privilege.name}}</td>
                    <td v-if="row.fire_brigade_unit" class="h-10 sm:h-auto border-primary-200 border  p-3 overflow-auto"> {{row.fire_brigade_unit.name}}</td>
                    <td v-else class="h-10 sm:h-auto border-primary-200 border  p-3 overflow-auto"> - </td>
                    <td class="h-10 sm:h-auto border-primary-200 border text-center p-3">
                        <i @click="edit(row)" class="far fa-edit fa-lg cursor-pointer"></i>
                        <i v-if="row.privilege_id == 3" @click="deleteRow(row)" class="cursor-pointer far fa-trash-alt fa-lg text-red-700 ml-2"></i>
                        <Link :href="'loginhistory/'+row.id"><i class="far fa-eye fa-lg ml-2"></i></Link>
                    </td>
                </tr>
            </Table>
            <pagination class="mt-6 mx-auto" :links="data.links" />
        </Card>
    </BreezeAuthenticatedLayout>

    <Modal :isOpen="isOpen" :editMode="editMode" :form="form" @save="save" @update="update" @closeModal="closeModal">
        <form @submit.prevent="save, update">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="mb-4">
                    <BreezeLabel for="nameField" value="Imię" />
                    <BreezeInput id="nameField" type="text" class="mt-1 block w-full" v-model="form.name" placeholder="Wprowadź imię" />
                    <div class="text-red-500" v-if="errors.name">{{ errors.name }}</div>
                </div>
                <div class="mb-4">
                    <BreezeLabel for="surnameField" value="Nazwisko" />
                    <BreezeInput id="surnameField" type="text" class="mt-1 block w-full" v-model="form.surname" placeholder="Wprowadź nazwisko"  />
                    <div class="text-red-500" v-if="errors.surname">{{ errors.surname }}</div>
                </div>
                <div class="mb-4">
                    <BreezeLabel for="emailField" value="Email" />
                    <BreezeInput id="emailField" type="email" class="mt-1 block w-full" v-model="form.email" placeholder="Wprowadź email"/>
                    <div class="text-red-500" v-if="errors.email">{{ errors.email }}</div>
                </div>
                <div class="mb-4">
                    <BreezeLabel for="phoneField" value="Nr telefonu" />
                    <BreezeInput id="phoneField" type="text" class="mt-1 block w-full" v-model="form.phone" placeholder="Wprowadź nr telefonu" />
                    <div class="text-red-500" v-if="errors.phone">{{ errors.phone }}</div>
                </div> 

                <div class="mb-4">
                    <BreezeLabel for="permField" value="Permission" />
                    <BreezeInput id="permField" type="text" class="mt-1 block w-full" v-model="form.phone" placeholder="xxxxxx" />
                    <div class="text-red-500" v-if="errors.phone">{{ errors.phone }}</div>
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
                <span v-if="editMode && $page.props.auth.user.id == form.id" class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                    <Link :href="route('password.change')">
                        <BreezeButton>
                            Zmień hasło
                        </BreezeButton>
                    </Link>
                </span>                                                            
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
import Message from "@/Components/Message.vue";
import Table from "@/Components/Table.vue";
import Modal from "@/Components/Modal.vue";
import FloatingButton from "@/Components/FloatingButton.vue";
import Pagination from "@/Components/Pagination.vue";

export default {
    props: {
        data: Object,
        errors: Object,
        units: Object
    },
    components: {
        BreezeAuthenticatedLayout,
        Head,
        Link,
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
                surname: null,
                email: null,
                phone: null,
                unit: this.defaultUnit
            },
            throws:['Imię','Nazwisko','Email','Telefon','Rola','Remiza','Działania'],
        }
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
                surname: null,
                email: null,
                phone: null,
                unit: this.defaultUnit
            }
        },
        save: function (data) {
            this.$inertia.post('/users', data,{
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
            this.$inertia.put('/users/' + data.id, data,{
                onSuccess: () => this.closeModal()
            });  
        },
        deleteRow: function (data) {
            if (!confirm('Na pewno?')) return;
            this.$inertia.delete('/users/' + data.id)
            this.reset();
            this.closeModal();
        }
    }
}
</script>