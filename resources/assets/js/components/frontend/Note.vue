<template>
   <div>
      <div class="col-md-6 s2-first note" v-if="editMode">
         <input type="text" v-model="noteText">
         <a @click="saveNote()">
            <i class="fal fa-save"></i>
         </a>
      </div>
      <div class="col-md-6 s2-first note" v-else>
         <p>{{ noteText }}</p>
         <a @click.prevent="editMode = !editMode">
            <i class="fal fa-edit"></i>
         </a>
      </div>
   </div>
</template>

<script>
   export default {
      data() {
         return {
            editMode: false,
            noteText: 'Some note'
         };
      },
      mounted() {
         if(localStorage.getItem('note')) {
            this.noteText = localStorage.getItem('note');
         }
      },
      methods: {
         saveNote() {
            this.editMode = false;
            console.log(this.noteText);
            localStorage.setItem('note', this.noteText);

            // this.axios.post('http://localhost:8000/yourPostApi', {
            //    name: this.name,
            //    description: this.description
            // })
            // .then(function (response) {
            //    currentObj.output = response.data;
            // })
            // .catch(function (error) {
            //    currentObj.output = error;
            // });
         }
      }
   }
</script>

<style scoped>
   p {
      display: inline-block;
      margin-right: 10px;
   }
   i {
      font-size: 20px;
      width: 30px;
      color: #000;
   }
   input {
      padding: 5px 10px;
      border-radius: 3px;
      border: 1px solid #ccc;
      margin: 10px;
      font-size: 14px;
      font-weight: 100;
      min-width: 220px;
   }
</style>