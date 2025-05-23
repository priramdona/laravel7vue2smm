<template>
    <div class="container">
        <div class="row mt-5">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Product List</h3>

                <div class="card-tools">
                  <button class="btn btn-success" data-toggle="modal" data-target="#modalAdd">
                    Add New <i class="fa fa-plus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Code</th>
                      <th>Name</th>
                      <th>Unit</th>
                      <th>Location</th>
                      <th>Stock</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(product, index) in products.data" :key="product.id">
                      <td>{{ index + 1 + (currentPage - 1) * 10 }}</td>
                      <td>{{ product.code }}</td>
                      <td>{{ product.name }}</td>
                      <td>{{ product.unit.name }}</td>
                      <td>{{ product.location.name }}</td>
                      <td>{{ product.stock }}</td>
                      <td>
                        <button data-toggle="modal" data-target="#modalAdd" @click="editProduct(product)" class="btn btn-sm btn-info">Edit</button>
                        <button class="btn btn-danger btn-sm" @click="deleteProduct(product.id)">Delete</button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            <div class="d-flex justify-content-center mt-3">
              <button 
                class="btn btn-primary"
                :disabled="!products.prev_page_url"
                @click="loadProducts(products.prev_page_url)">
                Previous
              </button>
              <button 
                class="btn btn-primary"
                :disabled="!products.next_page_url"
                @click="loadProducts(products.next_page_url)">
                Next
              </button>
            </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                
              <form @submit.prevent="createProduct" @keydown="form.onKeydown($event)">
                <AlertError :form="form" />
                <div class="modal-body">
                  <div class="mb-3">
                    <label for="code" class="form-label">Code</label>
                    <input
                      id="code"
                      v-model="form.code"
                      type="text"
                      name="code"
                      class="form-control"
                    />
                    <HasError :form="form" field="nik" />
                  </div>
                  <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input
                      id="name"
                      v-model="form.name"
                      type="text"
                      name="name"
                      class="form-control"
                    />
                    <HasError :form="form" field="name" />
                  </div>
                  
                  <div class="mb-3">
                    <label for="unit_id" class="form-label">Unit</label>
                    <select
                      id="unit_id"
                      v-model="form.unit_id"
                      class="form-control"
                    >
                      <option value="" disabled selected>Select Unit</option>
                      <option v-for="unit in units" :key="unit.id" :value="unit.id">
                        {{ unit.name }}
                      </option>
                    </select>
                    <HasError :form="form" field="unit_id" />
                  </div>
                  
                  <div class="mb-3">
                    <label for="location_id" class="form-label">Location</label>
                    <select
                      id="location_id"
                      v-model="form.location_id"
                      class="form-control"
                    >
                      <option value="" disabled selected>Select Location</option>
                      <option v-for="location in locations" :key="location.id" :value="location.id">
                        {{ location.name }}
                      </option>
                    </select>
                    <HasError :form="form" field="location_id" />
                  </div>
                  
                  <div class="mb-3">
                    <label for="stock" class="form-label">Stock</label>
                    <input
                      id="stock"
                      v-model="form.stock"
                      type="number"
                      stock="stock"
                      class="form-control"
                    />
                    <HasError :form="form" field="stock" />
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <Button :form="form" class="btn btn-primary">
                    {{ editMode ? 'Update' : 'Create' }}
                  </Button>
                </div>
              </form>
              </div>
          </div>
      </div>
    </div>
</template>


<script>

import axios from 'axios';
import Form from 'vform'
import { Button, HasError, AlertError } from 'vform/src/components/bootstrap4'

import Swal from 'sweetalert2';

    export default {
      components: {
          Button, HasError, AlertError
        },
        data() {
          return {
            units: [],
            locations: [],
            products: {
              data: [],
              prev_page_url: null,
              next_page_url: null,
            },
            form: new Form({
              code: '',
              name: '',
              stock: '',
              unit_id: '',
              location_id: '',
            }),
            currentPage: 1, 
            editMode: false,
            productId: null,
          };
        },
        created() {
          this.loadProducts('/api/products?page=1');
          this.loadUnits();
          this.loadLocations();
        },
        methods: {
          async loadProducts(url){
            try {
              const response = await axios.get(url);
              this.products = response.data;
              const urlParams = new URLSearchParams(url);
              this.currentPage = parseInt(urlParams.get('page'), 10) || 1;
            } catch (error) {
              console.error('Error fetching products:', error);
            }
          },
          loadUnits(){
            axios.get('/api/getUnits')
            .then(response => {
              this.units = response.data; 
            })
            .catch(error => {
              console.error('Error fetching units:', error);
            });
          },
          loadLocations(){
            axios.get('/api/getLocations')
            .then(response => {
              this.locations = response.data; 
            })
            .catch(error => {
              console.error('Error fetching locations:', error);
            });
          },
          editProduct(product) {
              this.editMode = true;
              this.productId = product.id;
              
              this.form.fill({
                code: product.code,
                name: product.name,
                location_id: product.location_id,
                unit_id: product.unit_id,
                stock: product.stock,
              });
          },
          async createProduct() {
            try {
              let response;
              if (this.editMode) {
                response = await this.form.put(`/api/products/${this.productId}`);
                Swal.fire({
                  icon: 'success',
                  title: 'Product Updated!',
                  text: response.data?.message || 'Product updated successfully!',
                });
                  
                // Tutup modal
                $('#modalAdd').modal('hide');
              } else {
                response = await this.form.post('/api/products');
                Swal.fire({
                  icon: 'success',
                  title: 'Product Created!',
                  text: response.data?.message || 'Product created successfully!',
                });
              }
              this.loadProducts('/api/products?page=1');
              this.resetForm();
            } catch (error) {
              Swal.fire({
                icon: 'error',
                title: 'Product Error!',
                text: error,
              });
            }
          },
          async deleteProduct(id) {
            const confirmed = await Swal.fire({
              title: 'Are you sure?',
              text: 'Do you really want to delete this product?',
              icon: 'warning',
              showCancelButton: true,
              confirmButtonText: 'Yes, delete it!',
              cancelButtonText: 'Cancel',
            });

            if (confirmed.isConfirmed) {
              try {
                const response = await axios.delete(`/api/products/${id}`);

                Swal.fire({
                  icon: 'success',
                  title: 'Deleted!',
                  text: response.data.message, 
                });

              } catch (error) {
                console.error('Error deleting product:', error);
                Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: error.response?.data?.message || 'There was an error deleting the product.', 
                });
              }
            }
            
            this.loadProducts('/api/products?page=1');
            this.resetForm();
          },
          resetForm() {
            this.editMode = false;
            this.productId = null;
            this.form.reset();
          }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
