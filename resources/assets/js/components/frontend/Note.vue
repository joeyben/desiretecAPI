<template>
   <div class="col-md-6 wish-note" >
      <div class="edit-mode" v-if="editMode">
         <input type="text" placeolder="Note..." @keyup.enter="saveNote" v-model="note">
         <a @click="saveNote">
            <i class="fal fa-save"></i>
         </a>
      </div>
      <div class="not-edit-mode" v-else>
         <p>{{ this.note }}</p>
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
            note: ''
         };
      },

      props: ['wishid', 'wishnote'],

      mounted() {
         this.note = this.wishnote;

         if (this.note == '') {
            this.editMode = true;
         }
      },

      methods: {
         saveNote() {
            this.editMode = false;

            axios.post('/wishes/updateNote', {
               id: this.wishid,
               note: this.note
            }).then(function (response) {
            })
            .catch(function (error) {
               console.log(error);
            });
         }
      }
   }
</script>

<style scoped>
   .wish-note {
      display: flex;
      justify-content: flex-end
   }
   p {
      display: inline-block;
      margin-right: 15px;
      margin-bottom: 0;
   }
   i {
      font-size: 20px;
      width: 30px;
      color: #000;
   }
   input {
      padding: 3px 15px;
      border-radius: 3px;
      border: 1px solid #ccc;
      margin-right: 10px;
      font-size: 14px;
      font-weight: 100;
      min-width: 220px;
   }
   input::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
    color: #dedede !important;
    opacity: 1; /* Firefox */
  }
</style>