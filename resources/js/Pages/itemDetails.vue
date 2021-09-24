<template>
    <Head title="Przedmiot" />

    <BreezeAuthenticatedLayout>
		<Card>		
			<div v-if="!item.activated">
				<div class="mt-4">
					<div class="text-center text-tertiary font-bold text-lg mb-4 sm:text-left">
						<h3>Aktywacja</h3>
					</div>
					<p class="text-tertiary">
						Podaj datę ostatniego wykonania każdego z poniższych serwisów. Jeżeli nie znasz dokładnej daty, podaj inną, od 
						której system powinien obliczyć datę następnego serwisu. Przycisk "Data produkcji" obliczy datę kolejnego serwisu
						od daty produkcji przedmiotu.
					</p>
					<form @submit.prevent="activateService()">
						<div v-for="(service, index) in dbservices" :key="service.id" class="mt-4 md:w-1/3" >
							<BreezeLabel class="text-tertiary font-bold" for="itemField" :value="service.name+' (co '+service.days_to_next+' dni)'" />
							<div class="flex gap-4">
								<input type="date" :max="currentDate()" v-model="dates[index]" class="border-gray-300 w-full focus:border-primary-200 focus:ring focus:ring-primary-200 focus:ring-opacity-50 rounded-md shadow-sm">
								<span class="cursor-pointer w-2/3 inline-flex items-center px-4 py-2 bg-primary-200 border border-transparent rounded-md font-semibold text-xs text-tertiary uppercase tracking-widest hover:bg-primary-100 active:bg-primary-200 focus:outline-none focus:border-primary-200 focus:shadow-outline-red transition ease-in-out duration-150" v-if="item.date_production" @click="dates[index] = item.date_production">DATA PRODUKCJI</span>
							</div>
						</div>
						
						<div class="flex mt-4 gap-2 justify-center sm:justify-start">
							<BreezeButton type="submit">
								Aktywuj
							</BreezeButton>
						</div>
					</form>
				</div>
			</div>

			<div v-else class="flex flex-col">
				<div class="text-left text-tertiary font-bold text-xl mb-4 flex justify-between">
					<h1>Szczegóły sprzętu</h1>
					<Link :href="'history/'+item.id+'/'+0" class="">
						<i class="fas fa-history fa-lg cursor-pointer hover:text-primary-200 transition duration-300 ease-in-out"></i>
					</Link>
				</div>
				<div class="flex w-full bg-primary-200 mb-4 justify-evenly p-3 rounded-lg flex-wrap">
					<button class="w-1/3 text-tertiary font-semibold rounded p-1 px-3 hover:bg-tertiary hover:text-text-200 transition duration-300 ease-in-out" @click="tabSwitch = 0">Serwisy</button>
					<button class="w-1/3 text-tertiary font-semibold rounded p-1 px-3 hover:bg-tertiary hover:text-text-200 transition duration-300 ease-in-out" @click="tabSwitch = 1">Użycia</button>
					<button v-if="cathegory.fillable" class="w-1/3 text-tertiary font-semibold rounded p-1 px-3 hover:bg-tertiary hover:text-text-200 transition duration-300 ease-in-out" @click="tabSwitch = 2">Napełnienia</button>
				</div>
				<div v-if="tabSwitch == 0" class="p-6 text-text-200 bg-tertiary rounded-lg shadow-lg">
					<div class="text-left text-secondary-200 font-bold text-xl mb-4">
						<h1>Serwisy</h1>
					</div>
					<div v-for="service in services" :key="service.id">
						<template v-if="service.is_performed == 0">
							<div class="font-semibold mb-8">
								<div class="text-lg">{{service.service_database.name}}</div>
								<div class="text-red-600" v-if="service.perform_date < currentDate()">{{service.perform_date}}</div>
								<div class="text-green-600" v-else-if="service.perform_date == currentDate()">{{service.perform_date}}</div>
								<div v-else>{{service.perform_date}}</div>
								<form>
									<input type="hidden" v-model="form.id">
									<div class="mb-4">
										<BreezeInput id="descField" type="textarea" class="mt-3 p-5 block w-full" v-model="form.desc" placeholder="Wprowadź opis (opcjonalnie)"/>
										<div class="text-red-500" v-if="errors.desc">{{ errors.desc }}</div>
									</div>    
									<BreezeButton class="mb-2" @click="save(form, service.id, service.perform_date)">
										Potwierdź wykonanie
									</BreezeButton>
								</form>
							</div>
						</template>
					</div>
				</div>
				<div v-if="tabSwitch == 1" class="p-6 md:mt-0 bg-tertiary rounded-lg shadow-lg">
					<Message>
						{{ $page.props.flash.message }}
					</Message>
					<div class="text-left text-secondary-200 font-bold text-xl mb-4">
						<h1>Wprowadź użycie</h1>
					</div>
					<form class="mt-4" @submit.prevent="insertUsage(formUsage)">					 
						<div class="mb-4">
							<BreezeLabel for="usageDateStart" value="Rozpoczęcie użycia" />
							<div class="flex">
								<BreezeInput id="usageDateStart" type="date" class="mt-1 block w-2/3" v-model="formUsage.Udate_start" :max="currentDate()"/>	
								<BreezeInput type="time" class="w-1/3" v-model="formUsage.Utime_start"></BreezeInput>
							</div>
							<div class="text-red-500" v-if="errors.Udate_start">{{ errors.Udate_start }}</div>
							<div class="text-red-500" v-if="errors.Utime_start">{{ errors.Utime_start }}</div>
						</div> 
						<div class="mb-4">
							<BreezeLabel for="usageDateEnd" value="Zakończenie użycia" />
							<div class="flex">
								<BreezeInput id="usageDateEnd" type="date" class="mt-1 block w-2/3" v-model="formUsage.Udate_end" :max="currentDate()"/>	
								<BreezeInput type="time" class="w-1/3" v-model="formUsage.Utime_end"></BreezeInput>
							</div>
							<div class="text-red-500" v-if="errors.Udate_end">{{ errors.Udate_end }}</div>
							<div class="text-red-500" v-if="errors.Utime_end">{{ errors.Utime_end }}</div>
						</div>  
						<div class="mb-4">
							<BreezeLabel for="usageDescField" value="Opis" />
							<BreezeInput id="usageDescField" type="textarea" class="p-6 block w-full" v-model="formUsage.description" placeholder="Wprowadź opis (opcjonalnie)"/>
							<div class="text-red-500" v-if="errors.description">{{ errors.description }}</div>
						</div>  
						<BreezeButton class="w-full mt-4 justify-center" @click="insertUsage">
							Zapisz użycie
						</BreezeButton>
					</form>
				</div>
				<div v-if="tabSwitch == 2" class="p-6 text-text-200 bg-tertiary rounded-lg shadow-lg">
					<Message>
						{{ $page.props.flash.message }}
					</Message>
					<div class="text-left text-secondary-200 font-bold text-xl mb-4">
						<h1>Napełnienia</h1>
					</div>
					<div class="flex w-full bg-primary-200 mb-4 justify-evenly p-3 rounded-lg flex-wrap">
						<button class="w-1/2 text-tertiary font-semibold rounded px-3 hover:bg-tertiary hover:text-text-200 transition duration-300 ease-in-out" @click="switchType(true)">Stoper</button>
						<button class="w-1/2 text-tertiary font-semibold rounded px-3 hover:bg-tertiary hover:text-text-200 transition duration-300 ease-in-out" @click="switchType(false)">Formularz</button>
					</div>
					<div v-if="!timer">
						<div class="mb-4">
							<BreezeLabel for="fillDateStart" value="Rozpoczęcie ładowania" />
							<div class="flex">
								<BreezeInput id="fillDateStart" type="date" class="mt-1 block w-2/3" v-model="formFill.date_start" :max="currentDate()"/>	
								<BreezeInput type="time" step="2" class="w-1/3" v-model="formFill.time_start"></BreezeInput>
							</div>							
							<div class="text-red-500" v-if="errors.date_start">{{ errors.date_start }}</div>
							<div class="text-red-500" v-if="errors.time_start">{{ errors.time_start }}</div>
						</div>

						<div class="mb-4">
							<BreezeLabel for="fillDateEnd" value="Zakończenie ładowania" />
							<div class="flex">
								<BreezeInput id="fillDateEnd" type="date" class="mt-1 block w-2/3" v-model="formFill.date_end" :max="currentDate()"/>	
								<BreezeInput type="time" step="2" class="w-1/3" v-model="formFill.time_end"></BreezeInput>
							</div>							
							<div class="text-red-500" v-if="errors.date_end">{{ errors.date_end }}</div>
							<div class="text-red-500" v-if="errors.time_end">{{ errors.time_end }}</div>
						</div>

						<BreezeButton class="w-full mt-4 justify-center" @click="storeFill()">
							Zapisz
						</BreezeButton>
					</div>
					<div v-else>
						<div class="text-center text-5xl font-bold text-text-200 mt-6">{{elapsedTime/1000 + 's'}}</div>
						<div class="flex justify-center gap-4 mt-6">
							<BreezeButton class="bg-green-600" @click="timerStart()">Start</BreezeButton>
							<BreezeButton @click="timerStop()">Stop</BreezeButton>
							<BreezeButton @click="timerReset()">Reset</BreezeButton>
						</div>
						<BreezeButton v-show="formFill.date_end" class="w-full mt-4 justify-center" @click="storeFill()">
							Zapisz
						</BreezeButton>
					</div>
				</div>
			</div>
		</Card>
		<div v-if="(item.date_expiry && item.date_expiry < currentDateFormatted()) || (item.date_legalisation_due && item.date_legalisation_due < currentDateFormatted())" id="modal" class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400" >
			<div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
				<div class="fixed inset-0 transition-opacity">
					<div class="absolute inset-0 bg-gray-500 opacity-75"></div>
				</div>
				<span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>
				<div class="w-full inline-block align-bottom bg-white rounded-lg text-left overflow-hidden my-auto shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" >
            		<div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
						<div class="bg-red-600 p-4 text-tertiary text-xl font-bold rounded-lg shadow-sm">
							Przedmiot przekroczył datę ważności i/lub legalizacji, nie powinny być na nim wykonywane żadne działania! Zalecane usunięcie przedmiotu!
						</div> 
					</div>
					
					<div class="bg-secondary-100 px-6 py-3 flex flex-row-reverse">
						<span class="flex rounded-md shadow-sm ml-3 w-auto">                         
							<Link :href="route('items.index')">
								<BreezeButton >
									Wróć
								</BreezeButton>
							</Link>
						</span>
						<span class="flex rounded-md shadow-sm mt-0 w-auto">
							<BreezeButton @click="closeModal()">
								Zostań
							</BreezeButton>
						</span>
					</div>
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
import { Head, Link} from "@inertiajs/inertia-vue3";
import Card from "@/Components/Card.vue";
import Message from "@/Components/Message.vue";

export default {
  props: {
    dbservices: Object,
    item: Object,
    services: Object,
    errors: Object,
	cathegory: Object
  },

  components: {
    BreezeAuthenticatedLayout,
    Head,
    BreezeButton,
    BreezeInput,
    BreezeLabel,
    Link,
    Card,
	Message
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
		  Udate_start: this.currentDateFormatted(),
		  Udate_end: this.currentDateFormatted(),
		  Utime_start: this.currentTimeFormatted(),
		  Utime_end: this.currentTimeFormatted()
	  },
	  formFill: {
		  item: this.item.id,
		  date_start: null,
		  date_end: null,
		  time_start: null,
		  time_end: null
	  },
      dates: [],
	  tabSwitch: 0,

	  timer: true,
	  elapsedTime: 0,
	  interval: 1000,
	  counter: null,
	  timerRunning: false,
	  freshStart: true
    };
  },
  methods: {
	appendLeadingZeroes(n){
		if(n <= 9){
			return "0" + n;
		}
		return n
	},
	timerStart(){
		if(!this.timerRunning){
			this.timerRunning = true
			
			if(this.freshStart){
				this.freshStart = false
				let now = new Date()
				this.formFill.date_start = now.getFullYear() +'-'+ this.appendLeadingZeroes(now.getMonth()+1) +'-'+ this.appendLeadingZeroes(now.getDate())
				this.formFill.time_start = this.appendLeadingZeroes(now.getHours()) +':'+ this.appendLeadingZeroes(now.getMinutes()) +':'+ this.appendLeadingZeroes(now.getSeconds())
			}

			this.counter = setInterval(() => {
				this.elapsedTime += this.interval;
			}, this.interval)
		}
		
	},
	timerStop(){
		clearInterval(this.counter)
		this.timerRunning = false
		if(this.formFill.date_start){
			let now = new Date()
			this.formFill.date_end = now.getFullYear() +'-'+ this.appendLeadingZeroes(now.getMonth()+1) +'-'+ this.appendLeadingZeroes(now.getDate())
			this.formFill.time_end = this.appendLeadingZeroes(now.getHours()) +':'+ this.appendLeadingZeroes(now.getMinutes()) +':'+ this.appendLeadingZeroes(now.getSeconds())
		}
	
	},
	timerReset(){
		this.timerStop()
		this.reset()
		this.elapsedTime = 0
		this.freshStart = true
	},
	setProductionDate(index){
		
	},
	switchType(bool){
		this.timer = bool
		this.reset()
	},
	currentDateFormatted: function(){
            let now = new Date()
		    return now.getFullYear() +'-'+ this.appendLeadingZeroes(now.getMonth()+1) +'-'+ this.appendLeadingZeroes(now.getDate())
	},
	currentTimeFormatted: function(){
            let now = new Date()
		    return this.appendLeadingZeroes(now.getHours()) +':'+ this.appendLeadingZeroes(now.getMinutes())
	},
	currentDate: function(){
		return new Date().toISOString().split('T')[0];
	},
	currentDateTime: function(){
		let today = new Date();
		today.setSeconds(0,0);
		return(today.toISOString().split('.')[0]);
	},
	closeModal(){
		document.getElementById('modal').setAttribute("hidden", true)
	},
    reset: function () {
      this.form = {
        desc: null,
      };
	  this.formUsage = {
		  id:this.item.id,
		  description: null,
		  Udate_start: this.currentDateFormatted(),
		  Udate_end: this.currentDateFormatted(),
		  Utime_start: this.currentTimeFormatted(),
		  Utime_end: this.currentTimeFormatted()
	  };

	  this.formFill = {
		  item: this.item.id,
		  date_start: null,
		  date_end: null,
		  time_start: null,
		  time_end: null
	  },
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
		if(this.dates.length == this.dbservices.length && !this.dates.includes(undefined)){
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
	insertUsage: function(data) {
		this.$inertia.post("/usages", data,{
			onSuccess: () => this.reset(),
		});
	},
	storeFill: function() {
		this.$inertia.post("/fills", this.formFill,{
			onSuccess: () => (this.reset(), this.timerStop(), this.elapsedTime = 0),
		});
	}
  },
};
</script>