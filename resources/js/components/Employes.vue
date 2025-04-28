<template>
    <div class="container">
        <div class="row mt-5">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Responsive Hover Table</h3>

                <div class="card-tools">
                  <button class="btn btn-success" data-toggle="modal" data-target="#modalAdd">
                    Add New <i class="fa fa-user-plus"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>NIK</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Departement</th>
                      <th>Status</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(employee, index) in employees.data" :key="employee.id">
                      <td>{{ index + 1 + (currentPage - 1) * 10 }}</td>
                      <td>{{ employee.nik }}</td>
                      <td>{{ employee.name }}</td>
                      <td>{{ employee.email }}</td>
                      <td>{{ employee.departement.name }}</td>
                      <td>{{ employee.status ? 'Active' : 'Inactive' }}</td>
                      <td>
                        <button data-toggle="modal" data-target="#modalAdd" @click="editEmployee(employee)" class="btn btn-sm btn-info">Edit</button>
                        <button class="btn btn-danger btn-sm" @click="deleteEmployee(employee.id)">Delete</button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-3">
              <button 
                class="btn btn-primary"
                :disabled="!employees.prev_page_url"
                @click="loadEmployees(employees.prev_page_url)">
                Previous
              </button>
              <button 
                class="btn btn-primary"
                :disabled="!employees.next_page_url"
                @click="loadEmployees(employees.next_page_url)">
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
                  <h5 class="modal-title" id="exampleModalLabel">Add Employee</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                
              <form @submit.prevent="createEmployee" @keydown="form.onKeydown($event)">
                <AlertError :form="form" />
                <div class="modal-body">
                      <!-- Name Input -->
                  <div class="mb-3">
                    <label for="nik" class="form-label">NIK</label>
                    <input
                      id="nik"
                      v-model="form.nik"
                      type="text"
                      name="nik"
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

                  <!-- Email Input -->
                  <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input
                      id="email"
                      v-model="form.email"
                      type="email"
                      name="email"
                      class="form-control"
                    />
                    <HasError :form="form" field="email" />
                  </div>
                  
                      <!-- Dropdown Departement -->
                  <div class="mb-3">
                    <label for="departement_id" class="form-label">Departement</label>
                    <select
                      id="departement_id"
                      v-model="form.departement_id"
                      class="form-control"
                    >
                      <option value="" disabled selected>Select Departement</option>
                      <option v-for="departement in departements" :key="departement.id" :value="departement.id">
                        {{ departement.name }}
                      </option>
                    </select>
                    <HasError :form="form" field="departement_id" />
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <!-- <button type="submit" class="btn btn-primary">Save changes</button> -->
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
            employees: {
              data: [],
              prev_page_url: null,
              next_page_url: null,
            },
            departements: [],
            form: new Form({
              nik: '',
              name: '',
              email: '',
              departement_id: '',
              status: true,
            }),
            currentPage: 1, // Tracking current page
            editMode: false,
            employeeId: null,
          };
        },
        created() {
          this.loadEmployees('/api/employees?page=1');
          this.loadDepartements();
        },
        methods: {
          async loadEmployees(url){
            try {
              const response = await axios.get(url);
              this.employees = response.data;
              const urlParams = new URLSearchParams(url);
              this.currentPage = parseInt(urlParams.get('page'), 10) || 1;
            } catch (error) {
              console.error('Error fetching employees:', error);
            }
          },
          loadDepartements(){
            // Ambil data departemen dari API saat komponen dibuat
            axios.get('/api/departements')
            .then(response => {
              this.departements = response.data; // Simpan data departemen
            })
            .catch(error => {
              console.error('Error fetching departements:', error);
            });
          },
          editEmployee(employee) {
              this.editMode = true;
              this.employeeId = employee.id;
              
              this.form.fill({
                nik: employee.nik,
                name: employee.name,
                email: employee.email,
                departement_id: employee.departement_id,
                status: employee.status,
              });
          },
          createEmployeeBackup() {
            this.form.post('/api/employees');
          },
          async createEmployee() {
            try {
              let response;
              if (this.editMode) {
                response = await this.form.put(`/api/employees/${this.employeeId}`);
                Swal.fire({
                  icon: 'success',
                  title: 'Employee Updated!',
                  text: response.data?.message || 'Employee updated successfully!',
                });
                  
                // Tutup modal
                $('#modalAdd').modal('hide');
              } else {
                response = await this.form.post('/api/employees');
                Swal.fire({
                  icon: 'success',
                  title: 'Employee Created!',
                  text: response.data?.message || 'Employee created successfully!',
                });
              }
              this.loadEmployees('/api/employees?page=1');
              this.resetForm();
            } catch (error) {
              // Show SweetAlert2 success message
              Swal.fire({
                icon: 'error',
                title: 'Employee Error!',
                text: error,
              });
            }
          },
          async deleteEmployee(id) {
            const confirmed = await Swal.fire({
              title: 'Are you sure?',
              text: 'Do you really want to delete this employee?',
              icon: 'warning',
              showCancelButton: true,
              confirmButtonText: 'Yes, delete it!',
              cancelButtonText: 'Cancel',
            });

            // Cek apakah user klik "Yes"
            if (confirmed.isConfirmed) {
              try {
                const response = await axios.delete(`/api/employees/${id}`);

                // Ambil message dari server
                Swal.fire({
                  icon: 'success',
                  title: 'Deleted!',
                  text: response.data.message, // <-- ambil message dari server
                });

              } catch (error) {
                console.error('Error deleting employee:', error);
                Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: error.response?.data?.message || 'There was an error deleting the employee.', 
                });
              }
            }
            
            this.loadEmployees('/api/employees?page=1');
            this.resetForm();
          },
          resetForm() {
            this.editMode = false;
            this.employeeId = null;
            this.form.reset();
                      
          }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
