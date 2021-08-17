<template>
    <Head title="Użytkownicy" />

    <BreezeAuthenticatedLayout>
        <Card>
            <BreezeButton @click="openModal()">
                Nowy
            </BreezeButton>

            <div v-if="$page.props.flash.message" class="mt-2 font-xl text-green-600 font-semibold">
                {{ $page.props.flash.message }}
            </div>
            <Table :data="data" :tdrows="tdrows" :throws="throws" @edit="edit" @deleteRow="deleteRow"></Table>

            <!-- <Link :href="route('password.change')" class="underline text-sm text-gray-600 hover:text-gray-900">
                Zmiana hasła
            </Link> -->
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
                    <BreezeLabel for="phoneField" value="Phone" />
                    <BreezeInput id="phoneField" type="text" class="mt-1 block w-full" v-model="form.phone" placeholder="Wprowadź nr telefonu" />
                    <div class="text-red-500" v-if="errors.phone">{{ errors.phone }}</div>
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

export default {
    props: {
        data: Object,
        errors: Object,
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
        Modal
    },

    data() {
        return {
            editMode: false,
            isOpen: false,
            form: {
                name: null,
                surname: null,
                email: null,
                phone: null
            },
            throws:['Imię','Nazwisko','Email','Telefon','Rola','Remiza','Działania'],
            tdrows:[['name'],['surname'] ,['email'] ,['phone'] ,['privilege','name'] ,['fire_brigade_unit','name']],
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
                phone: null
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
            this.$inertia.delete('/users/' + data.id, data)
            this.reset();
            this.closeModal();
        }
    }
}
</script>
