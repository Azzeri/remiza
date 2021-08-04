<template>
    <Head title="Uzytkownicy" />

    <BreezeAuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                     <table class="table-fixed w-full">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2">Imie</th>
                                <th class="px-4 py-2">Nazwisko</th>
                                <th class="px-4 py-2">Uprawnienie</th>
                                <th class="px-4 py-2">Remiza</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="row in users" :key="row.id">
                                <td class="border px-4 py-2">{{ row.name }}</td>
                                <td class="border px-4 py-2">{{ row.surname }}</td>
                                <td class="border px-4 py-2">{{ row.privilege.name }}</td>
                                <td class="border px-4 py-2">{{ row.fire_brigade_unit.name }}</td>
                                <!-- <td class="border px-4 py-2">
                                    <button @click="edit(row)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</button>
                                    <button @click="deleteRow(row)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
                                </td> -->
                            </tr>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import { Head } from '@inertiajs/inertia-vue3';

export default {
    props: ['users',],
    created(){
        console.log(this.users);
    },
    components: {
        BreezeAuthenticatedLayout,
        Head,
    },
}
</script>
