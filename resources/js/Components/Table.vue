<template>
    <table class="w-full flex flex-row flex-no-wrap rounded-lg overflow-hidden mt-4 sm:shadow-lg">
        <thead class="">
            <tr :class="margin" class="flex flex-col flex-no-wrap sm:table-row bg-primary-200 rounded-l-lg sm:rounded-none sm:mb-0 text-tertiary" v-for="r in data" :key="r">
                <th v-for="row in throws" :key="row" :class="height" class="p-3 text-left sm:h-auto">{{row}}</th>
            </tr>
        </thead>
        <tbody class="flex-1 sm:flex-none">
            <slot>
            </slot>
        </tbody>
    </table>
</template>

<script>
export default {
    props:{
        data:Number,
        throws:Array,
        height:String,
        margin:String
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