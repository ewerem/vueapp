<!DOCTYPE html>
<html>
<head>
    <title>Vue App</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap4.css"/>
</head>
<body>
    <div id="app">
        
        <div class="container-fluid bg-dark text-center display-4 text-light" style="font-size:35px;">
            CRUD APP WITH VUE JS
        </div>

        <div class="container mt-3">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <h4 class="text-success text-left">Registred Users</h4>
                </div>
                <div class="col-lg-6 col-md-6 text-right">
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#staticBackdrop">Add New User</button>
                </div>
            </div>
            <hr class="bg-dark">
            <div class="alert alert-danger" v-if="errorMsg">{{ errorMsg }}</div>
            <div class="alert alert-success" v-if="successMsg">{{ successMsg }}</div>

            <!-- displaying message -->
            <div class="mt-3">
                <table class="table table-bordered table-striped">
                 <thead>
                    <tr class="text-center bg-dark text-light">
                        <th>Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                 </thead>
                 <tbody>
                    <tr class="text-center" v-for="user in users">
                        <td>{{ user.id }}</td>
                        <td>{{ user.name }}</td>
                        <td>{{ user.email }}</td>
                        <td>{{ user.phone }}</td>
                        <td>
                            <a href="#staticBackdrop2" class="btn btn-secondary" data-toggle="modal" @click="selectUser(user);">Edit</a>
                        </td>
                        <td>
                            <a href="#staticBackdrop3" class="btn btn-danger" data-toggle="modal" @click="selectUser(user);">Delete</a>
                        </td>
                    </tr>
                 </tbody>
                </table>
            </div>

            <!-- add user modal dialog -->
            <div class="modal fade" id="staticBackdrop" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Add New User</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            
                                <div class="form-group">
                                    <input type="text" name="name" class="form-control form-control-lg" placeholder="User Name" v-model="newUser.name">
                                </div>
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control form-control-lg" placeholder="User Email" v-model="newUser.email">
                                </div>
                                <div class="form-group">
                                    <input type="number" name="phone" class="form-control form-control-lg" placeholder="User Phone" v-model="newUser.phone">
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-info btn-block btn-lg" @click="addUser();" data-dismiss="modal">
                                        Submit
                                    </button>
                                </div>
                
                        </div>
                    </div>
                </div>
            </div>

            <!-- end of user modal -->

            <!-- edit user modal dialog -->
            <div class="modal fade" id="staticBackdrop2" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Edit User</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <form method="post">
                                <div class="form-group">
                                    <input type="text" name="name" class="form-control form-control-lg" v-model="currentUser.name">
                                </div>
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control form-control-lg" v-model="currentUser.email">
                                </div>
                                <div class="form-group">
                                    <input type="number" name="phone" class="form-control form-control-lg" v-model="currentUser.phone">
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-secondary btn-block btn-lg" @click="updateUser();" data-dismiss="modal">
                                        Submit  Update
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- end of edit modal -->

            <!-- Delete user modal dialog -->
            <div class="modal fade" id="staticBackdrop3" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Delete User</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <h4 class="text-danger">Do you really want to delete {{ currentUser.name }}</h4>
                            <br>
                            <button class="btn btn-danger btn-lg" @click="deleteUser();" data-dismiss="modal">
                                Yes
                            </button>
                            <button class="btn btn-success btn-lg" data-dismiss="modal">
                                No
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- end of delete modal -->

        </div>

    </div>

<!-- ///////// ---->
<script src="js/jq.js"></script>
<script src="js/popper.js"></script>
<script src="js/bootstrap4.js"></script>
<script src="js/axios.min.js"></script>
<script src="js/vue.js"></script>
<script>

var app = new Vue ({
    el:'#app',
    data: {
        errorMsg: "",
        successMsg: "",
        users: [],
        newUser: {name: "", email: "", phone: ""},
        currentUser: {}
    },
    mounted: function(){
        this.getAllUsers();
    },
    methods: {
        getAllUsers(){
            axios.get("api.php?action=read").then(function(response){
                if(response.data.error){
                    app.errorMsg = response.data.message;
                }else{
                    app.users = response.data.users;
                }
            });
        },
        addUser(){
            var formData = app.toFormData(app.newUser);
            axios.post("api.php?action=create", formData).then(function(response){
                app.newUser = {name:"",email:"",phone:""};
                if(response.data.error){
                    app.errorMsg = response.data.message;
                       app.successMsg = "";
                }else{
                       app.successMsg = response.data.message;
                    app.getAllUsers();
                       app.errorMsg = "";
                }
            });  
        },
        updateUser(){
            var formData = app.toFormData(app.currentUser);
            axios.post("api.php?action=update", formData).then(function(response){
                app.currentUser = {};
                if(response.data.error){
                    app.errorMsg = response.data.message;
                    app.successMsg = "";
                }else{
                    app.successMsg = response.data.message;
                    app.getAllUsers();
                    app.errorMsg = "";
                }
            });
        },
        deleteUser(){
            var formData = app.toFormData(app.currentUser);
            axios.post("api.php?action=delete", formData).then(function(response){
                app.currentUser = {};
                if(response.data.error){
                    app.errorMsg = response.data.message;
                    app.successMsg = "";
                }else{
                    app.successMsg = response.data.message;
                    app.getAllUsers();
                    app.errorMsg = "";
                }
            });
        },
        toFormData(obj){
            var fd = new FormData();
            for(var i in obj){
                fd.append(i, obj[i]);
            }
            return fd;
        },
        selectUser(user){
            app.currentUser = user;
        },
    }
})

</script>
</body>
</html>