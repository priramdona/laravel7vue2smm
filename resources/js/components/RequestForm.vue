<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
        
                <form @submit.prevent="submitForm">
                    <div class="card card-dark">
                        <div class="card-header">
                            <h3 class="card-title">Create Request Product</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                <label>NIK</label>
                                <input type="text" class="form-control" v-model="nik" @blur="fetchEmployeeData" placeholder="NIK" required>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                <label>Employee Name</label>
                                <input type="text" class="form-control" :value="employee ? employee.name : ''" placeholder="Employee Name" disabled>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                <label>Departement</label>
                                <input type="text" class="form-control" :value="employee && employee.departement ? employee.departement.name : ''" placeholder="Departement" disabled>
                                </div>
                            </div>
                            </div>

                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                    <label>Date:</label>
                                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                        <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate" v-model="request_date" required>
                                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                      </div>

                    <div class="card card-dark">

                        <div class="card-header">
                            <h3 class="card-title">Requested Products</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                            <thead>
                                <tr>
                                <th style="width: 10px">#</th>
                                <th>Products</th>
                                <th>Location</th>
                                <th>Stock</th>
                                <th>Quantity</th>
                                <th>Unit</th>
                                <th>Remarks</th>
                                <th>Status</th>
                                <th style="width: 40px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in items" :key="index">
                                <td>{{ index + 1 }}</td>
                                <td>
                                    <select name="product_id" id="product_id" v-model="item.product_id" @change="fetchProductData(item, index)" class="form-control" required>
                                    <option value="">-- Select Product --</option>
                                    <option v-for="product in products" :value="product.id">{{ product.name }}</option>
                                    </select>
                                </td>
                                <td>
                                    <span v-if="item.product">{{ item.product.location.name }}</span>
                                </td>
                                <td>
                                    <span v-if="item.product">{{ item.product.stock }}</span>
                                </td>
                                <td>
                                    <input type="number" v-model="item.qty" placeholder="Qty" class="form-control" @input="validateQty(item)" :disabled="submitQty">
                                </td>
                                <td>
                                    <span v-if="item.product">{{ item.product.unit.name }}</span>
                                </td>
                                <td>     
                                    <input type="text" v-model="item.remarks" placeholder="Remarks" class="form-control">
                                </td>
                                <td>
                                    <strong>
                                        <span class="badge" :class="getBadgeClass(item.status)">
                                            {{ item.status || 'Empty' }}
                                        </span>
                                    </strong>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm" @click="removeItem(index)"><i class="fa fa-trash"></i></button>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                          
                        </div>
                        <div class="card-footer clearfix">    
                            <div class="mt-2 ml-3">
                            <button type="button" class="btn btn-outline-primary btn-sm" @click="addItem" :disabled="submitAdd"><i class="fa fa-add"></i> Tambah Barang</button>
                            </div>
                        </div>
                    </div>

                    <div>
                    <button type="submit" class="btn btn-block bg-primary" :disabled="submitDisabled">Submit</button>
                    </div>
                </form>
                
                
                <div v-if="alert" class="alert">
                    {{ alert }}
                </div>
            </div>
        </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import Swal from 'sweetalert2';

  export default {
    data() {
      return {
        nik: '',
        employee: null,
        products: [],
        items: [],
        alert: '',
        submitDisabled: false,
        submitQty: false,
        submitAdd: false,
        request_date: '',
      }
    },
    
    methods: {
      
      function(){
        $('#product_id').select2()
      },
      fetchEmployeeData() {
        if (!this.nik) return;
  
        axios.get(`/api/get-employe-by-nik/${this.nik}`)
          .then(res => {
            this.employee = res.data;
          })
          .catch(() => {
            this.employee = null;
          });
      },
      fetchProducts() {

        axios.get('/api/getProducts')
          .then(res => {
            this.products = res.data;  
          });
      },
      fetchProductData(item, index) {
        const id = item.product_id;
        if (!id) return;
  
        axios.get(`/api/products/${id}`)
          .then(res => {
            this.$set(this.items[index], 'product', res.data);
            this.submitQty = Number(res.data.stock) === 0;
            this.submitAdd = Number(res.data.stock) === 0;
            this.submitDisabled = Number(res.data.stock) === 0;

            if(Number(res.data.stock) === 0){
              Swal.fire({
                icon: 'error',
                title: 'Out of Stock!',
                text: 'Product '+ res.data.name +' Out of Stock',
              });
            }
          });
      },
      addItem() {
        this.items.push({ product_id: '', qty: '', product: null, remarks:'', status: 'Empty' });
      },
      removeItem(index) {
        this.items.splice(index, 1);
      },
      getBadgeClass(status) {
            if (status === 'Fullfill') {
              return 'bg-success';
            } else if (status === 'Partial') {
              return 'bg-warning';
            } else {
              return 'bg-danger';
            }
        },
      validateQty(item) {
        if (!item.product) return;

            if (item.qty === 0) {
              item.status = "Empty";
            } else if (item.qty <= item.product.stock) {
              item.status = "Fullfill";
            } else if (item.qty > item.product.stock) {
              item.status = "Partial";
            } else {
              item.status = "Empty";
            }
        
        this.checkSubmitDisable();
      },
      checkSubmitDisable() {
        this.submitDisabled = this.items.some(item => item.status === 'Empty');
      },
      submitForm() {
        const payload = {
          nik: this.nik,
          request_date: this.request_date,
          items: this.items.map(item => ({
            product_id: item.product_id,
            qty: item.qty,
            product_status: item.status,
            remarks: item.remarks
          }))
        };
  
        axios.post('/api/request-products', payload)
          .then(() => {
            this.alert = 'Request submited!';
            
            Swal.fire({
                icon: 'success',
                title: 'Request Submited!',
                text: 'Request product Save Succesfully',
              });
              
            this.resetForm();
          })
          .catch(err => {
            
            this.alert = 'Request Failed!';
            Swal.fire({
                icon: 'error',
                title: 'Request Failed!',
                text: 'Request product Failed, Please check and Try again.',
              });
          });
      },
      resetForm() {
        this.nik = '';
        this.employee = null;
        this.items = [];
        this.submitDisabled = false;
        this.submitQty = false;
        this.submitAdd = false;
        this.fetchProducts();
      }
    },
    mounted() {
      this.fetchProducts();
      this.addItem();
      this.$nextTick(() => {
            $('#reservationdate input').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
            }).on('changeDate', (e) => {
            this.request_date = e.format('yyyy-mm-dd');
            });
        });
    }
  }
  </script>
  
  <style scoped>
  .alert {
    margin-top: 10px;
    padding: 10px;
    background: #d4edda;
    color: #155724;
  }
  </style>
  