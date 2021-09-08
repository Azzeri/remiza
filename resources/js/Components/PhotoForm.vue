<template>
    <div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>
        <div class="w-full inline-block align-bottom bg-white rounded-lg text-left overflow-hidden my-auto shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" >
            <div class="p-4 flex flex-col">
                <div class="mx-auto">
                    <div class="text-text-200 font-bold text-lg mb-3 text-center">
					    <h3>Zdjęcie</h3>
				    </div>
                    <img :src="src" alt="img" class="w-24 h-24">
                </div>
                <div class="flex justify-center">
                    <form @submit.prevent="submit" class="hidden">
                        <input type="file" ref="file" accept="image/*" @input="photoForm.avatar = $event.target.files[0]" @change="change"/>
                        <!-- <progress v-if="photoForm.progress" :value="photoForm.progress.percentage" max="100">
                            {{ photoForm.progress.percentage }}%
                        </progress> -->
                    </form>
                    <BreezeButton class="mt-2" @click="browse()"> {{ buttonString }} </BreezeButton>
                    <BreezeButton v-if="this.cathegory.photo_path != '/images/default.png'" @click="deleteAvatar()" class="mt-2 ml-2"> Usuń</BreezeButton>
                </div>
            </div>
            <div class="bg-secondary-100 px-6 py-3 flex flex-row-reverse">
                <span class="flex rounded-md shadow-sm ml-3 w-auto">          
                    <BreezeButton @click="submit()">
                        Zapisz
                    </BreezeButton>
                </span>
                <span class="flex rounded-md shadow-sm mt-0 w-auto">
                    <BreezeButton  @click="closePhotoModal()">
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
    props:['cathegory'],

    components: {
        BreezeButton,
    },
    // created: function(){
    //     console.log(this.cathegory.id)
    //     this.src = this.cathegory.photo_path
    // },
    data(){
        return {
            src:this.cathegory.photo_path,
            photoForm :{
                avatar: null,
            },
        }
    },

    computed: {
        buttonString(){
            return this.cathegory.photo_path == '/images/default.png' ? 'Dodaj' : 'Zmień'
        }
    },

    methods:{
        browse(){
            this.$refs.file.click();
        },
        submit() {
            this.$inertia.post("cathegories/insertPhoto/"+this.cathegory.id, this.photoForm, {
                onSuccess: () => this.closePhotoModal()
            });
        },
        closePhotoModal(){
            this.src = this.cathegory.photo_path
            this.$emit('close-photo-modal')
        },
        change(e){
            let reader = new FileReader();
            reader.readAsDataURL(e.target.files[0]);
            reader.onload = (e) => {
                this.src = e.target.result;
            }
        },
        deleteAvatar: function(){
            if (!confirm('Na pewno?')) return;
            this.$inertia.post('cathegories/deletePhoto/' + this.cathegory.id)
            this.closePhotoModal();
        }
    },


    // setup(props, context) {
    //     const photoForm = useForm({
    //         avatar: null,
    //     });
    //     let src = props.cathegory.photo_path;

    //     function submit() {
    //         photoForm.post("cathegories/insertPhoto/"+props.cathegory.id, photoForm, {
    //             onSuccess: () => closePhotoModal()
    //         });
    //     }

    //     function closePhotoModal(){
    //         src = props.cathegory.photo_path
    //         photoForm.clearErrors()
    //         context.emit('close-photo-modal')
    //     }

    //     function change(e){
    //         let reader = new FileReader();
    //         reader.readAsDataURL(e.target.files[0]);
    //         reader.onload = (e) => {
    //             src = e.target.result;
    //         }
    //     }

    //     return { photoForm, submit, src, closePhotoModal, change };
    // },

};
</script>
