<template>
    <table class="w-full flex flex-row flex-no-wrap rounded-lg overflow-hidden mt-4 sm:shadow-lg">
        <thead class="">
            <tr class="flex flex-col flex-no wrap sm:table-row bg-gray-800 rounded-l-lg sm:rounded-none mb-2 sm:mb-0 text-white" v-for="r in data" :key="r">
                <th v-for="row in throws" :key="row" class="p-3 text-left">{{row}}</th>
            </tr>
        </thead>
        <tbody class="flex-1 sm:flex-none">
            <tr class="flex flex-col flex-no wrap sm:table-row mb-3 sm:mb-0 hover:bg-gray-100" v-for="row in data" :key="row">
                <td v-for="heading in tdrows" :key="heading" class="border-grey-light border  p-3">
                    <template v-if="row[heading[0]] != null">
                        <template v-if="heading.length == 1">
                            {{row[heading[0]]}}
                        </template>
                        <template v-else-if="heading.length == 2">
                            {{row[heading[0]][heading[1]]}}
                        </template>
                        <template v-else-if="heading.length == 3">
                            {{row[heading[0]][heading[1]][heading[2]]}}
                        </template>
                        <template v-else-if="heading.length == 4">
                            {{row[heading[0]][heading[1][heading[2]][heading[3]]]}}
                        </template>
                    </template>
                    <template v-else>
                        Brak danych
                    </template>
                </td>
                <td class="border-grey-light border text-center p-3">
                    <i @click="edit(row)" class="far fa-edit fa-lg "></i>
                    <i @click="deleteRow(row)" class="far fa-trash-alt fa-lg text-red-700 ml-2"></i>
                </td>
            </tr>
        </tbody>
    </table>
        <!-- <table class="w-full flex flex-row flex-no-wrap sm:bg-white rounded-lg overflow-hidden sm:shadow-lg my-5">
        <thead class="text-white">
            <tr class="bg-red-400 flex flex-col flex-no wrap sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0" v-for="r in data" :key="r">
                <th v-for="row in throws" :key="row" class="p-3 text-left">{{row}}</th>
            </tr>
        </thead>
        <tbody class="flex-1 sm:flex-none">
            <tr class="flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0" v-for="row in data" :key="row">
                <td v-for="heading in tdrows" :key="heading" class="border-grey-light border hover:bg-gray-100 p-3">
                    <template v-if="heading.length == 1">
                        {{row[heading[0]]}}
                    </template>
                    <template v-else-if="heading.length == 2">
                        {{row[heading[0]][heading[1]]}}
                    </template>
                    <template v-else-if="heading.length == 3">
                        {{row[heading[0]][heading[1]][heading[2]]}}
                    </template>
                    <template v-else-if="heading.length == 4">
                        {{row[heading[0]][heading[1][heading[2]][heading[3]]]}}
                    </template>
                </td>
                <td class="border-grey-light border text-center p-3">
                    <i @click="edit(row)" class="far fa-edit fa-lg "></i>
                    <i @click="deleteRow(row)" class="far fa-trash-alt fa-lg text-red-700 ml-2"></i>
                </td>
            </tr>
        </tbody>
    </table> -->
</template>

<script>
export default {
    props:{
        data:Object,
        tdrows:Array,
        throws:Array
    },
    methods:{
        edit(row){
            this.$emit('edit', row)
        },
        deleteRow(row){
            this.$emit('delete-row', row)
        }
    }
};
</script>

<style>
  @media (min-width: 640px) {
    table {
      display: inline-table !important;
    }

    thead tr:not(:first-child) {
      display: none;
    }
  }
    td:not(:last-child) {
    border-bottom: 0;
  }

  th:not(:last-child) {
    border-bottom: 2px solid rgba(0, 0, 0, .1);
  }
</style>