<template>
    <div class="container">
        <div class="row mt-5">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Department List</h3>

                <div class="card-tools">
                  <button class="btn btn-success" data-toggle="modal" data-target="#modalAdd">
                    Add New <i class="fa fa-plus"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Code</th>
                      <th>Name</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(department, index) in departments.data" :key="department.id">
                      <td>{{ index + 1 + (currentPage - 1) * 10 }}</td>
                      <td>{{ department.code }}</td>
                      <td>{{ department.name }}</td>
                      <td>
                        <button data-toggle="modal" data-target="#modalAdd" @click="editDepartment(department)" class="btn btn-sm btn-info">Edit</button>
                        <button class="btn btn-danger btn-sm" @click="deleteDepartment(department.id)">Delete</button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-3">
              <button 
                class="btn btn-primary"
                :disabled="!departments.prev_page_url"
                @click="loadDepartments(departments.prev_page_url)">
                Previous
              </button>
              <button 
                class="btn btn-primary"
                :disabled="!departments.next_page_url"
                @click="loadDepartments(departments.next_page_url)">
                Next
              </button>
            </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Add Department</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                
              <form @submit.prevent="createDepartment" @keydown="form.onKeydown($event)">
                <AlertError :form="form" />
                <div class="modal-body">
                      <!-- Name Input -->
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

// Import SweetAlert2
import Swal from 'sweetalert2';

    export default {
      components: {
          Button, HasError, AlertError
        },
        data() {
          return {
            departments: {
              data: [],
              prev_page_url: null,
              next_page_url: null,
            },
            form: new Form({
              code: '',
              name: '',
            }),
            currentPage: 1, 
            editMode: false,
            departmentId: null,
          };
        },
        created() {
          this.loadDepartments('/api/departments?page=1');
        },
        methods: {
          async loadDepartments(url){
            try {
              const response = await axios.get(url);
              this.departments = response.data;
              const urlParams = new URLSearchParams(url);
              this.currentPage = parseInt(urlParams.get('page'), 10) || 1;
            } catch (error) {
              console.error('Error fetching departments:', error);
            }
          },
          editDepartment(department) {
              this.editMode = true;
              this.departmentId = department.id;
              
              this.form.fill({
                code: department.code,
                name: department.name,
              });
          },
          async createDepartment() {
            try {
              let response;
              if (this.editMode) {
                response = await this.form.put(`/api/departments/${this.departmentId}`);
                Swal.fire({
                  icon: 'success',
                  title: 'Department Updated!',
                  text: response.data?.message || 'Deparrtment updated successfully!',
                });
                  
                // Tutup modal
                $('#modalAdd').modal('hide');
              } else {
                response = await this.form.post('/api/departments');
                Swal.fire({
                  icon: 'success',
                  title: 'Department Created!',
                  text: response.data?.message || 'Department created successfully!',
                });
              }
              this.loadDepartments('/api/departments?page=1');
              this.resetForm();
            } catch (error) {
              // Show SweetAlert2 success message
              Swal.fire({
                icon: 'error',
                title: 'Department Error!',
                text: error,
              });
            }
          },
          async deleteDepartment(id) {
            const confirmed = await Swal.fire({
              title: 'Are you sure?',
              text: 'Do you really want to delete this department?',
              icon: 'warning',
              showCancelButton: true,
              confirmButtonText: 'Yes, delete it!',
              cancelButtonText: 'Cancel',
            });

            if (confirmed.isConfirmed) {
              try {
                const response = await axios.delete(`/api/departments/${id}`);

                Swal.fire({
                  icon: 'success',
                  title: 'Deleted!',
                  text: response.data.message, 
                });

              } catch (error) {
                console.error('Error deleting department:', error);
                Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: error.response?.data?.message || 'There was an error deleting the department.', 
                });
              }
            }
            
            this.loadDepartments('/api/departments?page=1');
            this.resetForm();
          },
          resetForm() {
            this.editMode = false;
            this.departmentId = null;
            this.form.reset();
          }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
