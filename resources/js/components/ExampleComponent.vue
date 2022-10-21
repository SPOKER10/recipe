<template>

    <div>
        <h4 class="text-center font-weight-bold text-light"><img src="/img/gas.png" width="200"/></h4>
        <div class="row">
          <div class="col-4">
            <div class="list-group" id="list-tab" role="tablist">
                <a class="btn btn-primary list-group-item list-group-item-action" @click="addRecipe()"><img src="https://i.imgur.com/r8NBYK4.png" width="16"/> Add Recipe </a>
                <hr>
                <a v-for="(r, index) in dataTable" :id="r.id" :href="'#IDE'+index" class="list-group-item list-group-item-action" data-bs-toggle="list" role="tab" aria-controls="list-home">{{ r.recipe }}</a>
            </div>
          </div>
          <div class="col-8">
            <div class="tab-content" id="nav-tabContent">
                <div v-for="(r, index) in dataTable" :id="'IDE'+index" class="tab-pane fade show" role="tabpanel" aria-labelledby="list-home-list">
                   <div class="alert bg-home text-light" role="alert">
                      <h3 class="alert-heading fw-bold">{{ r.recipe }}</h3>
                        <p>
                            <h5 class="fst-italic">Ingredients:</h5>
                            <p style="white-space: pre;">{{ r.ingredients }}</p>
                        </p>
                      <hr>
                      <p>
                        <h5 class="fst-italic">Directions:</h5>
                        <p style="white-space: pre;">{{ r.directions }}</p>
                      </p>

                      <button :disabled="loading" class="btn btn-danger" @click="deleteRecipe(r, index)"><img src="https://cdn-icons-png.flaticon.com/512/860/860829.png" width="16"/> </button>
                      <button :disabled="loading" type="button" class="btn btn-primary" @click="editRecipe(r, index)"><img src="https://cdn0.iconfinder.com/data/icons/glyphpack/45/edit-alt-512.png" width="16"/> </button>
                    </div>
                </div>
            </div>
          </div>
        </div>

        <!-- Edit Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Recipe</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form>
                  <div class="mb-3">
                    <label for="recipient-name" class="col-form-label">Recipe:</label>
                    <input v-model="recipeEditData.recipe" type="text" class="form-control" id="recipient-name"/>
                  </div>
                  <div class="mb-3">
                    <label for="recipient-ingredients" class="col-form-label">Ingredients:</label>
                    <textarea v-model="recipeEditData.ingredients" type="text" class="form-control" id="recipient-ingredients"></textarea>
                  </div>
                  <div class="mb-3">
                    <label for="recipient-directions" class="col-form-label">Directions:</label>
                    <textarea v-model="recipeEditData.directions" type="text" class="form-control" id="recipient-directions"></textarea>
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button :disabled="loading" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button :disabled="loading" type="button" class="btn btn-primary" @click="saveRecipe()">Save</button>
              </div>
            </div>
          </div>
        </div>
    </div>

</template>

<script>
    //import {mapGetters} from 'vuex'
    import axios from "axios";
        import { Modal } from 'bootstrap'


    export default {
        name: "Posts",
        props: ["recipes"],
        mounted() {
            //this.$store.dispatch('fetchPosts')
        },
        data(props) {
            return {
              dataTable: props.recipes,
              loading: false,
              recipeEditData: {},
              myModal: null
            }
        },
        methods: {
            deleteRecipe(recipe, index) {
                this.loading = true;
                axios.post("/deleteRecipe", { 'id': recipe.id })
                    .then((resp) => {
                        this.dataTable.splice(index, 1);
                        alert('Recipe `'+recipe.recipe+'` it was successfully deleted!');
                        this.loading = false;
                });
            },
            editRecipe(recipe, index) {
                this.recipeEditData = recipe;
                this.myModal = new Modal(document.getElementById('editModal'), {});
                this.myModal.show();
            },
            addRecipe(recipe, index) {
                this.recipeEditData = {};
                this.myModal = new Modal(document.getElementById('editModal'), {});
                this.myModal.show();
            },
            saveRecipe() {
                this.loading = true;
                axios.post("/postRecipe", { 'dataPost': this.recipeEditData })
                    .then((resp) => {
                        if(!this.recipeEditData.id) {
                            this.recipeEditData.id = resp.id;
                            this.dataTable.push(this.recipeEditData);
                        }
                        this.myModal.hide();

                        alert('Recipe `'+this.recipeEditData.recipe+'` it was successfully '+(this.recipeEditData.id ? 'edited' : 'saved')+'!');
                        this.loading = false;
                });
            },
        },
        computed: {
            /*...mapGetters([
                'recipes'
            ])*/
        }
    }
</script>

<style scoped>

</style>