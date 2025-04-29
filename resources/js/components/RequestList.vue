<template>
    <div class="container">
      <div class="row mt-5">
        <div class="col-md-12">
          <div class="card card-dark">
            <div class="card-header">
              <h3 class="card-title">Request Product List</h3>
            </div>
            <div class="card-body table-responsive p-0">
              <table class="table table-hover text-nowrap">
              <thead>
                <tr>
                  <th>Code</th>
                  <th>User</th>
                  <th>Employee</th>
                  <th>Request Date</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="request in requestProducts" :key="request.id">
                  <td>{{ request.code }}</td>
                  <td>{{ request.user.name }}</td>
                  <td>{{ request.employee.name }}</td>
                  <td>{{ request.request_date }}</td>
                  <td>{{ request.status }}</td>
                  <td>
                    <button class="btn btn-info btn-sm" @click="viewRequest(request.id)"  data-toggle="modal" data-target="#modalAdd">View</button>
                  </td>
                </tr>
              </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

    <div v-if="showModal" class="modal fade  z-index: 9999" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Product Details</h5>
          </div>

          <!-- Main content -->
          <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>
                    <i class="fa fa-globe"></i> PT Sarana Makin Mulia.
                    <small class="float-right">Date: {{ selectedRequest.request_date }}</small>
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                  From
                  <address>

                    <strong>{{ selectedRequest.employee.name }}</strong><br>
                    {{ selectedRequest.code }}<br>
                    {{ selectedRequest.status }}<br>
                    <br>
                    Created by: {{ selectedRequest.user.name }}<br>
                  </address>
                </div>
              </div>
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                    <tr>
                      <th>Product</th>
                      <th>Quantity</th>
                      <th>Remarks</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item in selectedRequest.request_product_items" :key="item.id">
                      <td>{{ item.product.name }}</td>
                      <td>{{ item.qty }}</td>
                      <td>{{ item.remarks }}</td>
                      <td>{{ item.status }}</td>
                    </tr>
                  </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <div class="row no-print">
                <div class="col-12">
                  <a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
                 
                </div>
              </div>
            </div>

          <button class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</template>
  
<script>
import axios from 'axios';

export default {
  data() {
    return {
      requestProducts: [],
      selectedRequest: null,
      showModal: false,
    };
  },
  created() {
    this.fetchRequestProducts();
  },
  methods: {
    fetchRequestProducts() {
      axios.get('/api/request-products')
        .then(response => {
          this.requestProducts = response.data;
        })
        .catch(error => {
          console.error(error);
        });
    },
    viewRequest(id) {
      axios.get(`/api/request-products/${id}`)
        .then(response => {
          this.selectedRequest = response.data;
          // this.selectedRequest = request;
          this.showModal = true;
        })
        .catch(error => {
          console.error(error);
        });
    }
  }
}
</script>
