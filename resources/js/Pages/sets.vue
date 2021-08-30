<template>
  <Head title="Zestawy" />

  <BreezeAuthenticatedLayout>
  <FloatingButton @openModal="openModal"></FloatingButton>
    <SetsNav :sets="sets" v-if="set != null">
	  <i @click="edit()" class="far fa-edit fa-lg "></i>
	  <i @click="deleteRow()" class="far fa-trash-alt fa-lg text-red-700 ml-2"></i>
      <h1>{{set.name}}</h1>
      <hr>
      <ul>
        <li v-for="row in set.itemsdb" :key="row.id">
          {{row.database_items.name}}
          <Link :href="route('item.details', id=row.id)"><i class="far fa-eye fa-lg ml-2"></i></Link>
        </li>
      </ul>
    </SetsNav>
	<Modal :isOpen="isOpen" :editMode="editMode" :form="form" @save="save" @update="update" @closeModal="closeModal">
		<form @submit.prevent="save, update">
			<div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
				<div class="mb-4">
					<BreezeLabel for="nameField" value="Nazwa" />                
					<input id="nameField" type="text" v-model="form.name" class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
					<div class="text-red-500" v-if="errors.name">{{ errors.name }}</div>
				</div>
				<div class="flex justify-between">
					<div class="mb-4 w-full">
						<BreezeLabel for="itemsField" value="Przedmioty" />
						<select multiple class="border-gray-300 w-full focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" id="itemsField">
							<template v-for="row in items" :key="row.id">
								<option v-if="!idsInArr.includes(row.id)" @click="addToChosen(row)">
									{{row.database_items.name}}
								</option>
							</template>
						</select>
					</div>
					<div class="mb-4 w-full ml-3">
						<BreezeLabel for="chosenField" value="Wybrane" />
						<select multiple class="border-gray-300 w-full focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" id="chosenField">
							<template v-for="row in form.selected" :key="row.id">
								<option @click="removeFromChosen(row)">
									{{row.database_items.name}}
								</option>
							</template>
						</select>
					</div>					
				</div>
				<!-- {{form.selected[0]}}<br>{{items[0]}} -->
				<div class="text-red-500" v-if="errors.selected">{{ errors.selected }}</div>
			</div> 
		</form>
	</Modal>
  </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import BreezeButton from "@/Components/Button.vue";
import BreezeInput from "@/Components/Input.vue";
import BreezeLabel from "@/Components/Label.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Card from "@/Components/Card.vue";
import Table from "@/Components/Table.vue";
import Modal from "@/Components/Modal.vue";
import FloatingButton from "@/Components/FloatingButton.vue";
import SetsNav from "@/Components/SetsNav.vue";

export default {
	props: {
		sets: Object,
		set: Object,
		items: Object,
		errors: Object
	},

	components: {
		BreezeAuthenticatedLayout,
		Head,
		BreezeButton,
		BreezeInput,
		BreezeLabel,
		Link,
		Card,
		Table,
		Modal,
		FloatingButton,
		SetsNav
	},

	data() {
		return {
			editMode: false,
			isOpen: false,
			form: {
				name: null,
				selected: []
			},
			idsInArr: []
		}
	},
    computed: {

	},
    methods: {
		getIds() {
			for (let i of this.form.selected)
				this.idsInArr.push(i.id);
		},
		addToChosen(item) {
			this.form.selected.push(item)
			this.idsInArr.push(item.id)
		},
		removeFromChosen(item) {
			this.form.selected.splice(this.form.selected.indexOf(item),1)
			this.idsInArr.splice(this.idsInArr.indexOf(item.id),1)
		},
        openModal: function () {
            this.isOpen = true;
        },
        closeModal: function () {
            this.isOpen = false;
            this.reset();
            this.editMode=false;
			this.idsInArr = []
        },
        reset: function () {
            this.form = {
              name: null,
              selected: []
            }
        },
        save: function (data) {
            this.$inertia.post('/sets', data,{
                onSuccess: () => this.closeModal(),
            })
			// this.reset()
        },
        edit: function () {
            this.form.name = this.set.name
			this.form.selected = this.set.itemsdb
			this.getIds()
            this.editMode = true;
            this.openModal();
			
        },
        update: function () {console.log(this.form.selected)
            this.$inertia.put('/sets/' + this.set.id, this.form,{
                onSuccess: () => this.closeModal()
            });     
        },
        deleteRow: function () {
            if (!confirm('Na pewno?')) return;
            this.$inertia.delete('/sets/' + this.set.id)
            this.reset();
            this.closeModal();
        }
    }
};
</script>
