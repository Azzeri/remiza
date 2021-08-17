<template>
    <Head title="Przedmiot" />

    <BreezeAuthenticatedLayout>
   <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
             <div v-if="$page.props.flash.message" class="mt-2 text-green-600 font-semibold">
                    {{ $page.props.flash.message }}
                </div>
            <!-- <div class="p-6 bg-white border-b border-gray-200 overflow-hidden shadow-sm sm:rounded-lg">
                <div>{{item.database_items.name}}</div>
                <ul>
                    <li v-for="service in dbservices" :key="service.id">{{service.name}}</li>
                </ul>
            </div> -->
            <div v-if="!item.activated">
                <BreezeButton @click="openModal()" class="mb-2">
                    Aktywuj
                </BreezeButton>
            </div>
            <div v-if="item.activated" class="flex justify-evenly">
                <div class="p-6 bg-white border-b border-gray-200 overflow-hidden shadow-sm sm:rounded-lg">
                    <h1 class="text-xl font-semibold text-green-600">Nadchodzące</h1>
                    <ul>
                        <li v-for="service in services" :key="service.id">
                            <template v-if="service.is_performed == 0">
                                <div class="border-b-2 mt-4">
                                    Data: {{service.perform_date}}<br>
                                    Nazwa serwisu: {{service.service_database.name}}<br>
                                    <form >
                                        <input type="hidden" v-model="form.id">
                                        <div class="mb-4">
                                            <BreezeInput id="descField" type="textarea" class="mt-1 block w-full" v-model="form.desc" placeholder="Wprowadź opis"/>
                                            <div class="text-red-500" v-if="errors.desc">{{ errors.desc }}</div>
                                        </div>    
                                        <BreezeButton class="mb-2" @click="save(form, service.id)">
                                            Potwierdź wykonanie
                                        </BreezeButton>
                                    </form>
                                </div>
                            </template>
                        </li>
                    </ul>
                </div>
                <div class="p-6 bg-white border-b border-gray-200 overflow-hidden shadow-sm sm:rounded-lg">
                    <h1 class="text-xl font-semibold">Historia</h1>
                    <ul>
                        <li v-for="service in services" :key="service.id">
                            <template v-if="service.is_performed == 1">
                                <div class="border-b-2 mt-4">
                                <!-- Id: {{service.id}}<br> -->
                                Nazwa serwisu: {{service.service_database.name}}<br>                               
                                Opis: {{service.description}}<br>
                                Data: {{service.perform_date}}<br>
                                <!-- Zakończono: {{service.is_performed}}<br> -->
                                Wykonawca: {{service.user.name}} {{service.user.surname}}<br>
                                </div>
                            </template>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
     </div> 

            <div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400" v-if="isOpen">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

                <div class="fixed inset-0 transition-opacity">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" >
                   <form @submit.prevent="activate">
                       <div v-for="(service, index) in dbservices" :key="service.id">
                            <input type="date" v-model="dates[index]">
                       </div>
                        

                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">          
                            <BreezeButton @click="activate()">
                                Zapisz
                            </BreezeButton>
                        </span>
                        <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                            <BreezeButton  @click="closeModal()">
                                Zamknij
                            </BreezeButton>
                        </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import BreezeButton from "@/Components/Button.vue";
import BreezeInput from "@/Components/Input.vue";
import BreezeLabel from "@/Components/Label.vue";
import { Head } from "@inertiajs/inertia-vue3";
import { Link } from "@inertiajs/inertia-vue3";

export default {
  props: {
    dbservices: Object,
    item: Object,
    services: Object,
    errors: Object,
  },

  components: {
    BreezeAuthenticatedLayout,
    Head,
    BreezeButton,
    BreezeInput,
    BreezeLabel,
    Link,
  },

  data() {
    return {
      isOpen: false,
      form: {
        desc: null,
        id: null,
      },
      dates: ["2021-01-01", "2021-01-01"],
    };
  },
  methods: {
    openModal: function () {
      this.isOpen = true;
    },
    closeModal: function () {
      this.isOpen = false;
    },
    reset: function () {
      this.form = {
        desc: null,
      };
      this.dates = ["2021-01-01", "2021-01-01"];
    },
    save: function (data, id) {
      this.form.id = id;
      this.$inertia.post("/services/finish", data);
      this.reset();
    },
    activate: function () {
      let data = [];
      for (let i = 0; i < this.dbservices.length; i++) {
        let x = {
          id: this.dbservices[i].id,
          date: this.dates[i],
        };
        data.push(x);
      }
      this.$inertia.post("/services/activate/" + this.item.id, data, {
        onSuccess: () => this.closeModal(),
      });
      this.reset();
    },
  },
};
</script>
