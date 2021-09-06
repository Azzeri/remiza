<template>
    <Head title="Przedmiot" />

    <BreezeAuthenticatedLayout>
		<Card>
			<div v-if="$page.props.flash.message" class="mt-2 text-green-600 font-semibold">
				{{ $page.props.flash.message }}
			</div>
	  
			<div v-if="!item.activated">
				<div class="mt-4">
					<form @submit.prevent="activateService">
						<div class="mb-4" v-for="(service, index) in dbservices" :key="service.id">
							<BreezeLabel for="itemField" :value="'Kiedy ostatnio wykonano serwis: '+service.name" />
							<input type="date" :max="currentDate()" v-model="dates[index]" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
						</div>
						
						<div class="flex gap-2">
							<span class="flex w-full rounded-md shadow-sm sm:w-auto">          
								<BreezeButton @click="activateService()">
									Aktywuj
								</BreezeButton>
							</span>
						</div>
					</form>
				</div>
			</div>

			<div v-else class="flex flex-col md:flex-row md:justify-evenly">
				<div class="pl-6 overflow-hidden">
					<Link :href="'history/'+item.id" class="">
						<BreezeButton class="mb-2"> Historia </BreezeButton>
					</Link>
				</div>
				<div class="p-6 overflow-hidden">
					<h1 class="text-xl font-semibold text-red-700">Serwisy</h1>
					<ul>
						<li v-for="service in services" :key="service.id">
							<template v-if="service.is_performed == 0">
								<div class="border-b-2 mt-4">
									<div class="text-red-700" v-if="service.perform_date < currentDate()">Data: {{service.perform_date}}</div>
									<div class="text-yellow-700" v-else-if="service.perform_date == currentDate()">Data: {{service.perform_date}}</div>
									<div v-else>Data: {{service.perform_date}}</div>
									<div>Nazwa serwisu: {{service.service_database.name}}</div>
									<form >
										<input type="hidden" v-model="form.id">
										<div class="mb-4">
											<BreezeInput id="descField" type="textarea" class="mt-1 block w-full" v-model="form.desc" placeholder="Wprowadź opis"/>
											<div class="text-red-500" v-if="errors.desc">{{ errors.desc }}</div>
										</div>    
										<BreezeButton class="mb-2" @click="save(form, service.id, service.perform_date)">
											Potwierdź wykonanie
										</BreezeButton>
									</form>
								</div>
							</template>
						</li>
					</ul>
				</div>
				<div class="p-6 mt-6 md:mt-0 overflow-hidden">
					<h1 class="text-xl font-semibold text-red-700">Użycie</h1>
						<form class="mt-4" @submit.prevent="insertUsage">
							<div class="mb-4">
								<BreezeLabel for="usageDescField" value="Opis" />
								<BreezeInput id="usageDescField" type="textarea" class="mt-1 block w-full" v-model="formUsage.description" placeholder="Wprowadź opis"/>
								<div class="text-red-500" v-if="errors.description">{{ errors.description }}</div>
							</div>   
							<div class="mb-4">
								<BreezeLabel for="usageDateField" value="Rozpoczęcie użycia" />
								<BreezeInput id="usageDateField" type="datetime-local" :max="currentDateTime()" class="mt-1 block w-full" v-model="formUsage.start"/>								
								<div class="text-red-500" v-if="errors.start">{{ errors.start }}</div>
							</div> 
							<div class="mb-4">
								<BreezeLabel for="usageMinutesField" value="Zakończenie użycia" />
								<BreezeInput id="usageMinutesField" type="datetime-local" :max="currentDateTime()" class="mt-1 block w-full" v-model="formUsage.end"/>
								<div class="text-red-500" v-if="errors.end">{{ errors.end }}</div>
							</div>  
							<BreezeButton class="mb-2" @click="insertUsage()">
								Zapisz użycie
							</BreezeButton>
						</form>
				</div>
			</div>
		</Card>
	</BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import BreezeButton from "@/Components/Button.vue";
import BreezeInput from "@/Components/Input.vue";
import BreezeLabel from "@/Components/Label.vue";
import { Head, Link} from "@inertiajs/inertia-vue3";
import Card from "@/Components/Card.vue";

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
    Card,
  },

  data() {
    return {
      form: {
        desc: null,
        id: null,
      },
	  formUsage:{
		  id:this.item.id,
		  description: null,
		  start: '2021-08-25T11:39:00',
		  end: this.currentDateTime()
	  },
      dates: [],
    };
  },
  methods: {
	currentDate: function(){
		return new Date().toISOString().split('T')[0];
	},
	currentDateTime: function(){
		let today = new Date();
		today.setSeconds(0,0);
		return(today.toISOString().split('.')[0]);
	},
    reset: function () {
      this.form = {
        desc: null,
      };
	  this.formUsage = {
		  id:this.item.id,
		  description: null,
		  start: this.currentDateTime(),
		  end: this.currentDateTime()
	  };
      this.dates = [];
    },
    save: function (data, id, date) {
	   if ( date > this.currentDate())
		   if (!confirm('Do serwisu zostało jeszcze trochę czasu, na pewno zatwierdzić wykonanie serwisu teraz?')) return;
	   
	  this.form.id = id;
      this.$inertia.post("/services/finish", data);
      this.reset();
    },
    activateService: function () {
		if(this.dates.length == this.dbservices.length){
			let data = [];
			for (let i = 0; i < this.dbservices.length; i++) {
				let x = {
				id: this.dbservices[i].id,
				date: this.dates[i],
				};
				data.push(x);
			}
			this.$inertia.post("/services/activate/" + this.item.id, data)
			this.reset();
		}
    },
	insertUsage: function() {
		this.$inertia.post("/usages/insertNew/", this.formUsage,{
			onSuccess: () => this.reset(),
		});
	}
  },
};
</script>
