<template>
  <div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400" v-if="isOpen">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>
        <div class="w-full inline-block align-bottom bg-white rounded-lg text-left overflow-hidden my-auto shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" >
            <slot></slot>

            <div class="bg-secondary-100 px-6 py-3 flex flex-row-reverse">
                <span class="flex rounded-md shadow-sm ml-3 w-auto">          
                    <BreezeButton v-show="!editMode" @click="save()">
                        Zapisz
                    </BreezeButton>
                </span>
                <span class="flex rounded-md shadow-sm ml-3 w-auto">                         
                    <BreezeButton  v-show="editMode" @click="update()">
                        Edytuj
                    </BreezeButton>
                </span>
                <span class="flex rounded-md shadow-sm mt-0 w-auto">
                    <BreezeButton  @click="closeModal()">
                        Zamknij
                    </BreezeButton>
                </span>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import BreezeButton from '@/Components/Button.vue'

export default {
    props:['isOpen', 'editMode', 'form'],

    methods:{
        save(){
            this.$emit('save', this.form)
        },
        update(){
            this.$emit('update', this.form)
        },
        closeModal(){
            this.$emit('close-modal')
        }
    },
    components: {
        BreezeButton,
    },
}
</script>

<style>

</style>