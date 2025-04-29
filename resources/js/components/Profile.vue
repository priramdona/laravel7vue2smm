<template>
    <div class="container">
        <div class="row mt-5">
          <div class="col-md-6">
            <div class="register-box">
            <div class="card card-outline card-primary">
                <div class="card-header text-center">
                <a href="../../index2.html" class="h1"><b>Profile</b>setting</a>
                </div>
                <div class="card-body">
                <p class="login-box-msg">Profile Information</p>

                <form action="../../index.html" method="post">
                    <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Full name">
                    <div class="input-group-append">
                        <div class="input-group-text">
                        <span class="fas fa-user"></span>
                        </div>
                    </div>
                    </div>
                    <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    </div>
                    <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Retype password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    </div>
                    <div class="row">
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Update</button>
                    </div>
                    </div>
                </form>
                </div>
            </div>
            </div>
          </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
